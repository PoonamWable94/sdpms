<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Production_assembly_skills_model extends CI_Model
{   
    var $table = 'tg_production_assembly_skills';     

    var $column_order = array(null,'p2.assembly','p3.assembly_activity','p1.skills','p1.status',null);
    var $column_search = array('p2.assembly','p3.assembly_activity','p1.skills','p1.status'); 
    var $order = array('p1.id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {   
        $this->db->select('p1.id, p1.assembly, p1.activityId, p1.skills, p1.status, p1.createdDtm, p2.assembly as main_activity, p3.assembly_activity');
        $this->db->from('tg_production_assembly_skills as p1'); 
        $this->db->join('tg_production_assembly as p2','p2.id = p1.assembly'); //activity
        $this->db->join('tg_production_sub_assembly as p3','p3.id = p1.activityId'); //sub activity        
        $this->db->where('p1.isDeleted',0);
        
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
    public function get_production_assembly_list()
    {
        $this->db->from('tg_production_assembly');
        $this->db->where('status',1);
        $this->db->where('isDeleted',1);
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

    public function get_task_activity($assembly_id)
    {   
        $this->db->from('tg_production_sub_assembly');
        $this->db->where('assembly_id',$assembly_id);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_production_skills_master()
    {
        $this->db->from('tg_production_skill_master');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_skill_name($id)
    {   
        $this->db->select('skills');
        $this->db->from('tg_production_skill_master');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

}

  