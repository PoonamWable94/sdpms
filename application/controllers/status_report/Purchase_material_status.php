<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Purchase_material_status extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('client_model');
        $this->load->model('status_report_model/Purchase_material_status_model');

        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Purchase Report';   
    }
    
    public function index()
    {
        $data['project_list'] = $this->Purchase_material_status_model->getProjectDetails();

        $this->global['pageTitle'] = 'Purchase Report';        
        $this->loadViews("status_report_view/purchase_material_status_listing.php", $this->global, $data);
    }   

    public function ajax_list()
    {
        $list = $this->Purchase_material_status_model->get_datatables();
        // print_r($list);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $lists)
        {
            
            $no++;
            $row = array();
            // $equipmentList1 = $tag_number = '';
            $row[] = '<input type="checkbox" class="data-check" value="'.$lists->activityID.'" >';
            $row[] = $no;
            $row[] = $lists->projectNo; 
            $row[] = $lists->description;                      
            $row[] = $lists->tech_req;                        
            $row[] = $lists->material_reqd_prod;                        
                                   
            // $row[] = 'MOC';
            // $row[] = 'Status';
            // $row[] = 


            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Purchase_material_status_model->count_all(),
                    "recordsFiltered" => $this->Purchase_material_status_model->count_filtered(),
                    "data" => $data,
                );        
        echo json_encode($output);
    }
      
//     public function add_client()
//     {    

//         // print_r($_POST); exit;                 
//         $this->form_validation->set_rules('company_name','Company Name','required');
//         $this->form_validation->set_rules('address','Company Address','required');
//         $this->form_validation->set_rules('area','Area','required');
//         // $this->form_validation->set_rules('job_no','Job No','required');
//         $this->form_validation->set_rules('phone_no','Phone No','required');
//         $this->form_validation->set_rules('email','Email Id','required');
//         $this->form_validation->set_rules('contact_persone_name','Person Name','required');
//         // $this->form_validation->set_rules('contact_persone_phone_no','Contact Person Phone No','required');
//         // $this->form_validation->set_rules('contact_persone_email','Contact Person Email Id','required');        
                
//         if($this->form_validation->run() == false)
//         {              
                      
//             $this->loadViews("client/add_client", $this->global, NULL);
//         }
//         else{ 
           
//             $data = array(
//                         'company_name'  => $this->input->post('company_name'),                        
//                         'address'  => $this->input->post('address'),
//                         'area'      => $this->input->post('area'),
//                         // 'job_no'      => $this->input->post('job_no'),
//                         'phone_no'        => $this->input->post('phone_no'),                        
//                         'email'   => $this->input->post('email'),  
//                         'contact_persone_name'   => $this->input->post('contact_persone_name'),  
//                         // 'contact_persone_phone_no'      => $this->input->post('contact_persone_phone_no'),                                            
//                         // 'contact_persone_email'      => $this->input->post('contact_persone_email'),                                            
//                     );

//             $lastInsertId = $this->client_model->save($data);
                                                          
//             redirect(base_url('client'));            
//         }
//     }

//     public function edit_data($id)
//     {    
//         $data['pdata'] = $this->client_model->get_by_id($id);          
//         $this->loadViews('client/edit_client',$this->global, $data,NULL);                      
//     }

//     public function view_data($id)
//     {              
//         $data = $this->client_model->get_client_view($id);                            
//         echo json_encode($data);              
//     }
 
//     public function update_client()
//     {
//         $pid = $_POST['id'];
//         $this->form_validation->set_rules('company_name','Company Name','required');
//         $this->form_validation->set_rules('address','Company Address','required');
//         $this->form_validation->set_rules('area','Area','required');
//         // $this->form_validation->set_rules('job_no','Job No','required');
//         $this->form_validation->set_rules('phone_no','Phone No','required');
//         $this->form_validation->set_rules('email','Email Id','required');
//         $this->form_validation->set_rules('contact_persone_name','Person Name','required');
//         // $this->form_validation->set_rules('contact_persone_phone_no','Contact Person Phone No','required');
//         // $this->form_validation->set_rules('contact_persone_email','Contact Person Email Id','required'); 
        
//         if($this->form_validation->run() == false)
//         {                  
//             $data['pdata'] = $this->client_model->get_by_id($pid);                               
//             $this->loadViews("client/edit_client", $this->global, $data , NULL);
//         }
//         else{                  

//             $data = array(
//                         'company_name'  => $this->input->post('company_name'),                        
//                         'address'  => $this->input->post('address'),
//                         'area'      => $this->input->post('area'),
//                         // 'job_no'      => $this->input->post('job_no'),
//                         'phone_no'        => $this->input->post('phone_no'),                        
//                         'email'   => $this->input->post('email'),  
//                         'contact_persone_name'   => $this->input->post('contact_persone_name'),  
//                         // 'contact_persone_phone_no'      => $this->input->post('contact_persone_phone_no'),                                            
//                         // 'contact_persone_email'      => $this->input->post('contact_persone_email'),
//                     );
            
//             $this->client_model->update(array('id' => $pid), $data);                            
//             redirect(base_url('client'));
//         }
//     }
 
//     public function ajax_delete($id)
//     {
//         $this->client_model->delete_by_id($id);
//         echo json_encode(array("status" => TRUE));
//     }
 
//     public function ajax_bulk_delete()
//     {
//         $list_id = $this->input->post('id');
//         foreach ($list_id as $id) {
//             $this->client_model->delete_by_id($id);
//         }
//         echo json_encode(array("status" => TRUE));
//     }     

//     public function update_status()
// 	{
//         $this->client_model->update_status($this->input->post('id'), $this->input->post('status'));
// 	}   

}

?>