<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Name_of_document extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('name_of_document_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Name Of Document';
      $this->loadViews("master/quality_master/name_of_document", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->name_of_document_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $quality_status)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$quality_status->id.'" >';
            $row[] = $no;
            $row[] = $quality_status->name_doc;
             
            if($quality_status->status == 1)
                $status_class = "md-btn-success";
            else if($quality_status->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($quality_status->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$quality_status->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $quality_status->createdDtm;

            //add html for action
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('."'".$quality_status->id."'".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$quality_status->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$quality_status->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->name_of_document_model->count_all(),
                        "recordsFiltered" => $this->name_of_document_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->name_of_document_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $name_doc  = $this->input->post('name_doc');
        $data   = array('name_doc'     =>$name_doc,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->name_of_document_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        $data['name_doc'] = $this->input->post('name_doc');
        $this->name_of_document_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->name_of_document_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->name_of_document_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('name_doc') == '')
        {
            $data['inputerror'][] = 'name_doc';
            $data['error_string'][] = 'Name Document  is required';
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
        $this->name_of_document_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>