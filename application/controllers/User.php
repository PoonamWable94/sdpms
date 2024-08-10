<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');        
        $this->isLoggedIn();
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'User List';
        $this->loadViews("user/user_list", $this->global);     
    }

    public function userListing()
    {      
        $userRole = $_POST['userRole'];          
        $list = $this->user_model->get_datatables();        
        $data = array();
        $no = $_POST['start'];

        // print_r($list); exit;        
        foreach ($list as $user)
        {
            $no++;
            $skill_name= '';
            $row = array();
            // $row[] = '<input type="checkbox" class="data-check" value="'.$user->userId.'" >';
            $row[] = $no;                      
            $row[] = $user->dept_name;                           
            $row[] = $user->role;
            $row[] = $user->name;
            $row[] = $user->email;
            $row[] = $user->uname;            
            $row[] = $user->mobile;                                                                                                                 
             
            if($user->status == 1)
                $status_class = "md-btn-success";
            else if($user->status == 0)
                $status_class = "md-btn";    

            $status = ($user->status? "Active" : "Passive");
            $row[] = '<i data='."'".$user->userId."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';            

            $skill_name = trim($user->skill_name,',');                                            
            $skill_name = str_replace(","," | ",$skill_name); 
            $row[] = wordwrap($skill_name, 80, '<br/>', false);  

            if($userRole == 1 || $userRole == 2){
                $row[] = $user->pwd;    
            }

            $row[] = '<a href="'.base_url().'login-history/'.$user->userId.'" title="login history" data-uk-tooltip><i class="material-icons md-color-cyan-700">&#xE88F;</i></a> |
                    <a href="'.base_url().'editOld/'.$user->userId.'"  title="Edit" data-uk-tooltip><i class="material-icons md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_user_data('.$user->userId.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';
            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->user_model->count_all(),
                "recordsFiltered" => $this->user_model->count_filtered(),
                "data" => $data,
            );        
        echo json_encode($output);
    }        
   
    public function addNew()
    {
        if($this->isTicketter() == TRUE){
            $this->loadThis();
        }
        else{            
            $data['dept']  = $this->user_model->getUserDepts();            
            $data['roles'] = $this->user_model->getUserRoles();            
            
            $this->global['pageTitle'] = 'Add New User';
            $this->loadViews("user/addNew", $this->global, $data, NULL);
        }
    }    
       
    public function add_new_user(){
        // print_r($_POST);exit;

        $name = ucwords(strtolower($this->security->xss_clean($_POST['fname'])));
        $email = strtolower($this->security->xss_clean($_POST['email']));
        $password = $_POST['password'];
        $role = $_POST['role'];
        $dept = $_POST['dept'];        
        $mobile = $_POST['mobile'];
        $uname = $_POST['uname'];
        
        $skill_name = "";
        $skills = 0;
        if(isset($_POST['skills']) && !empty($_POST['skills'])){
            $skills = implode(",",$_POST['skills']);
            $skillId = $_POST['skills'];
        
            foreach($skillId as $skillsIdd){
                // $getskillname = $this->user_model->getDesignSkillName($skillsIdd);
                if($dept == 2){
                    $getskillname = $this->user_model->getDesignSkillName($skillsIdd);                            
                }else if($dept == 3){
                    $getskillname = $this->user_model->getPurchaseSkillName($skillsIdd);
                }else if($dept == 4){
                    $getskillname = $this->user_model->getProductionSkillName($skillsIdd);
                    // $taskId = $getskillname->task;
                }else{
                    $getskillname = $this->user_model->getDesignSkillName($skillsIdd);
                }

                $skill_name = $skill_name.''.$getskillname->skills.',';
            }
        }

        $userInfo = array(
            'email'         =>  $email, 
            'password'      =>  getHashedPassword($password), 
            'pwd'           =>  $password,
            'roleId'        =>  $role,
            'dept_id'       =>  $dept,  
            'name'          =>  $name,
            'skills'        =>  $skills,
            'skill_name'    =>  $skill_name,
            'mobile'        =>  $mobile, 
            // 'emp_signature' =>  $this->do_upload('emp_signature') ? $this->do_upload('emp_signature') : '',
            'createdBy'     =>  $this->vendorId, 
            'uname'         =>  $uname,
            //'createdDtm'    =>  date('Y-m-d H:i:s')
        );
        
        $this->load->model('user_model');
        $last_userId = $result = $this->user_model->addNewUser($userInfo);
        
        if($last_userId > 0)
        {
            //save user skills
            if(isset($_POST['skills']) && !empty($_POST['skills'])){
                foreach($skillId as $skills){
                    $taskId =0;
                    if($dept == 2){
                        $getskillname = $this->user_model->getDesignSkillName($skills);                            
                    }else if($dept == 3){
                        $getskillname = $this->user_model->getPurchaseSkillName($skills);
                    }else if($dept == 4){
                        $getskillname = $this->user_model->getProductionSkillName($skills);
                        // $taskId = $getskillname->task;
                    }else{
                        $getskillname = $this->user_model->getDesignSkillName($skills);
                    }
                    

                    $userArray = array(
                        'userId'    => $last_userId,
                        'deptId'    => $dept,
                        'skillId'   => $skills,
                        // 'taskId'    => $taskId,
                        'skill'     => $getskillname->skills,
                    );
                    $save = $this->user_model->addUserSkills($userArray);
                }
            }                                
            $data['userID'] = $last_userId;                          
            echo json_encode($data); 
        }
        else
        {
            $data['userID'] = 0;                          
            echo json_encode($data); 
        }
    }        
   
    function editOld($userId = NULL)
    {        
        if($userId > 0)
        {            
            $data['dept'] = $deptId = $this->user_model->getUserDepts();                       
            $data['roles'] = $this->user_model->getUserRoles();
    
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $deptId = $data['userInfo']->dept_id;
            if($deptId == 2){
                $skillist = $this->user_model->get_design_skill();
            }else if($deptId == 3){
                $skillist = $this->user_model->get_purchase_skill();
            }else if($deptId == 4){
                $skillist = $this->user_model->get_production_skill();
            }else{
                $skillist = $this->user_model->get_purchase_skill();
            }
                    
            $options        = array();
            $options[""]    = "Select";
            $selectedItemId = explode(',',$data['userInfo']->skills);

            foreach($skillist as $skills)
            {
                $options[$skills->id] = $skills->skills;
            }
            $data["skillist"] = form_multiselect("skills[]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown", 'id' => 'skills_id','placeholder' => 'Select Skill'));
            // echo json_encode($data);

            $this->global['pageTitle'] = 'Edit User';
            // echo '<pre>';
            // print_r($data); exit;
            $this->loadViews("user/editOld", $this->global, $data, NULL);
        }
        
    }

    public function update_user(){
        // echo '<pre>';
        // print_r($_POST); exit;

        $userId = $_POST['userId'];
        $deptId = $_POST['dept'];
        $name = ucwords(strtolower($this->security->xss_clean($_POST['fname'])));
        $email = strtolower($this->security->xss_clean($_POST['email']));        
        $mobile = $this->security->xss_clean($_POST['mobile']);

        $skill_name = "";
        $skills = 0; 

        if(isset($_POST['skills']) && !empty($_POST['skills'])){
            $skills = implode(",",$_POST['skills']);
            $skillId = $_POST['skills'];                                        
            
            foreach($skillId as $skillsIdd){
                // $getskillname = $this->user_model->getDesignSkillName($skillsIdd);
                if($deptId == 2){
                    $getskillname = $this->user_model->getDesignSkillName($skillsIdd);                            
                }else if($deptId == 3){
                    $getskillname = $this->user_model->getPurchaseSkillName($skillsIdd);
                }else if($deptId == 4){
                    $getskillname = $this->user_model->getProductionSkillName($skillsIdd);
                    // $taskId = $getskillname->task;
                }else{
                    $getskillname = $this->user_model->getDesignSkillName($skillsIdd);
                }

                $skill_name = $skill_name.''.$getskillname->skills.',';
            }
        }else{
            $skill_name = "";
            $skills = 0;                    
        }                
       
        $userInfo = array(
            'email'=>$email,             
            'name'=>$name, 
            'mobile'=>$mobile, 
            'skills'=>$skills, 
            'skill_name'=>$skill_name,             
            'updatedBy'=>$this->vendorId, 
            'updatedDtm'=>date('Y-m-d H:i:s'),             
        );        
        
        $result = $this->user_model->editUser($userInfo, $userId);
        
        if($result == true)
        {
            //delete previous user skills
            $delete_skills = $this->user_model->delete_skills_after_update($userId,$deptId);

            if(isset($skillId) && !empty($skillId)){
                foreach($skillId as $skills){
                    $taskId =0;
                    if($deptId == 2){
                        $getskillname = $this->user_model->getDesignSkillName($skills);                            
                    }else if($deptId == 3){
                        $getskillname = $this->user_model->getPurchaseSkillName($skills);
                    }else if($deptId == 4){
                        $getskillname = $this->user_model->getProductionSkillName($skills);
                        // $taskId = $getskillname->task;
                    }else{
                        $getskillname = $this->user_model->getDesignSkillName($skills);
                    }                        

                    $userArray = array(
                        'userId'    => $userId,
                        'deptId'    => $deptId,
                        'skillId'   => $skills,
                        // 'taskId'    => $taskId,
                        'skill'     => $getskillname->skills,
                    );
                    $save = $this->user_model->addUserSkills($userArray);
                }
            }                    

            $data['userID'] = $userId;                          
            echo json_encode($data); 
        }
        else
        {
            $data['userID'] = 0;                          
            echo json_encode($data); 
        }
    }
    
    public function delete_user(){
        $userId = $_POST['userId'];
        $userInfo = array('isDeleted'=>1,'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
        $result = $this->user_model->deleteUser($userId, $userInfo);
        
        if ($result > 0) { 
            $userSkillsInfo = array('status'=>'0','isDeleted'=>'0');            
            $result = $this->user_model->deleteUserSkills($userId, $userSkillsInfo);
            echo(json_encode(array('status'=>TRUE))); 
        }
        else { 
            echo(json_encode(array('status'=>FALSE))); 
        }
    }  
    
    public function update_status(){
        $userId = $_POST['userId'];
        $status = $_POST['status'];                            
        $result = $this->user_model->update_user_status($userId, $status);
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = '404 - Page Not Found';
        
        $this->loadViews("user/404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'User Login History';
            
            $this->loadViews("user/loginHistory", $this->global, $data, NULL);
        }        
    }

    /**
     * This function is used to show users profile
     */
    function profile($active = "details")
    {
        $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        $data["active"] = $active;
        
        $this->global['pageTitle'] = $active == "details" ? 'Konark Engineers : My Profile' : 'CodeInsect : Change Password';
        $this->loadViews("user/profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {                    
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            
            $userInfo = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'updated_by'=>$this->vendorId, 'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
            if($result == true)
            {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }

            redirect('profile/'.$active);
        }
    }
    
    function changePassword($active = "changepass")
    {                
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updated_by'=>$this->vendorId,
                                'updated_on'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }       

    public function user_skills()
    {
        $deptId = $_POST['deptId'];
        if($deptId == 2){
            $skillist = $this->user_model->get_design_skill();
        }else if($deptId == 3){
            $skillist = $this->user_model->get_purchase_skill();
        }else if($deptId == 4){
            $skillist = $this->user_model->get_production_skill();
        }else{
            $skillist = $this->user_model->get_purchase_skill();
        }                           
         echo json_encode($skillist);   
    }

    public function check_uname(){
        $uname = $_POST['uname'];
        $is_exists = $this->user_model->check_unique_uname($uname);
        echo json_encode($is_exists);
    }
    
}

?>