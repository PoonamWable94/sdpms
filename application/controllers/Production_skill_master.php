<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_skill_master extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_skill_master_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Production Skills';
        //$data['design_task'] = $this->production_skill_master_model->get_design_task();
        //print_r($data); die;
        $this->loadViews("master/production_master/production_skills_master", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->production_skill_master_model->get_datatables();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $skills)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$skills->id.'" >';
            $row[] = $no;
            $row[] = $skills->skills;
             
            if($skills->status == 1)
                $status_class = "md-btn-success";
            else if($skills->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($skills->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$skills->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $skills->createdOn;

            //add html for action
            $row[] = '
                
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->production_skill_master_model->count_all(),
                        "recordsFiltered" => $this->production_skill_master_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->production_skill_master_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $skill  = $this->input->post('skill');
        $data   = array(
                'skills'     =>$skill,                         
            );

        $insert = $this->production_skill_master_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        
        $data['skills'] = $this->input->post('skill');
        $this->production_skill_master_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->production_skill_master_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->production_skill_master_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if(trim($this->input->post('skill')) == '')
        {
            $data['inputerror'][] = 'skill';
            $data['error_string'][] = 'Skill  is required';
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function update_status()
	{
        $this->production_skill_master_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>