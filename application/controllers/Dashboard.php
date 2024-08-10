<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();   
        $this->load->model("dashboard_model");
    }

    public function index()
    {
       $this->global['pageTitle'] = 'Konark Project Management System';

       $data["clientCount"] = $this->dashboard_model->get_client_count();
       $data["totalProjects"] = $this->dashboard_model->get_total_projects_count();
       $data["totalCompletedProjects"] = $this->dashboard_model->get_total_completed_projects_count();
       $data["totalLiveProjects"] = $this->dashboard_model->get_total_live_projects_count();
       $data["currentProjects"] = $this->dashboard_model->get_live_projects();       
       $this->loadViews("user/dashboard", $this->global, $data, NULL);
    }
}
?>