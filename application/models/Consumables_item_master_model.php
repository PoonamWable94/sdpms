<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Consumables_item_master_model extends CI_Model
{   
    var $table = 'tg_consumable_item_master';     
    
    var $column_order = array(null,'sub_group','main_group','item_name','unit','alternate_unit',null); //set column field database for datatable orderable
    var $column_search = array('sub_group','main_group','item_name','unit','alternate_unit'); //set column field database for datatable searchable just firstname , lastname , address are searchable 
    var $order = array('id' => 'asc');
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {           
        // $this->db->where('tg_department.status',1);
        // $this->db->select('sub_group_1_master.*, p1.main_group');  
        // $this->db->join('tg_main_group_master as p1','p1.id = sub_group_1_master.');
         $this->db->select('tg_consumable_item_master.*, p1.main_group,p2.sub_group');  
         $this->db->join('tg_main_group_master as p1','p1.id = tg_consumable_item_master.main_group_id');
         $this->db->join('sub_group_1_master as p2','p2.id = tg_consumable_item_master.sub_group_id');
        // $this->db->where('sub_group_1_master.isDeleted',1);
         $this->db->where('tg_consumable_item_master.isDeleted',1);
         $this->db->order_by('tg_consumable_item_master.id','DESC');
         
        $this->db->from($this->table);
       
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
            // $this->db->order_by('id','DESC');
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
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
    }
    // public function get_main_group()
    // {
    //     $this->db->from('sub_group_1_master');
    //     $this->db->where('isDeleted',1);
    //     $query = $this->db->get();
 
    //     return $query->result();
    // }

    public function get_main_group()
    {
        $this->db->from('tg_main_group_master');
        $this->db->where('isDeleted',1);
        $this->db->where('status',1);
        $query = $this->db->get();
 
        return $query->result();
       
    }
    public function get_sub_group()
    {
        $this->db->from('sub_group_1_master');
        $this->db->where('isDeleted',1);
        $this->db->where('status',1);
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

    public function get_subgroup_by_maingroup($main_group_id)
    {
        $this->db->select('id, sub_group');
        $this->db->from('sub_group_1_master');
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);
        $this->db->where('main_group_id', $main_group_id); // Assuming you have taluka_id column in tg_gaon table
        $query = $this->db->get();

        return $query->result();
    }


}

  