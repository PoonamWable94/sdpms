<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    var $table = 'tg_employee';
    var $column_order = array(null, 'dept_name', 'skill', null); // set column field database for datatable orderable
    var $column_search = array('dept_name', 'skill'); // set column field database for datatable searchable 
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('tg_employee.*, p1.dept_name, p2.skill');
        $this->db->join('tg_department as p1', 'p1.dept_id = tg_employee.dept_id');
        $this->db->join('tg_skill as p2', 'p2.id = tg_employee.skill_id');
        $this->db->where('tg_employee.isDeleted', 1);
        $this->db->from('tg_employee');
        $this->db->order_by('tg_employee.id', 'DESC');

        $i = 0;
        foreach ($this->column_search as $item)
        {
            if ($_POST['search']['value'])
            {
                if ($i === 0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order']))
        {
            $column_index = $_POST['order']['0']['column'];
            $column_dir = $_POST['order']['0']['dir'];
            // Check if the column index exists in the column_order array
            if (isset($this->column_order[$column_index]))
            {
                $this->db->order_by($this->column_order[$column_index], $column_dir);
            }
            else
            {
                $this->db->order_by('id', 'DESC');
            }
        }
        else if (isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()e
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
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
        $this->db->where('isDeleted', 1);
        return $this->db->count_all_results();
    }

    public function get_dept()
    {
        $this->db->from('tg_department');
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_skill()
    {
        $this->db->from('tg_skill');
        $this->db->where('isDeleted', 1);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }


    public function get_by_id($id)
    {
        $this->db->select('tg_employee.*, p1.dept_name, p2.skill');
        $this->db->join('tg_department as p1', 'p1.dept_id = tg_employee.dept_id');
        $this->db->join('tg_skill as p2', 'p2.id = tg_employee.skill_id');
        $this->db->from($this->table);
        $this->db->where('tg_employee.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

  
    public function delete_by_id($id)
    {
        $data = array('isDeleted' => 0);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        $data = array('status' => $status);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }
    
}

?>

  