<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Main_group_master extends BaseController
{
    public function __construct()
    {
        parent::__construct();
         $this->load->model('Main_group_master_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Main Group Master';        
        $this->loadViews("master/inventory_master/main_group_master", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->Main_group_master_model->get_datatables();
        //print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $fg)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$fg->id.'" >';
            $row[] = $no;
           // $row[] = $fg->id;
            $row[] = $fg->main_group;
                        
            if($fg->status == 1)
                $status_class = "md-btn-success";
            else if($fg->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($fg->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$fg->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            //add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$fg->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$fg->id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Main_group_master_model->count_all(),
                        "recordsFiltered" => $this->Main_group_master_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Main_group_master_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'main_group'   =>$this->input->post('main_group'),
                    'createdDtm' => date('Y-m-d h:i:s')
                );
        $insert = $this->Main_group_master_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data   = array(
            'main_group'   =>$this->input->post('main_group'),
            'updatedDtm' => date('Y-m-d h:i:s')
        );
        $this->Main_group_master_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Main_group_master_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Main_group_master_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if(trim($this->input->post('main_group')) == '')
        {
            $data['inputerror'][] = 'main_group';
            $data['error_string'][] = 'main_group name is required';
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
        $this->Main_group_master_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
 }

?>