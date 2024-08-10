<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Design_material_status extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('status_report_model/Design_material_status_model');
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'Konark PMS- Design Department';
        $this->load->model('add_new_project_model');
    }
    
    public function index()
    {                   
        // $projectID = $data['projectID'] = $_GET['projectID'];     // for listing selected project 
        // $data['project_info'] = $this->Design_material_status_model->get_project_info($projectID); 
        $data['project_list'] = $this->Design_material_status_model->getProjectDetails();
        // $data['activity_list'] = $this->Design_material_status_model->get_all_activity(); 
        $data['activity_list'] = $this->Design_material_status_model->get_design_activity();  
        
        $this->global['pageTitle'] = 'Design Activity Status Report';        
        $this->loadViews("status_report_view/design_material_status_listing", $this->global, $data);
    }  
    
    public function get_activity_status(){
        $data['activity_list'] = $this->Design_material_status_model->get_activity_by_projectID($projectID); 
    }

    public function project_activity($projectID) {
        $list = $this->Design_material_status_model->get_project_activity($projectID);     
        $activity_list = $this->Design_material_status_model->get_design_activity(); 
    
        foreach ($activity_list as $obj) {
            
            $obj->updated_count = 0;
            $obj->not_updated_count = 0;
            foreach ($list as $li) {
                 
                $obj->projectNo = $li->projectNo;
                $obj->projectID = $li->projectID;
                
                if ($obj->id == $li->activity) {
                    $obj->updated_count = count($this->Design_material_status_model->get_project_activity_count($projectID, $obj->id ,1));
                    $obj->not_updated_count = count($this->Design_material_status_model->get_project_activity_count($projectID, $obj->id ,0));
                    break;  // No need to continue once found
                }

            }
        }
    
        return $activity_list;
    }
    

    public function list_activity() {
        $data = array();
        $no = $_POST['start'];
        $projects = $this->add_new_project_model->get_datatables();
    
        foreach ($projects as $pr) {
            $total_activity = 0;
            $updated_activity = 0;

            $row = array();
            $row[] = $pr->id;
            $row[] = $pr->project_no;
            $activity_list = $this->project_activity($pr->id);
            
            
            foreach ($activity_list as $act) {
                
                    $row[] = '<i class="material-icons check md-color-green-400" id="">&#xe5ca;</i>'.$act->updated_count.'|<i class="material-icons close md-color-red-400" id="">&#xe5cd;</i>:'.$act->not_updated_count;
                                        
            }

            
    
            $data[] = $row;
        }
    
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->add_new_project_model->count_all(),
            "recordsFiltered" => $this->add_new_project_model->count_filtered(),
            "data" => $data,
        );
    
        echo json_encode($output);
    }






   public function list_activity1(){
        $list = $this->add_new_project_model->get_datatables();
    //    echo'<pre>'; print_r($list); die;
        $data = array();
        $no = $_POST['start'];
        $todays_date = date("Y-m-d");

        foreach ($list as $lists)
        {
            $edit = base_url('add_new_project/edit_data/').$lists->id;

            $no++;
            $row = array();
            
            
            // $row[] = $no;
            $row[] = $lists->id;  
            // if($lists->act_desp_date != '' && $lists->isCompleted == 1){ // completed project
            //     $row[] = '<p class="project_over" title="Project completed">'.$lists->project_no.' / '.$lists->company_name.'</p>';   
            // }else{
            //     if($lists->del_date < $todays_date){ // project delay
            //         $row[] = '<p class="project_delayed" title="Project delay">'.$lists->project_no.' / '.$lists->company_name.'</p>';   
            //     }else{
            //         $row[] = '<p class="project_progress" title="Project in progress">'.$lists->project_no.' / '.$lists->company_name.'</p>';  
            //     }                
            // } 
                                            
            // $equipmentlist = $this->add_new_project_model->get_Equipment_tag_by_id($lists->id);
            // foreach($equipmentlist as $equipment){
            //     $equipmentList1 = $equipmentList1.''.$equipment->equipment_name.'<br/>';
            //     $tag_number = $tag_number.''.$equipment->tag_number.'<br/>';
            // }

            // $equip_qty_nos = '';
            // $tagArray = explode(',',$lists->equip_qty);        
            // foreach($tagArray as $equip_qty){                              
            //     $equip_qty_nos = $equip_qty_nos.''.$equip_qty.'<br/>';
            // }

            // $row[] = $equipmentList1;
            // $row[] = $tag_number;  
            // $row[] = $equip_qty_nos;                      
            // $row[] = $lists->po_number;
            // $row[] = $lists->po_date_time;
            // $row[] = $lists->del_date;
            // if($lists->proj_comp_date != '0000-00-00'){
            //     $row[] = $lists->proj_comp_date;            
            // }else{
            //     $row[] = '';
            // }

            // if($lists->act_desp_date != '0000-00-00'){
            //     $row[] = $lists->act_desp_date;            
            // }else{
            //     $row[] = '';
            // }
                       
            // $managerlist = $this->add_new_project_model->get_manager_by_id($lists->manager_name);
            // $row[] = $managerlist->name;

            // $row[] = $lists->jobvendor;

            // if($lists->status == 1)
            //     $status_class = "md-btn-success";
            // else if($lists->status == 0)
            //     $status_class = "md-btn";    

            // $status = ($lists->status? "Active" : "Passive");

            // $row[] = '<i data='."'".$lists->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
           
            // $row[] = '
            //     <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('.$lists->id.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
            //     <a href='."'".$edit."'".' data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
            //     <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$lists->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';            

            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->add_new_project_model->count_all(),
                    "recordsFiltered" => $this->add_new_project_model->count_filtered(),
                    "data" => $data,
                );        
        echo json_encode($output);
      }

    public function addActivity(){
        $projectID = $projectequipment = 0;

        if(isset($_GET['projectID']) && isset($_GET['projectequipment'])){
            $projectID = $_GET['projectID'];
            $projectequipment = $_GET['projectequipment'];  // in number format
        }else{
            $projectID = $this->input->post('projectID');
            $projectequipment = $this->input->post('projectequipment'); 
        }  
        // print_r($_GET);
        $get_equipment_tag_no = $this->Design_material_status_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->Design_material_status_model->get_client_name($projectID); 
        $project_no = $this->Design_material_status_model->get_Project_no_by_pid($projectID); 
        
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;
        // print_r($get_equipment_tag_no);
        // exit;
        $equipmentName = $get_equipment_tag_no->equipment_name;
        $tag_number = $get_equipment_tag_no->tag_number;
        
        $data['getAllDesignActivity'] = $this->Design_material_status_model->getDesignEqpActivity($projectID,$projectequipment,$client_id);        

        // $data["activitylist"] = $this->Design_material_status_model->get_design_activity();  
        $activity_list = $this->Design_material_status_model->get_design_activity();  
        $options        = array();
        $options[""]    = "";
        $selectedItemId = "";
        foreach($activity_list as $activity)
        {
            $options[$activity->id] = $activity->activity_data;
        }
        $data["activitylist"] = form_multiselect("activity[]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown activity_list_reset", 'id' => 'activity_id', 'name' => 'activity'));        

        $data['projectID'] = $projectID;
        $data['projectNo'] = $projectNo;
        $data['projectequipment'] = $projectequipment;  // equipment in no format
        $data['projectequipmentName'] = $equipmentName;  // equipment in text
        $data['client_id']= $client_id;
        $data['client_name']= $clientName;
        $data['tag_number'] = $tag_number;
        $data['designProjectStartDate'] = $project_no->designProjectStartDate;
        $data['designProjectEndDate'] = $project_no->designProjectEndDate; 
        $data['designActualStartDate'] = $project_no->designActualStartDate;
        $data['designActualEndDate'] = $project_no->designActualEndDate; 
        // echo '<pre>';
        // print_r($data); exit;
        $this->loadViews("designwindow/addActivity", $this->global, $data);                  
    }

    public function saveNewActivity()
    {
        // print_r($_POST); exit;        
        if(isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['activity']) && !empty($_POST['activity']))
        {             
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];  
            $activity = $_POST['activity'];   // array contains multiple activity numbers                              
                       
            $get_equipment_tag_no = $this->Design_material_status_model->get_equipment_tag_no($projectequipment, $projectID);
            $client_name = $this->Design_material_status_model->get_client_name($projectID); 
            $project_no = $this->Design_material_status_model->get_Project_no_by_pid($projectID); 

            foreach($activity as $activity_list){
                $skill_list = $this->Design_material_status_model->get_design_activity_skill($activity_list);
                
                $skills_array= '';
                foreach($skill_list as $skills){
                    $skills_array.=$skills->id.',';
                }
                // print_r($skills_array); exit;
                $projectNo = $project_no->project_no; 
                $client_id = $client_name->id;
                $clientName = $client_name->company_name;

                $equipmentName = $get_equipment_tag_no->equipment_name;
                $tag_number = $get_equipment_tag_no->tag_number;
                
                // $personUserId = '';
                // foreach($person1 as $userid=>$name){
                //     $personUserId = $personUserId.''.$name.',';
                // }
                
                $data = array(   
                    'projectNo'       => $projectNo,  
                    'client'          => $client_id,            
                    'projectequipment'=> $projectequipment, 
                    'tag_number'      => $tag_number, 
                    'projectID'       => $projectID,  
                    'activity'        => $activity_list,
                    'skill1'          => rtrim($skills_array,','),  
                    // 'skill1' => $skills_array,
                    // 'manpower1'       => $manpower1, 
                    // 'person1'         => rtrim($personUserId,','),  
                    // 'startDate'       => $startDate, 
                    // 'targetDate'      => $targetDate,  
                    // 'completionDate'  => $completionDate, 	
                    // 'releaseDate'     => $releaseDate, 	
                    // 'clientApproval'  => $clientApproval, 	
                    // 'prod_release'  => $prod_release,			                                           				                      
                );
                // print_r($data); exit;
                $last_insert_id = $insert = $this->Design_material_status_model->saveActivity($data);

                $logData = array();
                $logData = array(
                    'mul_tbl_id' => $last_insert_id,
                    'mul_tbl_coordinator' => 'tg_design_window',
                    'activity_type' => 1,
                    'from_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );

        
                $insertdata = $this->Design_material_status_model->saveNotificationLog($logData);
            }

            // if($last_insert_id > 0){
            //     // $personData = array();
            //     // $per_names = '';
            //     foreach($person_name as $userid=>$name){
            //         $getname = $this->Design_material_status_model->get_person_name($name);
            //         $personData = array(   
            //             'design_window_id'   => $last_insert_id,  
            //             'projectID'          => $projectID,            
            //             'projectequipment'   => $projectequipment, 
            //             'activityId'         => $activity, 
            //             // 'userId'             => $name,  
            //             // 'userName'           => $getname->name,                     				                                           				                      
            //         );
            //         $this->db->set($personData);
            //         $insertdata = $this->Design_material_status_model->saveDesignActivityPersons($personData);
            //     }
            // }                   

            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data);       
        }                  
    }

    public function editActivityView() //Activity ID
    {
        $activityID = $_POST['activityID'];
        $data['act_data'] = $this->Design_material_status_model->get_activity_by_id($activityID);        
        $data["activitylist"] = $this->Design_material_status_model->get_design_activity();          

        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->Design_material_status_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->Design_material_status_model->get_equipment_tag_no($projectequipment, $projectID);
        $activity = $data['act_data']->activity;
        $totalSkills = $this->Design_material_status_model->get_activity_skills_count($activity);         
        // print_r($totalSkills); exit;

        $client_name = $client_name->company_name;
        $projectNo = $data['act_data']->projectNo;
        $equipment_name = $get_equipment_tag_no->equipment_name;
        $tag_number = $data['act_data']->tag_number; 
        
        $data['projectID'] = $projectID;
        $data['projectequipment'] = $projectequipment;
        $data['client_name'] = $client_name;        
        $data['projectNo'] = $projectNo;        
        $data['projectequipmentName'] = $equipment_name;        
        $data['tag_number'] = $tag_number; 
        
        $data['skills_list'] = $this->Design_material_status_model->get_design_activity_skill($activity);         
        $data['selected_skills'] = explode(',',$data['act_data']->skill1);

        $personsdata = array();   
        // $totalSkills = 3;            
        $activitySkills = $this->Design_material_status_model->get_design_activity_wise_skill($activity);
        // print_r($activitySkills);  exit;
        foreach($activitySkills as $skills){
            if($skills->totalSkills >= $totalSkills){
                $personsdata[$skills->userId] = $skills->name;
            }            
        }
        $data["personsdata"] = $personsdata;  
        
        echo json_encode($data);                                     
    }

    public function editSingleActivity($activityID) //Activity ID from design projects my activity list..
    {        
        $data['act_data'] = $this->Design_material_status_model->get_activity_by_id($activityID); 
        // print_r(); exit;       
        $activitylist = $this->Design_material_status_model->get_activity_details($data['act_data']->activity);                 
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->Design_material_status_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->Design_material_status_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;        

        $client_name = $client_name->company_name;
        $projectNo = $data['act_data']->projectNo;
        $equipment_name = $get_equipment_tag_no->equipment_name;
        $tag_number = $data['act_data']->tag_number; 
        
        $data['projectID'] = $projectID;
        $data['projectequipment'] = $projectequipment;
        $data['client_name'] = $client_name;        
        $data['projectNo'] = $projectNo;        
        $data['projectequipmentName'] = $equipment_name;        
        $data['tag_number'] = $tag_number; 
        $data['activity_id']  = $activity;
        $data['activity_name'] = $activitylist[0]->activity_data;  

        $skill_name = '';
        $skills_list = $this->Design_material_status_model->get_design_activity_skill($activity);          
        foreach($skills_list as $skill)
        {
            $skill_name = $skill_name.' '.$skill->skills.'|';
        }
        $data['skills_list'] = $skill_name;        
         
        $userName = '';
        if($data['act_data']->person1){        
            $person_list = explode(',',$data['act_data']->person1);
            foreach($person_list as $persons){
                $userNameList = $this->Design_material_status_model->get_person_user_name($persons);                    
                $userName = $userName.''.$userNameList->name.' | ';
            }
        }
        $data['person_names'] = $userName;
        
        // echo '<pre>';
        // print_r($data);exit;
        $this->loadViews("designwindow/editActivity", $this->global, $data);                   
    }    

    public function get_activity_detail()
    {
        $activityID = $_GET['activityID'];
        $projectequipment = $_GET['projectequipment'];
        $data['activity_details'] = $this->Design_material_status_model->get_activity_detail_by_id($activityID,$projectequipment);
        
        $skillName = '';
        if($data['activity_details']->skill1){
            $skillsArray = explode(',',$data['activity_details']->skill1);
            foreach($skillsArray as $skillss){
                $getskillName = $this->Design_material_status_model->get_skills_name($skillss);                    
                $skillName = $skillName.''.$getskillName->skills.' | ';
            }
        }
        $data['skill1'] = $skillName;

        $userName = '';
        if($data['activity_details']->person1){                
            $personArray = explode(',',$data['activity_details']->person1);
            foreach($personArray as $userId){
                $userNameList = $this->Design_material_status_model->get_person_user_name($userId);                    
                $userName = $userName.''.$userNameList->name.' | ';
            }
        } 
        $data['person1'] = $userName;        
        echo json_encode($data);
    }
    
    // public function delete_activity($activityID)
    // {
    //     $this->Design_material_status_model->delete_by_id($activityID);
    //     echo json_encode(array("status" => TRUE));
    // }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->Design_material_status_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }    

    public function update_status()
	{
        $this->Design_material_status_model->update_status($this->input->post('activityID'), $this->input->post('status'));
	}

    public function export_csv($projectID)
	{         
        $design_data = $this->Design_material_status_model->getActivityDetails($projectID);              
        
		$filename = 'activity_'.date('d-m-Y').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
		$file = fopen('php://output','w');        		
		$header = array("Client", "Project No","Equipment", "TAG No", "Activity", "Skill", "Person", "Manpower", "Start Date", "Target Date", "Completion Date", "Release Date", "Client Approval", "Revision No", "Delay", "Reason"); 
		fputcsv($file, $header);

		foreach ($design_data as $key=>$value)
		{             
            fputcsv($file,$value);             
		}
		fclose($file);		
		exit; 
    }
    
    public function delete_new_activity()
    {
        $activityID = $_POST['activityID'];
        $isDeleted = $this->Design_material_status_model->delete_by_id($activityID);
        if($isDeleted > 0){
            $this->Design_material_status_model->delete_persons_curr_activity($activityID);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }
        
    }

    public function getActivitySkill(){ 
        $activityID = $_POST['activityID'];       
        $data = $this->Design_material_status_model->get_design_activity_skill($activityID);
        echo json_encode($data);                
    }

    public function getPersonsActivitySkill(){
        // print_r($_POST); exit;
        $data = array();
        $activityID = $_POST['activityID']; 
        $totalSkills = $_POST['totalSkills'];

        $activitySkills = $this->Design_material_status_model->get_design_activity_wise_skill($activityID);
        // print_r($activitySkills);  exit;
        foreach($activitySkills as $skills){  //8
            if($skills->totalSkills >= $totalSkills){
                $data[$skills->userId] = $skills->name;
            }            
        }
        echo json_encode($data);
    }

    public function getActivityTimeRequired(){
        $activityID = $_POST['activityID']; 
        $data = $this->Design_material_status_model->get_design_activity_time($activityID);
        echo json_encode($data);
    }

    public function updateActivityData(){
        // print_r($_POST); exit;
        if(isset($_POST['activityID']) && !empty($_POST['activityID']) && isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['taskCompDate']) && !empty($_POST['taskCompDate'])){
            $activityID = $_POST['activityID'];
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment']; 
            $taskCompDate = $_POST['taskCompDate']; 
            $delayDays   = $_POST['delayDays'];
            $is_overtime   = $_POST['is_overtime'];
            $delayRemark = $_POST['delayRemark'];
            $clientApproval = $_POST['clientApproval']; 
            $actual_start_date   = $_POST['actual_start_date'];

            $data = array(
                'actual_start_date' => $actual_start_date,
                'taskCompDate'    => $taskCompDate, 
                'delayDays'       => $delayDays, 
                'delayRemark'     => $delayRemark, 
                'clientApproval'  => $clientApproval, 
                'is_overtime'     => $is_overtime,
                // 'prod_release'    => $prod_release,
            );
            $this->Design_material_status_model->updateActivity($data,$activityID);

            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data); 

        }else{
            $data['projectID'] = 0;        
            $data['projectequipment'] = 0;  // equipment in no format        
            echo json_encode($data); 
        }
    }

    public function updateActivity(){ // update single activity data        
        // print_r($_POST); exit;   

        if(isset($_POST['activityID']) && !empty($_POST['activityID']) && isset($_POST['person_name_id']) && !empty($_POST['person_name_id']) && isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['startDate']) && !empty($_POST['startDate']) && isset($_POST['targetDate']) && !empty($_POST['targetDate']) )
        { 
            $activityID = $_POST['activityID'];
            $projectID = $_POST['projectID']; //
            $projectequipment = $_POST['projectequipment'];  // 
            $activity = $_POST['activity_data_id'];              
            $manpower1 = $_POST['manpower1'];                
            $startDate = $_POST['startDate'];        
            $targetDate = $_POST['targetDate'];                     
            $level = $_POST['level']; 
            $row_order = $_POST['row_order']; 
            $activity_days = $_POST['activity_days']; 
            $activity_time_hours = $_POST['activity_time_hours']; 
            $activity_time_minutes = $_POST['activity_time_minutes']; 
            $clientApproval = $_POST['clientApproval']; 
            // $prod_release   = $_POST['prod_release'];
            $person1 = $_POST['person_name_id'];
            $person_name = $_POST['person_name_id'];         
            
            $personUserId = '';
            foreach($person1 as $userid=>$name){
                $personUserId = $personUserId.''.$name.',';
            }
            
            $activityData = array(    
                'level'       => $level, 
                'row_order'       => $row_order, 
                'activity_days'       => $activity_days, 
                'activity_time_hours'       => $activity_time_hours, 
                'activity_time_minutes'       => $activity_time_minutes, 
                'manpower1'       => $manpower1, 
                'person1'         => rtrim($personUserId,','),  
                'startDate'       => $startDate, 
                'targetDate'      => $targetDate,  
                // 'taskCompDate'    => $taskCompDate, 
                // 'delayRemark'       => $delayRemark,             	
                'clientApproval'  => $clientApproval, 
                // 'prod_release'    => $prod_release, 	
                'is_all_updated'  => 1,			                                           				                      
            );
            //print_r($data); die;
            if($activityID > 0){
                $updated_status_before = $this->Design_material_status_model->is_UpdatedActivity_activityID($activityID);// for log module 
        
        
                        $insert = $this->Design_material_status_model->updateActivity($activityData,$activityID);
            

                $updated_status_after = $this->Design_material_status_model->is_UpdatedActivity_activityID($activityID);// for log module
        
                      
                $logData = array();
                $logData = array(
                    'mul_tbl_id' => $activityID,
                    'mul_tbl_coordinator' => 'tg_design_window',
                    'activity_type' => 2,
                    'from_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );

                
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->Design_material_status_model->saveNotificationLog($logData);
                    }
                }
            
                // delete previus persons activities skills
                $this->Design_material_status_model->beforeEditPeronsActivitySkills($activityID);

                foreach($person_name as $userid=>$name){
                    $getname = $this->Design_material_status_model->get_person_name($name);
                    $personData = array(
                        'design_window_id'   => $activityID,  
                        'projectID'          => $projectID,            
                        'projectequipment'   => $projectequipment, 
                        'activityId'         => $activity, 
                        'userId'             => $name,  
                        'userName'           => $getname->name,                     				                                           				                      
                    );
                    $this->db->set($personData);
                    $insertdata = $this->Design_material_status_model->saveDesignActivityPersons($personData);
                }
            }

            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data); 
        }
    }

    public function updateAllActivityOnce(){ // update all activity data at a time
        // print_r($_POST); exit;                        
        if(isset($_POST['activityID']) && count($_POST['activityID']) > 0 && isset($_POST['person_name_id']) && count($_POST['person_name_id']) > 0 && isset($_POST['startDate']) && count($_POST['startDate']) > 0 && isset($_POST['targetDate']) && count($_POST['targetDate']) > 0)
        // if(isset($_POST['activityID']) && count($_POST['activityID']) > 0)
        {      
            $projectID = $_POST['projectID']; // single value
            $projectequipment = $_POST['projectequipment'];  // single value
            $total_cnt = count($_POST['activityID']);
            $total_persons = 0;

            $activityID = $_POST['activityID'][0]; 
            $manpower1 = $_POST['manpower1'][0];
            $person_name_id = $_POST['person_name_id'];
            if($manpower1 > 0){
                $total_persons = count($person_name_id[$activityID]);  
            }
                                                
            $activity = $_POST['activity_data_id'][0];              
                            
            $startDate = $_POST['startDate'][0];        
            $targetDate = $_POST['targetDate'][0];                     
            $level = $_POST['level'][0]; 
            $row_order = $_POST['row_order'][0]; 
            $activity_days = $_POST['activity_days'][0]; 
            $activity_time_hours = $_POST['activity_time_hours'][0]; 
            $activity_time_minutes = $_POST['activity_time_minutes'][0]; 
            $clientApproval = $_POST['clientApproval'][0]; 
            // $prod_release   = $_POST['prod_release'][0];
            
            $person_list = '';
            if($manpower1 > 0){
                for($j=0; $j < $total_persons; $j++){
                    $person_list = $person_list.''.$person_name_id[$activityID][$j].',';                 
                }  
                $person_list = rtrim($person_list,','); 
            }  
            
                $updated_status = 0;
                if($person_list != ''){
                    $updated_status = 1;
                }

            $activityData = array(    
                'level'                 => $level, 
                'row_order'             => $row_order, 
                'activity_days'         => $activity_days, 
                'activity_time_hours'   => $activity_time_hours, 
                'activity_time_minutes' => $activity_time_minutes,
                'manpower1'             => $manpower1, 
                'person1'               => $person_list,  
                'startDate'             => $startDate, 
                'targetDate'            => $targetDate,  
                // 'taskCompDate'    => $taskCompDate, 
                // 'delayDays'       => $delayDays,             	
                'clientApproval'        => $clientApproval, 
                // 'prod_release'          => $prod_release, 
                'is_all_updated'		=> $updated_status,
            );

            if($activityID > 0){
                $updated_status_before = $this->Design_material_status_model->is_UpdatedActivity_activityID($activityID);// for log module 
                        $update = $this->Design_material_status_model->updateActivity($activityData,$activityID);
                $updated_status_after = $this->Design_material_status_model->is_UpdatedActivity_activityID($activityID);// for log module
        
                      
                $logData = array();
                $logData = array(
                    'mul_tbl_id' => $activityID,
                    'mul_tbl_coordinator' => 'tg_design_window',
                    'activity_type' => 2,
                    'from_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );

               
        
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->Design_material_status_model->saveNotificationLog($logData);
                    }
                }

                if($manpower1 > 0){
                    // delete previus persons activities skills
                    $this->Design_material_status_model->beforeEditPeronsActivitySkills($activityID);

                    for($j=0; $j < $total_persons; $j++){                        
                        $userId =  $person_name_id[$activityID][$j];
                        $getname = $this->Design_material_status_model->get_person_name($userId);
                        
                        $personData = array(   
                            'design_window_id'   => $activityID,  
                            'projectID'          => $projectID,            
                            'projectequipment'   => $projectequipment, 
                            'activityId'         => $activity, 
                            'userId'             => $userId,  
                            'userName'           => $getname->name,                     				                                           				                      
                        );                        
                        $this->db->set($personData);
                        $insertdata = $this->Design_material_status_model->saveDesignActivityPersons($personData);                                                          
                    }  
                }                   
            }

            // loop for all activities (no of rows)
            $startDate1 = $targetDate;
            for($i=1; $i<$total_cnt;$i++){ // by activity ids
                $activityID = $_POST['activityID'][$i]; 
                $manpower1 = $_POST['manpower1'][$i];
                $person_name_id = $_POST['person_name_id'];
                if($manpower1 > 0){
                    $total_persons = count($person_name_id[$activityID]);  
                }
                                                    
                $activity = $_POST['activity_data_id'][$i];              
                                
                // $startDate = $_POST['startDate'][$i];        
                // $targetDate = $_POST['targetDate'][$i];                     
                $level = $_POST['level'][$i]; 
                $row_order = $_POST['row_order'][$i];                 
                $clientApproval = $_POST['clientApproval'][$i]; 
                // $prod_release   = $_POST['prod_release'][$i];

                $activity_days = $_POST['activity_days'][$i]; 
                $activity_time_hours = $_POST['activity_time_hours'][$i]; 
                $activity_time_minutes = $_POST['activity_time_minutes'][$i]; 
                $TOTAL_ACT_TIME = $activity_days*24*60 + $activity_time_hours*60 + $activity_time_minutes;
                // $TOTAL_ACT_TIME = $TOTAL_ACT_TIME*3;
                $new_target_date_time = '';                    
                $dateTime = new DateTime($startDate1);                     
                $new_target_date_time = $dateTime->modify("+{$TOTAL_ACT_TIME} minutes");                    
                $new_target_date_time = $new_target_date_time->format('Y-m-d H:i');
                
                $person_list = '';
                if($manpower1 > 0){
                    for($j=0; $j < $total_persons; $j++){
                        $person_list = $person_list.''.$person_name_id[$activityID][$j].',';                 
                    }  
                    $person_list = rtrim($person_list,','); 
                }  
                
                $updated_status = 0;
                if($person_list != ''){
                    $updated_status = 1;
                }

                $activityData1 = array(    
                    'level'                 => $level, 
                    'row_order'             => $row_order, 
                    'activity_days'         => $activity_days, 
                    'activity_time_hours'   => $activity_time_hours, 
                    'activity_time_minutes' => $activity_time_minutes, 
                    'manpower1'             => $manpower1, 
                    'person1'               => $person_list,  
                    'startDate'             => $startDate1, 
                    'targetDate'            => $new_target_date_time,  
                    // 'taskCompDate'    => $taskCompDate, 
                    // 'delayDays'       => $delayDays,             	
                    'clientApproval'        => $clientApproval, 
                    // 'prod_release'          => $prod_release, 
                    'is_all_updated'		=> $updated_status,				                                           				                      
                );
                $startDate1 = $new_target_date_time;
                if($activityID > 0){
                    // $update = $this->Design_material_status_model->updateActivity($activityData1,$activityID);

                
                $updated_status_before = $this->Design_material_status_model->is_UpdatedActivity_activityID($activityID);// for log module 
                        $update = $this->Design_material_status_model->updateActivity($activityData1,$activityID);
                $updated_status_after = $this->Design_material_status_model->is_UpdatedActivity_activityID($activityID);// for log module
        
                      
                $logData = array();
                $logData = array(
                    'mul_tbl_id' => $activityID,
                    'mul_tbl_coordinator' => 'tg_design_window',
                    'activity_type' => 2,
                    'from_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );


                       
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->Design_material_status_model->saveNotificationLog($logData);
                    }
                }


                    if($manpower1 > 0){
                        // delete previus persons activities skills
                        $this->Design_material_status_model->beforeEditPeronsActivitySkills($activityID);

                        for($j=0; $j < $total_persons; $j++){                        
                            $userId =  $person_name_id[$activityID][$j];
                            $getname = $this->Design_material_status_model->get_person_name($userId);
                            
                            $personData = array(   
                                'design_window_id'   => $activityID,  
                                'projectID'          => $projectID,            
                                'projectequipment'   => $projectequipment, 
                                'activityId'         => $activity, 
                                'userId'             => $userId,  
                                'userName'           => $getname->name,                     				                                           				                      
                            );                        
                            $this->db->set($personData);
                            $insertdata = $this->Design_material_status_model->saveDesignActivityPersons($personData);                                                          
                        }  
                    }                   
                }
            }

            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data); 
        }else{
            $data['projectID'] = 0;        
            $data['projectequipment'] = 0;  // equipment in no format        
            echo json_encode($data); 
        }

    }

    public function reorderActivity(){
        // print_r($_POST); exit;
        if(isset($_POST['row_order']) && count($_POST['row_order']) > 0 && isset($_POST['level']) && count($_POST['level']) > 0){
            $projectID = $_POST['projectID']; // single value
            $projectequipment = $_POST['projectequipment'];  // single value
            $total_cnt = count($_POST['activityID']);

            for($i=0; $i<$total_cnt;$i++){ // by activity ids
                $activityID = $_POST['activityID'][$i];
                $level = $_POST['level'][$i]; 
                $row_order = $_POST['row_order'][$i];

                $activityData = array(    
                    'level'                 => $level, 
                    'row_order'             => $row_order, 
                );
                $update = $this->Design_material_status_model->updateActivity($activityData,$activityID);
            }
            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data); 
        }else{
            $data['projectID'] = 0;        
            $data['projectequipment'] = 0;  // equipment in no format        
            echo json_encode($data); 
        }
    }

    
    public function updateNextActivityStartDate(){
        // print_r($_POST);exit;
        $activityID = $_POST['activityID'];
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];
        $row_order = $_POST['row_order'];
        $total_activity_count = $_POST['total_activity_count'];        
        $startDate = $_POST['targetDate'];        
        $startDate_copy = $_POST['targetDate'];        
        $row_order = $row_order+1;

        if($activityID > 0){
            for($i = $row_order; $i <= $total_activity_count; $i++){                
                $get_activity_details = $this->Design_material_status_model->get_activity_details_by_activity($projectID, $projectequipment, $i);
                
                $activityID = $get_activity_details->activityID;
                $days = $get_activity_details->activity_days;
                $hours = $get_activity_details->activity_time_hours;
                $minutes = $get_activity_details->activity_time_minutes;

                $shift_start_time = 9;
                $shift_end_time = 17;

                $total_time = $days*24*60 + $hours*60 + $minutes;
                $total_time_in_hrs = $days*24 + $hours;                
                $total_time_for_next_day = '+1 hours';                
                $new_target_date_time = $date_str = $hours_str = $minutes_str = '';    
                
                $j = 0;                         
                for($j = 1; $j <= $total_time_in_hrs; $j++){                       
                    $new_target_time = date("Y-m-d H:i:s", strtotime($total_time_for_next_day, strtotime($startDate_copy)));                    
                    
                    $date_str = substr($new_target_time,0,10);
                    $hours_str = substr($new_target_time,11,2);
                    $minutes_str = substr($new_target_time,14,2);                    

                    if($hours_str <= $shift_end_time){
                        $new_target_time1 = $date_str.' '.$hours_str.':'.$minutes_str;                        
                        $total_time_for_next_day = '+1 hours';                                               
                        $startDate_copy = $new_target_time1;
                        $new_target_date_time = $new_target_time1;                        
                    }else{
                        $total_time_for_next_day = '+16 hours';                      
                        $total_time_in_hrs = $total_time_in_hrs+1;
                    }                     
                }
               
                if($total_time_in_hrs <= 0){
                    $new_target_date_time = $startDate;
                }else{
                    $new_target_date_time = $date_str.' '.$hours_str.':'.$minutes_str;;                    
                }                
                               
                //update start date and target date
                $update_in_time = $this->Design_material_status_model->updateNextActivityStartDate($startDate, $new_target_date_time,$activityID); 
                $startDate = $new_target_date_time;
                $startDate_copy = $new_target_date_time;
            }
            
            $data['activityID'] = $activityID;                    
            echo json_encode($data); 
        }else{
            $data['activityID'] = 0;                    
            echo json_encode($data); 
        }
    }

    public function saveProjectTimeline(){
        // print_r($_POST);
        $designProjectStartDate = $_POST['designProjectStartDate'];
        $designProjectEndDate = $_POST['designProjectEndDate'];
        $designActualStartDate = $_POST['designActualStartDate'];
        $designActualEndDate = $_POST['designActualEndDate'];
        $project_id = $_POST['project_id'];

        $dataArray = array(
            'designProjectStartDate' => $designProjectStartDate,
            'designProjectEndDate' => $designProjectEndDate,
            'designActualStartDate' => $designActualStartDate,
            'designActualEndDate' => $designActualEndDate,
        );
        $this->Design_material_status_model->updateProjectTimeline($project_id,$dataArray); 
        
        $data['designProjectStartDate'] = $designProjectStartDate;                    
        $data['designProjectEndDate'] = $designProjectEndDate;
        $data['designActualStartDate'] = $designActualStartDate;                    
        $data['designActualEndDate'] = $designActualEndDate;
        echo json_encode($data); 
    }
}
?>