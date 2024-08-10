<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Semi_Finish_Good extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semi_Finish_Good_model');
        $this->load->model('Finish_Good_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Semi Finish Good';    
        $data['finish_good'] = $this->Finish_Good_model->get_finish_good(); 
       // print_r($data); die();   
        $this->loadViews("master/product/semi_Finish_Good", $this->global, $data, NULL , NULL );
    }

    public function ajax_list()
    {
        $list = $this->Semi_Finish_Good_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $sfg)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$sfg->id.'" >';
             $row[] = $no;
             $row[] = $sfg->fg_name;
             $row[] = $sfg->sfg_name;
                        
            if($sfg->status == 1)
                $status_class = "md-btn-success";
            else if($sfg->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($sfg->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$sfg->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            // add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$sfg->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$sfg->id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Semi_Finish_Good_model->count_all(),
                        "recordsFiltered" => $this->Semi_Finish_Good_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Semi_Finish_Good_model->get_by_id($id);
        //print_r($data); die();
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'fg_id' => $this->input->post('fg_name'),
                    'sfg_name'   => $this->input->post('sfg_name'),
                    'createdDtm' => date('Y-m-d H:i:s'),
                );
        $insert = $this->Semi_Finish_Good_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 

   

public function ajax_update()
    {
        $this->_validate();
        $data   = array(
            'fg_id' => $this->input->post('fg_name'),
            'sfg_name'   => $this->input->post('sfg_name'),
            'updatedDtm' => date('Y-m-d H:i:s') 
        );
        $this->Semi_Finish_Good_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Semi_Finish_Good_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Semi_Finish_Good_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if($this->input->post('fg_name') == '' || $this->input->post('fg_name') == '0')
        {
            $data['inputerror'][] = 'fg_name';
            $data['error_string'][] = 'Finish Good is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('sfg_name') == '')
        {
            $data['inputerror'][] = 'sfg_name';
            $data['error_string'][] = 'Semi Finish Good model name is required';
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
        $this->Semi_Finish_Good_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>