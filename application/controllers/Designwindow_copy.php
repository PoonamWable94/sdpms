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
        $data['projectID'] = $_GET['projectID'];     // for listing selected project 
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
            $row[] = $activity->projectNo.'/'.$activity->company_name;
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
            $row[] = $activity->delayDays.' days';
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

        $get_equipment_tag_no = $this->design_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->design_window_model->get_client_name($projectID); 
        $project_no = $this->design_window_model->get_Project_no_by_pid($projectID); 
        
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;

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
        $data["activitylist"] = $this->design_window_model->get_activity_details($data['act_data']->activity); 

        // $data["activitylist"] = $this->design_window_model->get_design_activity();          
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->design_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->design_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;
        $totalSkills = $this->design_window_model->get_activity_skills_count($activity);                 
        $data['activityTime'] = $this->design_window_model->get_design_activity_time($activity);

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
        
        // Generating Activity Skills Dropdown...
        // $skills_list = $this->design_window_model->get_design_activity_skill($activity);  
        // $options        = array();
        // $options[""]    = "Select";
        // $selectedItemId = explode(',',$data['act_data']->skill1);
        // foreach($skills_list as $skill)
        // {
        //     $options[$skill->id] = $skill->skills;
        // }
        // $data["skills_list"] = form_multiselect("skill1[]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown", 'id' => 'skill1_id'));        
                         
        // $activitySkills = $this->design_window_model->get_design_activity_wise_skill($activity);
        // $options1        = array();
        // $options1[""]    = "Select";
        // $selectedItemId1 = explode(',',$data['act_data']->person1);
        // foreach($activitySkills as $skills){
        //     if($skills->totalSkills >= $totalSkills){
        //         $options1[$skills->userId] = $skills->name;
        //     }            
        // }
        // $data["persons_list"] = form_multiselect("person_name_id[]", $options1, $selectedItemId1, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown", 'id' => 'person_name_id'));                                
        echo '<pre>';
        print_r($data);exit;
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
            $prod_release   = $_POST['prod_release'];
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
                'prod_release'    => $prod_release, 				                                           				                      
            );
            //print_r($data); die;
            if($activityID > 0){
                $insert = $this->design_window_model->updateActivity($activityData,$activityID);
            
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
        if(isset($_POST['activityID']) && count($_POST['activityID']) > 0 && isset($_POST['person_name_id']) && count($_POST['person_name_id']) > 0 && isset($_POST['startDate']) && count($_POST['startDate']) > 0 && isset($_POST['targetDate']) && count($_POST['targetDate']) > 0)
        // if(isset($_POST['activityID']) && count($_POST['activityID']) > 0)
        {      
            $projectID = $_POST['projectID']; // single value
            $projectequipment = $_POST['projectequipment'];  // single value
            $total_cnt = count($_POST['activityID']);
            $total_persons = 0;

            // loop for all activities (no of rows)
            for($i=0; $i<$total_cnt;$i++){ // by activity ids
                $activityID = $_POST['activityID'][$i]; 
                $manpower1 = $_POST['manpower1'][$i];
                $person_name_id = $_POST['person_name_id'];
                if($manpower1 > 0){
                    $total_persons = count($person_name_id[$activityID]);  
                }
                                                    
                $activity = $_POST['activity_data_id'][$i];              
                                
                $startDate = $_POST['startDate'][$i];        
                $targetDate = $_POST['targetDate'][$i];                     
                $level = $_POST['level'][$i]; 
                $row_order = $_POST['row_order'][$i]; 
                $activity_days = $_POST['activity_days'][$i]; 
                $activity_time_hours = $_POST['activity_time_hours'][$i]; 
                $activity_time_minutes = $_POST['activity_time_minutes'][$i]; 
                $clientApproval = $_POST['clientApproval'][$i]; 
                $prod_release   = $_POST['prod_release'][$i];
                
                $person_list = '';
                if($manpower1 > 0){
                    for($j=0; $j < $total_persons; $j++){
                        $person_list = $person_list.''.$person_name_id[$activityID][$j].',';                 
                    }  
                    $person_list = rtrim($person_list,','); 
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
                    'prod_release'          => $prod_release, 				                                           				                      
                );
                
                if($activityID > 0){
                    $update = $this->design_window_model->updateActivity($activityData,$activityID);

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
}
?>