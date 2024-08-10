<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Purchase_skills extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_skills_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Purchase Skills';
        $data['purchase_activity'] = $this->purchase_skills_model->get_purchase_activity();
        $this->loadViews("master/purchase_master/purchase_skills", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->purchase_skills_model->get_datatables();
       //print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $skills)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$skills->id.'" >';
            $row[] = $no;
             $row[] = $skills->purchase_activity;
            $row[] = $skills->skills;
             
            if($skills->status == 1)
                $status_class = "md-btn-success";
            else if($skills->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($skills->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$skills->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            $row[] = $skills->createdDtm;

            //add html for action
            $row[] = '
                
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$skills->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->purchase_skills_model->count_all(),
                        "recordsFiltered" => $this->purchase_skills_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->purchase_skills_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        $data   = $this->input->post();
       // print_r($data); die;
        $purchase_activity  = $this->input->post('activity');
        $skill  = $this->input->post('skills');
        $data   = array('purchase_activity'   =>$purchase_activity,
                         'skills'     =>$skill,
                         'status'     =>1,
                         'isDeleted'  =>0,
                         'createdDtm' =>date('Y-m-d H:i:s'),
                         'updatedDtm' =>'');

        $insert = $this->purchase_skills_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

        //$data = $this->input->post();
        $data['purchase_activity']  = $this->input->post('activity');
        $data['skills']  = $this->input->post('skills');
        $this->purchase_skills_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->purchase_skills_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->purchase_skills_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if(trim($this->input->post('skills')) == '')
        {
            $data['inputerror'][] = 'skills';
            $data['error_string'][] = 'Skills  is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('activity') == '')
        {
            $data['inputerror'][] = 'activity';
            $data['error_string'][] = 'Please select activity';
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
        $this->purchase_skills_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>