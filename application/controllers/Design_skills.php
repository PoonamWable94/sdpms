<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Design_skills extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('design_skills_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Design Skills';               
        $data["skillist"] = $this->design_skills_model->get_design_skill_master();        
        $data['design_activity'] = $this->design_skills_model->get_design_activity();        
        $this->loadViews("master/design_master/design_skills", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->design_skills_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $skills)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$skills->id.'" >';
            $row[] = $no;
             $row[] = $skills->activity_data;
            $row[] = $skills->skills;
            
            if($skills->status == 1)
                $status_class = "md-btn-success";
            else if($skills->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($skills->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$skills->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $skills->createdDtm;

            //add html for action
            // <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
            $row[] = '                
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->design_skills_model->count_all(),
                        "recordsFiltered" => $this->design_skills_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->design_skills_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $design_activity  = $this->input->post('activity');
        $skill_list  = $this->input->post('skills');        
        // echo '<pre>';        
        // print_r($skill_list);exit;

        foreach($skill_list as $key=>$value){
            // $commaIndex = strrpos($value,',');           
            // $beforecomma =  substr($value, 0,$commaIndex);
            // $aftercomma = substr($value,$commaIndex + 1); 
            $getSkillName = $this->design_skills_model->get_skill_name($value);

            $data = array(
                    'design_activity'   =>  $design_activity,
                    'skills'            =>  $getSkillName->skills,
                    'skill_master_id'   =>  $value,
            );
            $insert = $this->design_skills_model->save($data);
        }       
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        // print_r($_POST); exit;

        $this->_validate();
        $id = $this->input->post('id');

        $design_activity  = $this->input->post('activity');
        $skill_list  = $this->input->post('skills');        
        // echo '<pre>';        
        // print_r($skill_list[0]);exit;

        foreach($skill_list as $key=>$value){
            // $commaIndex = strrpos($value,',');           
            // $beforecomma =  substr($value, 0,$commaIndex);
            // $aftercomma = substr($value,$commaIndex + 1); 
            $getSkillName = $this->design_skills_model->get_skill_name($value);

            $data = array(
                    'design_activity'   =>  $design_activity,
                    'skills'            =>  $getSkillName->skills,
                    'skill_master_id'   =>  $value,
            );          
            $this->design_skills_model->update(array('id' => $id), $data);
            break;
        } 
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->design_skills_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->design_skills_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('skills') == '')
        {
            $data['inputerror'][] = 'skills';
            $data['error_string'][] = 'Skills  is required';
            $data['status'] = FALSE;
        }
        // if($this->input->post('dept') == '')
        // {
        //     $data['inputerror'][] = 'dept';
        //     $data['error_string'][] = 'Department name is required';
        //     $data['status'] = FALSE;
        // }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function update_status()
	{
        $this->design_skills_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>