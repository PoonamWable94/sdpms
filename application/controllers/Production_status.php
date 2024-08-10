<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_Status extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_status_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Production Status';
       
        $this->loadViews("master/production_master/production_status", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->production_status_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $production_status)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$production_status->id.'" >';
            $row[] = $no;
            $row[] = $production_status->production_status;
             
            if($production_status->status == 1)
                $status_class = "md-btn-success";
            else if($production_status->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($production_status->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$production_status->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $production_status->createdDtm;

            //add html for action
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$production_status->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$production_status->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->production_status_model->count_all(),
                        "recordsFiltered" => $this->production_status_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->production_status_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $production_status  = $this->input->post('status');
        $data   = array('production_status'     =>$production_status,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->production_status_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        $data['production_status'] = $this->input->post('status');
        $this->production_status_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->production_status_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->production_status_model->delete_by_id($id);
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
        $this->production_status_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>