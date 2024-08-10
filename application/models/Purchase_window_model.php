<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_window_model extends CI_Model
{   
    public function __construct(){
        parent::__construct();
    }

    var $table = 'tg_purchase_window';         
    var $column_order = array(null,null,'p1.projectNo','p1.client','p1.projectequipment','p1.tag_number', 'p1.tag_no', 'p1.description', 'p1.tech_req', 'p1.stock', 'p1.po_release_date', 'p1.actual_po_date', 'p1.quality_remark', 'p1.release_for_prod', 'p1.mtc', null);
    var $column_search = array('p1.projectNo','p1.client','p1.projectequipment','p1.tag_number', 'p1.tag_no', 'p1.description', 'p1.tech_req', 'p1.stock', 'p1.po_release_date', 'p1.actual_po_date', 'p1.quality_remark', 'p1.release_for_prod', 'p1.mtc'); 
    var $order = array('p1.sort_order' => 'asc');
 
    private function _get_datatables_query($projectID)
    {          
        $this->db->select('p1.*, p3.equipment, p4.company_name');
        $this->db->from('tg_purchase_window as p1');
        // $this->db->join('tg_purchase_activity_data as p2','p2.id = p1.activity');        
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
     
    public function delete_by_id($activityID)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('activityID', $activityID);
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
        $this->db->select('
        design.projectNo,  design.tag_number, design.tag_no, design.description, design.tech_req, design.stock, design.po_release_date, design.actual_po_date,
        p4.equipment,
        p3.company_name, 
        design.release_for_prod, design.mtc,
        ');
        
        // $this->db->join('tg_activity_data as p1','p1.id = design.activityID');
        
        $this->db->join('tg_client as p3','p3.id = design.client');
        $this->db->join('tg_equipment as p4','p4.id = design.projectequipment');

        $this->db->where('design.isDeleted', '1');
        $this->db->where('design.status', '1');
        $this->db->where('design.projectID', $projectID);
        // $this->db->from('tg_purchase_window as design');
        $query = $this->db->get('tg_purchase_window as design');
        return $query->result_array();
		// $query = $this->db->get();
        // return $query->result();
    }


    // public function getActivityDetails($projectID){
    //     $this->db->select('p3.company_name, design.projectNo, p4.equipment, design.tag_number, p1.activity_data AS activity, p2.skills AS skill1, design.person1, design.manpower1, design.startDate, design.targetDate,  design.completionDate, design.releaseDate, design.clientApproval, design.revisionNo, design.delay, design.reason');
    //     $this->db->from('tg_purchase_window as design');
    //     $this->db->join('tg_activity_data as p1','p1.id = design.activity');
    //     $this->db->join('tg_design_skills as p2','p2.id = design.skill1');
    //     $this->db->join('tg_client as p3','p3.id = design.client');
    //     $this->db->join('tg_equipment as p4','p4.id = design.projectequipment');
    
    //     $this->db->where('design.isDeleted', '1');
    //     $this->db->where('design.status', '1');
    //     $this->db->where('design.projectID', $projectID);
    
    //     $query = $this->db->get(); // Remove alias from get() method
    //     return $query->result_array();
    // }


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
    
    public function updateProjectTimeline($activityID, $data)
    {        
        $this->db->where('id', $activityID);
        $this->db->update('tg_project_detail', $data);        
        return $this->db->affected_rows();
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
        $this->db->select('p2.activityID, p2.projectID, p2.projectequipment,p2.tag_no,p2.bom_date, p2.description, p2.tech_req, p2.dim_width, p2.dim_length, p2.dim_thickness, p2.qty, p2.rev_odl, p2.stock, p2.vendor, p2.po_release_date, p2.actual_po_date, p2.appr_date, p2.material_reqd_prod, p2.exp_material_rec_date, p2.actual_material_rec_date, p2.tc_rec, p2.remark, p2.release_for_prod, p2.quality_remark, p2.qap_given, p2.mtc, p2.sort_order,p2.is_disabled, p2.parent_activity_id');        
        // $this->db->join('tg_purchase_activity_data as p1','p1.id = p2.activity');
        // $this->db->join('tg_users as p3','p3.userId = p2.person_name');
        $where = array('p2.isDeleted'=>'1','p2.status'=>'1','p2.projectID'=>$projectID,'p2.projectequipment'=>$projectequipment,'p2.client'=>$client_id);
        $this->db->where($where); 
        $this->db->order_by('p2.sort_order','ASC');   
        // $this->db->limit($limit, $start);    
        $query = $this->db->get('tg_purchase_window as p2');
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

    public function get_highest_sort_order(){
        $this->db->select_max('sort_order');
        $this->db->from($this->table);
        $this->db->where('status', '1');
        $this->db->where('isDeleted', '1');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_project_info($projectID){
        $this->db->select('p1.project_no, p2.company_name');
        $this->db->from('tg_project_detail as p1');       
        $this->db->join('tg_client as p2','p2.id = p1.client');                
        $this->db->where('p1.id',$projectID);   
        $query = $this->db->get();
        return $query->row();     
    }


    // notification log module
    public function saveNotificationLog($data){
        $this->db->insert('tg_activity_notification_log', $data);
        return $this->db->insert_id();
    }

    public function is_UpdatedActivity_activityID($activityID){
        $this->db->from('tg_purchase_window');
        $where = array('activityID'=>$activityID);
        $this->db->where($where);         
        $query = $this->db->get();
        return $query->result();
    }
}