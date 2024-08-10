<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_assembly extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Production_assembly_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Production assembly Master';       
        $this->loadViews("master/production_master/production_assembly", $this->global, NULL , NULL);
    }

    public function ajax_list()
    {
        $list = $this->Production_assembly_model->get_datatables();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $assembly)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$assembly->id.'" >';
            $row[] = $no;
            $row[] = $assembly->assembly;
             
            if($assembly->status == 1)
                $status_class = "md-btn-success";
            else if($assembly->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($assembly->status? "Active" : "Passive");

            $row[] = '<i data='."'".$assembly->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $assembly->createdDtm;

            // <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('."'".$assembly->id."'".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
            $row[] = '                
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$assembly->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$assembly->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Production_assembly_model->count_all(),
                        "recordsFiltered" => $this->Production_assembly_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Production_assembly_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();        
        $data = array(
            'assembly' => $this->input->post('assembly'),            
        );

        $insert = $this->Production_assembly_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        $data['assembly'] = $this->input->post('assembly');
        $this->Production_assembly_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Production_assembly_model->delete_by_id($id);
        $this->Production_assembly_model->delete_by_id_assembly($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Production_assembly_model->delete_by_id($id);
            $this->Production_assembly_model->delete_by_id_assembly($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if(trim($this->input->post('assembly')) == '')
        {
            $data['inputerror'][] = 'assembly';
            $data['error_string'][] = 'Assembly Activity is required';
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }

    public function update_status()
	{
        $this->Production_assembly_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>