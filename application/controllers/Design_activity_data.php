<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Design_activity_data extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('design_activity_data_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Design Activity Data';
        $data['design_activity'] = $this->design_activity_data_model->get_design_activity();
        //print_r($data); die;
        $this->loadViews("master/design_master/design_activity_data", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->design_activity_data_model->get_datatables();      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
            $row[] = $activity->design_activity;
            $row[] = $activity->activity_data;
            $timeHours = substr($activity->activity_time,0,2);
            $timeMinutes = substr($activity->activity_time,3,2);
            $row[] = $activity->activity_days.' days '.$timeHours.' hrs '.$timeMinutes.' min';

            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($activity->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$activity->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $activity->createdDtm;

            //add html for action
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
               
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->design_activity_data_model->count_all(),
                        "recordsFiltered" => $this->design_activity_data_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->design_activity_data_model->get_by_id($id);
       // print_r($data); die();
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        // print_r($_POST); exit;
        $this->form_validation->set_rules('activity','design_activity','required');        
		$this->form_validation->set_rules('activity_data','activity_data','required');
        $this->form_validation->set_rules('activity_days','Days','required');
        $this->form_validation->set_rules('activity_time','Time','required');	

        if($this->form_validation->run() == TRUE)     
        {                      
            $data = array(
                'design_activity'   =>  $this->input->post('activity'),
                'activity_data'     =>  trim($this->input->post('activity_data')),
                'activity_days'     =>  $this->input->post('activity_days'),
                'activity_time'     =>  $this->input->post('activity_time'),
            );
            
            $insert = $this->design_activity_data_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
        else{           
            $data['design_activity'] = $this->design_activity_data_model->get_design_activity();
            echo json_encode(array("status" => FALSE));
        }       
    }
 
    public function ajax_update()
    {
        $this->form_validation->set_rules('activity','design_activity','required');        
		$this->form_validation->set_rules('activity_data','activity_data','required');
        $this->form_validation->set_rules('activity_days','Days','required');
        $this->form_validation->set_rules('activity_time','Time','required');
        
        if($this->form_validation->run() == TRUE)     
        {                      
            $data = array(
                'design_activity'   =>  $this->input->post('activity'),
                'activity_data'     =>  $this->input->post('activity_data'),
                'activity_days'     =>  $this->input->post('activity_days'),
                'activity_time'     =>  $this->input->post('activity_time'),
            );
            
            $this->design_activity_data_model->update(array('id' => $this->input->post('id')), $data);
            echo json_encode(array("status" => TRUE));
        }
        else{           
            $data['design_activity'] = $this->design_activity_data_model->get_design_activity();
            echo json_encode(array("status" => FALSE));
        }                
    }
 
    public function ajax_delete($id)
    {
        $this->design_activity_data_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->design_activity_data_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }

    public function update_status()
	{
        $this->design_activity_data_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>