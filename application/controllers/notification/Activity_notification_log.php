<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Activity_notification_log extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notification/Activity_notification_log_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Activity Notification List';
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Activity Notification List';        
        $this->loadViews("notification/activity_notification_log_listing", $this->global);

        // $roll = $this->Activity_notification_log_model->get_datatables();
        
    } 
    
    

    public function ajax_list() {
        $this->load->model('Activity_notification_log_model');
        $list = $this->Activity_notification_log_model->get_datatables();
    
        $data = array();
        $no = $_POST['start'];
    
        foreach ($list as $lists) {
            $no++;
            $row = array();
            $row[] = $no;

            if($lists->notification_type == 1){//new project add
                $row[] = $lists->new_projectNo; 
                $row[] = $lists->new_projectNo;
            }elseif($lists->notification_type == 2){//design activity add
                $row[] = $lists->projectNo_add; 
                $row[] = $lists->noti_name_add;
            }elseif($lists->notification_type == 3){//design activity update
                $row[] = $lists->projectNo_update; 
                $row[] = $lists->noti_name_update;
            }elseif($lists->notification_type == 4){//production component add
                $row[] = $lists->projectNo_pac; 
                $row[] = $lists->noti_name_pac;
            }elseif($lists->notification_type == 5){ //production assembl add
                $row[] = $lists->projectNo_aas; 
                $row[] = $lists->noti_name_aas;
            }elseif($lists->notification_type == 6){ //production compnent activity update
                $row[] = $lists->projectNo_puc; 
                $row[] = $lists->noti_name_puc;
            }elseif($lists->notification_type == 7){ //production compnent activity update
                $row[] = $lists->projectNo_uas; 
                $row[] = $lists->noti_name_uas;
            }elseif($lists->notification_type == 9){ //purchase update bom
                $row[] = $lists->projectNo_ub; 
                $row[] = $lists->noti_name_ub;
            }
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
    
    
      
    public function add_client()
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
                      
            $this->loadViews("client/add_client", $this->global, NULL);
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
                                                          
            redirect(base_url('client'));            
        }
    }

    public function edit_data($id)
    {    
        $data['pdata'] = $this->Activity_notification_log_model->get_by_id($id);          
        $this->loadViews('client/edit_client',$this->global, $data,NULL);                      
    }

    public function view_data($id)
    {              
        $data = $this->Activity_notification_log_model->get_client_view($id);                            
        echo json_encode($data);              
    }
 
    public function update_client()
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
            $this->loadViews("client/edit_client", $this->global, $data , NULL);
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
            redirect(base_url('client'));
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