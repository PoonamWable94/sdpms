<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Skill extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Skill_model');
        $this->load->model('Employee_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $data['dept_name'] = $this->Employee_model->get_dept();
        $this->global['pageTitle'] = 'Skill';        
        $this->loadViews("master/skill", $this->global, $data,NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->Skill_model->get_datatables();
    //    print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $ski)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$ski->id.'" >';
            $row[] = $no;
            $row[] = $ski->dept_name;
            $row[] = $ski->skill;
                        
            if($ski->status == 1)
                $status_class = "md-btn-success";
            else if($ski->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($ski->status? "ACTIVE" : "INACTIVE");

            $row[] = '<i data='."'".$ski->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            //add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$ski->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$ski->id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Skill_model->count_all(),
                        "recordsFiltered" => $this->Skill_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Skill_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'dept_id'   => $this->input->post('dept_id'),
                    'skill'   => $this->input->post('skill'),
                    'createdDtm' => date('Y-m-d h:i:s')
                );
        $insert = $this->Skill_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data   = array(
            'dept_id'   => $this->input->post('dept_id'),
            'skill'   => $this->input->post('skill'),
            'updatedDtm' => date('Y-m-d h:i:s')
        );
        $this->Skill_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Skill_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
{
    $list_id = $this->input->post('id');
    foreach ($list_id as $id) {
        $this->Skill_model->delete_by_id($id);
    }
    echo json_encode(array("status" => TRUE));
}
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if(trim($this->input->post('dept_id')) == '0')
        {
            $data['inputerror'][] = 'dept_id';
            $data['error_string'][] = 'Department name is required';
            $data['status'] = FALSE;
        }
        
        // Retrieve and trim the input
        $skill = trim($this->input->post('skill'));
    
        // Check if the trimmed input is '0'
        if ($skill === '0' || $skill === '') {
            $data['inputerror'][] = 'skill';
            $data['error_string'][] = 'Skill is required';
            $data['status'] = FALSE;
        }
    
        // Return JSON response if validation fails
        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    

    public function update_status()
	{
        $this->Skill_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>