<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }
   
    public function index()
    {
        $this->isLoggedIn();
    }
    
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            // $status = 'session_expire';
                // setFlashData($status, "Session has been expire.. please login again..");
            $this->load->view('user/login');
        }
        else
        {
            redirect('dashboard');
        }
    }
        
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('uname', 'User Name', 'required|trim');
        // $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $uname = strtolower($this->security->xss_clean($this->input->post('uname')));
            // $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($uname, $password);

            if(!empty($result))
            {
                $lastLogin = $this->login_model->lastLoginInfo($result->userId);

                // for department wise user access
                $design = $purchase = $production = $quality = 0;

                $roleInfo = $this->login_model->departmentUserAccessInfo($result->roleId);
                $design = $roleInfo->design;
                $purchase = $roleInfo->purchase;
                $production = $roleInfo->production;
                $quality = $roleInfo->quality;
                $vendor = $roleInfo->vendor;

                $sessionArray = array(
                    'userId'=>$result->userId, 
                    'uname'=>$result->uname,                    
                    'role'=>$result->roleId,
                    'dept'=>$result->dept_id,
                    'roleText'=>$result->role,
                    'dept_name'=>$result->dept_name,
                    'name'=>$result->name,
                    'isLoggedIn' => TRUE,
                    'design_dept_access' => $design,
                    'purchase_dept_access' => $purchase,
                    'production_dept_access' => $production,
                    'quality_dept_access' => $quality,
                    'vendor_dept_access' => $vendor,
                );
                
                $role= $sessionArray['role'];              
                if(isset($lastLogin->createdDtm)){
                    $sessionArray['lastLogin'] = $lastLogin->createdDtm;    
                }
                
                $this->session->set_userdata($sessionArray);

                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

                $loginInfo = array("userId"=>$result->userId, "uname"=>$result->uname, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());

                $this->login_model->lastLogin($loginInfo);
              
                //if($role ==2){
                redirect('dashboard');
          // }elseif ($role==3) {
                //redirect('dashboard/design_dashboard');
           //}elseif ($role==3) {
                //redirect('dashboard/design_dashboard');
          // }
            }
            else
            {
                $this->session->set_flashdata('error', 'Username or password mismatch');
                $this->index();
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('user/forgotPassword');
        }
        else
        {
            redirect('dashboard');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = strtolower($this->security->xss_clean($this->input->post('login_email')));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['created_on'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo->name;
                        $data1["email"] = $userInfo->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);     
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('user/newPassword', $data);
        }
        else
        {
            redirect('login');
        }
    }
    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = strtolower($this->input->post("email"));
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password reset successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password reset failed';
            }
            
            setFlashData($status, $message);

            redirect("login");
        }
    }
}

?>