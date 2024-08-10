<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Productionwindow extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_window_model');
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'PMS- Production Department';
    }
    
    public function index()
    {                   
        $projectID = $data['projectID'] = $_GET['projectID'];     // for listing selected project 
        $data['project_info'] = $this->production_window_model->get_project_info($projectID); 
        $this->loadViews("productionwindow/listActivity", $this->global, $data);
    }   

    public function list_activity()
    {        
        $projectID = $_POST['projectID'];
        $list = $this->production_window_model->get_datatables($projectID);        
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
            $row[] = $activity->activity; 
            $row[] = $activity->quantity;                                    
            $row[] = $activity->ind_time;
            $row[] = $activity->total_time; 
            $row[] = $activity->name;  
            $row[] = $activity->clientApproval;            
            $row[] = $activity->prod_release; 
            $row[] = $activity->mfg_type;                     
             
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn";    

            $status = ($activity->status? "Active" : "Passive");
            $row[] = '<i data='."'".$activity->activityID."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';            

            // $row[] = '<a href="'.base_url().'productionwindow/editSingleActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
            //           <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_activity_data('.$activity->activityID.','.$activity->projectequipment.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
            //           <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $row[] = '                      
                    <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';
            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->production_window_model->count_all($projectID),
                "recordsFiltered" => $this->production_window_model->count_filtered($projectID),
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

        $get_equipment_tag_no = $this->production_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->production_window_model->get_client_name($projectID); 
        $project_no = $this->production_window_model->get_Project_no_by_pid($projectID); 
        
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;

        $equipmentName = $get_equipment_tag_no->equipment_name;
        $tag_number = $get_equipment_tag_no->tag_number;
        
        $data['getAllProductionActivity'] = $this->production_window_model->getProductionActivityData($projectID,$projectequipment,$client_id);        
             
        $data['prod_dept_supervisors'] = $this->production_window_model->get_production_dept_supervisors_persons();

        $activity_list = $this->production_window_model->get_production_activity();  
        $options        = array();
        $options[""]    = "";
        $selectedItemId = "";
        foreach($activity_list as $activity)
        {
            $options[$activity->id] = $activity->task;
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
        $this->loadViews("productionwindow/addActivity", $this->global, $data);                  
    }

    public function saveNewActivity()
    {
        // print_r($_POST); exit;        
        if(isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']) && isset($_POST['activity']) && !empty($_POST['activity']))
        {             
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];  
            $activity = $_POST['activity'];   // array contains multiple activity numbers                              
                       
            $get_equipment_tag_no = $this->production_window_model->get_equipment_tag_no($projectequipment, $projectID);
            $client_name = $this->production_window_model->get_client_name($projectID); 
            $project_no = $this->production_window_model->get_Project_no_by_pid($projectID); 
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
                // Save into productionwindow table
                $last_component_id = $this->production_window_model->saveActivity($data_array); 
                                
            // add assembly
                $sub_activity_list = $this->production_window_model->get_production_sub_activity($activity_id);
                $sub_activity_array= '';
                foreach($sub_activity_list as $sub_activity){                                        
                    $sub_activity_skills_array='';     
                    $sub_activity_id = $sub_activity->id;    

                    $sub_activity_skills = $this->production_window_model->get_production_sub_activity_skills($activity_id,$sub_activity_id);
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
                    );  
                    // save into tg_production_comp_assembly table                 
                    $last_assembly_id = $this->production_window_model->saveCompAssembly($data);
                }                
            }                              
            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data);       
        }                  
    }

    public function editActivityView() //Activity ID
    {
        $activityID = $_POST['activityID'];
        $data['act_data'] = $this->production_window_model->get_activity_by_id($activityID);        
        $data["activitylist"] = $this->production_window_model->get_production_sub_activity();          

        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->production_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->production_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;
        $totalSkills = $this->production_window_model->get_activity_skills_count($activity);         
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
        
        $data['skills_list'] = $this->production_window_model->get_production_sub_activity($activity);         
        $data['selected_skills'] = explode(',',$data['act_data']->skill1);

        $personsdata = array();   
        // $totalSkills = 3;            
        $activitySkills = $this->production_window_model->get_design_activity_wise_skill($activity);
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
        $data['act_data'] = $this->production_window_model->get_activity_by_id($activityID); 
        // print_r(); exit;       
        $activitylist = $this->production_window_model->get_activity_details($data['act_data']->activity);                 
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->production_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->production_window_model->get_equipment_tag_no($projectequipment, $projectID);        
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
        $skills_list = $this->production_window_model->get_production_sub_activity($activity);          
        foreach($skills_list as $skill)
        {
            $skill_name = $skill_name.' '.$skill->skills.'|';
        }
        $data['skills_list'] = $skill_name;        
         
        $userName = '';
        if($data['act_data']->person1){        
            $person_list = explode(',',$data['act_data']->person1);
            foreach($person_list as $persons){
                $userNameList = $this->production_window_model->get_person_user_name($persons);                    
                $userName = $userName.''.$userNameList->name.' | ';
            }
        }
        $data['person_names'] = $userName;
        
        // echo '<pre>';
        // print_r($data);exit;
        $this->loadViews("productionwindow/editActivity", $this->global, $data);                   
    }    

    public function get_activity_detail()
    {
        $activityID = $_GET['activityID'];
        $projectequipment = $_GET['projectequipment'];
        $data['activity_details'] = $this->production_window_model->get_activity_detail_by_id($activityID,$projectequipment);
        
        $skillName = '';
        if($data['activity_details']->skill1){
            $skillsArray = explode(',',$data['activity_details']->skill1);
            foreach($skillsArray as $skillss){
                $getskillName = $this->production_window_model->get_skills_name($skillss);                    
                $skillName = $skillName.''.$getskillName->skills.' | ';
            }
        }
        $data['skill1'] = $skillName;

        $userName = '';
        if($data['activity_details']->person1){                
            $personArray = explode(',',$data['activity_details']->person1);
            foreach($personArray as $userId){
                $userNameList = $this->production_window_model->get_person_user_name($userId);                    
                $userName = $userName.''.$userNameList->name.' | ';
            }
        } 
        $data['person1'] = $userName;        
        echo json_encode($data);
    }
    
    // public function delete_activity($activityID)
    // {
    //     $this->production_window_model->delete_by_id($activityID);
    //     echo json_encode(array("status" => TRUE));
    // }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->production_window_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }    

    public function update_status()
	{
        $this->production_window_model->update_status($this->input->post('activityID'), $this->input->post('status'));
	}

    public function export_csv($projectID)
	{         
        $design_data = $this->production_window_model->getActivityDetails($projectID);              
        
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
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];
        $isDeleted = $this->production_window_model->delete_by_id($activityID);
        $isDeleted1 = $this->production_window_model->delete_assembly_by_id($activityID,$projectID,$projectequipment);        

        if($isDeleted > 0 && $isDeleted1 > 0){
            $this->production_window_model->delete_persons_curr_activity($activityID,$projectID,$projectequipment);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }        
    }

    public function delete_new_assembly(){
        $assemblyID = $_POST['assemblyID'];        
        $isDeleted = $this->production_window_model->delete_one_assembly_by_id($assemblyID);        

        if($isDeleted > 0){            
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        } 
    }

    public function getActivitySkill(){ 
        $activityID = $_POST['activityID'];       
        $data = $this->production_window_model->get_production_sub_activity($activityID);
        echo json_encode($data);                
    }

    public function getPersonsActivitySkill(){
        // print_r($_POST); exit;
        $data = array();
        $activityID = $_POST['activityID']; 
        $totalSkills = $_POST['totalSkills'];

        $activitySkills = $this->production_window_model->get_design_activity_wise_skill($activityID);
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
        $data = $this->production_window_model->get_design_activity_time($activityID);
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
            $delayRemark = $_POST['delayRemark'];
            $clientApproval = $_POST['clientApproval']; 
            $prod_release   = $_POST['prod_release'];

            $data = array(
                'taskCompDate'    => $taskCompDate, 
                'delayDays'       => $delayDays, 
                'delayRemark'     => $delayRemark, 
                'clientApproval'  => $clientApproval, 
                'prod_release'    => $prod_release,
            );
            $this->production_window_model->updateActivity($data,$activityID);

            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data); 

        }else{
            $data['projectID'] = 0;        
            $data['projectequipment'] = 0;  // equipment in no format        
            echo json_encode($data); 
        }
    }

    public function updateOrder(){
        $row_order = $_POST['row_order'];
        $activityID = $_POST['activityID'];

        $update_order = $this->production_window_model->update_row_order($row_order,$activityID);
        if($update_order > 0){
            $data['activityID'] = $activityID;                     
            echo json_encode($data);
        }else{
            $data['activityID'] = 0;                     
            echo json_encode($data);
        }         
    }

    public function duplicateComponent(){
        $activityID = $_POST['activityID'];
        $data['act_data'] = $this->production_window_model->get_activity_by_id($activityID);
        $comp_data = array(
            'projectID' => $data['act_data']->projectID,
            'projectNo' => $data['act_data']->projectNo,
            'row_order' => $data['act_data']->row_order,
            'client' => $data['act_data']->client,
            'projectequipment' => $data['act_data']->projectequipment,
            'tag_number' => $data['act_data']->tag_number,
            'activity' => $data['act_data']->activity,
            'sub_activity' => $data['act_data']->sub_activity,
            'supervisor' => $data['act_data']->supervisor,
            'quantity' => $data['act_data']->quantity,
            'ind_time' => $data['act_data']->ind_time,
            'ind_time_hidden' => $data['act_data']->ind_time_hidden,
            'total_time_hidden' => $data['act_data']->total_time_hidden,
            'total_time' => $data['act_data']->total_time,            
            'clientApproval' => $data['act_data']->clientApproval,
            'prod_release' => $data['act_data']->prod_release,
            'mfg_type' => $data['act_data']->mfg_type,                       
        );

        $duplicate_component_id = $this->production_window_model->saveActivity($comp_data);
        
        $duplicate_assembly = $this->production_window_model->get_duplicate_assembly($activityID);        
        foreach($duplicate_assembly as $assembly){
            $assembly_data = array(
                'activityID'          => $duplicate_component_id,
                'projectID'           => $assembly->projectID,
                'projectNo'           => $assembly->projectNo,
                'client'              => $assembly->client,
                'projectequipment'    => $assembly->projectequipment,
                'tag_number'          => $assembly->tag_number,                
                'activity'            => $assembly->activity,
                'sub_activity'        => $assembly->sub_activity,
                'sub_activity_name'   => $assembly->sub_activity_name,
                'skill'               => $assembly->skill,                
                'activity_days'            => $assembly->activity_days, 
                'activity_time_hours'     => $assembly->activity_time_hours, 
                'activity_time_minutes'   => $assembly->activity_time_minutes, 
                'total_time'          => $assembly->total_time, 
                'total_time_save'     => $assembly->total_time_save,
                'startDate'            => $assembly->startDate,
                'targetDate'            => $assembly->targetDate,
                'manpower'            => $assembly->manpower,
                'resp_persons'            => $assembly->resp_persons,
                'quality_qc_date'            => $assembly->quality_qc_date,
                'quality_qc_remark'            => $assembly->quality_qc_remark,
                'tpi_qc_date'            => $assembly->tpi_qc_date,
                'tpi_qc_remark'            => $assembly->tpi_qc_remark,
                'clientApproval'            => $assembly->clientApproval,
                'prod_release'            => $assembly->prod_release,
                'mfg_type'            => $assembly->mfg_type,
                'is_all_updated'      => 1,
            );
            $this->production_window_model->saveCompAssembly($assembly_data);
        }

        if($duplicate_component_id > 0){
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
            $quality_qc_date = $_POST['quality_qc_date'];
            $quality_qc_remark = $_POST['quality_qc_remark'];
            $tpi_qc_date = $_POST['tpi_qc_date'];
            $tpi_qc_remark = $_POST['tpi_qc_remark'];
            $mfg_type   = $_POST['mfg_type'];
            $clientApproval   = $_POST['clientApproval'];
            $prod_release       = $_POST['prod_release'];
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
                'quality_qc_date'      => $quality_qc_date,
                'quality_qc_remark'    => $quality_qc_remark,
                'tpi_qc_date'          => $tpi_qc_date,
                'tpi_qc_remark'        => $tpi_qc_remark,
                'clientApproval'       => $clientApproval,
                'prod_release'         => $prod_release,
                'mfg_type'             => $mfg_type,
                'is_all_updated'       => 1,
            );
            $this->production_window_model->updateAssemblyActivity($data,$assemblyID);

            //delete previus persons activities skills
            $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

            foreach($person_name as $userid=>$name){
                $getname = $this->production_window_model->get_person_name($name);
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
                $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);
            }
            
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
            $activityID = $_POST['activityID'];
            $projectID = $_POST['projectID']; //
            $projectequipment = $_POST['projectequipment'];  // 
            // $activity = $_POST['activity_data_id'];              
            $supervisor = $_POST['supervisor'];                
            $quantity = $_POST['quantity'];        
            $ind_time = $_POST['ind_time']; 
            $ind_time_hidden = $_POST['ind_time_hidden'];                                             
            $total_time_hidden = $_POST['total_time_hidden']; 
            $total_time = $_POST['total_time'];             
            $clientApproval = $_POST['clientApproval']; 
            $prod_release   = $_POST['prod_release'];
            $mfg_type = $_POST['mfg_type'];                        
            
            $activityData = array(    
                'quantity'       => $quantity, 
                'supervisor'       => $supervisor, 
                'ind_time'       => $ind_time, 
                'ind_time_hidden' => $ind_time_hidden,
                'total_time'       => $total_time,  
                'total_time_hidden' => $total_time_hidden,                                                                             	
                'clientApproval'  => $clientApproval, 
                'prod_release'    => $prod_release,                
                'mfg_type'       => $mfg_type, 	
                'dateModified'   => date('Y-m-d H:i:s',time()),                                           				                      
            );
            
            if($activityID > 0){
                $insert = $this->production_window_model->updateActivity($activityData,$activityID);                            
            }

            $out_data['projectID'] = $projectID;        
            $out_data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($out_data); 
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
                $update = $this->production_window_model->updateActivity($activityData,$activityID);
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

    public function updateComponentActivityTime(){
        // print_r($_POST); exit;
        if($_POST['projectID'] > 0 && $_POST['projectequipment'] > 0 && $_POST['activity_id'] > 0 && $_POST['main_activity_id'] > 0){
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];
            $activity_id = $_POST['activity_id'];
            $main_activity_id = $_POST['main_activity_id'];            
            $get_time = $this->production_window_model->get_all_assembly_time($projectID, $projectequipment,$activity_id,$main_activity_id);
            // print_r($get_time);
            $days = $get_time->days;
            $hours = $get_time->hours;
            $minutes = $get_time->minutes;

            //get qty
            $get_qty = $this->production_window_model->get_all_component_qty($projectID, $projectequipment,$activity_id,$main_activity_id);
            $quantity = $get_qty->quantity;

            $total_time = ($days*24*60)+($hours*60)+$minutes;
            $toal_time_formated_hours = round($total_time / 60);
            $toal_time_formated_min = $total_time % 60;
            $toal_time_formated = $toal_time_formated_hours.'hr '.$toal_time_formated_min.'m';

            $final_time = $quantity*$total_time;
            $final_time_formated_hours = round($final_time / 60);
            $final_time_formated_min = $final_time % 60;
            $final_time_formated = $final_time_formated_hours.'hr '.$final_time_formated_min.'m';
            
            //update inv time
            $update_in_time = $this->production_window_model->update_component_inv_time($projectID, $projectequipment,$activity_id,$main_activity_id,$total_time,$toal_time_formated,$final_time,$final_time_formated); 
            $data['activity_id'] = $activity_id;  
            $data['activity_time'] =  $toal_time_formated;
            $data['activity_time_hidden'] =  $total_time;                     
            $data['total_time'] = $final_time_formated;                  
            $data['total_time_hidden'] = $final_time;                  
            $data['quantity'] = $quantity;                  
            echo json_encode($data); 
        }
    }
}
?>