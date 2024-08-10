<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Production_employee extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_employee_model');        
        $this->isLoggedIn();
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Production Employee List';
        $this->loadViews("master/production_master/list_production_employee", $this->global);     
    }

    public function userListing()
    {                      
        $list = $this->production_employee_model->get_datatables();        
        $data = array();
        $no = $_POST['start'];              
        foreach ($list as $user)
        {
            $no++;            
            $row = array();            
            $row[] = $no;                      
            $row[] = $user->name;                           
            $row[] = $user->email;
            $row[] = $user->mobile;
            $skill_name = trim($user->skill_name,',');                                            
            $skill_name = str_replace(","," | ",$skill_name); 
            $row[] = wordwrap($skill_name, 80, '<br/>', false);                                                                                                                          
             
            if($user->status == 1)
                $status_class = "md-btn-success";
            else if($user->status == 0)
                $status_class = "md-btn";    

            $status = ($user->status? "Active" : "Passive");
            $row[] = '<i data='."'".$user->userId."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';                                   

            $row[] = '
                    <a href="'.base_url().'production_employee/editOld/'.$user->userId.'"  title="Edit" data-uk-tooltip><i class="material-icons md-color-orange-400">&#xE254;</i></a>
                    <a onclick="delete_user_data('.$user->userId.')" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>';
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->production_employee_model->count_all(),
                "recordsFiltered" => $this->production_employee_model->count_filtered(),
                "data" => $data,
            );        
        echo json_encode($output);
    }        
   
    public function addNew()
    {
        $skillist = $this->production_employee_model->get_production_skill();                               
        $options        = array();
        $options[""]    = "";
        $selectedItemId = "";
        foreach($skillist as $skills)
        {
            $options[$skills->id] = $skills->skills;
        }
        $data["skillsList"] = form_multiselect("skills[]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown activity_list_reset", 'id' => 'skills_id'));        
        
        $this->global['pageTitle'] = 'Add New Employee';
        $this->loadViews("master/production_master/add_production_employee", $this->global, $data, NULL);        
    }    
       
    public function add_new_user(){
        // print_r($_POST);exit;

        $name = ucwords(strtolower($this->security->xss_clean($_POST['fname'])));
        $email = strtolower($this->security->xss_clean($_POST['email']));              
        $mobile = $_POST['mobile'];      
        
        $skill_name = "";
        $skills = 0;
        if(isset($_POST['skills']) && !empty($_POST['skills'])){
            $skills = implode(",",$_POST['skills']);
            $skillId = $_POST['skills'];
        
            foreach($skillId as $skillsIdd){               
                $getskillname = $this->production_employee_model->getProductionSkillName($skillsIdd);                    
                $skill_name = $skill_name.''.$getskillname->skills.',';
            }
        }

        $userInfo = array(
            'email'         =>  $email,            
            'name'          =>  $name,
            'skills'        =>  $skills,
            'skill_name'    =>  $skill_name,
            'mobile'        =>  $mobile
        );        
        $last_userId = $result = $this->production_employee_model->addNewUser($userInfo);
        
        if($last_userId > 0)
        {
            //save user skills
            if(isset($_POST['skills']) && !empty($_POST['skills'])){
                foreach($skillId as $skills){                   
                    $getskillname = $this->production_employee_model->getProductionSkillName($skills);
                        
                    $userArray = array(
                        'userId'    => $last_userId,                        
                        'skillId'   => $skills,                        
                        'skill'     => $getskillname->skills,
                    );
                    $save = $this->production_employee_model->addUserSkills($userArray);
                }
            }                                
            $out_data['userID'] = $last_userId;                          
            echo json_encode($out_data); 
        }
        else
        {
            $out_data['userID'] = 0;                          
            echo json_encode($out_data); 
        }
    }        
   
    public function editOld($userId = NULL)
    {        
        if($userId > 0)
        {                          
            $data['userInfo'] = $this->production_employee_model->getUserInfo($userId);           
            
            $skillist = $this->production_employee_model->get_production_skill();                    
            $options        = array();
            $options[""]    = "Select";
            $selectedItemId = explode(',',$data['userInfo']->skills);

            foreach($skillist as $skills)
            {
                $options[$skills->id] = $skills->skills;
            }
            $data["skillist"] = form_multiselect("skills[]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown", 'id' => 'skills_id','placeholder' => 'Select Skill'));
            // echo json_encode($data);

            $this->global['pageTitle'] = 'Edit Employee';           
            $this->loadViews("master/production_master/edit_production_employee", $this->global, $data, NULL);
        }        
    }

    public function update_user(){
        // echo '<pre>';
        // print_r($_POST); exit;

        $userId = $_POST['userId'];
        $name = ucwords(strtolower($this->security->xss_clean($_POST['fname'])));
        $email = strtolower($this->security->xss_clean($_POST['email']));        
        $mobile = $this->security->xss_clean($_POST['mobile']);

        $skill_name = "";
        $skills = 0; 

        if(isset($_POST['skills']) && !empty($_POST['skills'])){
            $skills = implode(",",$_POST['skills']);
            $skillId = $_POST['skills'];                                        
            
            foreach($skillId as $skillsIdd){               
                $getskillname = $this->production_employee_model->getProductionSkillName($skillsIdd);                
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
            'skill_name'=>$skill_name                       
        );        
        
        $result = $this->production_employee_model->editUser($userInfo, $userId);
        
        if($result == true)
        {
            //delete previous user skills
            $delete_skills = $this->production_employee_model->delete_skills_after_update($userId);

            if(isset($skillId) && !empty($skillId)){
                foreach($skillId as $skills){                   
                    $getskillname = $this->production_employee_model->getProductionSkillName($skills);
                    
                    $userArray = array(
                        'userId'    => $userId,                        
                        'skillId'   => $skills,                        
                        'skill'     => $getskillname->skills,
                    );
                    $save = $this->production_employee_model->addUserSkills($userArray);
                }
            }                    

            $out_data['userID'] = $userId;                          
            echo json_encode($out_data); 
        }
        else
        {
            $out_data['userID'] = 0;                          
            echo json_encode($out_data); 
        }
    }
    
    public function delete_user(){
        $userId = $_POST['userId'];
        $userInfo = array('isDeleted'=>1);
            
        $result = $this->production_employee_model->deleteUser($userId, $userInfo);
        
        if ($result > 0) { 
            $userSkillsInfo = array('status'=>'0','isDeleted'=>'0');            
            $result = $this->production_employee_model->deleteUserSkills($userId, $userSkillsInfo);
            echo(json_encode(array('status'=>TRUE))); 
        }
        else { 
            echo(json_encode(array('status'=>FALSE))); 
        }
    }  
    
    public function update_status(){
        $userId = $_POST['userId'];
        $status = $_POST['status'];                            
        $result = $this->production_employee_model->update_user_status($userId, $status);
    }
    
}

?>