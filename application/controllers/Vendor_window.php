<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Vendor_window extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_window_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        // print_r($_GET['projectID']);exit;
        $data['projectID'] = $_GET['projectID'];
        $this->global['pageTitle'] = 'Vendor Window'; 
        $data['vendor_location'] = $this->vendor_window_model->get_locations(); 
        $data['vendor_name'] = $this->vendor_window_model->get_vendor_name(); 
        // $data['projects'] = $this->vendor_window_model->get_projects(); 
        $data['materail_description'] = $this->vendor_window_model->get_materail_description(); 
        $data['work_scope'] = $this->vendor_window_model->get_work_scope(); 
        // $data['client_list'] = $this->vendor_window_model->get_client_list();     
        $this->loadViews("master/vendor_master/vendor_window_list", $this->global, $data);
    }

    public function ajax_list()
    {
        $projectID = $_GET['projectID'];
        $list = $this->vendor_window_model->get_datatables($projectID);
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $location)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$location->id.'" >';
            $row[] = $no;             
            $row[] = $location->project_no;
            $row[] = $location->company_name;
            $row[] = $location->name;
            $row[] = $location->location;
            $row[] = $location->grade;
            $row[] = $location->description;            
            $row[] = $location->work;            
            $row[] = $location->qty;
            $row[] = $location->pending_qty;
            $row[] = $location->send_date;
            $row[] = $location->reqd_date;
            $row[] = $location->actual_rec_date;            
             
            if($location->status == 1)
                $status_class = "md-btn-success";
            else if($location->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($location->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$location->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';                                                 
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$location->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$location->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->vendor_window_model->count_all(),
                "recordsFiltered" => $this->vendor_window_model->count_filtered($projectID),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->vendor_window_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        // $this->_validate();  
        $projectID = $_POST['projectID'];
        // print_r($_POST);exit;
        $get_project_info = $this->vendor_window_model->get_project_info($projectID);   
        $job_no = $get_project_info->project_no;
        $client = $get_project_info->id;

        $data = array( 
            'projectID'         => $projectID,          
            'job_no'            => $job_no, 
            'client'            => $client,
            'vendor_name'       => $this->input->post('vendor_name'), 
            'location'          => $this->input->post('location'),
            'grade'             => $this->input->post('grade'), 
            'description'       => $this->input->post('description'),
            'qty'               => $this->input->post('qty'), 
            'work_scope'        => $this->input->post('work_scope'),
            'send_date'         => $this->input->post('send_date'), 
            'pending_qty'       => $this->input->post('pending_qty'),
            'reqd_date'         => $this->input->post('reqd_date'), 
            'actual_rec_date'   => $this->input->post('actual_rec_date'),                        
        );

        $insert = $this->vendor_window_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        // $this->_validate();        
        $data = array(                       
            'vendor_name'     => $this->input->post('vendor_name'), 
            'location'     => $this->input->post('location'),
            'grade'     => $this->input->post('grade'), 
            'description'     => $this->input->post('description'),
            'qty'     => $this->input->post('qty'), 
            'work_scope'     => $this->input->post('work_scope'),
            'send_date'     => $this->input->post('send_date'), 
            'pending_qty'     => $this->input->post('pending_qty'),
            'reqd_date'     => $this->input->post('reqd_date'), 
            'actual_rec_date'     => $this->input->post('actual_rec_date'),                
        );
        $this->vendor_window_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->vendor_window_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->vendor_window_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('job_no') == '')
        {
            $data['inputerror'][] = 'job_no';
            $data['error_string'][] = 'Job Number  is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('client') == '')
        {
            $data['inputerror'][] = 'client';
            $data['error_string'][] = 'client  is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('vendor_name') == '')
        {
            $data['inputerror'][] = 'vendor_name';
            $data['error_string'][] = 'vendor name  is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('location') == '')
        {
            $data['inputerror'][] = 'location';
            $data['error_string'][] = 'location is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('grade') == '')
        {
            $data['inputerror'][] = 'grade';
            $data['error_string'][] = 'grade is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('description') == '')
        {
            $data['inputerror'][] = 'description';
            $data['error_string'][] = 'description is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('qty') == '')
        {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'qty is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('work_scope') == '')
        {
            $data['inputerror'][] = 'work_scope';
            $data['error_string'][] = 'work scope  is required';
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
        $this->vendor_window_model->update_status($this->input->post('id'), $this->input->post('status'));
	}

    public function get_vendors(){ 
        $data = '';   
        $location = $_POST['location'];    
        $vendor_name = $this->vendor_window_model->get_vendor_name($location);                                     
         foreach($vendor_name as $list){             
             $data.= "<option value = '".$list->id."'>".$list->name."</option>";                                 
         } 
         echo json_encode($data);          
    }
}

?>