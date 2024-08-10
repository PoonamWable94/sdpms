<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Design_standerds_referred extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_master/design_standerds_referred_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Design Standard Referred';
        //$data['design_activity'] = $this->design_standerds_referred_model->get_design_activity();
        //print_r($data); die;
        $this->loadViews("master/project_master/design_standerd_referred", $this->global, NULL , NULL);
    }
    
    public function ajax_list()
    {
        $list = $this->design_standerds_referred_model->get_datatables();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
            $row[] = $activity->design_standerd_Referred;
             
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($activity->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$activity->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $activity->createdDtm;

            //add html for action
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->design_standerds_referred_model->count_all(),
                        "recordsFiltered" => $this->design_standerds_referred_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->design_standerds_referred_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $design_standerd_Referred  = $this->input->post('design_standerd_Referred');
        $data   = array('design_standerd_Referred'     =>$design_standerd_Referred,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->design_standerds_referred_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        
        $data['design_standerd_Referred'] = $this->input->post('design_standerd_Referred');
        $this->design_standerds_referred_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->design_standerds_referred_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->design_standerds_referred_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('design_standerd_Referred') == '')
        {
            $data['inputerror'][] = 'design_standerd_Referred';
            $data['error_string'][] = 'Design standerd is required';
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
        $this->design_standerds_referred_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>