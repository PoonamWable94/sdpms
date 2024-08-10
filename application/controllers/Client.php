<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Client extends BaseController
{
    public function __construct()
    {
        parent::__construct();
       // $this->load->library('curl');
        $this->load->model('client_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Add New Client';   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Add New Client';        
        $this->loadViews("client/list_client", $this->global);
    } 
    
    // public function fetch_clients() {
    //     $url = 'https://192.168.1.10/pms/client/get_clients';
    //     $response = $this->curl->simple_get($url);
    //     $clients = json_decode($response, true);

    //     print_r($clients); die();

    //     // Process clients as needed
    //     $data['clients'] = $clients;
    //     $this->load->view('clients_index', $data);
    // }


    // public function select_client(){
    //     if (empty($this->clients)) {
    //         show_error('No client data available.');
    //         return;
    //     }

    //     // Pass client data to the view
    //     $data['clients'] = $this->clients;
    //     $this->load->view('client/client_api', $data);

    // }

    
    public function fetch_clients() {
        $username = "admin";
        $password = "1234";
        $apikey = "konarkGlobal";

        // create & initialize a curl session
        $curl = curl_init();

        // print_r($curl); die();

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        CURL_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        CURL_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        CURL_setopt($curl, CURLOPT_HTTPHEADER, array("X-API-KEY: ". $apikey));
        CURL_setopt($curl, CURLOPT_USERPWD, "$username:$password");
        

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, "https://techgarnerworks.in/pms_temp/konarkqualitycheck/api/Pms_project_details/api_client_datatables");
        // curl_exec() executes the started curl session
        // $output contains the output string
        $response = curl_exec($curl);
        // (deletes the variable made by curl_init)
        curl_close($curl);

       // print_r($response);

       // return $response;    
       // Check for cURL errors
       if ($response === false || !empty($curl_error)) {
           show_error('cURL Error: ' . $curl_error);
       } else {
           // Check if there are hidden characters or issues
           $response = trim($response);
           // Decode JSON response
           $clients = json_decode($response, true);
   
           // Check for JSON decoding errors
           if (json_last_error() !== JSON_ERROR_NONE) {
               show_error('JSON Error: ' . json_last_error_msg());
           }

        //    $this->select_client();
   
           // Process clients as needed
           $data['clients'] = $clients;
           $this->load->view('client/client_api', $data);
       }
    }

    public function save_selected_client() {
        // Load necessary models
        $this->load->model('client_model');
    
        // Get selected client ID from POST data
        $selected_client_id = $this->input->post('client_id');
    
        // Validate the selected client ID
        if (empty($selected_client_id)) {
            show_error('No client selected.');
            return;
        }
    
        // Save the selected client ID to the database
        $this->client_model->save_client($selected_client_id);
        
    }


    public function fetch_and_display_client_details() {
        // Load necessary models
        $this->load->model('client_model');
        
        // Get the selected client ID from the database
        $client_id_data = $this->client_model->get_selected_client_id();
      //  print_r($client_id_data); die();
        if (empty($client_id_data)) {
            show_error('No client ID found.');
            return;
        }
        
        $client_id = $client_id_data['client_id']; // Adjust key if needed

        //print_r($client_id); die();
        
        $username = "admin";
        $password = "1234";
        $apikey = "konarkGlobal";
    
        // Initialize cURL session
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apikey));
        curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($curl, CURLOPT_URL, 'https://techgarnerworks.in/pms_temp/konarkqualitycheck/api/Pms_project_details/api_client?id=' . urlencode($client_id));
       
        
        // Execute cURL session
        $response = curl_exec($curl);

       // print_r($response); die();
    
        // Check for cURL errors
        if ($response === false) {
            $curl_error = curl_error($curl);
            curl_close($curl);
            show_error('cURL Error: ' . $curl_error);
            return;
        }
    
        curl_close($curl);
        
        // Trim and decode JSON response
        $response = trim($response);
        $client_details = json_decode($response, true);
    
        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            show_error('JSON Error: ' . json_last_error_msg());
            return;
        }
    
        // Print response for debugging
      // print_r($client_details);
    
        // Check if client details are empty
        if (empty($client_details)) {
            show_error('No data found for the specified client ID.');
            return;
        }
    
        // Pass client details to view
        $data['client'] = $client_details;
        $this->load->view('client/client_details_by_api', $data);
    }


   
    public function ajax_list()
    {
        $list = $this->client_model->get_datatables();
    //    echo'<pre>'; print_r($list); die;
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $lists)
        {
            $edit = base_url('client/edit_data/').$lists->id;

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
                $status_class = "md-btn-danger";    

            $status = ($lists->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$lists->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
           
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('.$lists->id.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                <a href='."'".$edit."'".' data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$lists->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';
            

            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->client_model->count_all(),
                    "recordsFiltered" => $this->client_model->count_filtered(),
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

            $lastInsertId = $this->client_model->save($data);
                                                          
            redirect(base_url('client'));            
        }
    }

    public function edit_data($id)
    {    
        $data['pdata'] = $this->client_model->get_by_id($id);          
        $this->loadViews('client/edit_client',$this->global, $data,NULL);                      
    }

    public function view_data($id)
    {              
        $data = $this->client_model->get_client_view($id);                            
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
            $data['pdata'] = $this->client_model->get_by_id($pid);                               
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
            
            $this->client_model->update(array('id' => $pid), $data);                            
            redirect(base_url('client'));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->client_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->client_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }     

    public function update_status()
	{
        $this->client_model->update_status($this->input->post('id'), $this->input->post('status'));
	}   

}

?>