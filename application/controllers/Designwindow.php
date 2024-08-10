<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Designwindow extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('design_window_model');
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'Konark PMS- Design Department';
    }
    
    public function index()
    {                   
        $projectID = $data['projectID'] = $_GET['projectID'];     // for listing selected project 
        $data['project_info'] = $this->design_window_model->get_project_info($projectID); 
        $this->loadViews("designwindow/listActivity", $this->global, $data);
    }   

    public function list_activity()
    {
        $projectID = $_POST['projectID'];
        $list = $this->design_window_model->get_datatables($projectID);        
        $data = array();
        $no = $_POST['start'];

        // print_r($list);
        // die;
        foreach ($list as $activity)
        {
            $no++;
            $skillName= '';
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->activityID.'" >';
            $row[] = $no;                                    
            // $row[] = $activity->projectNo.'/'.$activity->company_name;
            $row[] = $activity->equipment;
            $row[] = $activity->tag_number;
            $row[] = wordwrap($activity->activity, 40, '<br/>', false);            
            
            $skillName = '';
            if($activity->skill1){
                $skillsArray = explode(',',$activity->skill1);
                foreach($skillsArray as $skillss){
                    $getskillName = $this->design_window_model->get_skills_name($skillss);                    
                    $skillName = $skillName.''.$getskillName->skills.'<br/>';
                }
            }
            $row[] = $skillName;
            
            //get perosn/usernames
            $userName = '';
            if($activity->person1){                
                $personArray = explode(',',$activity->person1);
                foreach($personArray as $userId){
                    $userNameList = $this->design_window_model->get_person_user_name($userId);                    
                    $userName = $userName.''.$userNameList->name.'<br/>';
                }
            } 
            $row[] = $userName;
            $row[] = $activity->delayDays;
            $row[] = $activity->clientApproval;
            // $row[] = $activity->startDate;  
            // $row[] = $activity->targetDate; 
            // $row[] = $activity->clientApproval;                     
             
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn";    

            $status = ($activity->status? "Active" : "Passive");
            $row[] = '<i data='."'".$activity->activityID."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';            

            $row[] = '<a href="'.base_url().'designwindow/editSingleActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                      <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_activity_data('.$activity->activityID.','.$activity->projectequipment.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                      <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->design_window_model->count_all($projectID),
            "recordsFiltered" => $this->design_window_model->count_filtered($projectID),
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
        $get_equipment_tag_no = $this->design_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->design_window_model->get_client_name($projectID); 
        $project_no = $this->design_window_model->get_Project_no_by_pid($projectID); 
        
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;
        // print_r($get_equipment_tag_no);
        // exit;
        $equipmentName = $get_equipment_tag_no->equipment_name;
        $tag_number = $get_equipment_tag_no->tag_number;
        
        $data['getAllDesignActivity'] = $this->design_window_model->getDesignEqpActivity($projectID,$projectequipment,$client_id);        

        // $data["activitylist"] = $this->design_window_model->get_design_activity();  
        $activity_list = $this->design_window_model->get_design_activity();  
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
                       
            $get_equipment_tag_no = $this->design_window_model->get_equipment_tag_no($projectequipment, $projectID);
            $client_name = $this->design_window_model->get_client_name($projectID); 
            $project_no = $this->design_window_model->get_Project_no_by_pid($projectID); 

            foreach($activity as $activity_list){
                $skill_list = $this->design_window_model->get_design_activity_skill($activity_list);
                
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
                $last_insert_id = $insert = $this->design_window_model->saveActivity($data);

                $logData = array();
                $logData = array(
                    'design_window_aa_id' => $last_insert_id,
                    'notification_type' => 2,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );

        
                $insertdata = $this->design_window_model->saveNotificationLog($logData);
            }

            // if($last_insert_id > 0){
            //     // $personData = array();
            //     // $per_names = '';
            //     foreach($person_name as $userid=>$name){
            //         $getname = $this->design_window_model->get_person_name($name);
            //         $personData = array(   
            //             'design_window_id'   => $last_insert_id,  
            //             'projectID'          => $projectID,            
            //             'projectequipment'   => $projectequipment, 
            //             'activityId'         => $activity, 
            //             // 'userId'             => $name,  
            //             // 'userName'           => $getname->name,                     				                                           				                      
            //         );
            //         $this->db->set($personData);
            //         $insertdata = $this->design_window_model->saveDesignActivityPersons($personData);
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
        $data['act_data'] = $this->design_window_model->get_activity_by_id($activityID);        
        $data["activitylist"] = $this->design_window_model->get_design_activity();          

        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->design_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->design_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $activity = $data['act_data']->activity;
        $totalSkills = $this->design_window_model->get_activity_skills_count($activity);         
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
        
        $data['skills_list'] = $this->design_window_model->get_design_activity_skill($activity);         
        $data['selected_skills'] = explode(',',$data['act_data']->skill1);

        $personsdata = array();   
        // $totalSkills = 3;            
        $activitySkills = $this->design_window_model->get_design_activity_wise_skill($activity);
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
        $data['act_data'] = $this->design_window_model->get_activity_by_id($activityID); 
        // print_r(); exit;       
        $activitylist = $this->design_window_model->get_activity_details($data['act_data']->activity);                 
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->design_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->design_window_model->get_equipment_tag_no($projectequipment, $projectID);        
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
        $skills_list = $this->design_window_model->get_design_activity_skill($activity);          
        foreach($skills_list as $skill)
        {
            $skill_name = $skill_name.' '.$skill->skills.'|';
        }
        $data['skills_list'] = $skill_name;        
         
        $userName = '';
        if($data['act_data']->person1){        
            $person_list = explode(',',$data['act_data']->person1);
            foreach($person_list as $persons){
                $userNameList = $this->design_window_model->get_person_user_name($persons);                    
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
        $data['activity_details'] = $this->design_window_model->get_activity_detail_by_id($activityID,$projectequipment);
        
        $skillName = '';
        if($data['activity_details']->skill1){
            $skillsArray = explode(',',$data['activity_details']->skill1);
            foreach($skillsArray as $skillss){
                $getskillName = $this->design_window_model->get_skills_name($skillss);                    
                $skillName = $skillName.''.$getskillName->skills.' | ';
            }
        }
        $data['skill1'] = $skillName;

        $userName = '';
        if($data['activity_details']->person1){                
            $personArray = explode(',',$data['activity_details']->person1);
            foreach($personArray as $userId){
                $userNameList = $this->design_window_model->get_person_user_name($userId);                    
                $userName = $userName.''.$userNameList->name.' | ';
            }
        } 
        $data['person1'] = $userName;        
        echo json_encode($data);
    }
    
    // public function delete_activity($activityID)
    // {
    //     $this->design_window_model->delete_by_id($activityID);
    //     echo json_encode(array("status" => TRUE));
    // }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->design_window_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }    

    public function update_status()
	{
        $this->design_window_model->update_status($this->input->post('activityID'), $this->input->post('status'));
	}

    public function export_csv($projectID)
	{         
        $design_data = $this->design_window_model->getActivityDetails($projectID);              
        
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
        $isDeleted = $this->design_window_model->delete_by_id($activityID);
        if($isDeleted > 0){
            $this->design_window_model->delete_persons_curr_activity($activityID);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }
        
    }

    public function getActivitySkill(){ 
        $activityID = $_POST['activityID'];       
        $data = $this->design_window_model->get_design_activity_skill($activityID);
        echo json_encode($data);                
    }

    public function getPersonsActivitySkill(){
        // print_r($_POST); exit;
        $data = array();
        $activityID = $_POST['activityID']; 
        $totalSkills = $_POST['totalSkills'];

        $activitySkills = $this->design_window_model->get_design_activity_wise_skill($activityID);
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
        $data = $this->design_window_model->get_design_activity_time($activityID);
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
            $this->design_window_model->updateActivity($data,$activityID);

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
                $updated_status_before = $this->design_window_model->is_UpdatedActivity_activityID($activityID);// for log module 
        
        
                        $insert = $this->design_window_model->updateActivity($activityData,$activityID);
                        

                $updated_status_after = $this->design_window_model->is_UpdatedActivity_activityID($activityID);// for log module
        
                      
                $logData = array();
                $logData = array(
                    'design_window_au_id' => $activityID,
                    'notification_type' => 3,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );

                
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->design_window_model->saveNotificationLog($logData);
                    }
                }
            
                // delete previus persons activities skills
                $this->design_window_model->beforeEditPeronsActivitySkills($activityID);

                foreach($person_name as $userid=>$name){
                    $getname = $this->design_window_model->get_person_name($name);
                    $personData = array(
                        'design_window_id'   => $activityID,  
                        'projectID'          => $projectID,            
                        'projectequipment'   => $projectequipment, 
                        'activityId'         => $activity, 
                        'userId'             => $name,  
                        'userName'           => $getname->name,                     				                                           				                      
                    );
                    $this->db->set($personData);
                    $insertdata = $this->design_window_model->saveDesignActivityPersons($personData);
                }
            }

            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data); 
        }
    }

    public function updateAllActivityOnce(){ // update all activity data at a time
        // print_r($_POST); exit;  
        if(isset($_POST['row_order']) && !empty($_POST['row_order']) && isset($_POST['activityID']) && !empty($_POST['activityID']) && isset($_POST['person_name_id']) && !empty($_POST['person_name_id']) && isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['startDate']) && !empty($_POST['startDate']) && isset($_POST['targetDate']) && !empty($_POST['targetDate']) )                      
        // if(isset($_POST['activityID']) && count($_POST['activityID']) > 0 && isset($_POST['person_name_id']) && count($_POST['person_name_id']) > 0 && isset($_POST['startDate']) && count($_POST['startDate']) > 0 && isset($_POST['targetDate']) && count($_POST['targetDate']) > 0)
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
                $updated_status_before = $this->design_window_model->is_UpdatedActivity_activityID($activityID);// for log module 
                        $update = $this->design_window_model->updateActivity($activityData,$activityID);
                $updated_status_after = $this->design_window_model->is_UpdatedActivity_activityID($activityID);// for log module
        
                      
                $logData = array();
                $logData = array(
                    'design_window_au_id' => $activityID,
                    'notification_type' => 3,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );

               
        
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->design_window_model->saveNotificationLog($logData);
                    }
                }

                if($manpower1 > 0){
                    // delete previus persons activities skills
                    $this->design_window_model->beforeEditPeronsActivitySkills($activityID);

                    for($j=0; $j < $total_persons; $j++){                        
                        $userId =  $person_name_id[$activityID][$j];
                        $getname = $this->design_window_model->get_person_name($userId);
                        
                        $personData = array(   
                            'design_window_id'   => $activityID,  
                            'projectID'          => $projectID,            
                            'projectequipment'   => $projectequipment, 
                            'activityId'         => $activity, 
                            'userId'             => $userId,  
                            'userName'           => $getname->name,                     				                                           				                      
                        );                        
                        $this->db->set($personData);
                        $insertdata = $this->design_window_model->saveDesignActivityPersons($personData);                                                          
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
                    // $update = $this->design_window_model->updateActivity($activityData1,$activityID);

                
                $updated_status_before = $this->design_window_model->is_UpdatedActivity_activityID($activityID);// for log module 
                        $update = $this->design_window_model->updateActivity($activityData1,$activityID);
                $updated_status_after = $this->design_window_model->is_UpdatedActivity_activityID($activityID);// for log module
        
                      
                $logData = array();
                $logData = array(
                    'design_window_au_id' => $activityID,
                    'notification_type' => 3,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );


                       
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->design_window_model->saveNotificationLog($logData);
                    }
                }


                    if($manpower1 > 0){
                        // delete previus persons activities skills
                        $this->design_window_model->beforeEditPeronsActivitySkills($activityID);

                        for($j=0; $j < $total_persons; $j++){                        
                            $userId =  $person_name_id[$activityID][$j];
                            $getname = $this->design_window_model->get_person_name($userId);
                            
                            $personData = array(   
                                'design_window_id'   => $activityID,  
                                'projectID'          => $projectID,            
                                'projectequipment'   => $projectequipment, 
                                'activityId'         => $activity, 
                                'userId'             => $userId,  
                                'userName'           => $getname->name,                     				                                           				                      
                            );                        
                            $this->db->set($personData);
                            $insertdata = $this->design_window_model->saveDesignActivityPersons($personData);                                                          
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
                $update = $this->design_window_model->updateActivity($activityData,$activityID);
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
                $get_activity_details = $this->design_window_model->get_activity_details_by_activity($projectID, $projectequipment, $i);
                
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
                $update_in_time = $this->design_window_model->updateNextActivityStartDate($startDate, $new_target_date_time,$activityID); 
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
        $this->design_window_model->updateProjectTimeline($project_id,$dataArray); 
        
        $data['designProjectStartDate'] = $designProjectStartDate;                    
        $data['designProjectEndDate'] = $designProjectEndDate;
        $data['designActualStartDate'] = $designActualStartDate;                    
        $data['designActualEndDate'] = $designActualEndDate;
        echo json_encode($data); 
    }
}
?>