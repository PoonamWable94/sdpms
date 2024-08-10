<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Design_status extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('design_status_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Design Status';
        $data['dept'] = $this->design_status_model->get_department();
        $this->loadViews("master/design_master/design_status", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->design_status_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $design_status)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$design_status->id.'" >';
            $row[] = $no;
            $row[] = $design_status->design_status;
             
            if($design_status->status == 1)
                $status_class = "md-btn-success";
            else if($design_status->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($design_status->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$design_status->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $design_status->createdDtm;

            //add html for action
            $row[] = '
                
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$design_status->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$design_status->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->design_status_model->count_all(),
                        "recordsFiltered" => $this->design_status_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->design_status_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $design_status  = $this->input->post('status');
        $data   = array('design_status'     =>$design_status,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->design_status_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        $data['design_status'] = $this->input->post('status');
        $this->design_status_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->design_status_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->design_status_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if(trim($this->input->post('status')) == '')
        {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'status  is required';
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
        $this->design_status_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>