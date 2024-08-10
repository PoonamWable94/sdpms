<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Add_new_project_model extends CI_Model
{   
    var $table = 'tg_project_detail';     
    
    var $column_order = array('clint.company_name', 'tg_project_detail.project_no', 'tg_project_detail.equipment', 'tg_project_detail.tag_number', 'tg_project_detail.equip_qty', 'tg_project_detail.po_number', 'tg_project_detail.po_date_time', 'tg_project_detail.del_date', 'tg_project_detail.proj_comp_date','tg_project_detail.act_desp_date', 'tg_project_detail.isCompleted', 'tg_project_detail.manager_name', 'tg_project_detail.status'); 
    var $column_search = array('clint.company_name', 'tg_project_detail.project_no', 'tg_project_detail.equipment', 'tg_project_detail.tag_number', 'tg_project_detail.equip_qty', 'tg_project_detail.po_number', 'tg_project_detail.po_date_time', 'tg_project_detail.del_date', 'tg_project_detail.proj_comp_date','tg_project_detail.act_desp_date', 'tg_project_detail.isCompleted','tg_project_detail.manager_name', 'tg_project_detail.status'); 
    var $order = array('tg_project_detail.project_no' => 'ASC'); 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {           
        $this->db->select('clint.company_name, tg_project_detail.id,tg_project_detail.project_no, tg_project_detail.manager_name, tg_project_detail.po_date_time, tg_project_detail.po_number, tg_project_detail.del_date, tg_project_detail.proj_comp_date,tg_project_detail.act_desp_date,tg_project_detail.isCompleted, tg_project_detail.tag_number, tg_project_detail.equip_qty, tg_project_detail.description,tg_project_detail.status,tg_project_detail.createdDtm, tg_project_detail.jobvendor');
        $this->db->from($this->table);
        $this->db->join('tg_client as clint','clint.id = tg_project_detail.client'); 
        // $this->db->join('tg_project_equipment as equipments','equipments.projectID = tg_project_detail.id');
        $this->db->where('tg_project_detail.isDeleted',0);  
        // $this->db->where('equipments.isDeleted',1);       
        // $this->db->where('equipments.status',1);  
        // $this->db->order_by('tg_project_detail.id ASC'); 
        
        if($this->input->post('projects_id'))
        {
            $projects_id = $this->input->post('projects_id');
              $this->db->where('tg_project_detail.id',$projects_id);   
                    
        } //it is from production status report
               
        $i = 0;     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
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
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',0);
        return $this->db->count_all_results();
    }
    public function get_all_equipment()
    {
        $this->db->from('tg_equipment');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_all_client()
    {
        $this->db->from('tg_client');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_all_managers()
    {
        $this->db->from('tg_users');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $this->db->where('roleId',3);
        $this->db->or_where('roleId',2);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_all_equipments($projectID)
    {   
        $this->db->from('tg_project_equipment');
        $this->db->where('projectID',$projectID);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_by_id($id)
    {   
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_Project_no_by_pid($projectID)
    {   
        $this->db->select('project_no');
        $this->db->from($this->table);
        $this->db->where('id',$projectID);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_manager_by_id($id)
    {   
        $this->db->select('name');
        $this->db->from('tg_users');
        $this->db->where('userId',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_Equipment_tag_by_id($projectID)
    {   
        $this->db->from('tg_project_equipment');
        $this->db->where('status',1);
        $this->db->where('isDeleted',1);
        $this->db->where('projectID',$projectID);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_project_view($id){
        $this->db->select('clint.company_name, tg_project_detail.id,tg_project_detail.project_no, tg_project_detail.manager_name, tg_project_detail.po_date_time,tg_project_detail.del_date,tg_project_detail.proj_comp_date, tg_project_detail.act_desp_date, tg_project_detail.isCompleted, tg_project_detail.equipment, tg_project_detail.tag_number, tg_project_detail.equip_qty, tg_project_detail.description,tg_project_detail.status,tg_project_detail.createdDtm, tg_project_detail.jobvendor');
        $this->db->from($this->table);
        $this->db->join('tg_client as clint','clint.id = tg_project_detail.client'); 
        // $this->db->join('tg_project_equipment as equipments','equipments.projectID = tg_project_detail.id');
        $this->db->where('tg_project_detail.id',$id);
        // $this->db->where('equipments.equipment',$eid);
        $this->db->where('tg_project_detail.isDeleted',0);
        // $this->db->where('equipments.isDeleted',1);        
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_equipment_name($id)
    {   
        $this->db->select('equipment');
        $this->db->from('tg_equipment');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {

        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    public function save_equipment($data)
    {
        $this->db->insert('tg_project_equipment',$data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
       
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $data = array( 
            'isDeleted' => 1
        );
        $this->db->where('id', $id);
        $this->db->update($this->table,$data);
    }

    public function delete_by_id_project_details($projectID)
    {
        $data = array( 
            'isDeleted' => 0,
            'status' => 0,
        );
        $this->db->where('projectID', $projectID);
        $this->db->update('tg_project_equipment',$data);
    }

    public function update_status($id,$status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    } 

    public function get_all_projects()
    {
        $this->db->from($this->table);
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
 
        return $query->result();
    }


     public function get_all_department()
    {
        $this->db->from('tg_department');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function delete_eq_tag_update($projectID){
        $this->db->where('projectID', $projectID);
        $this->db->delete('tg_project_equipment'); 
    }

    public function check_if_eqp_activity_exists($projectID,$equipmentId){
        $where = array('projectID' => $projectID, 'projectequipment' => $equipmentId, 'isDeleted' => '1', 'status' => '1');
        $this->db->from('tg_design_window');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getProjectDetails(){
        $this->db->select('p1.id, p1.project_no, p2.company_name, p3.name as manager, p1.equipment, p1.tag_number, p1.equip_qty, p1.po_date_time, p1.po_number, p1.del_date, p1.proj_comp_date, p1.act_desp_date, p1.isCompleted');
        $this->db->from('tg_project_detail as p1');
        $this->db->join('tg_client as p2','p2.id = p1.client'); 
        $this->db->join('tg_users as p3','p3.userId = p1.manager_name'); 
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->order_by('p1.id ASC'); 
        $query = $this->db->get();
 
        return $query->result_array();
    }

    public function get_project_equipment_name($equipmentId,$projectId)
    {   
        $this->db->select('equipment_name,equip_qty,tag_number');
        $this->db->from('tg_project_equipment');
        $this->db->where('projectID',$projectId);
        $this->db->where('equipment',$equipmentId);        
        $query = $this->db->get();
 
        return $query->row();
    }



    public function saveNotificationLog($data){
        $this->db->insert('tg_activity_notification_log',$data);
        return $this->db->insert_id();
    }

}

  