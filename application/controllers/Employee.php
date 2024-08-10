<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Employee extends BaseController
{
    public function __construct()
    {
        parent::__construct();
         $this->load->model('Employee_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Employee Group Master';
        $data['dept_name'] = $this->Employee_model->get_dept();
        $data['skill'] = $this->Employee_model->get_skill();
        $this->loadViews("master/employee", $data, $this->global, NULL, NULL);
    }
    

    public function ajax_list()
    {
        $list = $this->Employee_model->get_datatables();
        // print_r($list); 
        // die();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $emp)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$emp->id.'" >';
            $row[] = $no;
           
            $row[] = $emp->dept_name;
            $row[] = $emp->skill;
            $row[] = $emp->employee;
            $row[] = $emp->email;
            $row[] = $emp->phone;
            
                        
            if($emp->status == 1)
               $status_class = "md-btn-success";
             else if($emp->status == 0)
              $status_class = "md-btn-danger";    

                  $status = ($emp->status ? "Active" : "Inactive");

                      $row[] = '<i data="'.$emp->id.'" class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            //add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$emp->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$emp->id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Employee_model->count_all(),
                        "recordsFiltered" => $this->Employee_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Employee_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'dept_id'   => $this->input->post('dept_id'),
                    'skill_id'   => $this->input->post('skill_id'),
                    'employee'   => $this->input->post('employee'),
                    'email'   => $this->input->post('email'),
                    'phone'   => $this->input->post('phone'),
                    'createdDtm' => date('Y-m-d h:i:s')
                );
        $insert = $this->Employee_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data   = array(
               'dept_id'   => $this->input->post('dept_id'),
                    'skill_id'   => $this->input->post('skill_id'),
                    'employee'   => $this->input->post('employee'),
                    'email'   => $this->input->post('email'),
                    'phone'   => $this->input->post('phone'),
            'updatedDtm' => date('Y-m-d h:i:s')
        );
        $this->Employee_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Employee_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Employee_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if(trim($this->input->post('dept_id')) == '0')
        {
            $data['inputerror'][] = 'dept_id';
            $data['error_string'][] = 'Department name is required';
            $data['status'] = FALSE;
        }
        if(trim($this->input->post('skill_id')) == ''|| $this->input->post('skill_id') == '0')
        {
            $data['inputerror'][] = 'skill_id';
            $data['error_string'][] = 'skill name is required';
            $data['status'] = FALSE;
        }
        if(trim($this->input->post('employee'))== '')
        {
            $data['inputerror'][] = 'employee';
            $data['error_string'][] = 'employee name is required';
            $data['status'] = FALSE;
        }
        if(trim($this->input->post('email'))== '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }
        if(trim($this->input->post('phone'))== '')
        {
            $data['inputerror'][] = 'phone';
            $data['error_string'][] = 'Phone No is required';
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
        $this->Employee_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
 }

?>