<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_material_status_model extends CI_Model
{   
    public function __construct(){
        parent::__construct();
    }

    var $table = 'tg_purchase_window';         
    var $column_order = array(null,null,'p1.projectNo','p1.client','p1.projectequipment','p1.tag_number', 'p1.tag_no', 'p1.description', 'p1.tech_req', 'p1.stock', 'p1.po_release_date', 'p1.actual_po_date', 'p1.quality_remark', 'p1.release_for_prod', 'p1.mtc', null);
    var $column_search = array('p1.projectNo','p1.client','p1.projectequipment','p1.tag_number', 'p1.tag_no', 'p1.description', 'p1.tech_req', 'p1.stock', 'p1.po_release_date', 'p1.actual_po_date', 'p1.quality_remark', 'p1.release_for_prod', 'p1.mtc'); 
    var $order = array('p1.sort_order' => 'asc');
 
    private function _get_datatables_query()
    {          
        $this->db->select('p1.*');
        // $this->db->select('p1.*, p3.equipment, p4.company_name');

        $this->db->from('tg_purchase_window as p1');
        // $this->db->join('tg_purchase_activity_data as p2','p2.id = p1.activity');        
        // $this->db->join('tg_equipment as p3','p3.id = p1.projectequipment');
        // $this->db->join('tg_client as p4','p4.id = p1.client');
        
        $this->db->where('p1.isDeleted',1);
        // $this->db->where('p1.projectID',$projectID);               

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

        if($this->input->post('projects_id'))
        {
            $projects_id = $this->input->post('projects_id');
            $this->db->where('p1.projectID',$projects_id);   
                    
        }
    }
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
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

    // public function get_by_id($id)
    // {   
    //     $this->db->from($this->table);
    //     $this->db->where('id',$id);
    //     $query = $this->db->get();
 
    //     return $query->row();
    // }   
  
    // public function get_client_view($id){
    //     $this->db->select('*');
    //     $this->db->from($this->table);  
    //     $this->db->where('id',$id);                      
    //     $query = $this->db->get();
 
    //     return $query->row();
    // }  
 
    // public function save($data)
    // {

    //     $this->db->insert($this->table,$data);
    //     return $this->db->insert_id();
    // }   
 
    // public function update($where, $data)
    // {       
    //     $this->db->update($this->table, $data, $where);
    //     return $this->db->affected_rows();
    // }
 
    // public function delete_by_id($id)
    // {
    //     $data = array( 
    //         'isDeleted' => 1
    //     );
    //     $this->db->where('id', $id);
    //     $this->db->update($this->table,$data);
    // }

    // public function update_status($id,$status)
    // {
    //     $data['status'] = $status;
    //     $this->db->where('id', $id);
    //     $this->db->update($this->table, $data);
    // }       

}

  