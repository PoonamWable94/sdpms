<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Accesscontrol extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('access_control_model');
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'Konark PMS- Access Control';
    }
    
    public function index()
    {   
        $data['users'] = $this->access_control_model->get_user_roles();        
        $data['department_access'] = $this->access_control_model->get_department_access();
        $this->loadViews("user/access_control_list", $this->global, $data, NULL);
    }

    public function dept_access_list(){

        $list = $this->access_control_model->get_datatables();  
        // $list = json_decode(json_encode($list), true);  

        // print_r($list);  
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $control)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$control->accessID.'" >';
            $row[] = $no;
            $row[] = $control->role;  
            if($control->design == 1) { $row[] = 'Yes';     }else { $row[] = 'No';  }
            if($control->purchase == 1) { $row[] = 'Yes';     }else { $row[] = 'No';  }
            if($control->production == 1) { $row[] = 'Yes';     }else { $row[] = 'No';  }
            if($control->quality == 1) { $row[] = 'Yes';     }else { $row[] = 'No';  }                             
             
            // if($control->status == 1)
            //     $status_class = "md-btn-primary";
            // else if($control->status == 0)
            //     $status_class = "md-btn-danger";    

            // $status = ($control->status? "Active" : "Passive");
            // $row[] = '<i data='."'".$control->accessID."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
            
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="View" onclick="edit_data('."'".$control->accessID."', 1 ".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                        <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$control->accessID."', 0".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                        <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$control->accessID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';
            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->access_control_model->count_all(),
                "recordsFiltered" => $this->access_control_model->count_filtered(),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }

    public function view_dept_access_control($accessID)
    {
        $accessList = $this->access_control_model->get_by_access($accessID);        
        echo json_encode($accessList);
    }

    public function update_dept_access_control(){
        $accessID = $_POST['accessID'];

        if(isset($_POST['design']) && $_POST['design'] == 1) { $data['design'] = 1; } else { $data['design'] = 0; }
        if(isset($_POST['purchase']) && $_POST['purchase'] == 1) { $data['purchase'] = 1; } else { $data['purchase'] = 0; }
        if(isset($_POST['production']) && $_POST['production'] == 1) { $data['production'] = 1; } else { $data['production'] = 0; }
        if(isset($_POST['quality']) && $_POST['quality'] == 1) { $data['quality'] = 1; } else { $data['quality'] = 0; }       

        $this->access_control_model->update(array('accessID' => $accessID), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_dept_access($accessID){
        $this->access_control_model->delete_by_id($accessID);
        echo json_encode(array("status" => TRUE));
    }

    public function bulk_delete_dept_access()
    {
        $list_id = $this->input->post('accessID');
        foreach ($list_id as $accessID) {
            $this->access_control_model->delete_by_id($accessID);
        }
        echo json_encode(array("status" => TRUE));
    }

    public function add_user(){
        // print_r($_POST);die();
        if(isset($_POST['userroleID']) && $_POST['userroleID'] > 0){
            $userroleID = $_POST['userroleID'];
            $data = array( 'roleID' => $userroleID, );

            $insert = $this->access_control_model->save($data);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }        
    }

}