<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Delay_model extends CI_Model
{   
    var $table = 'tg_delay';     
    
    var $column_order = array(null,'id','delay','projectNo','raised_by','raised_on','description','createdDtm','pass_on','status',null); //set column field database for datatable orderable
    var $column_search = array('id','delay','projectNo','raised_by','raised_on','description','pass_on','status','createdDtm'); //set column field database for datatable searchable just firstname , lastname , address are searchable 
    var $order = array('id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {   
        $this->db->select('tg_delay.id,tg_delay.delay,tg_delay.projectNo,tg_delay.raised_by,tg_delay.raised_on,tg_delay.description,tg_delay.pass_on,tg_delay.action,tg_delay.status');
       $this->db->join('tg_project_detail as project','project.id = tg_delay.projectNo');
        $this->db->where('tg_delay.isDeleted',0);
         
        $this->db->from($this->table);   
        
        
       if($this->input->post('project_No')){
           $this->db->where('projectNo',$this->input->post('project_No'));
       }
       
       if($this->input->post('dept_name')){
           $this->db->where('tg_delay.raised_on',$this->input->post('dept_name'));
       }
 
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
    
     function get_my_datatables()
    {
         $name = $this->session->userdata('uname');        
        $dept_name = $this->session->userdata('dept_name'); 
        if($dept_name !="Admin"){
         $this->db->where('raised_on',$dept_name);
          $this->db->or_where('pass_on',$dept_name);
        //  $data = array('raised_on' => $dept_name, 'pass_on' => $dept_name);
        //  $this->db->where($data);
        }
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
    public function get_delay()
    {
        $this->db->from('tg_delay');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
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
    
    public function get_all_projects()
    {
        $this->db->select('id,project_no');
        $this->db->from('tg_project_detail');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
       // $this->db->where('isCompleted',0);
       $this->db->order_by('id','desc');
        $query = $this->db->get();
 
        return $query->result();
    }
    
    public function get_all_departments()
    {
        $this->db->select('dept_id,dept_name');
        $this->db->from('tg_department');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $this->db->order_by('dept_id','asc');
        $query = $this->db->get();
 
        return $query->result();
    }
    
    public function change_status($id,$status){
        $this->db->set('status', $status);
        $this->db->where('id', $id);    
        $this->db->update('tg_delay');   
    }
    
    public function change_token($id,$token){
        $this->db->set('token', $token);
        $this->db->where('id', $id);    
        $this->db->update('tg_delay');   
    }


}

  