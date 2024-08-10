<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_client_count()
    {
        $this->db->from('tg_client');
        $this->db->where('status', 1);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();       
    }

    public function get_total_projects_count()
    {
        $this->db->from('tg_project_detail');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_total_completed_projects_count()
    {
        $this->db->from('tg_project_detail');
        $this->db->where('isCompleted', 1);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_total_live_projects_count()
    {
        $this->db->from('tg_project_detail');
        $this->db->where('isCompleted', 0);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_live_projects(){
        $this->db->select('id, project_no, designProjectStartDate,designProjectEndDate,purchaseProjectStartDate, purchaseProjectEndDate,productionProjectStartDate, productionProjectEndDate, designActualStartDate, designActualEndDate, purchaseActualStartDate, purchaseActualEndDate, productionActualStartDate, productionActualEndDate');
        $this->db->from('tg_project_detail');
        $this->db->where('isCompleted', 0);
        $this->db->where('isDeleted', 0);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }

     // public function get_client_count()
    // {
    //     $this->db->select('client_id');
    //     $this->db->from('tg_common_lead');
    // //    $this->db->where('status', 0);  // Assuming status 1 means active
    //     // $this->db->where('isDeleted', 0);  // Assuming isDeleted 0 means not deleted
    //     $this->db->group_by('client_id');  // Group by client_id to get distinct clients
    //     $query = $this->db->get();
    //     return $query->num_rows();       
    // }
}
?>