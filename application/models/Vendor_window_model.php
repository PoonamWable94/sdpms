<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_window_model extends CI_Model
{   
    var $table = 'tg_vendor_window';     
    
    var $column_order = array(null,'p4.project_no','p3.company_name','p7.name','p2.location','p1.grade','p5.description','p1.qty','p6.work','p1.send_date','p1.pending_qty','p1.reqd_date','p1.actual_rec_date','p1.status',null);
    var $column_search = array('p4.project_no','p3.company_name','p7.name','p2.location','p1.grade','p5.description', 'p6.work'); 
    var $order = array('id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($projectID)
    {   
        $this->db->select('p1.id, p1.grade, p1.qty, p1.pending_qty, p1.send_date, p1.reqd_date, p1.actual_rec_date, p1.status, p2.location, p3.company_name, p4.project_no, p5.description, p6.work, p7.name');                                      
        $this->db->from('tg_vendor_window as p1'); 
        $this->db->join('tg_vendor_location as p2','p2.id = p1.location');                 
        $this->db->join('tg_client as p3','p3.id = p1.client');                 
        $this->db->join('tg_project_detail as p4','p4.id = p1.projectID');                 
        $this->db->join('tg_vendor_material_desc as p5','p5.id = p1.description');                 
        $this->db->join('tg_vendor_work_scope as p6','p6.id = p1.work_scope');  
        $this->db->join('tg_vendor_name as p7','p7.id = p1.vendor_name');                 
        $this->db->where('p1.isDeleted','1'); 
        $this->db->where('p1.projectID',$projectID); 
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
 
    function get_datatables($projectID)
    {
        $this->_get_datatables_query($projectID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($projectID)
    {
        $this->_get_datatables_query($projectID);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {   
        $this->db->select('p1.id, p1.grade, p1.qty, p1.pending_qty, p1.send_date, p1.reqd_date, p1.actual_rec_date, p1.status, p2.location, p2.id as locationId, p3.company_name, p3.id as clientId, p4.project_no, p4.id as projectId, p5.description, p5.id as descId, p6.work, p6.id as workid, p7.name, p7.id as vendorId');                                      
        $this->db->from('tg_vendor_window as p1'); 
        $this->db->join('tg_vendor_location as p2','p2.id = p1.location');                 
        $this->db->join('tg_client as p3','p3.id = p1.client');                 
        $this->db->join('tg_project_detail as p4','p4.id = p1.projectID');                 
        $this->db->join('tg_vendor_material_desc as p5','p5.id = p1.description');                 
        $this->db->join('tg_vendor_work_scope as p6','p6.id = p1.work_scope');  
        $this->db->join('tg_vendor_name as p7','p7.id = p1.vendor_name');        
        $this->db->where('p1.id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_project_info($projectID){
        $this->db->select('p2.id, p1.project_no');
        $this->db->from('tg_project_detail as p1'); 
        $this->db->join('tg_client as p2','p2.id = p1.client'); 
        $this->db->where('p1.id',$projectID);
        $query = $this->db->get();
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table,$data);
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
            'isDeleted' => 0
        );
        $this->db->where('id', $id);
        $this->db->update($this->table,$data);
    }

    public function update_status($id,$status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    } 

    public function get_locations(){
        $this->db->select('id, location');
        $this->db->from('tg_vendor_location');
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);        
        $query = $this->db->get();        
        return $query->result();
    }  

    public function get_materail_description(){
        $this->db->select('id, description');
        $this->db->from('tg_vendor_material_desc');
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);        
        $query = $this->db->get();        
        return $query->result();
    }

    public function get_vendor_name(){
        $this->db->select('id, name');
        $this->db->from('tg_vendor_name');
        // $this->db->where('location', $id);
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);        
        $query = $this->db->get();        
        return $query->result();
    }

    public function get_work_scope(){
        $this->db->select('id, work');
        $this->db->from('tg_vendor_work_scope');
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);        
        $query = $this->db->get();        
        return $query->result();
    }  
}

  