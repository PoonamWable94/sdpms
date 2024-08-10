<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Quality_activity_data extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quality_activity_data_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Quality Activity Data';               
        $data["activityList"] = $this->quality_activity_data_model->get_activity_master();                     
        $this->loadViews("master/quality_master/activity_data", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->quality_activity_data_model->get_datatables();
    //   print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
            $row[] = $activity->activity;
            $row[] = $activity->activity_data;
            
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($activity->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$activity->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
            $row[] = $activity->createdOn;            
            $row[] = '                
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->quality_activity_data_model->count_all(),
                "recordsFiltered" => $this->quality_activity_data_model->count_filtered(),
                "data" => $data,
        );        
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {        
        $data = $this->quality_activity_data_model->get_by_id($id);
        // print_r($data); exit;
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        // print_r($_POST); exit;
        $this->_validate();                   
        $data = array(
                'activity_id'   =>  $this->input->post('activity_id'),
                'activity'      =>  $this->input->post('activity'),                
            );

        $insert = $this->quality_activity_data_model->save($data);             
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {       
        $this->_validate();
        $id = $this->input->post('id');

        $data = array(
            'activity_id'   =>  $this->input->post('activity_id'),
            'activity'      =>  $this->input->post('activity'),                
        );         

        $this->quality_activity_data_model->update(array('id' => $id), $data);                             
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->quality_activity_data_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->quality_activity_data_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('activity_id') == '')
        {
            $data['inputerror'][] = 'activity_id';
            $data['error_string'][] = 'activity master  is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('activity') == '')
        {
            $data['inputerror'][] = 'activity';
            $data['error_string'][] = 'activity  is required';
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
        $this->quality_activity_data_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>