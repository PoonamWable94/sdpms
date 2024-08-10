<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Role extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('roles_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'User Role';        
        $this->loadViews("master/roles", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->roles_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $roles)
        {
            $no++;
            $row = array();
            // $row[] = '<input type="checkbox" class="data-check" value="'.$roles->roleId.'" >';
            // $row[] = $no;
            $row[] = $roles->roleId;
            $row[] = $roles->role;
                        
            if($roles->status == 1)
                $status_class = "md-btn-success";
            else if($roles->status == 0)
                $status_class = "md-btn";    

            $status = ($roles->status? "Active" : "Passive");

            $row[] = '<i data='."'".$roles->roleId."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $roles->createdDtm;

            //add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$roles->roleId."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->roles_model->count_all(),
                        "recordsFiltered" => $this->roles_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($roles_id)
    {
        $data = $this->roles_model->get_by_id($roles_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'role'   => $this->input->post('role'),
                );
        $insert = $this->roles_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data   = array(
            'role'   => $this->input->post('role'),
        );
        $this->roles_model->update(array('roleId' => $this->input->post('roleId')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->roles_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('roleId');
        foreach ($list_id as $id) {
            $this->roles_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if($this->input->post('role') == '')
        {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Roles is required';
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
        $this->roles_model->update_status($this->input->post('roleId'), $this->input->post('status'));
	}
}

?>