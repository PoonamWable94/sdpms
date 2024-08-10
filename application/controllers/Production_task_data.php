<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_task_data extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_task_data_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Design Activity Data';
        $data['production_task'] = $this->production_task_data_model->get_production_task();
        $data['get_production_sub_activity_array'] = $this->production_task_data_model->get_production_sub_activity();
        
        //print_r($data); die;
        $this->loadViews("master/production_master/task_data", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->production_task_data_model->get_datatables();
        
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
            $row[] = $activity->task;
            $row[] = $activity->task_data;            
            // $row[] = '<input type="text" id="activity_order-'.$activity->id.'" name="activity_order[]" value="'.$activity->activity_order.'" class="numberOnly" style="width:40px;">';
            
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($activity->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$activity->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $activity->createdDtm;

            //add html for action
            $row[] = '
               
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->production_task_data_model->count_all(),
                        "recordsFiltered" => $this->production_task_data_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->production_task_data_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $task  = $this->input->post('task');
        $task_data  = $this->input->post('task_data');
        $data   = array('task'     =>$task,
                         'task_data'     =>$task_data,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->production_task_data_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        
        $data['task'] = $this->input->post('task');
        $data['task_data'] = $this->input->post('task_data');
        $this->production_task_data_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->production_task_data_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->production_task_data_model->delete_by_id($id);
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
            $data['error_string'][] = 'Task is required';
            $data['status'] = FALSE;
        }
        if(trim($this->input->post('task_data')) == '')
        {
            $data['inputerror'][] = 'task_data';
            $data['error_string'][] = 'Task data is required';
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
        $this->production_task_data_model->update_status($this->input->post('id'), $this->input->post('status'));
	}

    public function reorderSubActivity(){
        // print_r($_POST); exit;
        // print_r(count($_POST['activity_id']));
        if(isset($_POST['activity_id']) && !empty($_POST['activity_id'])){
            for($i=0; $i < count($_POST['activity_id']); $i++){
                // print_r($_POST['order_value'][$i]);
                $id = $_POST['activity_id'][$i];
                $activity_order = $_POST['order_value'][$i];
                $this->production_task_data_model->update_activity_order($id, $activity_order);
            }
            echo 1;
        }else{
            echo 0;
        }
    }
}

?>