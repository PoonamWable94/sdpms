<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Purchasewindow extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('purchase_window_model');
        $this->load->library("pagination");
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'Konark PMS- Purchase Department';
    }
    
    public function index()
    {                   
        $projectID = $data['projectID'] = $_GET['projectID'];        
        $data['project_info'] = $this->purchase_window_model->get_project_info($projectID);        
        $this->loadViews("purchasewindow/listActivity", $this->global, $data);
    }   

    public function list_activity()
    {        
        $projectID = $_POST['projectID'];
        $list = $this->purchase_window_model->get_datatables($projectID);        
        $data = array();
        $no = $_POST['start'];
        $no = 1;
        $revision_no = 0;
        foreach ($list as $activity)
        {            
            $skillName= '';
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$activity->activityID.'" >';
            if($activity->parent_activity_id == 0){
                $row[] = $no;
                $no++;
                $revision_no = 0;
            }else{
                $revision_no++;
                $row[] = 'R'.$revision_no;                
            }
            
            // $row[] = $activity->projectNo.'/'.$activity->company_name;
            $row[] = $activity->equipment.'/'.$activity->tag_number;
            $row[] = $activity->tag_no;
            $row[] = $activity->description;
            $row[] = $activity->tech_req;
            if($activity->stock == 1){
                $row[] = 'Stock';
            }else{
                $row[] = 'Purchase';
            }
            
            $row[] = $activity->vendor;
            // $row[] = $activity->price;
            $row[] = $activity->po_release_date;
            $row[] = $activity->actual_po_date;
            $row[] = $activity->quality_remark;
            $row[] = $activity->release_for_prod;           
            $row[] = $activity->mtc;                                                                        

            // <a href="'.base_url().'purchasewindow/editSingleActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
            if($activity->is_disabled == 0){
                $row[] = '  
                        <a href="'.base_url().'purchasewindow/editSingleActivity/'.$activity->activityID.'" data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> | 
                        <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_activity_data('.$activity->activityID.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                        <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->activityID."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';
            }else{
                $row[] = '
                        <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_activity_data('.$activity->activityID.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a>';
            }
            
            $data[] = $row;
        }
 
        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->purchase_window_model->count_all($projectID),
                "recordsFiltered" => $this->purchase_window_model->count_filtered($projectID),
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

        // $config = array();
        // $config["base_url"] = base_url() . "purchasewindow/addActivity"."?projectID=".$projectID.'&projectequipment='.$projectequipment;
        // $config["total_rows"] = $this->purchase_window_model->count_all_eqpwise_rows($projectID,$projectequipment);
        // $config["per_page"] = 10;
        // $config["uri_segment"] = 3;

        // $this->pagination->initialize($config);

        // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;        

        $get_equipment_tag_no = $this->purchase_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->purchase_window_model->get_client_name($projectID); 
        $project_no = $this->purchase_window_model->get_Project_no_by_pid($projectID); 
         
         
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;
        $purchaseProjectStartDate=  $project_no->purchaseProjectStartDate;
        $purchaseProjectEndDate=  $project_no->purchaseProjectEndDate;
        $purchaseActualStartDate=  $project_no->purchaseActualStartDate;
        $purchaseActualEndDate=  $project_no->purchaseActualEndDate;
        

        $equipmentName = $get_equipment_tag_no->equipment_name;
        $tag_number = $get_equipment_tag_no->tag_number;                
        
        $data['getAllPurchaseActivity'] = $this->purchase_window_model->getPurchaseEqpActivity($projectID,$projectequipment,$client_id);        

        $data["activitylist"] = $this->purchase_window_model->get_purchase_activity(); 
        $data["personlist"] = $this->purchase_window_model->get_purchase_dept_persons();  

        $data['projectID'] = $projectID;
        $data['projectNo'] = $projectNo;
        $data['projectequipment'] = $projectequipment;  // equipment in no format
        $data['projectequipmentName'] = $equipmentName;  // equipment in text
        $data['client_id']= $client_id;
        $data['client_name']= $clientName;
        $data['tag_number'] = $tag_number; 
        $data['purchaseProjectStartDate'] = $purchaseProjectStartDate;
        $data['purchaseProjectEndDate'] = $purchaseProjectEndDate;
        $data['purchaseActualStartDate'] = $purchaseActualStartDate;
        $data['purchaseActualEndDate'] = $purchaseActualEndDate;
        // echo '<pre>';
        // print_r($data['getAllPurchaseActivity']); exit;
        
        // $data["links"] = $this->pagination->create_links();
       
        $this->loadViews("purchasewindow/addActivity", $this->global, $data);                  
    }
    
    public function saveProjectTimeline(){
        // print_r($_POST);
        $purchaseProjectStartDate = $_POST['purchaseProjectStartDate'];
        $purchaseProjectEndDate = $_POST['purchaseProjectEndDate'];
        $purchaseActualStartDate = $_POST['purchaseActualStartDate'];
        $purchaseActualEndDate = $_POST['purchaseActualEndDate'];
        $projectID = $_POST['project_id'];

        $dataArray = array(
            'purchaseProjectStartDate' => $purchaseProjectStartDate,
            'purchaseProjectEndDate' => $purchaseProjectEndDate,
            'purchaseActualStartDate' => $purchaseActualStartDate,
            'purchaseActualEndDate' => $purchaseActualEndDate,
        );
        $this->purchase_window_model->updateProjectTimeline($projectID,$dataArray); 
        
        $data['purchaseProjectStartDate'] = $purchasenProjectStartDate;                    
        $data['purchaseProjectEndDate'] = $purchaseProjectEndDate;
        $data['purchaseActualStartDate'] = $purchaseActualStartDate;                    
        $data['purchaseActualEndDate'] = $purchaseActualEndDate;
        echo json_encode($data); 
    }

    public function saveNewActivity()
    {
        // print_r($_POST); exit;                          
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment']; 
        $purchaseProjectStartDate = $_POST['purchaseProjectStartDate'];
         $purchaseProjectEndDate = $_POST['purchaseProjectEndDate'];
          $purchaseActualStartDate = $_POST['purchaseActualStartDate'];
           $purchaseActualEndDate = $_POST['purchaseActualEndDate'];
        $activity = $_POST['activity'];  
        $description = $_POST['description'];  
        $material_specf = $_POST['material_specf'];  
        $size = $_POST['size'];  
        $qty = $_POST['qty'];        
        $in_stock = $_POST['in_stock'];  
        $stock_available = $_POST['stock_available'];  
        $procured = $_POST['procured'];  
        $production_date = $_POST['production_date']; 
        $del_date = $_POST['del_date']; 
        $person_name = $_POST['person_name'];
        $po_date = $_POST['po_date']; 
        $actual_rec_date = $_POST['actual_rec_date']; 
        $material_tc = $_POST['material_tc']; 
        $tc_received = $_POST['tc_received']; 

        $get_equipment_tag_no = $this->purchase_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->purchase_window_model->get_client_name($projectID); 
        $project_no = $this->purchase_window_model->get_Project_no_by_pid($projectID); 
        
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;

        $equipmentName = $get_equipment_tag_no->equipment_name;
        $tag_number = $get_equipment_tag_no->tag_number;                       
        
        $data = array(   
            'projectNo'       => $projectNo,  
            'client'          => $client_id,            
            'projectequipment'=> $projectequipment, 
            'tag_number'      => $tag_number, 
            'purchaseProjectStartDate' =>$purchaseProjectStartDate,
            'purchaseProjectEndDate' =>$purchaseProjectEndDate,
            'purchaseActualStartDate' =>$purchaseActualStartDate,
            'purchaseActualEndDate' =>$purchaseActualEndDate,
            'projectID'       => $projectID,  
            'activity'        => $activity,
            'description'     => $description,  
            'material_specf'       => $material_specf, 
            'size'         => $size,  
            'qty'       => $qty, 
            'in_stock'      => $in_stock,  
            'stock_available'  => $stock_available, 	
            'procured'     => $procured, 	
            'production_date'  => $production_date, 	
            'del_date'  => $del_date,	                
            'po_date'       => $po_date, 
            'actual_rec_date'      => $actual_rec_date,  
            'material_tc'  => $material_tc, 	
            'tc_received'     => $tc_received, 	
            'person_name'  => $person_name, 	                
        );
        //print_r($data); die;
        $last_insert_id = $insert = $this->purchase_window_model->saveActivity($data);                              

        $data['projectID'] = $projectID;        
        $data['projectequipment'] = $projectequipment;  // equipment in no format        
        echo json_encode($data);                               
    }

    public function editActivityView() //Activity ID
    {
        $activityID = $_POST['activityID'];
        $data['act_data'] = $this->purchase_window_model->get_activity_by_id($activityID);        
        $data["activitylist"] = $this->purchase_window_model->get_purchase_activity();          

        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->purchase_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->purchase_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        $activity = $data['act_data']->activity;
        $totalSkills = $this->purchase_window_model->get_activity_skills_count($activity);         
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

        echo json_encode($data);                                     
    }

    public function editSingleActivity($activityID) //Activity ID from design projects my activity list..
    {        
        $data['act_data'] = $this->purchase_window_model->get_activity_by_id($activityID);        
        // $data["activitylist"] = $this->purchase_window_model->get_purchase_activity();          
       
        $projectID = $data['act_data']->projectID;
        $projectequipment = $data['act_data']->projectequipment;       

        $client_name = $this->purchase_window_model->get_client_name($projectID); 
        $get_equipment_tag_no = $this->purchase_window_model->get_equipment_tag_no($projectequipment, $projectID);        
        // $activity = $data['act_data']->activity;
        // $totalSkills = $this->purchase_window_model->get_activity_skills_count($activity);                 
        // $data['activityTime'] = $this->purchase_window_model->get_design_activity_time($activity);

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
        $data['activityID']  = $data['act_data']->activityID; 
        // echo '<pre>';
        // print_r($data);exit;   
        $this->loadViews("purchasewindow/editActivity", $this->global, $data);                   
    }

    public function update_purchase_details(){        
        // print_r($_POST); exit;       
    
        $activityID = $_POST['activityID'];
        $projectID = $_POST['projectID'];        
        $tag_no = $_POST['tag_no'];  
        $bom_date = $_POST['bom_date'];  
        $description = $_POST['description'];  
        $tech_req = $_POST['tech_req'];  
        $dim_width = $_POST['dim_width'];        
        $dim_length = $_POST['dim_length'];  
        $dim_thickness = $_POST['dim_thickness'];  
        // $weight = $_POST['weight'];  
        $qty = $_POST['qty']; 
        // $price = $_POST['price']; 
        $rev_odl = $_POST['rev_odl'];
        $stock = $_POST['stock']; 
        $vendor = $_POST['vendor']; 
        $po_release_date = $_POST['po_release_date']; 
        $actual_po_date = $_POST['actual_po_date'];
        $appr_date = $_POST['appr_date'];             
        $qap_given = $_POST['qap_given'];
        $material_reqd_prod = $_POST['material_reqd_prod'];
        $exp_material_rec_date = $_POST['exp_material_rec_date'];
        $actual_material_rec_date = $_POST['actual_material_rec_date'];
        $tc_rec = $_POST['tc_rec'];
        $remark = $_POST['remark'];
        $quality_remark = $_POST['quality_remark'];
        $release_for_prod = $_POST['release_for_prod'];
        $mtc = $_POST['mtc'];
        
        $activityData = array(                                 
            'tag_no'        => $tag_no,
            'bom_date'     => $bom_date,  
            'description'       => $description, 
            'tech_req'         => $tech_req,  
            'dim_width'       => $dim_width, 
            'dim_length'      => $dim_length,  
            'dim_thickness'  => $dim_thickness, 	
            // 'weight'     => $weight, 	
            'qty'  => $qty, 	
            // 'price'  => $price,	                
            'rev_odl'       => $rev_odl, 
            'stock'      => $stock,  
            'vendor'  => $vendor, 	
            'po_release_date'     => $po_release_date, 	
            'actual_po_date'  => $actual_po_date,
            'appr_date'  => $appr_date,  				                                           				                      
            'qap_given'  => $qap_given,
            'material_reqd_prod'  => $material_reqd_prod,
            'exp_material_rec_date'  => $exp_material_rec_date,
            'actual_material_rec_date'  => $actual_material_rec_date,
            'tc_rec'  => $tc_rec,
            'remark'  => $remark,
            'quality_remark'  => $quality_remark,
            'release_for_prod'  => $release_for_prod,
            'mtc' => $mtc,
        );           
        $insert = $this->purchase_window_model->updatePurchase($activityData,$activityID);                                   
        $data['projectID'] = $projectID;                       
        echo json_encode($data);         
    }

    public function updateActivity(){        
        // print_r($_POST); exit;       
    
        $activityID = $_POST['activityID'];
        $projectID = $_POST['projectID'];        
        $activity = $_POST['activity'];  
        $description = $_POST['description'];  
        $material_specf = $_POST['material_specf'];  
        $size = $_POST['size'];  
        $qty = $_POST['qty'];        
        $in_stock = $_POST['in_stock'];  
        $stock_available = $_POST['stock_available'];  
        $procured = $_POST['procured'];  
        $production_date = $_POST['production_date']; 
        $del_date = $_POST['del_date']; 
        $person_name = $_POST['person_name'];
        $po_date = $_POST['po_date']; 
        $actual_rec_date = $_POST['actual_rec_date']; 
        $material_tc = $_POST['material_tc']; 
        $tc_received = $_POST['tc_received'];             
        
        $activityData = array(                                 
            'activity'        => $activity,
            'description'     => $description,  
            'material_specf'       => $material_specf, 
            'size'         => $size,  
            'qty'       => $qty, 
            'in_stock'      => $in_stock,  
            'stock_available'  => $stock_available, 	
            'procured'     => $procured, 	
            'production_date'  => $production_date, 	
            'del_date'  => $del_date,	                
            'po_date'       => $po_date, 
            'actual_rec_date'      => $actual_rec_date,  
            'material_tc'  => $material_tc, 	
            'tc_received'     => $tc_received, 	
            'person_name'  => $person_name,  				                                           				                      
        );           
        $insert = $this->purchase_window_model->updatePurchase($activityData,$activityID);                                   
        $data['projectID'] = $projectID;                       
        echo json_encode($data);         
    }

    public function get_activity_detail()
    {
        $activityID = $_GET['activityID'];        
        $data['list'] = $this->purchase_window_model->get_activity_detail_by_id($activityID);
        
        $data['activityID'] = $activityID;                    
        echo json_encode($data);
    }
    
    // public function delete_activity($activityID)
    // {
    //     $this->purchase_window_model->delete_by_id($activityID);
    //     echo json_encode(array("status" => TRUE));
    // }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->purchase_window_model->delete_permanent($id);
        }       
        echo json_encode(array("status" => TRUE));
    } 
            
    public function update_status()
	{
        $this->purchase_window_model->update_status($this->input->post('activityID'), $this->input->post('status'));
	}

    public function export_csv($projectID)
	{         
        $design_data = $this->purchase_window_model->getActivityDetails($projectID);  
        
       
        
		$filename = 'activity_'.date('d-m-Y').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
		$file = fopen('php://output','w');        		
		$header = array("Project No", "Tag Number","Tag No", "Description", "Tech Req", "Stock", "Po Release Date", "Actual Po Date", "Equipment", "Company Name", "Release For 
        Prod", "MTC"); 
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
        $isDeleted = $this->purchase_window_model->delete_permanent($activityID);
        if($isDeleted > 0){
            // $this->purchase_window_model->delete_persons_curr_activity($activityID);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        }
        
    }

    public function getActivitySkill(){ 
        $activityID = $_POST['activityID']; 
        $data = $this->purchase_window_model->get_design_activity_skill($activityID);
        echo json_encode($data); 
        // print_r(json_encode($data));
        // $data = '';   
        // $activityID = $_POST['activityID'];    
        // $skillslist = $this->purchase_window_model->get_design_activity_skill($activityID);                             

        // foreach($skillslist as $skills){        
        //     $data.= "<option value = '".$skills->id."'>".$skills->skills."</option>";                                 
        // } 
        // echo json_encode($data);          
    }

    public function getPersonsActivitySkill(){
        $data = array();
        $activityID = $_POST['activityID']; 
        $totalSkills = $_POST['totalSkills'];

        $activitySkills = $this->purchase_window_model->get_design_activity_wise_skill($activityID);
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
        $data = $this->purchase_window_model->get_design_activity_time($activityID);
        echo json_encode($data);
    }

    public function updateAllPurchaseOnce(){
        $total_pur_cnt = count($_POST['activityID']);
        // print_r($_POST); exit;

        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];                      

        for($i=0; $i < $total_pur_cnt; $i++){
            $activityID = $_POST['activityID'][$i]; 
            $tag_no = $_POST['tag_no'][$i]; 
            $bom_date = $_POST['bom_date'][$i]; 
            $description = $_POST['description'][$i];  
            $tech_req = $_POST['tech_req'][$i];  
            $dim_width = $_POST['dim_width'][$i];  
            $dim_length = $_POST['dim_length'][$i];  
            $dim_thickness = $_POST['dim_thickness'][$i];
            // $weight = $_POST['weight'][$i];        
            $qty = $_POST['qty'][$i];  
            $rev_odl = $_POST['rev_odl'][$i];  
            $stock = $_POST['stock'][$i];  
            $vendor = $_POST['vendor'][$i]; 
            $po_release_date = $_POST['po_release_date'][$i]; 
            $actual_po_date = $_POST['actual_po_date'][$i];
            // $price = $_POST['price'][$i]; 
            $appr_date = $_POST['appr_date'][$i]; 
            $qap_given = $_POST['qap_given'][$i];
            $material_reqd_prod = $_POST['material_reqd_prod'][$i]; 
            $exp_material_rec_date = $_POST['exp_material_rec_date'][$i]; 
            $actual_material_rec_date = $_POST['actual_material_rec_date'][$i]; 
            $tc_rec = $_POST['tc_rec'][$i]; 
            $remark = $_POST['remark'][$i];
            $quality_remark = $_POST['quality_remark'][$i];
            $release_for_prod = $_POST['release_for_prod'][$i]; 
            $mtc = $_POST['mtc'][$i];
                        
            $data = array(                  
                'tag_no'        => $tag_no,
                'bom_date'      => $bom_date,
                'description'     => $description,  
                'tech_req'       => $tech_req, 
                'dim_width'         => $dim_width,  
                'dim_length'       => $dim_length, 
                'dim_thickness'      => $dim_thickness, 
                // 'weight'  => $weight, 
                'qty'  => $qty, 	
                'rev_odl'     => $rev_odl, 	
                'stock'  => $stock, 	
                'vendor'  => $vendor,	                
                'po_release_date'       => $po_release_date, 
                'actual_po_date'      => $actual_po_date,  
                // 'price'  => $price, 	
                'appr_date'     => $appr_date, 	
                'qap_given' => $qap_given,
                'material_reqd_prod'  => $material_reqd_prod, 
                'exp_material_rec_date'  => $exp_material_rec_date, 
                'actual_material_rec_date'  => $actual_material_rec_date, 
                'tc_rec'  => $tc_rec, 
                'remark' => $remark,
                'quality_remark' => $quality_remark,
                'release_for_prod' => $release_for_prod,	
                'mtc' => $mtc,                
            );
            //print_r($data); die;
            $last_insert_id = $insert = $this->purchase_window_model->updatePurchase($data, $activityID);

            
            
            // notification log -------------------------
            if($last_insert_id == 1){
                // print_r($last_insert_id);
                $logData = array();
                $logData = array(
                    'purchase_window_ub_id' => $activityID,
                    'notification_type' => 9,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
                );
                
                $insertdata = $this->purchase_window_model->saveNotificationLog($logData);
            }
            // ----------------------

        }

        $data1['projectID'] = $projectID;        
        $data1['projectequipment'] = $projectequipment;      
        echo json_encode($data1); 
    }

    public function updateSinglePurchase(){
        // print_r($_POST); exit;
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];                      
        
        $activityID = $_POST['activityID']; 
        $tag_no = $_POST['tag_no']; 
        $bom_date = $_POST['bom_date'];
        $description = $_POST['description'];  
        $tech_req = $_POST['tech_req'];  
        $dim_width = $_POST['dim_width'];  
        $dim_length = $_POST['dim_length'];  
        $dim_thickness = $_POST['dim_thickness'];   
        // $weight = $_POST['weight'];      
        $qty = $_POST['qty'];  
        $rev_odl = $_POST['rev_odl'];  
        $stock = $_POST['stock'];  
        $vendor = $_POST['vendor']; 
        $po_release_date = $_POST['po_release_date']; 
        $actual_po_date = $_POST['actual_po_date'];
        // $price = $_POST['price']; 
        $appr_date = $_POST['appr_date']; 
        $qap_given = $_POST['qap_given'];
        $material_reqd_prod = $_POST['material_reqd_prod']; 
        
        $exp_material_rec_date = $_POST['exp_material_rec_date']; 
        $actual_material_rec_date = $_POST['actual_material_rec_date']; 
        $tc_rec = $_POST['tc_rec']; 
        $remark = $_POST['remark']; 
        $release_for_prod = $_POST['release_for_prod'];
        $quality_remark = $_POST['quality_remark'];
        $mtc = $_POST['mtc'];                    

        $data = array(                  
            'tag_no'        => $tag_no,
            'bom_date'      => $bom_date,
            'description'     => $description,  
            'tech_req'       => $tech_req, 
            'dim_width'         => $dim_width,  
            'dim_length'       => $dim_length, 
            'dim_thickness'      => $dim_thickness,
            // 'weight'      => $weight,  
            'qty'  => $qty, 	
            'rev_odl'     => $rev_odl, 	
            'stock'  => $stock, 	
            'vendor'  => $vendor,	                
            'po_release_date'       => $po_release_date, 
            'actual_po_date'      => $actual_po_date,  
            // 'price'  => $price, 	
            'appr_date'     => $appr_date, 	
            'qap_given' => $qap_given,
            'material_reqd_prod'  => $material_reqd_prod, 
            'exp_material_rec_date'  => $exp_material_rec_date, 
            'actual_material_rec_date'  => $actual_material_rec_date, 
            'tc_rec'  => $tc_rec, 
            'remark' => $remark,	
            'release_for_prod' => $release_for_prod,
            'quality_remark' => $quality_remark,     
            'mtc' => $mtc,           
        );
        //print_r($data); die;
        
        
        
        // $updated_status_before = $this->purchase_window_model->is_UpdatedActivity_activityID($activityID);// for log module 
            $update = $insert = $this->purchase_window_model->updatePurchase($data, $activityID); 
        // $updated_status_after = $this->purchase_window_model->is_UpdatedActivity_activityID($activityID);// for log module
        
        if($update = 1){
            $logData = array();
            $logData = array(
                'purchase_window_ub_id' => $activityID,
                'notification_type' => 9,
                'noti_created_dept_id' => $this->session->userdata('dept'),
                'roleId' => $this->session->userdata('role'),
                'userId' => $this->session->userdata('userId'),
                'date' => date('Y-m-d'),
            );
            
            $insertdata = $this->purchase_window_model->saveNotificationLog($logData);
        }

       
        

        $data['projectID'] = $projectID;        
        $data['projectequipment'] = $projectequipment;      
        echo json_encode($data); 
    }


    


    public function addSinglePurchase(){
        // print_r($_POST); exit;
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];                      
        $projectNo = $_POST['projectNo'];                      
        $client_id = $_POST['client_id'];                      
        $tag_number = $_POST['tag_number'];                      
        
        $sort_order = $_POST['sort_order'];
        $activityID = $_POST['activityID']; 
        $tag_no = $_POST['tag_no']; 
        $bom_date = $_POST['bom_date'];
        $description = $_POST['description'];  
        $tech_req = $_POST['tech_req'];  
        $dim_width = $_POST['dim_width'];  
        $dim_length = $_POST['dim_length'];  
        $dim_thickness = $_POST['dim_thickness'];   
        // $weight = $_POST['weight'];      
        $qty = $_POST['qty'];  
        $rev_odl = $_POST['rev_odl'];  
        $stock = $_POST['stock'];  
        $vendor = $_POST['vendor']; 
        $po_release_date = $_POST['po_release_date']; 
        $actual_po_date = $_POST['actual_po_date'];
        // $price = $_POST['price']; 
        $appr_date = $_POST['appr_date']; 
        $qap_given = $_POST['qap_given'];
        $material_reqd_prod = $_POST['material_reqd_prod']; 
        $exp_material_rec_date = $_POST['exp_material_rec_date']; 
        $actual_material_rec_date = $_POST['actual_material_rec_date']; 
        $tc_rec = $_POST['tc_rec']; 
        $remark = $_POST['remark']; 
        $release_for_prod = $_POST['release_for_prod'];
        $quality_remark = $_POST['quality_remark'];
        $mtc = $_POST['mtc'];                    

        $data = array(   
            'sort_order' => $sort_order,
            'parent_activity_id' => $activityID,
            'projectID' => $projectID,
            'projectequipment' => $projectequipment,  
            'projectNo' => $projectNo,
            'client' => $client_id,
            'tag_number' => $tag_number,         
            'tag_no'        => $tag_no,
            'bom_date'      => $bom_date,
            'description'     => $description,  
            'tech_req'       => $tech_req, 
            'dim_width'         => $dim_width,  
            'dim_length'       => $dim_length, 
            'dim_thickness'      => $dim_thickness,
            // 'weight'      => $weight,  
            'qty'  => $qty, 	
            'rev_odl'     => $rev_odl, 	
            'stock'  => $stock, 	
            'vendor'  => $vendor,	                
            'po_release_date'       => $po_release_date, 
            'actual_po_date'      => $actual_po_date,  
            // 'price'  => $price, 	
            'appr_date'     => $appr_date, 	
            'qap_given' => $qap_given,
            'material_reqd_prod'  => $material_reqd_prod, 
            'exp_material_rec_date'  => $exp_material_rec_date, 
            'actual_material_rec_date'  => $actual_material_rec_date, 
            'tc_rec'  => $tc_rec, 
            'remark' => $remark,	
            'release_for_prod' => $release_for_prod,
            'quality_remark' => $quality_remark,     
            'mtc' => $mtc,           
        );
        //print_r($data); die;
        $this->purchase_window_model->add_purchase_excel_bulk($data);        

        //update parent purchase to make it disable
        $purchaseData = array(
            'is_disabled' => 1,
        );        
        $this->purchase_window_model->updatePurchase($purchaseData,$activityID);

        $data['projectID'] = $projectID;        
        $data['projectequipment'] = $projectequipment;      
        echo json_encode($data); 
    }

    public function view_purchase(){
        // print_r($_POST);
        $activityID = $_GET['activityID'];
        $data = $this->purchase_window_model->get_activity_by_id($activityID);
        echo json_encode($data);
    }

    public function importPurchaseFile(){
        ini_set('display_errors','Off');
        // echo '<pre>';
        // print_r($_POST);
        // print_r($_FILES);
        // exit;
          
        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];
        $projectNo = $_POST['projectNo'];
        $client_id = $_POST['client_id'];
        $tag_number = $_POST['tag_number'];
        // $purchaseProjectStartDate = $_POST['purchaseProjectStartDate'];
        //  $purchaseProjectEndDate = $_POST['purchaseProjectEndDate'];
        //   $purchaseActualStartDate = $_POST['purchaseActualStartDate'];
        //   $purchaseActualEndDate = $_POST['purchaseActualEndDate'];

        include_once APPPATH.'/libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php';
        include_once APPPATH.'/libraries/spreadsheet-reader-master/SpreadsheetReader.php';

        $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            
        if(in_array($_FILES["file"]["type"],$mimes)){               
            $uploadFilePath = 'uploads/purchase_files/'.basename($_FILES['file']['name']);          
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
                
            $Reader = new SpreadsheetReader($uploadFilePath);                    
            $Sheets = $Reader -> Sheets();
            
            //get highest sort order
            $sort_order_cnt = $this->purchase_window_model->get_highest_sort_order();
            // print_r($sort_order_cnt);exit;
            $sort_order = 0;
            $sort_order = $sort_order_cnt[0]->sort_order + 1;
            // print_r($sort_order);
            foreach ($Sheets as $Index => $Name) // will run no of sheets times
            {
                // echo 'Sheet #'.$Index.': '.$Name;
                $data_cnt =0;
                $last_tag_no = $this_tag_no = '';
                $Reader -> ChangeSheet($Index);                
                foreach ($Reader as $Row)
                {
                    if($Row[3] != '' && $Row[4] != ''){
                        $data_cnt = count($Reader);  
                        if($data_cnt > 8){ // this cond will avoid header and alos check for empty sheet                           

                            if($Row[2] != ''){
                                $this_tag_no = $Row[2];               
                            }else{
                                $this_tag_no = $last_tag_no;
                            } 
                            $data_array = array(
                                'sort_order' => $sort_order,
                                'projectID' => $projectID,
                                'projectequipment' => $projectequipment,
                                'projectNo' => $projectNo,
            //                     'purchaseProjectStartDate' =>$purchaseProjectStartDate,
            // 'purchaseProjectEndDate' =>$purchaseProjectEndDate,
            // 'purchaseActualStartDate' =>$purchaseActualStartDate,
            // 'purchaseActualEndDate' =>$purchaseActualEndDate,
                                'client' => $client_id,
                                'tag_number' => $tag_number,
                                // 'tag_no' => isset($Row[2]) ? $Row[2] : ', 
                                'tag_no' => $this_tag_no, 
                                'description' => isset($Row[3]) ? $Row[3] : '',                                            
                                'tech_req' => isset($Row[4]) ? $Row[4] : '',                     
                                'dim_width' => isset($Row[5]) ? $Row[5] : '', 
                                'dim_length' => isset($Row[6]) ? $Row[6] : '', 
                                'dim_thickness' => isset($Row[7]) ? $Row[7] : '', 
                                'qty' => isset($Row[8]) ? $Row[8] : '',
                                'rev_odl' => isset($Row[9]) ? $Row[9] : '',
                                // 'weight' => isset($Row[10]) ? $Row[10] : '',
                                // 'stock_available' => isset($Row[8]) ? $Row[8] : '',
                                // 'procured' => isset($Row[9]) ? $Row[9] : '',
                                // 'production_date' => isset($Row[10]) ? $Row[10] : '',
                                // 'del_date' => isset($Row[11]) ? $Row[11] : '',
                                // 'po_date' => isset($Row[12]) ? $Row[12] : '',
                                // 'actual_rec_date' => isset($Row[13]) ? $Row[13] : '',
                                // 'material_tc' => isset($Row[14]) ? $Row[14] : '',
                                // 'tc_received' => isset($Row[15]) ? $Row[15] : '',
                            );

                            $insert_purchase = $this->purchase_window_model->add_purchase_excel_bulk($data_array); 
                            $sort_order++; 
                            if($Row[2] != ''){
                                $last_tag_no = $Row[2];               
                            } 




                            
                        }                  
                    }
                }
            }
        
            
            $data['projectID'] = $projectID;        
            $data['projectequipment'] = $projectequipment;  // equipment in no format        
            echo json_encode($data);                      
        }else {           

        }                
    }

}
?>