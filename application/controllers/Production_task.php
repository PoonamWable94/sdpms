<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_task extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_task_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Production Task';
        //$data['design_task'] = $this->production_task_model->get_design_task();
        //print_r($data); die;
        $this->loadViews("master/production_master/production_task", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->production_task_model->get_datatables();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $task)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$task->id.'" >';
            $row[] = $no;
            $row[] = $task->task;
             
            if($task->status == 1)
                $status_class = "md-btn-success";
            else if($task->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($task->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$task->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $task->createdDtm;

            //add html for action
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$task->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$task->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->production_task_model->count_all(),
                        "recordsFiltered" => $this->production_task_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->production_task_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $task  = $this->input->post('task');
        $data   = array('task'     =>$task,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->production_task_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        
        $data['task'] = $this->input->post('task');
        $this->production_task_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->production_task_model->delete_by_id($id);
        $this->production_task_model->delete_by_id_sub_activity($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->production_task_model->delete_by_id($id);
            $this->production_task_model->delete_by_id_sub_activity($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if(trim($this->input->post('task')) == '')
        {
            $data['inputerror'][] = 'task';
            $data['error_string'][] = 'Task  is required';
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
        $this->production_task_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>