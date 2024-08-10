<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Vendor_work_scope extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_work_scope_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Vendor Work Scope';        
        $this->loadViews("master/vendor_master/vendor_work_scope_master", $this->global, NULL);
    }

    public function ajax_list()
    {
        $list = $this->vendor_work_scope_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $work)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$work->id.'" >';
            $row[] = $no;             
            $row[] = $work->work;
             
            if($work->status == 1)
                $status_class = "md-btn-success";
            else if($work->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($work->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$work->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
            $row[] = $work->createdOn;                                        
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$work->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$work->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->vendor_work_scope_model->count_all(),
                "recordsFiltered" => $this->vendor_work_scope_model->count_filtered(),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->vendor_work_scope_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $skill  = $this->input->post('work');
        $data   = array(            
                'work'     => $this->input->post('work'),                
            );

        $insert = $this->vendor_work_scope_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();        
        $data['work'] = $this->input->post('work');
        $this->vendor_work_scope_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->vendor_work_scope_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->vendor_work_scope_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('work') == '')
        {
            $data['inputerror'][] = 'work';
            $data['error_string'][] = 'work scope is required';
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
        $this->vendor_work_scope_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>