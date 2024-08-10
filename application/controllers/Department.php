<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Department extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('department_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Department';        
        $this->loadViews("master/department", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->department_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $dept)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$dept->dept_id.'" >';
             $row[] = $no;
          //  $row[] = $dept->dept_id;
            $row[] = $dept->dept_name;
                        
            if($dept->status == 1)
                $status_class = "md-btn-success";
            else if($dept->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($dept->status? "ACTIVE" : "INACTIVE");

            $row[] = '<i data='."'".$dept->dept_id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            //add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$dept->dept_id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$dept->dept_id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->department_model->count_all(),
                        "recordsFiltered" => $this->department_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($dept_id)
    {
        $data = $this->department_model->get_by_id($dept_id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'dept_name'   => $this->input->post('dept_name'),
                );
        $insert = $this->department_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data   = array(
            'dept_name'   => $this->input->post('dept_name'),
        );
        $this->department_model->update(array('dept_id' => $this->input->post('dept_id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->department_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id'); // Make sure this matches the key in the JS function
        foreach ($list_id as $id) {
            $this->department_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
    
 
    private function _validate()
{
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    // Get and trim the input
    $dept_name = trim($this->input->post('dept_name'));

    // Check if the trimmed input is empty
    if ($dept_name === '' || $dept_name === '0') {
        $data['inputerror'][] = 'dept_name';
        $data['error_string'][] = 'Department name is required';
        $data['status'] = FALSE;
    }

    // Return validation result as JSON
    if ($data['status'] === FALSE) {
        echo json_encode($data);
        exit();
    }
}

    public function update_status()
	{
        $this->department_model->update_status($this->input->post('dept_id'), $this->input->post('status'));
	}
}

?>