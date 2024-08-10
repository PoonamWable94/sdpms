<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Customer extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Customer';        
        $this->loadViews("master/customer", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->Customer_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $sup)
        {
            $no++;
            $row = array();
             $row[] = '<input type="checkbox" class="data-check" >';
             $row[] = $no;
            // $row[] = $sup->id;
         
            $row[] = $sup->customer_name;
            $row[] = $sup->address;
            $row[] = $sup->state;
            $row[] = $sup->gst_no;
                        
            if($sup->status == 1)
                $status_class = "md-btn-success";
            else if($sup->status == 0)
                $status_class = "md-btn";    

            $status = ($sup->status? "Active" : "Passive");

            $row[] = '<i data='."'".$sup->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            //add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$sup->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$sup->id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Customer_model->count_all(),
                        "recordsFiltered" => $this->Customer_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Customer_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'customer_name'   => $this->input->post('customer_name'),
                    'address'   => $this->input->post('address'),
                    'state'   => $this->input->post('state'),
                    'gst_no'   => $this->input->post('gst_no'),

                    'createdDtm' => date('Y-m-d H:i:s'),
                );
        $insert = $this->Customer_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 

   

public function ajax_update()
    {
        $this->_validate();
        $data   = array(
            'customer_name'   => $this->input->post('customer_name'),
                    'address'   => $this->input->post('address'),
                    'state'   => $this->input->post('state'),
                    'gst_no'   => $this->input->post('gst_no'),

            'updatedDtm' => date('Y-m-d H:i:s') 
        );
        $this->Customer_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Customer_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Customer_model->delete_by_id($id);
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
            $data['error_string'][] = 'Customer name is required';
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
        $this->Customer_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>