<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    var $table = 'tg_supplier';     
    var $column_order = array(null, null, 'supplier_name', 'address', 'state', 'gst_no', 'status');
    var $column_search = array('supplier_name', 'address', 'state', 'gst_no'); //set column field database for datatable searchable
    
    var $order = array('id' => 'asc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->where('tg_supplier.isDeleted', 1);
        $this->db->from($this->table);

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
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if (isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
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
        $this->db->where('isDeleted', 0);
        return $this->db->count_all_results();
    }

    public function get_supplier()
    {
        $this->db->from('tg_supplier');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
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
        $data = array(
            'isDeleted' => 0
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }
}
?>
