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
            // $row[] = $activity->ind_time;                      
            $row[] = $activity->total_time; 

            $row[] = $activity->name;              
            $clientAppr = '<select name="clientApproval" id="clientApproval" class="client_approval_class" data-activityId='.$activity->activityID.' data-approval-type='.$activity->clientApproval.' >';
                if($activity->clientApproval == 'pending'){
                    $clientAppr.='<option value="pending" selected>Pending</option>
                                    <option value="yes">Yes</option>
                                    <option value="na">NA</option>';
                }else if($activity->clientApproval == 'yes'){
                    $clientAppr.='<option value="pending">Pending</option>
                                    <option value="yes" selected>Yes</option>
                                    <option value="na">NA</option>';
                }else{
                    $clientAppr.='<option value="pending">Pending</option>
                                    <option value="yes">Yes</option>
                                    <option value="na" selected>NA</option>';
                }  
            $clientAppr.= '</select>';
            $row[]  = $clientAppr;  
            
            $prod_release = '<select name="prod_release" id="prod_release" class="prod_release_class" data-activityId='.$activity->activityID.' data-approval-type='.$activity->prod_release.' >';
                if($activity->prod_release == 'no'){
                    $prod_release.='<option value="no" selected>No</option>
                                    <option value="yes">Yes</option>';
                }else{
                    $prod_release.='<option value="no">No</option>
                                    <option value="yes" selected>Yes</option>';
                }  
            $prod_release.= '</select>';
            $row[]  = $prod_release; 

            // $row[] = $activity->prod_release; 
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

            $row[] = '<a href="'.base_url().'productionwindow/editSingleActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>';
            // <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
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
        
        
        $data['getAllProductionAssemblyActivity'] = $this->production_window_model->getProductionAssemblyActivityData($projectID,$projectequipment,$client_id);        
        // echo "<pre>"; print_r($data['getAllProductionAssemblyActivity']);
             
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

        $assembly_activity_list = $this->production_window_model->get_production_assembly_activity();  
        $options1        = array();
        $options1[""]    = "";
        $selectedItemId1 = "";
        foreach($assembly_activity_list as $ass_activity)
        {
            $options1[$ass_activity->id] = $ass_activity->assembly;
        }
        $data["assembly_activitylist"] = form_multiselect("assembly[]", $options1, $selectedItemId1, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown activity_list_reset", 'id' => 'assembly_id', 'name' => 'assembly'));        

        $data['projectID'] = $projectID;
        $data['projectNo'] = $projectNo;
        $data['projectequipment'] = $projectequipment;  // equipment in no format
        $data['projectequipmentName'] = $equipmentName;  // equipment in text
        $data['client_id']= $client_id;
        $data['client_name']= $clientName;
        $data['tag_number'] = $tag_number; 
        $data['productionProjectStartDate'] = $project_no->productionProjectStartDate;
        $data['productionProjectEndDate'] = $project_no->productionProjectEndDate;
        $data['productionActualStartDate'] = $project_no->productionActualStartDate;
        $data['productionActualEndDate'] = $project_no->productionActualEndDate;
        // echo '<pre>';
        // print_r($data['getAllProductionActivity']); exit;
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



                $logData = array();
                $logData = array(
                    // 'pw_activityID' => $last_component_id,
                    // // 'mul_tbl_coordinator' => 'tg_production_window',                   
                    // // 'activity_type' => 4,
                    // 'from_dept_id' => $this->session->userdata('dept'),
                    // 'roleId' => $this->session->userdata('role'),
                    // 'userId' => $this->session->userdata('userId'),
                    // 'date' => date('Y-m-d'),


                    'production_window_ac_id' => $last_component_id,
                    'notification_type' => 4,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );
                

                $insertdata = $this->production_window_model->saveNotificationLog($logData);

                                  
                    


                // [__ci_last_regenerate] => 1718271267
            // [userId] => 2
            // [uname] => admin@konark_pms
            // [role] => 2
            // [dept] => 1
            // [roleText] => Admin
            // [dept_name] => Admin
            // [name] => Konark Admin
            // [isLoggedIn] => 1
            // [design_dept_access] => 1
            // [purchase_dept_access] => 1
            // [production_dept_access] => 1
            // [quality_dept_access] => 1
            // [vendor_dept_access] => 1
            // [lastLogin] => 2024-06-13 10:18:48
            
            
            // $notification_log_data = array(
            //     'projectID' => $lastInsertId,
            //     'projectNo' => $this->input->post('project_no'),
            //     'roleId' => $this->session->userdata('role'),
            //     'userId' => $this->session->userdata('userId'),
            //     'date' => date('Y-m-d'),
            // );
                                
            // add assembly
                $sub_activity_list = $this->production_window_model->get_production_sub_activity($activity_id);
                $sub_activity_array= '';
                $sub_act_order = 1;
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
                        'sub_act_order' => $sub_act_order,
                    );  
                    // save into tg_production_comp_assembly table                 
                    $last_assembly_id = $this->production_window_model->saveCompAssembly($data);
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
                $last_component_id = $this->production_window_model->saveAssembly($data_array); 

                // notification add ---------------------------------------------------
                $logData = array();
                $logData = array(
                    'production_window_assembly_aas_id' => $last_component_id,
                    'notification_type' => 5,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );
                $insertdata = $this->production_window_model->saveNotificationLog($logData);
                // --------------------------------------------------------------------

            // add assembly
                $sub_activity_list = $this->production_window_model->get_production_sub_assembly($activity_id);
                $sub_activity_array= '';
                $sub_act_order = 1;
                foreach($sub_activity_list as $sub_activity){                                        
                    $sub_activity_skills_array='';     
                    $sub_activity_id = $sub_activity->id;    

                    $sub_activity_skills = $this->production_window_model->get_production_sub_assemly_skills($activity_id,$sub_activity_id);
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
                    $last_assembly_id = $this->production_window_model->saveSubAssemblyActivity($data);
                    $sub_act_order++;
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
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->production_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->production_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;    
        $main_activity_name = $this->production_window_model->get_main_activity_name($activity);     

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
        $data['get_assembly_data'] = $this->production_window_model->get_component_assembly_data($projectID, $projectequipment, $activityID, $activity);         
        
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

    public function update_client_approval()
	{
        $this->production_window_model->update_client_approval($this->input->post('activityID'), $this->input->post('clientApproval'));
	}

    public function update_prod_release()
	{
        $this->production_window_model->update_prod_release($this->input->post('activityID'), $this->input->post('prod_release'));
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
        // $projectID = $_POST['projectID'];
        // $projectequipment = $_POST['projectequipment'];
        $isDeleted = $this->production_window_model->delete_by_id($activityID);
        $isDeleted1 = $this->production_window_model->delete_assembly_by_id($activityID);        

        if($isDeleted > 0 && $isDeleted1 > 0){
            $this->production_window_model->delete_persons_curr_activity($activityID,$projectID,$projectequipment);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }        
    }

    public function delete_new_assembly_activity()
    {
        $activityID = $_POST['activityID'];
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];
        $isDeleted = $this->production_window_model->delete_main_assembly_by_id($activityID);
        $isDeleted1 = $this->production_window_model->delete_sub_assembly_by_id($activityID,$projectID,$projectequipment);        

        if($isDeleted > 0 && $isDeleted1 > 0){
            // $this->production_window_model->delete_persons_curr_activity($activityID,$projectID,$projectequipment);
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

    public function delete_new_sub_assembly_data(){
        $assemblyID = $_POST['assemblyID'];        
        $isDeleted = $this->production_window_model->delete_one_sub_assembly_by_id($assemblyID);        

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

    public function updateAssemblyActivityOrder(){
        $row_order = $_POST['row_order'];
        $activityID = $_POST['activityID'];

        $update_order = $this->production_window_model->updateAssemblyActivityOrder($row_order,$activityID);
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
            // 'ind_time' => $data['act_data']->ind_time,
            // 'ind_time_hidden' => $data['act_data']->ind_time_hidden,
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
                'sub_act_order'       => $assembly->sub_act_order,
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
                'is_all_updated'      => $assembly->is_all_updated,
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

    public function duplicateAssemblyActvt(){
        $activityID = $_POST['activityID'];
        // print_r($activityID); exit;
        $data['act_data'] = $this->production_window_model->get_assembly_activity_by_id($activityID);
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
            // 'ind_time' => $data['act_data']->ind_time,
            // 'ind_time_hidden' => $data['act_data']->ind_time_hidden,
            'total_time_hidden' => $data['act_data']->total_time_hidden,
            'total_time' => $data['act_data']->total_time,            
            'clientApproval' => $data['act_data']->clientApproval,
            'prod_release' => $data['act_data']->prod_release,
            'mfg_type' => $data['act_data']->mfg_type,                       
        );

        $duplicate_component_id = $this->production_window_model->saveAssemblyActvt($comp_data);
        
        $duplicate_assembly = $this->production_window_model->get_duplicate_assembly_activity($activityID);        
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
                'sub_act_order'       => $assembly->sub_act_order,
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
                'is_all_updated'      => $assembly->is_all_updated,
            );
            $this->production_window_model->saveAssemblyActivityList($assembly_data);
        }

        if($duplicate_component_id > 0){
            $data['activityID'] = $activityID;                     
            echo json_encode($data);
        }else{
            $data['activityID'] = 0;                     
            echo json_encode($data);
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
            
                $logData = array();
                $logData = array(
                    'production_sub_assembly_list_uas_id' => $assemblyID,
                    'notification_type' => 7,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );
                    
                    $updated_status_before = $this->production_window_model->is_UpdatedActivity_Sub_assemblyID($assemblyID);// for log module 
                                            
                        $update_status_first_row = $this->production_window_model->updateSubAssemblyActivityData($data,$assemblyID);
            
                    $updated_status_after = $this->production_window_model->is_UpdatedActivity_Sub_assemblyID($assemblyID);
       
            
                
                    if($updated_status_before[0]->is_all_updated == 0){
                        if($updated_status_after[0]->is_all_updated == 1){
                            $insertdata = $this->production_window_model->saveNotificationLog($logData);
                        }
                    }

            // //delete previus persons activities skills
            // $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

            // foreach($person_name as $userid=>$name){
            //     $getname = $this->production_window_model->get_person_name($name);
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
            //     $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);
            // }
            
            $out_data['assemblyID'] = $assemblyID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['assemblyID'] = 0;                     
            echo json_encode($out_data); 
        }
    }  




// =============================================================================================

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
                $insert = $this->production_window_model->updateActivity($activityData,$activityID);                            
            }

            $out_data['projectID'] = $projectID;        
            $out_data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($out_data); 
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
                'sub_activity_name'         => $sub_activity_name,
                'manpower'                  => $manpower, 
                'targetDate'                => $targetDate, 
                'startDate'                 => $startDate, 
                'activity_days'             => $activity_days, 
                'activity_time_hours'       => $activity_time_hours,
                'activity_time_minutes'     => $activity_time_minutes,
                // 'quality_qc_date'      => $quality_qc_date,
                // 'quality_qc_remark'    => $quality_qc_remark,
                // 'tpi_qc_date'          => $tpi_qc_date,
                'tpi_qc_remark'             => $tpi_qc_remark,
                'clientApproval'            => $clientApproval,
                // 'prod_release'         => $prod_release,
                'mfg_type'                  => $mfg_type,
                'is_all_updated'            => 1,
            );

            // $updated_status_before = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);// for log module 
            // $updated_status_after = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);

            // $update_status = $this->production_window_model->updateAssemblyActivity($data,$assemblyID);

            // ------------------------------
                // $logData = array();
                // $logData = array(
                //         'mul_tbl_id' => $assemblyID,
                //         'mul_tbl_coordinator' => 'tg_production_comp_assembly',                   
                //         'activity_type' => 2,
                //         'from_dept_id' => $this->session->userdata('dept'),
                //         'roleId' => $this->session->userdata('role'),
                //         'userId' => $this->session->userdata('userId'),
                //         'date' => date('Y-m-d'),
                // );
            
            
                // if($update_status == 1){
                //    $insertdata = $this->production_window_model->saveNotificationLog($logData);
                // }



                    $logData = array();
                    $logData = array(
                        // 'mul_tbl_id' => $assemblyID,
                        // 'mul_tbl_coordinator' => 'tg_production_comp_assembly',                   
                        // 'activity_type' => 6,
                        // 'from_dept_id' => $this->session->userdata('dept'),
                        // 'roleId' => $this->session->userdata('role'),
                        // 'userId' => $this->session->userdata('userId'),
                        // 'date' => date('Y-m-d'),


                        'production_comp_assembly_ua_id' => $assemblyID,
                        'notification_type' => 6,
                        'noti_created_dept_id' => $this->session->userdata('dept'),
                        'roleId' => $this->session->userdata('role'),
                        'userId' => $this->session->userdata('userId'),
                        'date' => date('Y-m-d'),
                    );
                    
                    $updated_status_before = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);// for log module 
                                            
                        $update_status_first_row = $this->production_window_model->updateAssemblyActivity($data,$assemblyID);
            
                    $updated_status_after = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);
       
            
                
                    if($updated_status_before[0]->is_all_updated == 0){
                        if($updated_status_after[0]->is_all_updated == 1){
                            $insertdata = $this->production_window_model->saveNotificationLog($logData);
                        }
                    }
            
            // ------------------------------



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
                    //'userName'           => $getname->name,                     				                                           				                      
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


    // public function log(){
    //     $logData = array();
    //     $logData = array(
    //         'activityID' => 1,
    //         'compo_activity' => 1,
    //         'log_name' =>
    //         'from_dept_id' => 1,
    //         'roleId' => 1,
    //         'userId' => 1,
    //         'date' => date('Y-m-d'),
    //     );
        
    //     $insertdata = $this->production_window_model->saveNotificationLog($logData);
        
    // }


    public function logJoin(){

        $list = $this->production_window_model->notificationLoglist();

        echo "<pre>";
        print_r($list);
    }



    public function updateAllActivityOnce(){ // update all activity data at a time
        // echo "<pre>";
        // print_r($_POST); exit;                        
        if(isset($_POST['activityID']) && count($_POST['activityID']) > 0 && isset($_POST['person_name_id']) && count($_POST['person_name_id']) > 0 && isset($_POST['startDate']) && count($_POST['startDate']) > 0 && isset($_POST['targetDate']) && count($_POST['targetDate']) > 0)
        // if(isset($_POST['activityID']) && count($_POST['activityID']) > 0)
        {      
            $projectID = $_POST['projectID']; // single value
            $projectequipment = $_POST['projectequipment'];  // single value
            $main_activity_id = $_POST['main_activity_id'][0]; 
            $sub_activity_id = $_POST['sub_activity_id'][0]; 


            $total_cnt = count($_POST['activity_id']);


            $total_persons = 0;
            
            $assemblyID = $_POST['assemblyID'][0]; 
            $activityID = $_POST['activityID'][0]; 
            $manpower = $_POST['manpower'][0];
            
            $person_name_id = $_POST['person_name_id'];
            if($manpower > 0){
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
            if($manpower > 0){
                for($j=0; $j < $total_persons; $j++){
                    $person_list = $person_list.''.$person_name_id[$activityID][$j].',';                 
                }  
                $person_list = rtrim($person_list,','); 
            }   
            
            $sub_activity_name = $_POST['sub_activity'][0]; 
            $tpi_qc_remark = $_POST['tpi_qc_remark'][0]; 
            $mfg_type = $_POST['mfg_type'][0]; 

            $activityData = array(    
                // 'level'                 => $level, //*
                // 'row_order'             => $row_order, 
                'activity_days'         => $activity_days, 
                'activity_time_hours'   => $activity_time_hours, 
                'activity_time_minutes' => $activity_time_minutes, 
                'manpower'             => $manpower, 
                // 'person1'               => $person_list,  
                'startDate'             => $startDate, 
                'targetDate'            => $targetDate,  
                // 'taskCompDate'    => $taskCompDate, 
                // 'delayDays'       => $delayDays,             	
                'clientApproval'        => $clientApproval, 
                // 'prod_release'          => $prod_release, 
                
                
                'resp_persons'         => $person_list,
                'sub_activity_name'    => $sub_activity_name,
                'tpi_qc_remark'        => $tpi_qc_remark,
                'mfg_type'             => $mfg_type,
                'is_all_updated'       => 1,
            );
            
            if($activityID > 0){
                
                $update = $this->production_window_model->updateAssemblyActivity($activityData,$assemblyID);
            
                if($manpower > 0){
                    //delete previus persons activities skills
                    $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

                    for($j=0; $j < $total_persons; $j++){                        
                        $userId =  $person_name_id[$activityID][$j];
                        $getname = $this->production_window_model->get_person_name($userId);        //*
                        
                        $personData = array(   
                            'assembly_id'        => $assemblyID,  
                            'projectID'          => $projectID,            
                            'projectequipment'   => $projectequipment, 
                            'activityId'         => $main_activity_id, 
                            'sub_activityID'     => $sub_activity_id, 
                            'userId'             => $getname->name,  
                            // 'userName'           => $getname->name,   
                        );                        
                        
                        $this->db->set($personData);
                        $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);                                                          
                    }  
                }                   
            }


            
            // loop for all activities (no of rows)
            $startDate1 = $targetDate;
            for($i=1; $i<$total_cnt; $i++){ // by activity ids
                $activity_id = $_POST['activity_id'][$i]; 
                $manpower = $_POST['manpower'][$i];
                $assemblyID = $_POST['assemblyID'][$i];
                

                $person_name_id = $_POST['person_name_id'];
                if ($manpower > 0) {
                    $total_persons = count($person_name_id[$activityID]);
                }


                $person_list = '';
                if ($manpower > 0) {
                    for ($j = 0; $j < $total_persons; $j++) {
                        $person_list = $person_list.''.$person_name_id[$activityID][$j].',';    
                    }
                    $person_list = rtrim($person_list, ',');
                }
                

                

                                                    
                // $activity = $_POST['activity_data_id'][$i];              
                                
                // $startDate = $_POST['startDate'][$i];        
                // $targetDate = $_POST['targetDate'][$i];                     
                // $level = $_POST['level'][$i]; //*
                // $row_order = $_POST['row_order'][$i];      //*           
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
                

                $sub_activity_name = $_POST['sub_activity'][$i]; 
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i]; 
                $mfg_type = $_POST['mfg_type'][$i]; 
                

                $activityData1 = array(    
                    // 'level'                 => $level, //*
                    // 'row_order'             => $row_order, 
                    'activity_days'             => $activity_days, 
                    'activity_time_hours'       => $activity_time_hours, 
                    'activity_time_minutes'     => $activity_time_minutes, 
                    'manpower'                  => $manpower, 
                    // 'person1'               => $person_list,  
                    'startDate'                 => $startDate, 
                    'targetDate'                => $new_target_date_time,  
                    // 'taskCompDate'    => $taskCompDate, 
                    // 'delayDays'       => $delayDays,             	
                    'clientApproval'            => $clientApproval, 
                    // 'prod_release'          => $prod_release, 
                    
                    
                    'resp_persons'              => $person_list,
                    'sub_activity_name'   => $sub_activity_name,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    'mfg_type'             => $mfg_type,
                    'is_all_updated'       => 1,				                                           				                      
                );
                
                $startDate1 = $new_target_date_time;
                if($activityID > 0){
                    $update = $this->production_window_model->updateAssemblyActivity($activityData1, $assemblyID);
                    
                    

                    
                    if($manpower > 0){
                        //delete previus persons activities skills
                        $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

                        for($j=0; $j < $total_persons; $j++){                        
                            $userId =  $person_name_id[$activityID][$j];
                            $getname = $this->production_window_model->get_person_name($userId);
                            
                            $personData = array(   
                                'assembly_id'        => $assemblyID,  
                                'projectID'          => $projectID,            
                                'projectequipment'   => $projectequipment, 
                                'activityId'         => $main_activity_id, 
                                'sub_activityID'     => $sub_activity_id, 
                                'userId'             => $getname->name,  
                                //'userName'           => $getname->name,                     				                                           				                      
                            );                        
                            $this->db->set($personData);
                            $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);                                                          
                        }  
                    }                   
                }
            }

            // $data['projectID'] = $projectID;        
            // $data['projectequipment'] = $projectequipment;  // equipment in no format        
            // echo json_encode($data); 
        }else{
            $data['projectID'] = 0;        
            $data['projectequipment'] = 0;  // equipment in no format        
            echo json_encode($data); 
        }

    }

    public function all_updateActivity_subroutine($activityID,$projectID,$projectequipment,$supervisor,$quantity,$total_time_hidden,$total_time,$clientApproval,$mfg_type){ // update single activity data        
        // print_r($_POST); exit;   

        $out_data = array();
        // if(isset($_POST['activityID']) && !empty($_POST['activityID']) && isset($_POST['projectID']) && !empty($_POST['projectID']) && isset($_POST['projectequipment']) && !empty($_POST['projectequipment']))
        // { 
            // // print_r($_POST); exit;  
            // $activityID = $_POST['activityID'];
            // $projectID = $_POST['projectID']; //
            // $projectequipment = $_POST['projectequipment'];  // 
            // // $activity = $_POST['activity_data_id'];              
            // $supervisor = $_POST['supervisor'];                
            // $quantity = $_POST['quantity'];        
            // // $ind_time = $_POST['ind_time']; 
            // // $ind_time_hidden = $_POST['ind_time_hidden'];                                             
            // $total_time_hidden = $_POST['total_time_hidden']; 
            // $total_time = $_POST['total_time'];             
            // $clientApproval = $_POST['clientApproval']; 
            // // $prod_release   = $_POST['prod_release'];
            // $mfg_type = $_POST['mfg_type'];                        
            
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
                $insert = $this->production_window_model->updateActivity($activityData,$activityID);   
            }
           
        // }
    }

    public function all_updateActivity(){
        
        // echo "<pre>";
        // print_r($_POST['projectID']);
        // exit();
        
        if(isset($_POST['activityID']) && count($_POST['activityID']) > 0 && isset($_POST['person_name_id']) && count($_POST['person_name_id']) > 0 && isset($_POST['startDate']) && count($_POST['startDate']) > 0 && isset($_POST['targetDate']) && count($_POST['targetDate']) > 0)
        // if(isset($_POST['activityID']) && count($_POST['activityID']) > 0)
        {      
            $projectID = $_POST['projectID']; // single value
            $projectequipment = $_POST['projectequipment'];  // single value
            
            // $supervisor = $_POST['supervisor'];
            // $total_time = $_POST['total_time'];
            // $total_time_hidden = $_POST['total_time_hidden'];
            // $quantity = $_POST['quantity'];
            // $clientApproval_act = $_POST['clientApproval_act'];
            // $mfg_type_act = $_POST['mfg_type_act'];
            
            // $this->all_updateActivity_subroutine($_POST['activityID'][0],$projectID,$projectequipment,$supervisor,$quantity,$total_time_hidden,$total_time,$clientApproval_act,$mfg_type_act);






            $main_activity_id = $_POST['main_activity_id'][0]; 
            $sub_activity_id = $_POST['sub_activity_id'][0]; 


            $total_cnt = count($_POST['activity_id']);


            $total_persons = 0;
            
            $assemblyID = $_POST['assemblyID'][0]; 
            $activityID = $_POST['activityID'][0]; 
            $manpower = $_POST['manpower'][0];
            
            $person_name_id = $_POST['person_name_id'];

            

            if($manpower > 0){
                $total_persons = count($person_name_id[$assemblyID]);  
                
            }
            

            $activity = $_POST['activity_data_id'][0];              
                            
            $startDate = $_POST['startDate'][0];        
            $targetDate = $_POST['targetDate'][0];                     
            // $level = $_POST['level'][0]; 
            // $row_order = $_POST['row_order'][0]; 
            $activity_days = $_POST['activity_days'][0]; 
            $activity_time_hours = $_POST['activity_time_hours'][0]; 
            $activity_time_minutes = $_POST['activity_time_minutes'][0]; 
            $clientApproval = $_POST['clientApproval'][0]; 
            // $prod_release   = $_POST['prod_release'][0];
            

            
            $person_list = '';
            if($manpower > 0){
                for($j=0; $j < $total_persons; $j++){
                    $person_list = $person_list.''.$person_name_id[$assemblyID][$j].',';                 
                }  
                $person_list = rtrim($person_list,','); 
            }  
            
            
            
            $sub_activity_name = $_POST['sub_activity'][0]; 
            $tpi_qc_remark = $_POST['tpi_qc_remark'][0]; 
            $mfg_type = $_POST['mfg_type'][0]; 

            $activityData = array(    
                // 'level'                 => $level, //*
                // 'row_order'             => $row_order, 
                'activity_days'         => $activity_days, 
                'activity_time_hours'   => $activity_time_hours, 
                'activity_time_minutes' => $activity_time_minutes, 
                'manpower'             => $manpower, 
                // 'person1'               => $person_list,  
                'startDate'             => $startDate, 
                'targetDate'            => $targetDate,  
                // 'taskCompDate'    => $taskCompDate, 
                // 'delayDays'       => $delayDays,             	
                'clientApproval'        => $clientApproval, 
                // 'prod_release'          => $prod_release, 
                
                
                'resp_persons'         => $person_list,
                'sub_activity_name'    => $sub_activity_name,
                'tpi_qc_remark'        => $tpi_qc_remark,
                'mfg_type'             => $mfg_type,
                'is_all_updated'       => 1,
            );
            
            if($activityID > 0){
                
                // $logData = array();
                // $logData = array(
                //         'mul_tbl_id' => $assemblyID,
                //         'mul_tbl_coordinator' => 'tg_production_comp_assembly',                   
                //         'activity_type' => 2,
                //         'from_dept_id' => $this->session->userdata('dept'),
                //         'roleId' => $this->session->userdata('role'),
                //         'userId' => $this->session->userdata('userId'),
                //         'date' => date('Y-m-d'),
                // );
                
                // // $updated_status_before = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);// for log module 
                // // $updated_status_after = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);
                    
                // $update_status_first_row = $this->production_window_model->updateAssemblyActivity($activityData,$assemblyID);

                // if($update_status_first_row == 1){
                //     $insertdata = $this->production_window_model->saveNotificationLog($logData);
                // }


                $logData = array();
                $logData = array(
                    // 'mul_tbl_id' => $assemblyID,
                    // 'mul_tbl_coordinator' => 'tg_production_comp_assembly',                   
                    // 'activity_type' => 6,
                    // 'from_dept_id' => $this->session->userdata('dept'),
                    // 'roleId' => $this->session->userdata('role'),
                    // 'userId' => $this->session->userdata('userId'),
                    // 'date' => date('Y-m-d'),


                        'production_comp_assembly_ua_id' => $assemblyID,
                        'notification_type' => 6,
                        'noti_created_dept_id' => $this->session->userdata('dept'),
                        'roleId' => $this->session->userdata('role'),
                        'userId' => $this->session->userdata('userId'),
                        'date' => date('Y-m-d'),
                );
                    
                    $updated_status_before = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);// for log module 
                                            
                        $update_status_first_row = $this->production_window_model->updateAssemblyActivity($activityData,$assemblyID);
            
                    $updated_status_after = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);
       
            
                
                    if($updated_status_before[0]->is_all_updated == 0){
                        if($updated_status_after[0]->is_all_updated == 1){
                            $insertdata = $this->production_window_model->saveNotificationLog($logData);
                        }
                    }

               
            
                if($manpower > 0){
                    //delete previus persons activities skills
                    $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

                    for($j=0; $j < $total_persons; $j++){                        
                        $userId =  $person_name_id[$assemblyID][$j];
                        $getname = $this->production_window_model->get_person_name($userId);        //*
                        

                        // print_r($getname->name);


                        $personData = array(   
                            'assembly_id'        => $assemblyID,  
                            'projectID'          => $projectID,            
                            'projectequipment'   => $projectequipment, 
                            'activityId'         => $main_activity_id, 
                            'sub_activityID'     => $sub_activity_id, 
                            'userId'             => $userId,  
                            // 'userName'           => $getname,   
                        );                        
                        
                        $this->db->set($personData);
                        $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);                                                          
                    
                    }  
                }                   
            }


            
            // loop for all activities (no of rows)
            $startDate1 = $targetDate;
            for($i=1; $i<$total_cnt; $i++){ // by activity ids
                $activityID = $_POST['activityID'][$i]; 
                $manpower = $_POST['manpower'][$i];
                $assemblyID = $_POST['assemblyID'][$i];
                

                $person_name_id = $_POST['person_name_id'];
                if ($manpower > 0) {
                    $total_persons = count($person_name_id[$assemblyID]);
                }


                $person_list = '';
                if ($manpower > 0) {
                    for ($j = 0; $j < $total_persons; $j++) {
                        $person_list = $person_list.''.$person_name_id[$assemblyID][$j].',';    
                    }
                    $person_list = rtrim($person_list, ',');
                }

                $updated_status = 0;
                if($person_list != ''){
                    $updated_status = 1;
                }

               

                

                                                    
                $activity = $_POST['activity_data_id'][$i];              
                                
                // $startDate = $_POST['startDate'][$i];        
                // $targetDate = $_POST['targetDate'][$i];                     
                // $level = $_POST['level'][$i]; //*
                // $row_order = $_POST['row_order'][$i];      //*           
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
                

                $sub_activity_name = $_POST['sub_activity'][$i]; 
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i]; 
                $mfg_type = $_POST['mfg_type'][$i]; 
                
                

                $activityData1 = array(    
                    // 'level'                 => $level, //*
                    // 'row_order'             => $row_order, 
                    'activity_days'             => $activity_days, 
                    'activity_time_hours'       => $activity_time_hours, 
                    'activity_time_minutes'     => $activity_time_minutes, 
                    'manpower'                  => $manpower, 
                    // 'person1'               => $person_list,  
                    'startDate'                 => $startDate1, 
                    'targetDate'                => $new_target_date_time,  
                    // 'taskCompDate'    => $taskCompDate, 
                    // 'delayDays'       => $delayDays,             	
                    'clientApproval'            => $clientApproval, 
                    // 'prod_release'          => $prod_release, 
                    
                    
                    'resp_persons'              => $person_list,
                    'sub_activity_name'   => $sub_activity_name,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    'mfg_type'             => $mfg_type,
                    'is_all_updated'       => $updated_status,				                                           				                      
                );

                $startDate1 = $new_target_date_time;
                
                if($activityID > 0){
                    
                    // $updated_status_before = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);// for log module 
                    // $updated_status_after = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);
                    
                    // $update_status_except_first_row = $this->production_window_model->updateAssemblyActivity($activityData1, $assemblyID);
                    
                    
                    // ---------------------------                                  
                    $logData = array();
                    $logData = array(
                        // 'mul_tbl_id' => $assemblyID,
                        // 'mul_tbl_coordinator' => 'tg_production_comp_assembly',                   
                        // 'activity_type' => 6,
                        // 'from_dept_id' => $this->session->userdata('dept'),
                        // 'roleId' => $this->session->userdata('role'),
                        // 'userId' => $this->session->userdata('userId'),
                        // 'date' => date('Y-m-d'),

                        'production_comp_assembly_ua_id' => $assemblyID,
                        'notification_type' => 6,
                        'noti_created_dept_id' => $this->session->userdata('dept'),
                        'roleId' => $this->session->userdata('role'),
                        'userId' => $this->session->userdata('userId'),
                        'date' => date('Y-m-d'),
                    );
                    
                    $updated_status_before = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);// for log module 
                                            
                        $update_status_first_row = $this->production_window_model->updateAssemblyActivity($activityData1,$assemblyID);
            
                    $updated_status_after = $this->production_window_model->is_UpdatedActivity_assemblyID($assemblyID);
       
            
                
                    if($updated_status_before[0]->is_all_updated == 0){
                        if($updated_status_after[0]->is_all_updated == 1){
                            $insertdata = $this->production_window_model->saveNotificationLog($logData);
                        }
                    }
                    // ----------------------------


                    
                    if($manpower > 0){
                        //delete previus persons activities skills
                        $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

                        for($j=0; $j < $total_persons; $j++){                        
                            $userId =  $person_name_id[$assemblyID][$j];
                            $getname = $this->production_window_model->get_person_name($userId);
                            
                            $personData = array(   
                                'assembly_id'        => $assemblyID,
                                  
                                'projectID'          => $projectID,            
                                'projectequipment'   => $projectequipment, 
                                'activityId'         => $main_activity_id, 
                                'sub_activityID'     => $sub_activity_id, 
                                'userId'             => $userId,
                                //'userName'           => $getname->name,                     				                                           				                      
                            );                        
                            $this->db->set($personData);
                            $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);                                                          
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

    

    public function all_updateAssemblyActivity(){
        
        // echo "<pre>";
        // print_r($_POST['projectID']);
        // exit();
        
        if(isset($_POST['activityID']) && count($_POST['activityID']) > 0 && isset($_POST['person_name_id']) && count($_POST['person_name_id']) > 0 && isset($_POST['startDate']) && count($_POST['startDate']) > 0 && isset($_POST['targetDate']) && count($_POST['targetDate']) > 0)
        // if(isset($_POST['activityID']) && count($_POST['activityID']) > 0)
        {      
            $projectID = $_POST['projectID']; // single value
            $projectequipment = $_POST['projectequipment'];  // single value
            
            // $supervisor = $_POST['supervisor'];
            // $total_time = $_POST['total_time'];
            // $total_time_hidden = $_POST['total_time_hidden'];
            // $quantity = $_POST['quantity'];
            // $clientApproval_act = $_POST['clientApproval_act'];
            // $mfg_type_act = $_POST['mfg_type_act'];
            
            // $this->all_updateActivity_subroutine($_POST['activityID'][0],$projectID,$projectequipment,$supervisor,$quantity,$total_time_hidden,$total_time,$clientApproval_act,$mfg_type_act);






            $main_activity_id = $_POST['main_activity_id'][0]; 
            $sub_activity_id = $_POST['sub_activity_id'][0]; 


            $total_cnt = count($_POST['activity_id']);


            $total_persons = 0;
            
            $assemblyID = $_POST['assemblyID'][0]; 
            $activityID = $_POST['activityID'][0]; 
            $manpower = $_POST['manpower'][0];
            
            $person_name_id = $_POST['person_name_id'];

            

            if($manpower > 0){
                $total_persons = count($person_name_id[$assemblyID]);  
                
            }
            

            $activity = $_POST['activity_data_id'][0];              
                            
            $startDate = $_POST['startDate'][0];        
            $targetDate = $_POST['targetDate'][0];                     
            // $level = $_POST['level'][0]; 
            // $row_order = $_POST['row_order'][0]; 
            $activity_days = $_POST['activity_days'][0]; 
            $activity_time_hours = $_POST['activity_time_hours'][0]; 
            $activity_time_minutes = $_POST['activity_time_minutes'][0]; 
            $clientApproval = $_POST['clientApproval'][0]; 
            // $prod_release   = $_POST['prod_release'][0];
            

            
            $person_list = '';
            if($manpower > 0){
                for($j=0; $j < $total_persons; $j++){
                    $person_list = $person_list.''.$person_name_id[$assemblyID][$j].',';                 
                }  
                $person_list = rtrim($person_list,','); 
            }  
            
            
            
            $sub_activity_name = $_POST['sub_activity'][0]; 
            $tpi_qc_remark = $_POST['tpi_qc_remark'][0]; 
            $mfg_type = $_POST['mfg_type'][0]; 

            $activityData = array(    
                // 'level'                 => $level, //*
                // 'row_order'             => $row_order, 
                'activity_days'         => $activity_days, 
                'activity_time_hours'   => $activity_time_hours, 
                'activity_time_minutes' => $activity_time_minutes, 
                'manpower'             => $manpower, 
                // 'person1'               => $person_list,  
                'startDate'             => $startDate, 
                'targetDate'            => $targetDate,  
                // 'taskCompDate'    => $taskCompDate, 
                // 'delayDays'       => $delayDays,             	
                'clientApproval'        => $clientApproval, 
                // 'prod_release'          => $prod_release, 
                
                
                'resp_persons'         => $person_list,
                'sub_activity_name'    => $sub_activity_name,
                'tpi_qc_remark'        => $tpi_qc_remark,
                'mfg_type'             => $mfg_type,
                'is_all_updated'       => 1,
            );
            
            if($activityID > 0){
                
                $logData = array();
                $logData = array(
                    // 'mul_tbl_id' => $assemblyID,
                    // 'mul_tbl_coordinator' => 'tg_production_sub_assembly_list',                   
                    // 'activity_type' => 7,
                    // 'from_dept_id' => $this->session->userdata('dept'),
                    // 'roleId' => $this->session->userdata('role'),
                    // 'userId' => $this->session->userdata('userId'),
                    // 'date' => date('Y-m-d'),

                        'production_sub_assembly_list_uas_id' => $assemblyID,
                        'notification_type' => 7,
                        'noti_created_dept_id' => $this->session->userdata('dept'),
                        'roleId' => $this->session->userdata('role'),
                        'userId' => $this->session->userdata('userId'),
                        'date' => date('Y-m-d'),
                );
                
                    $updated_status_before = $this->production_window_model->is_UpdatedActivity_Sub_assemblyID($assemblyID);// for log module 
                                        
                        $update_status_first_row = $this->production_window_model->updateSubAssemblyActivityData($activityData,$assemblyID);
                    
                    $updated_status_after = $this->production_window_model->is_UpdatedActivity_Sub_assemblyID($assemblyID);
               
                    
                        
                if($updated_status_before[0]->is_all_updated == 0){
                    if($updated_status_after[0]->is_all_updated == 1){
                        $insertdata = $this->production_window_model->saveNotificationLog($logData);
                        echo "datainserted";
                    }
                }

               
            
                // if($manpower > 0){
                //     //delete previus persons activities skills
                //     $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

                //     for($j=0; $j < $total_persons; $j++){                        
                //         $userId =  $person_name_id[$assemblyID][$j];
                //         $getname = $this->production_window_model->get_person_name($userId);        //*
                        

                //         // print_r($getname->name);


                //         $personData = array(   
                //             'assembly_id'        => $assemblyID,  
                //             'projectID'          => $projectID,            
                //             'projectequipment'   => $projectequipment, 
                //             'activityId'         => $main_activity_id, 
                //             'sub_activityID'     => $sub_activity_id, 
                //             'userId'             => $userId,  
                //             // 'userName'           => $getname,   
                //         );                        
                        
                //         $this->db->set($personData);
                //         $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);                                                          
                    
                //     }  
                // }   above if is close because single update this condition is also closed                
            }


            
            // loop for all activities (no of rows)
            $startDate1 = $targetDate;
            for($i=1; $i<$total_cnt; $i++){ // by activity ids
                $activityID = $_POST['activityID'][$i]; 
                $manpower = $_POST['manpower'][$i];
                $assemblyID = $_POST['assemblyID'][$i];
                

                $person_name_id = $_POST['person_name_id'];
                if ($manpower > 0) {
                    $total_persons = count($person_name_id[$assemblyID]);
                }


                $person_list = '';
                if ($manpower > 0) {
                    for ($j = 0; $j < $total_persons; $j++) {
                        $person_list = $person_list.''.$person_name_id[$assemblyID][$j].',';    
                    }
                    $person_list = rtrim($person_list, ',');
                }

                $updated_status = 0;
                if($person_list != ''){
                    $updated_status = 1;
                }

               

                

                                                    
                $activity = $_POST['activity_data_id'][$i];              
                                
                // $startDate = $_POST['startDate'][$i];        
                // $targetDate = $_POST['targetDate'][$i];                     
                // $level = $_POST['level'][$i]; //*
                // $row_order = $_POST['row_order'][$i];      //*           
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
                

                $sub_activity_name = $_POST['sub_activity'][$i]; 
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i]; 
                $mfg_type = $_POST['mfg_type'][$i]; 
                
                

                $activityData1 = array(    
                    // 'level'                 => $level, //*
                    // 'row_order'             => $row_order, 
                    'activity_days'             => $activity_days, 
                    'activity_time_hours'       => $activity_time_hours, 
                    'activity_time_minutes'     => $activity_time_minutes, 
                    'manpower'                  => $manpower, 
                    // 'person1'               => $person_list,  
                    'startDate'                 => $startDate1, 
                    'targetDate'                => $new_target_date_time,  
                    // 'taskCompDate'    => $taskCompDate, 
                    // 'delayDays'       => $delayDays,             	
                    'clientApproval'            => $clientApproval, 
                    // 'prod_release'          => $prod_release, 
                    
                    
                    'resp_persons'              => $person_list,
                    'sub_activity_name'   => $sub_activity_name,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    'mfg_type'             => $mfg_type,
                    'is_all_updated'       => $updated_status,				                                           				                      
                );

                $startDate1 = $new_target_date_time;
                
                if($activityID > 0){

                    $logData = array(
                        // 'mul_tbl_id' => $assemblyID,
                        // 'mul_tbl_coordinator' => 'tg_production_sub_assembly_list',                   
                        // 'activity_type' => 7,
                        // 'from_dept_id' => $this->session->userdata('dept'),
                        // 'roleId' => $this->session->userdata('role'),
                        // 'userId' => $this->session->userdata('userId'),
                        // 'date' => date('Y-m-d'),
    
                        'production_sub_assembly_list_uas_id' => $assemblyID,
                            'notification_type' => 7,
                            'noti_created_dept_id' => $this->session->userdata('dept'),
                            'roleId' => $this->session->userdata('role'),
                            'userId' => $this->session->userdata('userId'),
                            'date' => date('Y-m-d'),
                    );
                    
                    $updated_status_before = $this->production_window_model->is_UpdatedActivity_Sub_assemblyID($assemblyID);// for log module 
                                            
                        $update_status_first_row = $this->production_window_model->updateSubAssemblyActivityData($activityData1,$assemblyID);
            
                    $updated_status_after = $this->production_window_model->is_UpdatedActivity_Sub_assemblyID($assemblyID);
       
            
                
                    if($updated_status_before[0]->is_all_updated == 0){
                        if($updated_status_after[0]->is_all_updated == 1){
                            $insertdata = $this->production_window_model->saveNotificationLog($logData);
                        }
                    }



                    

                    
                    // if($manpower > 0){
                    //     //delete previus persons activities skills
                    //     $this->production_window_model->beforeEditPeronsActivitySkills($assemblyID, $projectID, $projectequipment);

                    //     for($j=0; $j < $total_persons; $j++){                        
                    //         $userId =  $person_name_id[$assemblyID][$j];
                    //         $getname = $this->production_window_model->get_person_name($userId);
                            
                    //         $personData = array(   
                    //             'assembly_id'        => $assemblyID,
                                  
                    //             'projectID'          => $projectID,            
                    //             'projectequipment'   => $projectequipment, 
                    //             'activityId'         => $main_activity_id, 
                    //             'sub_activityID'     => $sub_activity_id, 
                    //             'userId'             => $userId,
                    //             //'userName'           => $getname->name,                     				                                           				                      
                    //         );                        
                    //         $this->db->set($personData);
                    //         $insertdata = $this->production_window_model->saveDesignActivityPersons($personData);                                                          
                    //     }  
                    // }   above if condition is hidden beucase single update also hidden                
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



// ============================================================================================

public function updateComponentActivityTime(){
    // print_r($_POST); exit;

    if($_POST['projectID'] > 0 && $_POST['projectequipment'] > 0 && $_POST['activity_id'] > 0 && $_POST['main_activity_id'] > 0){
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];
        $activity_id = $_POST['activity_id']; // prod table act id
        $main_activity_id = $_POST['main_activity_id'];               

        $get_time = $this->production_window_model->get_all_assembly_time($projectID, $projectequipment,$activity_id,$main_activity_id);
        // print_r($get_time);
        $days = $get_time->days;
        $hours = $get_time->hours;
        $minutes = $get_time->minutes;
        
        $quantity = $_POST['activity_qty'];

        $total_time = ($days*16*60)+($hours*60)+$minutes;            

        $final_time = $quantity*$total_time;
        if($final_time >= 60){
            $final_time_formated_hours = floor($final_time / 60);                
        }else{
            $final_time_formated_hours = 0;
        }
        $final_time_formated_min = $final_time % 60;
        $final_time_formated = $final_time_formated_hours.'hr '.$final_time_formated_min.'m';
        
        //update inv time
        $update_in_time = $this->production_window_model->update_component_inv_time($projectID, $projectequipment,$activity_id,$main_activity_id,$final_time,$final_time_formated); 
        $data['activity_id'] = $activity_id;                                  
        $data['total_time'] = $final_time_formated;                  
        $data['total_time_hidden'] = $final_time;   

        $total_sub_act_time_after_update = $_POST['total_sub_act_time_after_update'];
        $total_sub_act_time_before_update = $_POST['total_sub_act_time_before_update']; // current sub activity time required before update
        // $targetDate = $_POST['targetDate'];
        $startDate = '';
        $new_total_time =  0;            
        
        if($total_sub_act_time_after_update > $total_sub_act_time_before_update){ //add time
            $new_total_time = $total_sub_act_time_after_update - $total_sub_act_time_before_update;                
        }else{ //reduce time
            $new_total_time = $total_sub_act_time_before_update - $total_sub_act_time_after_update;
        }

        if($new_total_time != 0){
            $startDate = $_POST['targetDate'];
            $startDate_copy = $_POST['targetDate'];

            $this_sub_act_order = $_POST['this_sub_act_order'];            
            for($i = $this_sub_act_order-1; $i >= 1; $i--){
                // first get start date & time, activity time in minutes of this activity
                $get_details = $this->production_window_model->get_sub_activity_details_by_order($projectID, $projectequipment,$activity_id,$main_activity_id,$i); 
                if($get_details){
                    $assemblyID = $get_details->assemblyID;
                    $total_days = $get_details->activity_days;
                    $total_hours = $get_details->activity_time_hours;
                    $total_minutes = $get_details->activity_time_minutes;                    
                    $total_sub_act_time = $quantity*(($total_days*16*60) + ($total_hours*60) + $total_minutes);
                    
                    $total_time_in_hrs = $quantity*(($total_days*16*60) + ($total_hours*60));                        
                                                                  
                    $total_time_for_next_day = '+1 hours';                
                    $new_target_date_time = $date_str = $hours_str = $minutes_str = '';    

                    $j = 0;                         
                    for($j = 1; $j <= $total_time_in_hrs; $j++){                       
                        $new_target_time = date("Y-m-d H:i:s", strtotime($total_time_for_next_day, strtotime($startDate_copy)));                    
                        
                        $date_str = substr($new_target_time,0,10);
                        $hours_str = substr($new_target_time,11,2);
                        $minutes_str = substr($new_target_time,14,2);                    
    
                        if($hours_str >=00 && $hours_str < 07){
                            $total_time_for_next_day = '+7 hours';                      
                            // $total_time_in_hrs = $total_time_in_hrs+1;
                        }else{
                            $new_target_time1 = $date_str.' '.$hours_str.':'.$minutes_str;                        
                            $total_time_for_next_day = '+1 hours';                                               
                            $startDate_copy = $new_target_time1;
                            $new_target_date_time = $new_target_time1;  
                        }    
                    }
                   
                    if($total_time_in_hrs <= 0){
                        $new_target_date_time = $startDate;
                    }else{
                        $new_target_date_time = $date_str.' '.$hours_str.':'.$minutes_str;;                    
                    }  

                    // now add/reduce total time * qty 
                    // $new_target_date_time = '';                    
                    // $dateTime = new DateTime($startDate);                     
                    // $new_target_date_time = $dateTime->modify("+{$total_sub_act_time} minutes");                    
                    // $new_target_date_time = $new_target_date_time->format('Y-m-d H:i');
                
                    //update start date and target date
                    $update_in_time = $this->production_window_model->update_sub_activity_start_target_date($startDate, $new_target_date_time,$assemblyID); 
                    $startDate = $new_target_date_time;
                }
            }
        }

        // $data['quantity'] = $quantity;                  
        echo json_encode($data); 
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
                $insert = $this->production_window_model->updateAssemblyActvt($activityData,$activityID);                            
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

    

    public function updateAssemblyActivityTime(){
        // print_r($_POST); exit;
        if($_POST['projectID'] > 0 && $_POST['projectequipment'] > 0 && $_POST['activity_id'] > 0 && $_POST['main_activity_id'] > 0){
            $projectID = $_POST['projectID'];
            $projectequipment = $_POST['projectequipment'];
            $activity_id = $_POST['activity_id']; // prod table act id
            $main_activity_id = $_POST['main_activity_id'];               

            $get_time = $this->production_window_model->get_all_assembly_data_time($projectID, $projectequipment,$activity_id,$main_activity_id);
            // print_r($get_time);
            $days = $get_time->days;
            $hours = $get_time->hours;
            $minutes = $get_time->minutes;
            
            $quantity = $_POST['activity_qty'];

            $total_time = ($days*16*60)+($hours*60)+$minutes;            

            $final_time = $quantity*$total_time;
            if($final_time >= 60){
                $final_time_formated_hours = floor($final_time / 60);                
            }else{
                $final_time_formated_hours = 0;
            }
            $final_time_formated_min = $final_time % 60;
            $final_time_formated = $final_time_formated_hours.'hr '.$final_time_formated_min.'m';
            
            //update inv time
            $update_in_time = $this->production_window_model->update_assembly_inv_time($projectID, $projectequipment,$activity_id,$main_activity_id,$final_time,$final_time_formated); 
            $data['activity_id'] = $activity_id;                                  
            $data['total_time'] = $final_time_formated;                  
            $data['total_time_hidden'] = $final_time;   

            $total_sub_act_time_after_update = $_POST['total_sub_act_time_after_update'];
            $total_sub_act_time_before_update = $_POST['total_sub_act_time_before_update']; // current sub activity time required before update
            // $targetDate = $_POST['targetDate'];
            $startDate = '';
            $new_total_time =  0;            
            
            if($total_sub_act_time_after_update > $total_sub_act_time_before_update){ //add time
                $new_total_time = $total_sub_act_time_after_update - $total_sub_act_time_before_update;                
            }else{ //reduce time
                $new_total_time = $total_sub_act_time_before_update - $total_sub_act_time_after_update;
            }

            if($new_total_time != 0){
                $startDate = $_POST['targetDate'];
                $startDate_copy = $_POST['targetDate'];
                
                $this_sub_act_order = $_POST['this_sub_act_order'];            
                for($i = $this_sub_act_order-1; $i >= 1; $i--){
                    // first get start date & time, activity time in minutes of this activity
                    $get_details = $this->production_window_model->get_sub_assembly_details_by_order($projectID, $projectequipment,$activity_id,$main_activity_id,$i); 
                    if($get_details){
                        $assemblyID = $get_details->assemblyID;
                        $total_days = $get_details->activity_days;
                        $total_hours = $get_details->activity_time_hours;
                        $total_minutes = $get_details->activity_time_minutes;                    
                        $total_sub_act_time = $quantity*(($total_days*16*60) + ($total_hours*60) + $total_minutes);
                            
                        $total_time_in_hrs = $quantity*(($total_days*16*60) + ($total_hours*60));                       
                                                                      
                        $total_time_for_next_day = '+1 hours';                
                        $new_target_date_time = $date_str = $hours_str = $minutes_str = '';    

                        $j = 0;                         
                        for($j = 1; $j <= $total_time_in_hrs; $j++){                       
                            $new_target_time = date("Y-m-d H:i:s", strtotime($total_time_for_next_day, strtotime($startDate_copy)));                    
                            
                            $date_str = substr($new_target_time,0,10);
                            $hours_str = substr($new_target_time,11,2);
                            $minutes_str = substr($new_target_time,14,2);                    
        
                            if($hours_str >=00 && $hours_str < 07){
                                $total_time_for_next_day = '+7 hours';                      
                                // $total_time_in_hrs = $total_time_in_hrs+1;
                            }else{
                                $new_target_time1 = $date_str.' '.$hours_str.':'.$minutes_str;                        
                                $total_time_for_next_day = '+1 hours';                                               
                                $startDate_copy = $new_target_time1;
                                $new_target_date_time = $new_target_time1;  
                            }    
                        }
                       
                        if($total_time_in_hrs <= 0){
                            $new_target_date_time = $startDate;
                        }else{
                            $new_target_date_time = $date_str.' '.$hours_str.':'.$minutes_str;;                    
                        } 
                        // now add/reduce total time * qty 
                        // $new_target_date_time = '';                    
                        // $dateTime = new DateTime($startDate);                     
                        // $new_target_date_time = $dateTime->modify("+{$total_sub_act_time} minutes");                    
                        // $new_target_date_time = $new_target_date_time->format('Y-m-d H:i');
                    
                        //update start date and target date
                        $update_in_time = $this->production_window_model->update_sub_assembly_start_target_date($startDate, $new_target_date_time,$assemblyID); 
                        $startDate = $new_target_date_time;
                    }
                }
            }

            // $data['quantity'] = $quantity;                  
            echo json_encode($data); 
        }
    }

    public function update_all_subactivity(){
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
                
                $actual_start_date = $_POST['actual_start_date'][$i];
                $actual_end_date = $_POST['actual_end_date'][$i];

                $plannedStartDate = $_POST['plannedStartDate'][$i];
                $plannedEndDate = $_POST['plannedEndDate'][$i];

                $quality_qc_date = $_POST['quality_qc_date'][$i];
                $quality_qc_remark = $_POST['quality_qc_remark'][$i];
                $tpi_qc_date = $_POST['tpi_qc_date'][$i];
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];
                // $clientApproval   = $_POST['clientApproval'][$i];
                $prod_release       = $_POST['prod_release'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];

                $datetime1 = new DateTime($actual_start_date);
                $datetime2 = new DateTime($plannedStartDate);
                $interval = $datetime1->diff($datetime2);
                $startDelay = $interval->format('%a days %h hrs %i min');

                $datetime11 = new DateTime($plannedEndDate);
                $datetime22 = new DateTime($actual_end_date);
                $interval1 = $datetime11->diff($datetime22);
                $endDelay = $interval1->format('%a days %h hrs %i min');

                $data = array(    
                    'actual_start_date'    => $actual_start_date,
                    'actual_end_date'      => $actual_end_date,
                    'startDelay'           => $startDelay,
                    'endDelay'             => $endDelay,
                    'quality_qc_date'      => $quality_qc_date,
                    'quality_qc_remark'    => $quality_qc_remark,
                    'tpi_qc_date'          => $tpi_qc_date,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    // 'clientApproval'       => $clientApproval,
                    'prod_release'         => $prod_release,
                    'mfg_type'             => $mfg_type,                    
                );
                $this->production_window_model->updateAssemblyActivity($data,$assemblyID);
            }
            $out_data['projectID'] = $projectID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['projectID'] = 0;                     
            echo json_encode($out_data); 
        }
    }

    public function reorderComponentActivity(){
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

    public function reorderAssemblyActivity(){
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
                $update = $this->production_window_model->updateAssemblyActivityLevelOrder($activityData,$activityID);
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

    public function saveProjectTimeline(){
        // print_r($_POST);
        $productionProjectStartDate = $_POST['productionProjectStartDate'];
        $productionProjectEndDate = $_POST['productionProjectEndDate'];
        $productionActualStartDate = $_POST['productionActualStartDate'];
        $productionActualEndDate = $_POST['productionActualEndDate'];
        $projectID = $_POST['projectID'];

        $dataArray = array(
            'productionProjectStartDate' => $productionProjectStartDate,
            'productionProjectEndDate' => $productionProjectEndDate,
            'productionActualStartDate' => $productionActualStartDate,
            'productionActualEndDate' => $productionActualEndDate,
        );
        $this->production_window_model->updateProjectTimeline($projectID,$dataArray); 
        
        $data['productionProjectStartDate'] = $productionProjectStartDate;                    
        $data['productionProjectEndDate'] = $productionProjectEndDate;
        $data['productionActualStartDate'] = $productionActualStartDate;                    
        $data['productionActualEndDate'] = $productionActualEndDate;
        echo json_encode($data); 
    }


    

    public function assemblyList()
    {                   
        $projectID = $data['projectID'] = $_GET['projectID'];     // for listing selected project 
        // print_r($projectID);exit;
        $data['project_info'] = $this->production_window_model->get_project_info($projectID); 
        $this->loadViews("productionwindow/listAssemblyActivity", $this->global, $data);
    }

    public function list_assembly_activity()
    {
        $projectID = $_POST['projectID'];
        $list = $this->production_window_model->get_datatables1($projectID);        
        $data = array();
        $no = $_POST['start'];

        // print_r($list);
        // die;
        foreach ($list as $activity)
        {
            $no++;
            $skillName= '';
            $row = array();           
            $row[] = $no;                                    
            // $row[] = $activity->projectNo.'/'.$activity->company_name;
            $row[] = $activity->equipment;
            $row[] = $activity->tag_number;
            $row[] = $activity->activity; 
            $row[] = $activity->quantity;                                    
            // $row[] = $activity->ind_time;                      
            $row[] = $activity->total_time; 

            $row[] = $activity->name;              
            $clientAppr = '<select name="clientApproval" id="clientApproval" class="client_approval_class" data-activityId='.$activity->activityID.' data-approval-type='.$activity->clientApproval.' >';
                if($activity->clientApproval == 'pending'){
                    $clientAppr.='<option value="pending" selected>Pending</option>
                                    <option value="yes">Yes</option>
                                    <option value="na">NA</option>';
                }else if($activity->clientApproval == 'yes'){
                    $clientAppr.='<option value="pending">Pending</option>
                                    <option value="yes" selected>Yes</option>
                                    <option value="na">NA</option>';
                }else{
                    $clientAppr.='<option value="pending">Pending</option>
                                    <option value="yes">Yes</option>
                                    <option value="na" selected>NA</option>';
                }  
            $clientAppr.= '</select>';
            $row[]  = $clientAppr;  
            
            $prod_release = '<select name="prod_release" id="prod_release" class="prod_release_class" data-activityId='.$activity->activityID.' data-approval-type='.$activity->prod_release.' >';
                if($activity->prod_release == 'no'){
                    $prod_release.='<option value="no" selected>No</option>
                                    <option value="yes">Yes</option>';
                }else{
                    $prod_release.='<option value="no">No</option>
                                    <option value="yes" selected>Yes</option>';
                }  
            $prod_release.= '</select>';
            $row[]  = $prod_release; 

            // $row[] = $activity->prod_release; 
            $row[] = $activity->mfg_type;                     
             
            if($activity->status == 1)
                $status_class = "md-btn-success";
            else if($activity->status == 0)
                $status_class = "md-btn";    

            $status = ($activity->status? "Active" : "Passive");
            $row[] = '<i data='."'".$activity->activityID."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';            

            // $row[] = '<a href="'.base_url().'productionwindow/editSingleAssemblyActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
            //           <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_activity_data('.$activity->activityID.','.$activity->projectequipment.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
            //           <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';

            $row[] = '<a href="'.base_url().'productionwindow/editSingleAssemblyActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>';
                    // <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->production_window_model->count_all1($projectID),
            "recordsFiltered" => $this->production_window_model->count_filtered1($projectID),
            "data" => $data,
        );        
        echo json_encode($output);
    }

    public function editSingleAssemblyActivity($activityID) //Activity ID from design projects my activity list..
    {        
        $data['act_data'] = $this->production_window_model->get_assembly_activity_by_id($activityID);                         
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->production_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->production_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;    
        $main_activity_name = $this->production_window_model->get_main_assembly_activity_name($activity);     

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
        $data['get_assembly_data'] = $this->production_window_model->get_assembly_data($projectID, $projectequipment, $activityID, $activity);         

        // echo '<pre>';
        // print_r($data);exit;
        $this->loadViews("productionwindow/editAssemblyActivity", $this->global, $data);                   
    } 

    public function update_all_assembly_subactivity(){
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
                $actual_start_date = $_POST['actual_start_date'][$i];
                $actual_end_date = $_POST['actual_end_date'][$i];

                $plannedStartDate = $_POST['plannedStartDate'][$i];
                $plannedEndDate = $_POST['plannedEndDate'][$i];

                $quality_qc_date = $_POST['quality_qc_date'][$i];
                $quality_qc_remark = $_POST['quality_qc_remark'][$i];
                $tpi_qc_date = $_POST['tpi_qc_date'][$i];
                $tpi_qc_remark = $_POST['tpi_qc_remark'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];
                // $clientApproval   = $_POST['clientApproval'][$i];
                $prod_release       = $_POST['prod_release'][$i];
                $mfg_type   = $_POST['mfg_type'][$i];

                $datetime1 = new DateTime($actual_start_date);
                $datetime2 = new DateTime($plannedStartDate);
                $interval = $datetime1->diff($datetime2);
                $startDelay = $interval->format('%a days %h hrs %i min');

                $datetime11 = new DateTime($plannedEndDate);
                $datetime22 = new DateTime($actual_end_date);
                $interval1 = $datetime11->diff($datetime22);
                $endDelay = $interval1->format('%a days %h hrs %i min');

                $data = array(        
                    'actual_start_date'      => $actual_start_date,
                    'actual_end_date'    => $actual_end_date, 
                    'startDelay'      => $startDelay,
                    'endDelay'    => $endDelay,           
                    'quality_qc_date'      => $quality_qc_date,
                    'quality_qc_remark'    => $quality_qc_remark,
                    'tpi_qc_date'          => $tpi_qc_date,
                    'tpi_qc_remark'        => $tpi_qc_remark,
                    // 'clientApproval'       => $clientApproval,
                    'prod_release'         => $prod_release,
                    'mfg_type'             => $mfg_type,                    
                );
                $this->production_window_model->updateAssemblySubActivityList($data,$assemblyID);
            }
            $out_data['projectID'] = $projectID;                          
            echo json_encode($out_data); 
        }else{
            $out_data['projectID'] = 0;                     
            echo json_encode($out_data); 
        }
    }

    public function update_assembly_client_approval()
	{
        $this->production_window_model->update_assembly_client_approval($this->input->post('activityID'), $this->input->post('clientApproval'));
	}

    public function update_prod_assembly_release()
	{
        $this->production_window_model->update_prod_assembly_release($this->input->post('activityID'), $this->input->post('prod_release'));
	}

    public function update_assembly_status()
	{
        $this->production_window_model->update_assembly_status($this->input->post('activityID'), $this->input->post('status'));
	}

    public function delete_new_assembly_sub_activity()
    {
        $activityID = $_POST['activityID'];
        // $projectID = $_POST['projectID'];
        // $projectequipment = $_POST['projectequipment'];
        $isDeleted = $this->production_window_model->delete_assembly_activity_by_id($activityID);
        $isDeleted1 = $this->production_window_model->delete_sub_assembly_activity_by_id($activityID);        

        if($isDeleted > 0 && $isDeleted1 > 0){
            // $this->production_window_model->delete_persons_curr_activity($activityID,$projectID,$projectequipment);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }        
    }
}
?>