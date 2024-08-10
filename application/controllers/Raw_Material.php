<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Raw_Material extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Raw_Material_model');
        $this->load->model('Semi_Finish_Good_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Semi Finish Good';    
        $data['semi_finish_good'] = $this->Semi_Finish_Good_model->get_semi_finish_good(); 
       // print_r($data); die();   
        $this->loadViews("master/product/raw_material", $this->global, $data, NULL , NULL );
    }

    public function ajax_list()
    {
        $list = $this->Raw_Material_model->get_datatables();
      // print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $rm)
        {
            $no++;
            $row = array();
             $row[] = '<input type="checkbox" class="data-check" value="'.$rm->id.'" >';
             $row[] = $no;
             $row[] = $rm->sfg_name;
             $row[] = $rm->rm_name;
                        
            if($rm->status == 1)
                $status_class = "md-btn-success";
            else if($rm->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($rm->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$rm->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $dept->createdDtm;

            // add html for action
            $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$rm->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_data('.$rm->id.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Raw_Material_model->count_all(),
                        "recordsFiltered" => $this->Raw_Material_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Raw_Material_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data   = array(
                    'sfg_id' => $this->input->post('sfg_name'),
                    'rm_name'   => $this->input->post('rm_name'),
                    'createdDtm' => date('Y-m-d H:i:s'),
                );
        $insert = $this->Raw_Material_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
        {
            $this->_validate();
            $data   = array(
                'sfg_id' => $this->input->post('sfg_name'),
                'rm_name'   => $this->input->post('rm_name'),
                'updatedDtm' => date('Y-m-d H:i:s') 
            );
            $this->Raw_Material_model->update(array('id' => $this->input->post('id')), $data);
            echo json_encode(array("status" => TRUE));
        }
    
        public function ajax_delete($id)
        {
            $this->Raw_Material_model->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        }
    
        public function ajax_bulk_delete()
        {
            $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->Raw_Material_model->delete_by_id($id);
            }
            echo json_encode(array("status" => TRUE));
        }
    
        private function _validate()
        {
            $data = array();
            $data['error_string'] = array();
            $data['inputerror'] = array();
            $data['status'] = TRUE;

            if($this->input->post('sfg_name') == '' || $this->input->post('sfg_name') == '0')
            {
                $data['inputerror'][] = 'sfg_name';
                $data['error_string'][] = 'Semi Finish Good is required';
                $data['status'] = FALSE;
            }
            
            if(trim($this->input->post('rm_name')) == '')
            {
                $data['inputerror'][] = 'rm_name';
                $data['error_string'][] = 'Raw Material is required';
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
            $this->Raw_Material_model->update_status($this->input->post('id'), $this->input->post('status'));
        }
    }

?>