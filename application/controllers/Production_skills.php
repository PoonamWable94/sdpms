<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_skills extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_skills_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Production Activity & Skills';
        $data['production_task'] = $this->production_skills_model->get_production_task();
        $data["skillsList"] = $this->production_skills_model->get_production_skills_master();                
        
        $this->loadViews("master/production_master/production_skills", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->production_skills_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $skills)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$skills->id.'" >';
            $row[] = $no;
            $row[] = $skills->main_activity;
            $row[] = $skills->task_data;
            $row[] = $skills->skills;
             
            if($skills->status == 1)
                $status_class = "md-btn-success";
            else if($skills->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($skills->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$skills->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $skills->createdDtm;

            //add html for action
            $row[] = '
               
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->production_skills_model->count_all(),
                        "recordsFiltered" => $this->production_skills_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_add()
    {
        $this->_validate();  
        $skills = $this->input->post('skills'); 
        $getSkillName = $this->production_skills_model->get_skill_name($skills);

        $data   = array(
                    'task'              => $this->input->post('task'),
                    'activityId'        => $this->input->post('activityId'),
                    'skills'            => $getSkillName->skills,
                    'skill_master_id'   => $skills,                    
                );

        $insert = $this->production_skills_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->production_skills_model->get_by_id($id);
        echo json_encode($data);
    }     
 
    public function ajax_update()
    {
        $this->_validate();
        $skills = $this->input->post('skills'); 
        $getSkillName = $this->production_skills_model->get_skill_name($skills);

        $data   = array(
                    'task'              => $this->input->post('task'),
                    'activityId'        => $this->input->post('activityId'),
                    'skills'            => $getSkillName->skills,
                    'skill_master_id'   => $skills,                    
                );
        $this->production_skills_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->production_skills_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->production_skills_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('task') == '')
        {
            $data['inputerror'][] = 'task';
            $data['error_string'][] = 'Task  is required';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('activityId') == '')
        {
            $data['inputerror'][] = 'activityId';
            $data['error_string'][] = 'Activity is required';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('skills') == '')
        {
            $data['inputerror'][] = 'skills';
            $data['error_string'][] = 'Skills  is required';
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
        $this->production_skills_model->update_status($this->input->post('id'), $this->input->post('status'));
	}

    public function getTaskActivity(){ 
        $data = '';   
        $task = $_POST['task'];            

        $activitylist = $this->production_skills_model->get_task_activity($task);                                     
        foreach($activitylist as $activity){                        
            $data.= "<option value = '".$activity->id."'>".$activity->task_data."</option>"; 
        } 
       
        echo json_encode($data);          
    }

    public function getTaskActivity_edit(){ 
        $data = '';   
        $task = $_POST['task'];    
        $activityId = $_POST['activityId'];

        $activitylist = $this->production_skills_model->get_task_activity($task);                                     
        foreach($activitylist as $activity){ 
            if($activityId == $activity->id){
                $data.= "<option value = '".$activity->id."' selected=selected> ".$activity->task_data."</option>"; 
            }else{
                $data.= "<option value = '".$activity->id."'>".$activity->task_data."</option>"; 
            }                                
        }        
        echo json_encode($data);          
    }
}
?>