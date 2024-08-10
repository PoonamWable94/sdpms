<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Access_control_model extends CI_Model
{   
    var $table = 'tg_dept_access';     
    
    var $column_order = array('tg_dept_access.accessID', 'role.role', 'tg_dept_access.design', 'tg_dept_access.purchase','tg_dept_access.production', 'tg_dept_access.quality'); 
    var $column_search = array('tg_dept_access.accessID','role.role', 'tg_dept_access.design', 'tg_dept_access.purchase','tg_dept_access.production', 'tg_dept_access.quality'); 
    var $order = array('accessID' => 'ASC'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {   
        $this->db->select('tg_dept_access.accessID, role.role, tg_dept_access.design, tg_dept_access.purchase, tg_dept_access.production, tg_dept_access.quality');         
        $this->db->join('tg_roles as role','role.roleId = tg_dept_access.roleID');
        $this->db->where('tg_dept_access.status',1);
        $this->db->where('role.status',1);           
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
        $this->db->where('status',1);
        return $this->db->count_all_results();
    }
    public function get_department_access()
    {
        $this->db->from($this->table);
        $this->db->where('status',1);        
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_by_access($accessID)
    {   
        $this->db->from('tg_dept_access');
        $this->db->join('tg_roles as role','role.roleId = tg_dept_access.roleID');
        $this->db->where('tg_dept_access.accessID',$accessID);
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
 
    public function delete_by_id($accessID)
    {
        $data = array( 
            'status' => 0
        );

        $this->db->where('accessID', $accessID);
        $this->db->update($this->table,$data);
    }

    public function update_status($accessID,$status)
    {
        $data['status'] = $status;
        $this->db->where('accessID', $accessID);
        $this->db->update($this->table, $data);
    } 

    public function get_user_roles()
    {   
        $this->db->select('tg_roles.role, tg_roles.roleId');
        $this->db->from('tg_roles');
        $this->db->join('tg_dept_access as dept','dept.roleId <> tg_roles.roleID');        
        $this->db->where('dept.status',1);  
        $this->db->where('tg_roles.status',1);  
        $this->db->where('tg_roles.roleId <>',1);        
        
        $query = $this->db->get();
 
        return $query->result();
    }

}

  