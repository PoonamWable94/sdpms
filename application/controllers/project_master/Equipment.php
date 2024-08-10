<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Equipment extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_master/equipment_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Equipments';
        //$data['design_activity'] = $this->equipment_model->get_design_activity();
        //print_r($data); die;
        $this->loadViews("master/project_master/list_of_equipment", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->equipment_model->get_datatables();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
            $row[] = $activity->equipment;
             
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
                        "recordsTotal" => $this->equipment_model->count_all(),
                        "recordsFiltered" => $this->equipment_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->equipment_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $equipment  = $this->input->post('equipment');
        $data   = array('equipment'     =>$equipment,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->equipment_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        
        $data['equipment'] = $this->input->post('equipment');
        $this->equipment_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->equipment_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->equipment_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('equipment') == '')
        {
            $data['inputerror'][] = 'equipment';
            $data['error_string'][] = 'Equipment  is required';
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
        $this->equipment_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>