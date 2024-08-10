<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_window_model extends CI_Model
{   
    public function __construct(){
        parent::__construct();
    }

    var $table = 'tg_purchase_window';         
    var $column_order = array(null,);
    var $column_search = array(); 
    var $order = array('p1.id' => 'desc');
 
    private function _get_datatables_query($projectID)
    {          
        $this->db->select('p1.*, p3.equipment, p4.company_name');
        $this->db->from('tg_purchase_window as p1');
        $this->db->join('tg_users as p2','p2.userId = p1.createdBy');                
        $this->db->join('tg_equipment as p3','p3.id = p1.projectequipment');
        $this->db->join('tg_client as p4','p4.id = p1.client');
        
        $this->db->where('p1.isDeleted',1);
        $this->db->where('p1.projectID',$projectID);               

        $i = 0;
        foreach ($this->column_search as $item) 
        {
            if($_POST['search']['value']) 
            {                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables($projectID)
    {
        $this->_get_datatables_query($projectID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered($projectID)
    {
        $this->_get_datatables_query($projectID);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($projectID)
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
    }

    // public function count_all_eqpwise_rows($projectID,$projectequipment)
    // {
    //     $this->db->from($this->table);
    //     $this->db->where('projectID',$projectID);
    //     $this->db->where('projectequipment',$projectequipment);
    //     $this->db->where('isDeleted',1);
    //     return $this->db->count_all_results();
    // }

    public function get_purchase_activity()
    {
        $this->db->from('tg_purchase_activity_data');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_design_skill()
    {
        $this->db->from('tg_design_skills');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_activity_by_id($id)
    {                  
        $this->db->where('activityID',$id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_project_details($projectNo)
    {          
        $this->db->where('id', $projectNo);
        $this->db->from('tg_project_detail');
        $query = $this->db->get();
        return $query->row();
    }
 
    public function saveActivity($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    public function updatePurchase($data, $activityID)
    {        
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table, $data);        
        return $this->db->affected_rows();
    }

    public function get_activity_detail_by_id($activityID){
        $this->db->select('p2.equipment, p3.company_name, p1.*');
        $this->db->from('tg_purchase_window as p1');                
        $this->db->join('tg_equipment as p2','p2.id = p1.projectequipment');
        $this->db->join('tg_client as p3','p3.id = p1.client');
        $where = array('p1.activityID'=>$activityID);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->row();
    }
     
    public function delete_by_id($id)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('id', $id);
        $this->db->update($this->table,$data);
        return 1;
    }

    public function delete_permanent($activityID)
    {        
        $this->db->where('activityID', $activityID);
        $this->db->delete($this->table);        
        return true;
    }
    
    public function delete_persons_curr_activity($activityID)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('design_window_id', $activityID);
        $this->db->update('tg_design_person_activities',$data);
        return 1;
    }

    public function update_status($activityID,$status)
    {
        $data['status'] = $status;
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table, $data);
    } 

    public function getActivityDetails($projectID){
        $this->db->select('p3.company_name, design.projectNo, p4.equipment, design.tag_number, p1.activity_data AS activity, p2.skills AS skill1, design.person1, design.manpower1, design.startDate, design.targetDate,  design.completionDate, design.releaseDate, design.clientApproval, design.revisionNo, design.delay, design.reason');
        // $this->db->from('tg_purchase_window as design');
        $this->db->join('tg_activity_data as p1','p1.id = design.activity');
        $this->db->join('tg_design_skills as p2','p2.id = design.skill1');
        $this->db->join('tg_client as p3','p3.id = design.client');
        $this->db->join('tg_equipment as p4','p4.id = design.projectequipment');

        $this->db->where('design.isDeleted', '1');
        $this->db->where('design.status', '1');
        $this->db->where('design.projectID', $projectID);
        $query = $this->db->get('tg_purchase_window as design');
        return $query->result_array();
		// $query = $this->db->get();
        // return $query->result();
    }
    public function get_equipment_name($id)
    {   
        $this->db->select('equipment');
        $this->db->from('tg_equipment');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    public function get_client_name($projectID)
    {   
        $this->db->select('tg_client.id, tg_client.company_name');        
        $this->db->join('tg_client','tg_client.id=tg_project_detail.client');                
        $this->db->where('tg_project_detail.id',$projectID);
        $this->db->from('tg_project_detail');

        $query = $this->db->get();
        return $query->row();
    }   
    
    public function get_equipment_tag_no($projectequipment, $projectID){
        $this->db->select('projectID,equipment,tag_number,equipment_name');
        $this->db->from('tg_project_equipment');
        $this->db->where('projectID',$projectID);
        $this->db->where('equipment',$projectequipment);
        $this->db->where('status','1');
        $this->db->where('isDeleted','1');
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_skill_name($id)
    {   
        $this->db->select('id,skills');
        $this->db->from('tg_design_skills');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_Project_no_by_pid($projectID)
    {   
        $this->db->select('project_no, purchaseProjectStartDate, purchaseProjectEndDate, purchaseActualStartDate, purchaseActualEndDate');
        $this->db->from('tg_project_detail');
        $this->db->where('id',$projectID);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_skills_name($id)
    {   
        $this->db->select('skills');
        $this->db->from('tg_design_skills');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_person_user_name($userId)
    {   
        $this->db->select('name');
        $this->db->from('tg_users');
        $this->db->where('userId',$userId);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPurchaseEqpActivity($projectID,$projectequipment,$client_id){
        $this->db->select('p1.*, p2.name');                
        $this->db->from('tg_purchase_window as p1');
        $this->db->join('tg_users as p2','p2.userId = p1.createdBy');
        $where = array('p1.isDeleted'=>'1','p1.status'=>'1','p1.projectID'=>$projectID,'p1.projectequipment'=>$projectequipment,'p1.client'=>$client_id);
        $this->db->where($where);         
        $this->db->order_by('p1.activityID desc');
        // $this->db->limit($limit, $start);    
        $query = $this->db->get();
        return $query->result();
    }   

    public function saveDesignActivityPersons($data)
    {
        $this->db->insert('tg_design_person_activities');
        return $this->db->insert_id();
    }

    public function get_person_name($userId)
    {   
        $this->db->select('name');
        $this->db->from('tg_users');
        $this->db->where('userId',$userId);
        $query = $this->db->get(); 
        return $query->row();
    }

   

    public function beforeEditPeronsActivitySkills($activityID){
        $this->db->where('design_window_id', $activityID);
        $this->db->delete('tg_design_person_activities');
    }

    public function get_activity_skills_count($activity){             
        $this->db->where('design_activity',$activity);
        return $this->db->get('tg_design_skills')->num_rows();
    } 

    public function get_purchase_dept_persons()
    {
        $this->db->from('tg_users');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $this->db->where('dept_id',3);        
        $query = $this->db->get();
 
        return $query->result();
    }


    public function add_purchase_excel_bulk($data){
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }    

    public function get_project_info($projectID){
        $this->db->select('p1.project_no, p2.company_name');
        $this->db->from('tg_project_detail as p1');       
        $this->db->join('tg_client as p2','p2.id = p1.client');                
        $this->db->where('p1.id',$projectID);   
        $query = $this->db->get();
        return $query->row();     
    }

    public function updateProjectTimeline($activityID, $data)
    {        
        $this->db->where('id', $activityID);
        $this->db->update('tg_project_detail', $data);        
        return $this->db->affected_rows();
    }
}