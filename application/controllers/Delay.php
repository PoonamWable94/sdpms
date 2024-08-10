<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Delay extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('delay_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Delay';
        $data['delay'] = $this->delay_model->get_delay();
         $data['projects'] = $this->delay_model->get_all_projects();
          $data['departments'] = $this->delay_model->get_all_departments();
        //print_r($data); die;
        $this->loadViews("delay/delay_list", $this->global, $data , NULL);
    }
    
    public function my_delay()
    {
        $this->global['pageTitle'] = 'Delay';
        $data['delay'] = $this->delay_model->get_delay();
         $data['projects'] = $this->delay_model->get_all_projects();
          $data['departments'] = $this->delay_model->get_all_departments();
        //print_r($data); die;
        $this->loadViews("delay/my_delay_list", $this->global, $data , NULL);
    }

    public function ajax_list()
    {
        $list = $this->delay_model->get_datatables();
        // print_r($list);
        // exit();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
             if(($activity->pass_on == '') && ($activity->action == '') ){
                 $color='display: inline;';
                }
            else{
                if($this->session->userdata('dept_name') == $activity->pass_on){
                  $color='display: inline;';   
                 }else{
                    $color='display: none;'; 
                 }
                 
            }
            // if($activity->action == ''){
            //      $color1='display: inline';
            //     }
            // else{
            //      $color1='display: none';
            // }
            
            $row[] = '
                <a href="javascript:void(0)" style='."'".$color."'".' data-uk-tooltip title="Pass On" onclick="edit_data('."'".$activity->id."'".')">Pass On</a> 
               
                <a href="javascript:void(0)" style='."'".$color."'".' id="logo" data-uk-tooltip title="Take Action" onclick="action_data('."'".$activity->id."'".')">Take Action</a> 
                
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> ' ;
                
            $row[] = $activity->delay;
            $row[] = $activity->projectNo;
            // $row[] = $activity->delay_time;
            $row[] = $activity->raised_by;
            $row[] = $activity->raised_on;
            $row[] = $activity->description;
            // $row[] = $activity->createdDtm;
            $row[] = $activity->pass_on;
            $row[] = $activity->action;
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn-danger";    
            else if($activity->status == 3){
                    if($this->session->userdata('dept_name') == $activity->pass_on){
                    $status_class = "md-btn-success";  
                    }else{
                  $status_class = "yellow";
                    }
                
            }
            $status = ($activity->status? "Active" : "Closed");

             $row[] = '<i data='."'".$activity->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

          //  $row[] = $activity->createdDtm;

            //add html for action
            // $row[] = '
                
                
                
                
            //     <a href="javascript:void(0)" id="logo" data-uk-tooltip title="Take Action" onclick="action_data('."'".$activity->id."'".')">Take Action</a> |
                
            //      ' ;
                
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->delay_model->count_all(),
                        "recordsFiltered" => $this->delay_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
    public function ajax_my_list()
    {
        $list = $this->delay_model->get_my_datatables();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $activity)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->id.'" >';
            $row[] = $no;
             if(($activity->pass_on == '') && ($activity->action == '') ){
                 $color='display: inline;';
                }
            else{
                 if($this->session->userdata('dept_name') == $activity->pass_on){
                  $color='display: inline;';   
                 }else{
                    $color='display: none;'; 
                 }
                 
            }
            
            $row[] = '
                
                
                <a href="javascript:void(0)" style='."'".$color."'".' data-uk-tooltip title="Pass On" onclick="edit_data('."'".$activity->id."'".')">Pass On</a> 
                 
                <a href="javascript:void(0)" style='."'".$color."'".' id="logo" data-uk-tooltip title="Take Action" onclick="action_data('."'".$activity->id."'".')">Take Action</a> 
                
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> ' ;
                
            $row[] = $activity->delay;
            $row[] = $activity->projectNo;
            // $row[] = $activity->delay_time;
            $row[] = $activity->raised_by;
            $row[] = $activity->raised_on;
            $row[] = $activity->description;
            // $row[] = $activity->createdDtm;
            $row[] = $activity->pass_on;
            $row[] = $activity->action;
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn-danger";    
            else if($activity->status == 3){
                    if($this->session->userdata('dept_name') == $activity->pass_on){
                    $status_class = "md-btn-success";  
                    }else{
                  $status_class = "yellow";
                    }
                
            }
            $status = ($activity->status? "Active" : "Closed");

             $row[] = '<i data='."'".$activity->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

          //  $row[] = $activity->createdDtm;

            //add html for action
            // $row[] = '
                
                
                
                
            //     <a href="javascript:void(0)" id="logo" data-uk-tooltip title="Take Action" onclick="action_data('."'".$activity->id."'".')">Take Action</a> |
                
            //      ' ;
                
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->delay_model->count_all(),
                        "recordsFiltered" => $this->delay_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
 
    public function ajax_edit($id)
    {
        $data = $this->delay_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();

        //$data   = $this->input->post();       
        $delay  = $this->input->post('delay');
        $projectNo  = $this->input->post('projectNo');
      //  $delay_time  = $this->input->post('delay_time');
        $raised_by  = $this->input->post('raised_by');
        $raised_by_person  = $this->input->post('raised_by_person');
        $raised_on  = $this->input->post('raised_on');
        $raised_on_person  = $this->input->post('raised_on_person');
        $description  = $this->input->post('description');
        $data   = array('delay'     =>$delay,
                        'projectNo'     =>$projectNo,
                        // 'delay_time'     =>$delay_time,
                        'raised_by'     =>$raised_by,
                        'raised_by_person'     =>$raised_by_person,
                        'raised_on'     =>$raised_on,
                        'raised_on_person'     =>$raised_on_person,
                        'description'     =>$description,
                        'status'     =>1,
                        'isDeleted'  =>0,
                        'createdDtm' =>date('Y-m-d H:i:s'),
                     );

        $insert = $this->delay_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();

      $this->delay_model->change_status($this->input->post('id'),'3');
      // $this->delay_model->change_token($this->input->post('id'),'3'); 
       // $data['delay'] = $this->input->post('delay');
        $data['pass_on'] = $this->input->post('pass_on');
        $data['pass_on_person'] = $this->input->post('pass_on_person');
        $this->delay_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
    
    public function ajax_take_action()
    {
        $this->_validate();
        
         $row= $this->delay_model->get_by_id($this->input->post('id'));
         $this->delay_model->update_status($this->input->post('id'), $this->input->post('status'));
        
        $data['action'] = $this->input->post('action');
        $data['complete_date'] = $this->input->post('complete_date');
        $data['responsible_person'] = $this->input->post('responsible_person');
       
        // $data['no_of_delay_days'] =  date('Y-m-d', strtotime($data['complete_date']))-date('Y-m-d', strtotime($row->createdDtm));
        // echo $data['no_of_delay_days'];
        $date1=date_create($row->createdDtm);
        $date2=date_create($data['complete_date']);
        $diff=date_diff($date1,$date2);
        $data['no_of_delay_days']= $diff->format("%a");
        $this->delay_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->delay_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->delay_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        // if($this->input->post('delay') == '')
        // {
        //     $data['inputerror'][] = 'delay';
        //     $data['error_string'][] = 'Delay  is required';
        //     $data['status'] = FALSE;
        // }
        // if($this->input->post('raised_by') == '')
        // {
        //     $data['inputerror'][] = 'raised_by';
        //     $data['error_string'][] = 'This is required field';
        //     $data['status'] = FALSE;
        // }
        
        // if($this->input->post('raised_on') == '')
        // {
        //     $data['inputerror'][] = 'raised_on';
        //     $data['error_string'][] = 'This is required field';
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
        $this->delay_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
	
	
}

?>