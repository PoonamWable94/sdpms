<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Live_projects_report extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();   
        $this->load->model("live_projects_report_model");        
    }
    
    public function index()
    {        
        $data['getLiveProjects'] = $this->live_projects_report_model->getLiveProjects();
        $this->global['pageTitle'] = 'Live Projects Report';   
        // echo '<pre>'; 
        // print_r($data);
        // exit;   
        $this->loadViews("reports/live_projects_report_list", $this->global, $data);
    }

    // public function getLiveProjects(){
    //     $getLiveProjects = $this->live_projects_report_model->$getLiveProjects();

    // }

}
?>