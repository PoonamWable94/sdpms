<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Purchase_material_master extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_material_leadtime_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Purchase Status';
        $data['dept'] = $this->purchase_material_leadtime_model->get_department();
        $this->loadViews("master/purchase_master/material_master", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->purchase_material_leadtime_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $material)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$material->id.'" >';
            $row[] = $no;
            $row[] = $material->material;
             
            if($material->status == 1)
                $status_class = "md-btn-success";
            else if($material->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($material->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$material->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $material->createdDtm;

            //add html for action
            $row[] = '
               
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$material->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$material->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->purchase_material_leadtime_model->count_all(),
                        "recordsFiltered" => $this->purchase_material_leadtime_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->purchase_material_leadtime_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();
       
        $material  = $this->input->post('material');
        $data   = array('material'     =>$material,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->purchase_material_leadtime_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        $data['material'] = $this->input->post('material');
        $this->purchase_material_leadtime_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->purchase_material_leadtime_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->purchase_material_leadtime_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if(trim($this->input->post('material')) == '')
        {
            $data['inputerror'][] = 'material';
            $data['error_string'][] = 'material  is required';
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
        $this->purchase_material_leadtime_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>