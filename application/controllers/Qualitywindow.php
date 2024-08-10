<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Qualitywindow extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quality_window_model');
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'PMS- Quality Department';
    }
    
    public function index()
    {                   
        $projectID = $data['projectID'] = $_GET['projectID'];     // for listing selected project 
        $data['project_info'] = $this->quality_window_model->get_project_info($projectID); 
        $this->loadViews("qualitywindow/listActivity", $this->global, $data);
    }   

    public function list_activity()  // **********************************
    {        
        $projectID = $_POST['projectID'];
        $list = $this->quality_window_model->get_datatables($projectID);        
        $data = array();
        $no = $_POST['start'];
       
        foreach ($list as $activity)
        {
            $no++;
            $skillName= '';
            $row = array();           
            $row[] = $no;                                                
            $row[] = $activity->equipment;
            $row[] = $activity->tag_number;
            $row[] = $activity->activity; 
            $row[] = $activity->quantity;                                               
            $row[] = $activity->name;         
            $row[] = $activity->clientApproval;  
            $row[] = $activity->prod_release;           
            $row[] = $activity->mfg_type;                     
                        
            $row[] = '<a href="'.base_url().'qualitywindow/editSingleActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>';
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->quality_window_model->count_all($projectID),
                "recordsFiltered" => $this->quality_window_model->count_filtered($projectID),
                "data" => $data,
            );        
        echo json_encode($output);
    }

    public function list_assembly_activity()   // *************************
    {        
        $projectID = $_POST['projectID'];
        $list = $this->quality_window_model->get_datatables_assembly($projectID);        
        $data = array();
        $no = $_POST['start'];
      
        foreach ($list as $activity)
        {
            $no++;
            $skillName= '';
            $row = array();           
            $row[] = $no;                                                
            $row[] = $activity->equipment;
            $row[] = $activity->tag_number;
            $row[] = $activity->activity; 
            $row[] = $activity->quantity;                                               
            $row[] = $activity->name;         
            $row[] = $activity->clientApproval;  
            $row[] = $activity->prod_release;           
            $row[] = $activity->mfg_type;                     
                        
            $row[] = '<a href="'.base_url().'qualitywindow/editSingleAssemblyActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>';
            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->quality_window_model->count_all_assembly($projectID),
                "recordsFiltered" => $this->quality_window_model->count_filtered_assembly($projectID),
                "data" => $data,
            );        
        echo json_encode($output);
    } 

    public function saveNewActivity()
    {
        // print_r($_POST); exit;        
        if(isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['activity']) && !empty($_POST['activity']))
        {             
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];  
            $activity = $_POST['activity'];   // array contains multiple activity numbers                              
                       
            $get_equipment_tag_no = $this->quality_window_model->get_equipment_tag_no($projectequipment, $projectID);
            $client_name = $this->quality_window_model->get_client_name($projectID); 
            $project_no = $this->quality_window_model->get_Project_no_by_pid($projectID); 
            $projectNo = $project_no->project_no; 
            $client_id = $client_name->id;
            // $clientName = $client_name->company_name;

            // $equipmentName = $get_equipment_tag_no->equipment_name;
            $tag_number = $get_equipment_tag_no->tag_number;

            foreach($activity as $activity_id){    
            // add components
                $data_array = array(
                    'projectNo'       => $projectNo,  
                    'client'          => $client_id,            
                    'projectequipment'=> $projectequipment, 
                    'tag_number'      => $tag_number, 
                    'projectID'       => $projectID,  
                    'activity'        => $activity_id,
                );
                // Save into qualitywindow table
                $last_component_id = $this->quality_window_model->saveActivity($data_array); 
                                
            // add assembly
                $sub_activity_list = $this->quality_window_model->get_production_sub_activity($activity_id);
                $sub_activity_array= '';
                $sub_act_order = 1;
                foreach($sub_activity_list as $sub_activity){                                        
                    $sub_activity_skills_array='';     
                    $sub_activity_id = $sub_activity->id;    

                    $sub_activity_skills = $this->quality_window_model->get_production_sub_activity_skills($activity_id,$sub_activity_id);
                    foreach($sub_activity_skills as $skills){                        
                        $sub_activity_skills_array.=$skills->id.',';
                    }
                                                                                                   
                    $data = array(   
                        'projectNo'       => $projectNo,  
                        'client'          => $client_id,            
                        'projectequipment'=> $projectequipment, 
                        'tag_number'      => $tag_number, 
                        'projectID'       => $projectID, 
                        'activityID'    => $last_component_id,                            
                        'activity'      => $activity_id,
                        'sub_activity'  => $sub_activity_id,
                        'skill'         => rtrim($sub_activity_skills_array,','),      
                        'sub_act_order' => $sub_act_order,
                    );  
                    // save into tg_production_comp_assembly table                 
                    $last_assembly_id = $this->quality_window_model->saveCompAssembly($data);
                    $sub_act_order++;
                }                
            }                              
            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data);       
        }                  
    }

    public function saveNewAssemblyActivity()
    {
        // print_r($_POST); exit;        
        if(isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['assembly']) && !empty($_POST['assembly']))
        {             
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];  
            $activity = $_POST['assembly'];   // array contains multiple assembly numbers                              
                       
            $get_equipment_tag_no = $this->quality_window_model->get_equipment_tag_no($projectequipment, $projectID);
            $client_name = $this->quality_window_model->get_client_name($projectID); 
            $project_no = $this->quality_window_model->get_Project_no_by_pid($projectID); 
            $projectNo = $project_no->project_no; 
            $client_id = $client_name->id;
            // $clientName = $client_name->company_name;

            // $equipmentName = $get_equipment_tag_no->equipment_name;
            $tag_number = $get_equipment_tag_no->tag_number;

            foreach($activity as $activity_id){    
            // add components
                $data_array = array(
                    'projectNo'       => $projectNo,  
                    'client'          => $client_id,            
                    'projectequipment'=> $projectequipment, 
                    'tag_number'      => $tag_number, 
                    'projectID'       => $projectID,  
                    'activity'        => $activity_id,
                );
                // Save into qualitywindow table
                $last_component_id = $this->quality_window_model->saveAssembly($data_array); 

            // add assembly
                $sub_activity_list = $this->quality_window_model->get_production_sub_assembly($activity_id);
                $sub_activity_array= '';
                $sub_act_order = 1;
                foreach($sub_activity_list as $sub_activity){                                        
                    $sub_activity_skills_array='';     
                    $sub_activity_id = $sub_activity->id;    

                    $sub_activity_skills = $this->quality_window_model->get_production_sub_assemly_skills($activity_id,$sub_activity_id);
                    foreach($sub_activity_skills as $skills){                        
                        $sub_activity_skills_array.=$skills->id.',';
                    }
                                                                                                   
                    $data = array(   
                        'projectNo'       => $projectNo,  
                        'client'          => $client_id,            
                        'projectequipment'=> $projectequipment, 
                        'tag_number'      => $tag_number, 
                        'projectID'       => $projectID, 
                        'activityID'    => $last_component_id,                            
                        'activity'      => $activity_id,
                        'sub_activity'  => $sub_activity_id,
                        'skill'         => rtrim($sub_activity_skills_array,','),      
                        'sub_act_order' => $sub_act_order,
                    );  
                    // save into tg_production_comp_assembly table                 
                    $last_assembly_id = $this->quality_window_model->saveSubAssemblyActivity($data);
                    $sub_act_order++;
                }                
            }                              
            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data);       
        }                  
    }    

    public function editSingleActivity($activityID) //Activity ID from design projects my activity list..
    {        
        $data['act_data'] = $this->quality_window_model->get_activity_by_id($activityID);                         
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->quality_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->quality_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;    
        $main_activity_name = $this->quality_window_model->get_main_activity_name($activity);     

        $client_name = $client_name->company_name;
        $projectNo = $data['act_data']->projectNo;
        $equipment_name = $get_equipment_tag_no->equipment_name;
        $tag_number = $data['act_data']->tag_number; 
        $clientApproval = $data['act_data']->clientApproval; 
        
        $data['activityID'] = $activityID;
        $data['projectID'] = $projectID;
        $data['projectequipment'] = $projectequipment;
        $data['client_name'] = $client_name;        
        $data['projectNo'] = $projectNo;        
        $data['projectequipmentName'] = $equipment_name;        
        $data['tag_number'] = $tag_number; 
        $data['main_activity_id']  = $activity;
        $data['main_activity_name']  = $main_activity_name->task;
        $data['main_client_approval'] = $clientApproval;
        $data['get_assembly_data'] = $this->quality_window_model->get_component_assembly_data($projectID, $projectequipment, $activityID, $activity);         
        
        // echo '<pre>';
        // print_r($data);exit;
        $this->loadViews("qualitywindow/editActivity", $this->global, $data);                   
    } 
    
    public function editSingleAssemblyActivity($activityID) //Activity ID from design projects my activity list..
    {        
        $data['act_data'] = $this->quality_window_model->get_assembly_activity_by_id($activityID);                         
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->quality_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->quality_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;    
        $main_activity_name = $this->quality_window_model->get_main_assembly_activity_name($activity);     

        $client_name = $client_name->company_name;
        $projectNo = $data['act_data']->projectNo;
        $equipment_name = $get_equipment_tag_no->equipment_name;
        $tag_number = $data['act_data']->tag_number; 
        $clientApproval = $data['act_data']->clientApproval; 
        
        $data['activityID'] = $activityID;
        $data['projectID'] = $projectID;
        $data['projectequipment'] = $projectequipment;
        $data['client_name'] = $client_name;        
        $data['projectNo'] = $projectNo;        
        $data['projectequipmentName'] = $equipment_name;        
        $data['tag_number'] = $tag_number; 
        $data['main_activity_id']  = $activity;
        $data['main_activity_name']  = $main_activity_name->assembly;
        $data['main_client_approval'] = $clientApproval;
        $data['get_assembly_data'] = $this->quality_window_model->get_sub_assembly_activity_data($projectID, $projectequipment, $activityID, $activity);         
        
        // echo '<pre>';
        // print_r($data);exit;
        $this->loadViews("qualitywindow/editAssemblyActivity", $this->global, $data);                   
    } 


    public function get_activity_detail()
    {
        $activityID = $_GET['activityID'];
        $projectequipment = $_GET['projectequipment'];
        $data['activity_details'] = $this->quality_window_model->get_activity_detail_by_id($activityID,$projectequipment);
        
        $skillName = '';
        if($data['activity_details']->skill1){
            $skillsArray = explode(',',$data['activity_details']->skill1);
            foreach($skillsArray as $skillss){
                $getskillName = $this->quality_window_model->get_skills_name($skillss);                    
                $skillName = $skillName.''.$getskillName->skills.' | ';
            }
        }
        $data['skill1'] = $skillName;

        $userName = '';
        if($data['activity_details']->person1){                
            $personArray = explode(',',$data['activity_details']->person1);
            foreach($personArray as $userId){
                $userNameList = $this->quality_window_model->get_person_user_name($userId);                    
                $userName = $userName.''.$userNameList->name.' | ';
            }
        } 
        $data['person1'] = $userName;        
        echo json_encode($data);
    }       

    public function update_client_approval()
	{
        $this->quality_window_model->update_client_approval($this->input->post('activityID'), $this->input->post('clientApproval'));
	}

    public function update_prod_release()
	{
        $this->quality_window_model->update_prod_release($this->input->post('activityID'), $this->input->post('prod_release'));
	}

    public function export_csv($projectID)
	{         
        $design_data = $this->quality_window_model->getActivityDetails($projectID);              
        
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

    public function getActivitySkill(){ 
        $activityID = $_POST['activityID'];       
        $data = $this->quality_window_model->get_production_sub_activity($activityID);
        echo json_encode($data);                
    }

    public function getPersonsActivitySkill(){
        // print_r($_POST); exit;
        $data = array();
        $activityID = $_POST['activityID']; 
        $totalSkills = $_POST['totalSkills'];

        $activitySkills = $this->quality_window_model->get_design_activity_wise_skill($activityID);
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
        $data = $this->quality_window_model->get_design_activity_time($activityID);
        echo json_encode($data);
    }

    public function updateOrder(){
        $row_order = $_POST['row_order'];
        $activityID = $_POST['activityID'];

        $update_order = $this->quality_window_model->update_row_order($row_order,$activityID);
        if($update_order > 0){
            $data['activityID'] = $activityID;                     
            echo json_encode($data);
        }else{
            $data['activityID'] = 0;                     
            echo json_encode($data);
        }         
    }

    public function updateAssemblyActivityOrder(){
        $row_order = $_POST['row_order'];
        $activityID = $_POST['activityID'];

        $update_order = $this->quality_window_model->updateAssemblyActivityOrder($row_order,$activityID);
        if($update_order > 0){
            $data['activityID'] = $activityID;                     
            echo json_encode($data);
        }else{
            $data['activityID'] = 0;                     
            echo json_encode($data);
        }         
    }

    

    public function updateAssembly(){
        // print_r($_POST); exit;
        $out_data = array();
        if(isset($_POST['assemblyID']) && !empty($_POST['assemblyID'])){
            $assemblyID = $_POST['assemblyID']; 
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];
            $activity_id = $_POST['activity_id']; 
            $main_activity_id = $_POST['main_activity_id']; 
            $sub_activity_id = $_POST['sub_activity_id']; 

            $sub_activity_name = $_POST['sub_activity'];           
            $manpower = $_POST['manpower']; 
            $targetDate   = $_POST['targetDate'];
            $startDate = $_POST['startDate'];
            $activity_days = $_POST['activity_days'];
            $activity_time_hours = $_POST['activity_time_hours']; 
            $activity_time_minutes = $_POST['activity_time_minutes']; 
            // $quality_qc_date = $_POST['quality_qc_date'];
            // $quality_qc_remark = $_POST['quality_qc_remark'];
            // $tpi_qc_date = $_POST['tpi_qc_date'];
            $tpi_qc_remark = $_POST['tpi_qc_remark'];
            $mfg_type   = $_POST['mfg_type'];
            $clientApproval   = $_POST['clientApproval'];
            // $prod_release       = $_POST['prod_release'];
            $mfg_type   = $_POST['mfg_type'];
            $person1 = $_POST['person_name_id'];
            $person_name = $_POST['person_name_id'];

             $personUserId = '';
            foreach($person1 as $userid=>$name){
                $personUserId = $personUserId.''.$name.',';
            }

            $data = array(
                'resp_persons'              => rtrim($personUserId,','),
                'sub_activity_name'   => $sub_activity_name,
                'manpower'            => $manpower, 
                'targetDate'          => $targetDate, 
                'startDate'            => $startDate, 
                'activity_days'        => $activity_days, 
                'activity_time_hours'  => $activity_time_hours,
                'activity_time_minutes'  => $activity_time_minutes,
                // 'quality_qc_date'      => $quality_qc_date,
                // 'quality_qc_remark'    => $quality_qc_remark,
                // 'tpi_qc_date'          => $tpi_qc_date,
                'tpi_qc_remark'        => $tpi_qc_remark,
                'clientApproval'       => $clientApproval,
                // 'prod_release'         => $prod_release,
                'mfg_type'             => $mfg_type,
                'is_all_updated'       => 1,
            );
            $this->quality_window_model->updateAssemblyActivity($data,$assemblyID);

            //delete previus persons activities skills
            $this->quality_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

            foreach($person_name as $userid=>$name){
                $getname = $this->quality_window_model->get_person_name($name);
                $personData = array(   
                    'assembly_id'        => $assemblyID,  
                    'projectID'          => $projectID,            
                    'projectequipment'   => $projectequipment, 
                    'activityId'         => $main_activity_id, 
                    'sub_activityID'     => $sub_activity_id, 
                    'userId'             => $name,  
                    'userName'           => $getname->name,                     				                                           				                      
                );
                $this->db->set($personData);
                $insertdata = $this->quality_window_model->saveDesignActivityPersons($personData);
            }
            
            $out_data['assemblyID'] = $assemblyID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['assemblyID'] = 0;                     
            echo json_encode($out_data); 
        }
    }   
     
    public function updateAssemblySubActivity(){
        // print_r($_POST); exit;
        $out_data = array();
        if(isset($_POST['assemblyID']) && !empty($_POST['assemblyID'])){
            $assemblyID = $_POST['assemblyID']; 
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];
            $activity_id = $_POST['activity_id']; 
            $main_activity_id = $_POST['main_activity_id']; 
            $sub_activity_id = $_POST['sub_activity_id']; 

            $sub_activity_name = $_POST['sub_activity'];           
            $manpower = $_POST['manpower']; 
            $targetDate   = $_POST['targetDate'];
            $startDate = $_POST['startDate'];
            $activity_days = $_POST['activity_days'];
            $activity_time_hours = $_POST['activity_time_hours']; 
            $activity_time_minutes = $_POST['activity_time_minutes']; 
            // $quality_qc_date = $_POST['quality_qc_date'];
            // $quality_qc_remark = $_POST['quality_qc_remark'];
            // $tpi_qc_date = $_POST['tpi_qc_date'];
            $tpi_qc_remark = $_POST['tpi_qc_remark'];
            $mfg_type   = $_POST['mfg_type'];
            $clientApproval   = $_POST['clientApproval'];
            // $prod_release       = $_POST['prod_release'];
            $mfg_type   = $_POST['mfg_type'];
            $person1 = $_POST['person_name_id'];
            $person_name = $_POST['person_name_id'];

             $personUserId = '';
            foreach($person1 as $userid=>$name){
                $personUserId = $personUserId.''.$name.',';
            }

            $data = array(
                'resp_persons'              => rtrim($personUserId,','),
                'sub_activity_name'   => $sub_activity_name,
                'manpower'            => $manpower, 
                'targetDate'          => $targetDate, 
                'startDate'            => $startDate, 
                'activity_days'        => $activity_days, 
                'activity_time_hours'  => $activity_time_hours,
                'activity_time_minutes'  => $activity_time_minutes,
                // 'quality_qc_date'      => $quality_qc_date,
                // 'quality_qc_remark'    => $quality_qc_remark,
                // 'tpi_qc_date'          => $tpi_qc_date,
                'tpi_qc_remark'        => $tpi_qc_remark,
                'clientApproval'       => $clientApproval,
                // 'prod_release'         => $prod_release,
                'mfg_type'             => $mfg_type,
                'is_all_updated'       => 1,
            );
            $this->quality_window_model->updateSubAssemblyActivityData($data,$assemblyID);

            // //delete previus persons activities skills
            // $this->quality_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

            // foreach($person_name as $userid=>$name){
            //     $getname = $this->quality_window_model->get_person_name($name);
            //     $personData = array(   
            //         'assembly_id'        => $assemblyID,  
            //         'projectID'          => $projectID,            
            //         'projectequipment'   => $projectequipment, 
            //         'activityId'         => $main_activity_id, 
            //         'sub_activityID'     => $sub_activity_id, 
            //         'userId'             => $name,  
            //         'userName'           => $getname->name,                     				                                           				                      
            //     );
            //     $this->db->set($personData);
            //     $insertdata = $this->quality_window_model->saveDesignActivityPersons($personData);
            // }
            
            $out_data['assemblyID'] = $assemblyID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['assemblyID'] = 0;                     
            echo json_encode($out_data); 
        }
    }  

    public function updateActivity(){ // update single activity data        
        // print_r($_POST); exit;   
        $out_data = array();
        if(isset($_POST['activityID']) && !empty($_POST['activityID']) && isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']))
        { 
            // print_r($_POST); exit;  
            $activityID = $_POST['activityID'];
            $projectID = $_POST['projectID']; //
            $projectequipment = $_POST['projectequipment'];  // 
            // $activity = $_POST['activity_data_id'];              
            $supervisor = $_POST['supervisor'];                
            $quantity = $_POST['quantity'];        
            // $ind_time = $_POST['ind_time']; 
            // $ind_time_hidden = $_POST['ind_time_hidden'];                                             
            $total_time_hidden = $_POST['total_time_hidden']; 
            $total_time = $_POST['total_time'];             
            $clientApproval = $_POST['clientApproval']; 
            // $prod_release   = $_POST['prod_release'];
            $mfg_type = $_POST['mfg_type'];                        
            
            $activityData = array(    
                'quantity'       => $quantity, 
                'supervisor'       => $supervisor, 
                // 'ind_time'       => $ind_time, 
                // 'ind_time_hidden' => $ind_time_hidden,
                'total_time'       => $total_time,  
                'total_time_hidden' => $total_time_hidden,                                                                             	
                'clientApproval'  => $clientApproval, 
                // 'prod_release'    => $prod_release,                
                'mfg_type'       => $mfg_type, 	
                'dateModified'   => date('Y-m-d H:i:s',time()),                                           				                      
            );
            
            if($activityID > 0){
                $insert = $this->quality_window_model->updateActivity($activityData,$activityID);                            
            }

            $out_data['projectID'] = $projectID;        
            $out_data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($out_data); 
        }
    }

    public function updateAssemblyActivity(){ // update single activity data        
        // print_r($_POST); exit;   
        $out_data = array();
        if(isset($_POST['activityID']) && !empty($_POST['activityID']) && isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']))
        { 
            $activityID = $_POST['activityID'];
            $projectID = $_POST['projectID']; //
            $projectequipment = $_POST['projectequipment'];  // 
            // $activity = $_POST['activity_data_id'];              
            $supervisor = $_POST['supervisor'];                
            $quantity = $_POST['quantity'];        
            // $ind_time = $_POST['ind_time']; 
            // $ind_time_hidden = $_POST['ind_time_hidden'];                                             
            $total_time_hidden = $_POST['total_time_hidden']; 
            $total_time = $_POST['total_time'];             
            $clientApproval = $_POST['clientApproval']; 
            // $prod_release   = $_POST['prod_release'];
            $mfg_type = $_POST['mfg_type'];                        
            
            $activityData = array(    
                'quantity'       => $quantity, 
                'supervisor'       => $supervisor, 
                // 'ind_time'       => $ind_time, 
                // 'ind_time_hidden' => $ind_time_hidden,
                'total_time'       => $total_time,  
                'total_time_hidden' => $total_time_hidden,                                                                             	
                'clientApproval'  => $clientApproval, 
                // 'prod_release'    => $prod_release,                
                'mfg_type'       => $mfg_type, 	
                'dateModified'   => date('Y-m-d H:i:s',time()),                                           				                      
            );
            
            if($activityID > 0){
                $insert = $this->quality_window_model->updateAssemblyActvt($activityData,$activityID);                            
            }

            $out_data['projectID'] = $projectID;        
            $out_data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($out_data); 
        }
    }    

    public function update_all_subactivity(){ // ************************
        // echo '<pre>';
        // print_r($_POST);exit;
        $out_data = array();
        $activityID = $_POST['activityID']; 
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];            
        $main_activity_id = $_POST['main_activity_id'];

        if($projectID > 0 && $activityID > 0){                         
            $count = count($_POST['assemblyID']);

            for($i = 0; $i < $count; $i++){                
                $assemblyID = $_POST['assemblyID'][$i];
                $quality_qc_date = $_POST['quality_qc_date'][$i];
                $quality_qc_remark = $_POST['quality_qc_remark'][$i];
                $tpi_qc_date = $_POST['tpi_qc_date'][$i];
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];
                // $clientApproval   = $_POST['clientApproval'][$i];
                $prod_release       = $_POST['prod_release'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];

                $data = array(                   
                    'quality_qc_date'      => $quality_qc_date,
                    'quality_qc_remark'    => $quality_qc_remark,
                    'tpi_qc_date'          => $tpi_qc_date,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    // 'clientApproval'       => $clientApproval,
                    'prod_release'         => $prod_release,
                    'mfg_type'             => $mfg_type,                    
                );
                $this->quality_window_model->updateAssemblyActivity($data,$assemblyID);
            }
            $out_data['projectID'] = $projectID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['projectID'] = 0;                     
            echo json_encode($out_data); 
        }
    }

    public function update_all_assembly_subactivity(){ // ******************
        // echo '<pre>';
        // print_r($_POST);exit;
        $out_data = array();
        $activityID = $_POST['activityID']; 
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];            
        $main_activity_id = $_POST['main_activity_id'];

        if($projectID > 0 && $activityID > 0){                         
            $count = count($_POST['assemblyID']);

            for($i = 0; $i < $count; $i++){                
                $assemblyID = $_POST['assemblyID'][$i];
                $quality_qc_date = $_POST['quality_qc_date'][$i];
                $quality_qc_remark = $_POST['quality_qc_remark'][$i];
                $tpi_qc_date = $_POST['tpi_qc_date'][$i];
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];
                // $clientApproval   = $_POST['clientApproval'][$i];
                $prod_release       = $_POST['prod_release'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];

                $data = array(                   
                    'quality_qc_date'      => $quality_qc_date,
                    'quality_qc_remark'    => $quality_qc_remark,
                    'tpi_qc_date'          => $tpi_qc_date,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    // 'clientApproval'       => $clientApproval,
                    'prod_release'         => $prod_release,
                    'mfg_type'             => $mfg_type,                    
                );
                $this->quality_window_model->update_all_assembly_subactivity($data,$assemblyID);
            }
            $out_data['projectID'] = $projectID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['projectID'] = 0;                     
            echo json_encode($out_data); 
        }
    }
    public function add_dossier_doc(){
        if(isset($_POST['projectID']) && !empty($_POST['projectID'])){
            $projectID = $_POST['projectID'];
            $docs = $this->quality_window_model->get_all_dossier_docs();

            foreach($docs as $key){
                $data = array(
                    'projectID' => $projectID,
                    'name_doc_id' => $key->id,
                    'name_doc' => $key->name_doc,                    
                );
                $this->quality_window_model->saveDossierDocs($data);
            }            
            echo json_encode($projectID);
        }else{
            $projectID = 0;
            echo json_encode($projectID);
        }
    }

    public function updateAllDocumentsOnce(){
        // 
        $projectID = $_POST['projectID'];
        $get_cnt = count($_POST['status']);
        // print_r($projectID);
        // print_r($get_cnt);
        // exit;
        if($get_cnt > 0){
            for($i = 0; $i < $get_cnt; $i++){
                $data = array(
                    'status' => $_POST['status'][$i],  
                    'remark' => $_POST['remark'][$i],                    
                );
                // print_r($data);
                $this->quality_window_model->updateDossierDocs($data,$projectID,$_POST['name_doc_id'][$i]);
            }
            // exit;
            echo json_encode($projectID);
        }else{
            $projectID = 0;
            echo json_encode($projectID);
        }
        
    }
}
?>