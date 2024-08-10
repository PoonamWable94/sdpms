<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Semi_Finish_Good_model extends CI_Model
{   
    var $table = 'tg_semi_finish_good';     
    
    var $column_order = array(null,'fg.fg_name','sfg_name',null); //set column field database for datatable orderable
    var $column_search = array('sfg_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable 
    var $order = array('id' => 'desc');
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {           
        $this->db->select('sfg.*, fg.fg_name');
        $this->db->from('tg_semi_finish_good as sfg');         
        $this->db->join('tg_finish_good as fg','fg.id = sfg.fg_id');
        $this->db->where('sfg.isDeleted',1);
        // $this->db->from($this->table);
       
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
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
    }
    public function get_semi_finish_good()
    {
        $this->db->from('tg_semi_finish_good');
        $this->db->where('isDeleted',1);
        $this->db->where('status',1);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_semi_finish_goods_by_fg_id($fg_id)
    {
        $this->db->select('sfg_name');
        $this->db->where('fg_id', $fg_id);
        $query = $this->db->get('tg_semi_finish_good');

        if ($query->num_rows() > 0) {
            return $query->row()->sfg_name; // Assuming there's only one sfg_name per fg_id
        }
        return ''; // Return empty string if no semi finish goods found
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


}

  