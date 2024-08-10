<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Vendor_master extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_master_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Vendor Master';        
        $this->loadViews("master/vendor_master/vendor_master", $this->global, NULL);
    }

    public function ajax_list()
    {
        $list = $this->vendor_master_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $operation)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$operation->id.'" >';
            $row[] = $no;             
            $row[] = $operation->operation;
             
            if($operation->status == 1)
                $status_class = "md-btn-success";
            else if($operation->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($operation->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$operation->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
            $row[] = $operation->createdOn;                                        
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$operation->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$operation->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->vendor_master_model->count_all(),
                "recordsFiltered" => $this->vendor_master_model->count_filtered(),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->vendor_master_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $skill  = $this->input->post('operation');
        $data   = array(            
                'operation'     => $this->input->post('operation'),                
            );

        $insert = $this->vendor_master_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();        
        $data['operation'] = $this->input->post('operation');
        $this->vendor_master_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->vendor_master_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->vendor_master_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('operation') == '')
        {
            $data['inputerror'][] = 'operation';
            $data['error_string'][] = 'operation  is required';
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
        $this->vendor_master_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>