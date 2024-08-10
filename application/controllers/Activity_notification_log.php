<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Activity_notification_log extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Activity_notification_log_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Add New Activity';   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Add New Activity';        
        $this->loadViews("activity/list_activity", $this->global);
    }   
 
    public function ajax_list()
    {
        $list = $this->Activity_notification_log_model->get_datatables();
    //    echo'<pre>'; print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $lists)
        {
            $edit = base_url('Activity_notification_log/edit_data/').$lists->id;

            $no++;
            $row = array();
            // $equipmentList1 = $tag_number = '';
            // $row[] = '<input type="checkbox" class="data-check" value="'.$lists->id.'" >';
            $row[] = $no;
            $row[] = $lists->company_name;                                                          
            // $row[] = $lists->job_no;
            $row[] = $lists->area;                        
            $row[] = $lists->phone_no;
            $row[] = $lists->email;
            $row[] = $lists->contact_persone_name;           
            // $row[] = $lists->contact_persone_phone_no;
            // $row[] = $lists->contact_persone_email;

            if($lists->status == 1)
                $status_class = "md-btn-success";
            else if($lists->status == 0)
                $status_class = "md-btn";    

            $status = ($lists->status? "Active" : "Passive");

            $row[] = '<i data='."'".$lists->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
           
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('.$lists->id.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                <a href='."'".$edit."'".' data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$lists->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';
            

            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Activity_notification_log_model->count_all(),
                    "recordsFiltered" => $this->Activity_notification_log_model->count_filtered(),
                    "data" => $data,
                );        
        echo json_encode($output);
    }
      
    public function add_acitivity()
    {    

        // print_r($_POST); exit;                 
        $this->form_validation->set_rules('company_name','Company Name','required');
        $this->form_validation->set_rules('address','Company Address','required');
        $this->form_validation->set_rules('area','Area','required');
        // $this->form_validation->set_rules('job_no','Job No','required');
        $this->form_validation->set_rules('phone_no','Phone No','required');
        $this->form_validation->set_rules('email','Email Id','required');
        $this->form_validation->set_rules('contact_persone_name','Person Name','required');
        // $this->form_validation->set_rules('contact_persone_phone_no','Contact Person Phone No','required');
        // $this->form_validation->set_rules('contact_persone_email','Contact Person Email Id','required');        
                
        if($this->form_validation->run() == false)
        {              
                      
            $this->loadViews("activity/add_acitivity", $this->global, NULL);
        }
        else{ 
           
            $data = array(
                        'company_name'  => $this->input->post('company_name'),                        
                        'address'  => $this->input->post('address'),
                        'area'      => $this->input->post('area'),
                        // 'job_no'      => $this->input->post('job_no'),
                        'phone_no'        => $this->input->post('phone_no'),                        
                        'email'   => $this->input->post('email'),  
                        'contact_persone_name'   => $this->input->post('contact_persone_name'),  
                        // 'contact_persone_phone_no'      => $this->input->post('contact_persone_phone_no'),                                            
                        // 'contact_persone_email'      => $this->input->post('contact_persone_email'),                                            
                    );

            $lastInsertId = $this->Activity_notification_log_model->save($data);
                                                          
            redirect(base_url('Activity_notification_log'));            
        }
    }

    public function edit_data($id)
    {    
        $data['pdata'] = $this->Activity_notification_log_model->get_by_id($id);          
        $this->loadViews('Activity_notification_log/edit_activity',$this->global, $data,NULL);                      
    }

    public function view_data($id)
    {              
        $data = $this->Activity_notification_log_model->get_activity_view($id);                            
        echo json_encode($data);              
    }
 
    public function update_activity()
    {
        $pid = $_POST['id'];
        $this->form_validation->set_rules('company_name','Company Name','required');
        $this->form_validation->set_rules('address','Company Address','required');
        $this->form_validation->set_rules('area','Area','required');
        // $this->form_validation->set_rules('job_no','Job No','required');
        $this->form_validation->set_rules('phone_no','Phone No','required');
        $this->form_validation->set_rules('email','Email Id','required');
        $this->form_validation->set_rules('contact_persone_name','Person Name','required');
        // $this->form_validation->set_rules('contact_persone_phone_no','Contact Person Phone No','required');
        // $this->form_validation->set_rules('contact_persone_email','Contact Person Email Id','required'); 
        
        if($this->form_validation->run() == false)
        {                  
            $data['pdata'] = $this->Activity_notification_log_model->get_by_id($pid);                               
            $this->loadViews("Activity_notification_log/edit_activity", $this->global, $data , NULL);
        }
        else{                  

            $data = array(
                        'company_name'  => $this->input->post('company_name'),                        
                        'address'  => $this->input->post('address'),
                        'area'      => $this->input->post('area'),
                        // 'job_no'      => $this->input->post('job_no'),
                        'phone_no'        => $this->input->post('phone_no'),                        
                        'email'   => $this->input->post('email'),  
                        'contact_persone_name'   => $this->input->post('contact_persone_name'),  
                        // 'contact_persone_phone_no'      => $this->input->post('contact_persone_phone_no'),                                            
                        // 'contact_persone_email'      => $this->input->post('contact_persone_email'),
                    );
            
            $this->Activity_notification_log_model->update(array('id' => $pid), $data);                            
            redirect(base_url('Activity_notification_log'));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->Activity_notification_log_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Activity_notification_log_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }     

    public function update_status()
	{
        $this->Activity_notification_log_model->update_status($this->input->post('id'), $this->input->post('status'));
	}   

}

?>