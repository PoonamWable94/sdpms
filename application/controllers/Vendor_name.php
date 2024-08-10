<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Vendor_name extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_name_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Vendors'; 
        $data['vendor_location'] = $this->vendor_name_model->get_locations();     
        $this->loadViews("master/vendor_master/vendor_name_master", $this->global, $data);
    }

    public function ajax_list()
    {
        $list = $this->vendor_name_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $location)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$location->id.'" >';
            $row[] = $no;             
            $row[] = $location->name;
            $row[] = $location->location;
             
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
                "recordsTotal" => $this->vendor_name_model->count_all(),
                "recordsFiltered" => $this->vendor_name_model->count_filtered(),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->vendor_name_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();        
        $data = array(            
            'name'     => $this->input->post('name'), 
            'location'     => $this->input->post('location'),                
        );

        $insert = $this->vendor_name_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();        
        $data = array(            
            'name'     => $this->input->post('name'), 
            'location'     => $this->input->post('location'),                
        );
        $this->vendor_name_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->vendor_name_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->vendor_name_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('name') == '')
        {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Vendor name  is required';
            $data['status'] = FALSE;
        }

        // if($this->input->post('location') == '')
        // {
        //     $data['inputerror'][] = 'location';
        //     $data['error_string'][] = 'location  is required';
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
        $this->vendor_name_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>