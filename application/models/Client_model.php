<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model
{   
    var $table = 'tg_client';     
    
    var $column_order = array('company_name','job_no','address','area','phone_no','email','contact_persone_name','contact_persone_phone_no','contact_persone_email'); 
    var $column_search = array('company_name','job_no','address','area','phone_no','email','contact_persone_name','contact_persone_phone_no','contact_persone_email');  
    var $order = array('id' => 'DESC'); 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {           
        $this->db->select('*');
        $this->db->from($this->table);        
        $this->db->where('isDeleted',0);          
        // $this->db->where('status',1);       
               
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

    public function get_by_id($id)
    {   
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }   
  
    public function get_client_view($id){
        $this->db->select('*');
        $this->db->from($this->table);  
        $this->db->where('id',$id);                      
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
            'isDeleted' => 1
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
    
    public function save_client($client_id) {
        
        $data = array('client_id' => $client_id);
        $this->db->insert('tg_client_by_api', $data);
    }

    public function get_selected_client_id() {
        // Fetch the client ID from your table
        $query = $this->db->get('tg_client_by_api'); // Adjust table name as needed
        return $query->row_array(); // Adjust if your query returns more than one row
    }

}

  