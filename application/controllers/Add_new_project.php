<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Add_new_project extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('add_new_project_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = 'Add New Project';   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Add New Project';        
        $this->loadViews("project/list_all_project", $this->global);

        
    }

    public function myactivities(){
        $this->global['pageTitle'] = 'My Activity List';
        // Generating Project No Dropdown...
        $data['projects'] = $this->add_new_project_model->get_all_projects();        
        $this->loadViews("project/list_myactivities", $this->global, $data,  NULL);
    }

    public function ajax_list()
    {
        $list = $this->add_new_project_model->get_datatables();
       echo'<pre>'; print_r($list); die;
        $data = array();
        $no = $_POST['start'];
        $todays_date = date("Y-m-d");

        foreach ($list as $lists)
        {
            $edit = base_url('add_new_project/edit_data/').$lists->id;

            $no++;
            $row = array();
            $equipmentList1 = $tag_number = '';
            
            $row[] = $no;
            if($lists->act_desp_date != '' && $lists->isCompleted == 1){ // completed project
                $row[] = '<p class="project_over" title="Project completed">'.$lists->project_no.' / '.$lists->company_name.'</p>';   
            }else{
                if($lists->del_date < $todays_date){ // project delay
                    $row[] = '<p class="project_delayed" title="Project delay">'.$lists->project_no.' / '.$lists->company_name.'</p>';   
                }else{
                    $row[] = '<p class="project_progress" title="Project in progress">'.$lists->project_no.' / '.$lists->company_name.'</p>';  
                }                
            } 
                                            
            $equipmentlist = $this->add_new_project_model->get_Equipment_tag_by_id($lists->id);
            foreach($equipmentlist as $equipment){
                $equipmentList1 = $equipmentList1.''.$equipment->equipment_name.'<br/>';
                $tag_number = $tag_number.''.$equipment->tag_number.'<br/>';
            }

            $equip_qty_nos = '';
            $tagArray = explode(',',$lists->equip_qty);        
            foreach($tagArray as $equip_qty){                              
                $equip_qty_nos = $equip_qty_nos.''.$equip_qty.'<br/>';
            }

            $row[] = $equipmentList1;
            $row[] = $tag_number;  
            $row[] = $equip_qty_nos;                      
            $row[] = $lists->po_number;
            $row[] = $lists->po_date_time;
            $row[] = $lists->del_date;
            if($lists->proj_comp_date != '0000-00-00'){
                $row[] = $lists->proj_comp_date;            
            }else{
                $row[] = '';
            }

            if($lists->act_desp_date != '0000-00-00'){
                $row[] = $lists->act_desp_date;            
            }else{
                $row[] = '';
            }
                       
            $managerlist = $this->add_new_project_model->get_manager_by_id($lists->manager_name);
            $row[] = $managerlist->name;

            $row[] = $lists->jobvendor;

            if($lists->status == 1)
                $status_class = "md-btn-success";
            else if($lists->status == 0)
                $status_class = "md-btn";    

            $status = ($lists->status? "Active" : "Passive");

            $row[] = '<i data='."'".$lists->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';
           
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="View" onclick="view_data('.$lists->id.')"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a> |
                <a href='."'".$edit."'".' data-uk-tooltip title="Edit"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$lists->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';            

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
      
    public function add_project()
    {                
        $this->form_validation->set_rules('project_no','Project No','required');
        $this->form_validation->set_rules('equipment','Equipment','required');
        $this->form_validation->set_rules('po_date_time','PO Date','required');
        $this->form_validation->set_rules('po_number','PO Number','required');
        $this->form_validation->set_rules('del_date','Delivery Date','required');
        $this->form_validation->set_rules('client','client','required');
        $this->form_validation->set_rules('manager_name','Manager','required');
        $this->form_validation->set_rules('tag_number[]','Tag number','required');
        $this->form_validation->set_rules('equip_qty[]','Quantity','required');
        $this->form_validation->set_rules('description','Description','required');
             
        if($this->form_validation->run() == false)
        {              
            $data["equipmentlist"] = $this->add_new_project_model->get_all_equipment();            
            $data['clientlist'] = $this->add_new_project_model->get_all_client();
            $data['managers'] = $this->add_new_project_model->get_all_managers();
            $data['projects'] = $this->add_new_project_model->get_all_projects();
            $data['department'] = $this->add_new_project_model->get_all_department();            
            $this->loadViews("project/add_new_project", $this->global, $data , NULL);
        }
        else{ 
            // echo '<pre>';
            // print_r($_POST); exit;
            $equipment = array();
            // print_r($_POST['tag_number']);
            $equip_qty = $_POST['equip_qty'];
            $tag_number = $_POST['tag_number'];
            $no = 0;
            foreach($tag_number as $key=>$value){
                $equipment[$no]= $key;
                $no++;
            }  

            $data = array(
                'project_no'    => str_replace(' ', '', $this->input->post('project_no')),
                'equipment'     => implode(",",$equipment),
                'po_date_time'  => $this->input->post('po_date_time'),
                'del_date'      => $this->input->post('del_date'),
                'client'        => $this->input->post('client'),
                'tag_number'    => implode(",",$tag_number),
                'equip_qty'     => implode(",",$equip_qty),
                'jobvendor'   => $this->input->post('jobvendor'),
                'description'   => $this->input->post('description'),  
                'manager_name'  => $this->input->post('manager_name'),  
                'po_number'     => $this->input->post('po_number'), 
                'project_year'  => date("Y", strtotime($this->input->post('po_date_time'))),
            );

            $lastInsertId = $this->add_new_project_model->save($data);

            //store equipment and tag number in separate table
            foreach($tag_number as $eq=>$tag){
                $getEquipmentName = $this->add_new_project_model->get_equipment_name($eq); 
                $data1 = array(
                    'projectID' => $lastInsertId,
                    'equipment' => $eq,
                    'tag_number' => $tag,
                    'equip_qty' => $equip_qty[$eq],
                    'equipment_name' => $getEquipmentName->equipment,
                );
                $saveEu = $this->add_new_project_model->save_equipment($data1);
            } 
            
            // $userRole = $this->session->userdata('role');
            // $dept_id = $this->session->userdata('dept');    
            // $design = $this->session->userdata('design_dept_access');
            // $purchase = $this->session->userdata('purchase_dept_access');
            // $production = $this->session->userdata('production_dept_access');
            // $quality = $this->session->userdata('quality_dept_access'); 
            // $vendor = $this->session->userdata('vendor_dept_access'); 
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
            
            
            $log_data = array(
                    // 'project_detail_ap_id' => $lastInsertId,
                    // 'notification_type' => 1,
                    // 'noti_created_dept_id' => $this->session->userdata('dept'),
                    // 'roleId' => $this->session->userdata('role'),
                    // 'userId' => $this->session->userdata('userId'),
                    // 'date' => date('Y-m-d'),


                    'project_detail_ap_id' => $lastInsertId,
                    'notification_type' => 1,
                    'noti_created_dept_id' => $this->session->userdata('dept'),
                    'roleId' => $this->session->userdata('role'),
                    'userId' => $this->session->userdata('userId'),
                    'date' => date('Y-m-d'),
            );

            
            // notification log
            $inserted_notification_response = $this->add_new_project_model->saveNotificationLog($log_data);
            
            

            redirect(base_url('add_new_project'));
        }
    }   
 
    public function update_project()
    {
        // echo "<pre>";       
        // print_r($_POST);
        // exit;
        $pid = $_POST['id'];
        $this->form_validation->set_rules('project_no','Project No','required');
        $this->form_validation->set_rules('manager_name','Manager','required');
        $this->form_validation->set_rules('po_date_time','PO Date','required');
        $this->form_validation->set_rules('po_number','PO Number','required');
        $this->form_validation->set_rules('del_date','Delivery Date','required');
        // $this->form_validation->set_rules('act_desp_date','Actual dispatch Date','required');
        $this->form_validation->set_rules('client','client','required');
        // $this->form_validation->set_rules('tag_number[]','Tag number','required');
        $this->form_validation->set_rules('description','Description','required');
        
        if($this->form_validation->run() == false)
        {      
            $data = $eqDataArray = $tagDataArray = $finalEqTagArray = array();         
            $data['pdata'] = $this->add_new_project_model->get_by_id($pid);         
            $data["equipmentlist"] = $this->add_new_project_model->get_all_equipment();            
            $data['clientlist'] = $this->add_new_project_model->get_all_client();
            $data['managers'] = $this->add_new_project_model->get_all_managers();
            $data["equipmentTagList"] = $this->add_new_project_model->get_Equipment_tag_by_id($pid);  
          
            $this->loadViews("project/edit_project", $this->global, $data , NULL);
        }
        else{   
            $equipment = array();
            $equip_qty = $_POST['equip_qty'];
            $tag_number = $_POST['tag_number'];
            // print_r($tag_number); exit;
            $no = 0;
            foreach($tag_number as $key=>$value){
                $equipment[$no]= $key;
                $no++;
            }   

            $isCompleted = 0;
            $act_desp_date = $this->input->post('act_desp_date');
            if($act_desp_date != ''){
                $isCompleted = 1;
            }

            $data = array(
                'project_no'    => str_replace(' ', '', $this->input->post('project_no')),
                'client'      => $this->input->post('client'),
                'equipment'     => implode(",",$equipment),
                'po_date_time'  => $this->input->post('po_date_time'),
                'del_date'      => $this->input->post('del_date'),
                'proj_comp_date'=> $this->input->post('proj_comp_date'),
                'act_desp_date' => $this->input->post('act_desp_date'),
                'isCompleted'   => $isCompleted,
                'tag_number'    => implode(",",$tag_number),
                'equip_qty'     => implode(",",$equip_qty),
                'jobvendor'   => $this->input->post('jobvendor'),
                'description'   => $this->input->post('description'), 
                'manager_name'  => $this->input->post('manager_name'),   
                'po_number'     => $this->input->post('po_number'), 
                'project_year'  => date("Y", strtotime($this->input->post('po_date_time'))),
                'updatedOn'     =>  date('Y-m-d H:i:s'),
            );
            
            $this->add_new_project_model->update(array('id' => $pid), $data);
            
            //delete previous records by Project ID
            $deletePreviousRecords = $this->add_new_project_model->delete_eq_tag_update($pid);             
             //store new/updated equipment and tag number
            foreach($tag_number as $eq=>$tag){
                $getEquipmentName = $this->add_new_project_model->get_equipment_name($eq); 
                $data1 = array(
                    'projectID' => $pid,
                    'equipment' => $eq,
                    'tag_number' => $tag,
                    'equip_qty' => $equip_qty[$eq],
                    'equipment_name' => $getEquipmentName->equipment,
                );
                $saveEu = $this->add_new_project_model->save_equipment($data1);
            }       
            redirect(base_url('add_new_project'));
        }
    }

    public function edit_data($id)
    { 
        $data = $eqDataArray = $tagDataArray = $finalEqTagArray = array();         
        $data['pdata'] = $this->add_new_project_model->get_by_id($id); 
        $data['clientlist'] = $this->add_new_project_model->get_all_client();  
        $data['managers'] = $this->add_new_project_model->get_all_managers();      
        $data["equipmentlist"] = $this->add_new_project_model->get_all_equipment();   
        $data["equipmentTagList"] = $this->add_new_project_model->get_Equipment_tag_by_id($id);  

        $this->loadViews('project/edit_project',$this->global, $data,NULL);                      
    }

    public function view_data($id)
    {    
        $data = array();    
        $data['project'] = $this->add_new_project_model->get_project_view($id);         
        // echo '<pre>'; print_r($data['project']->equipment); exit; 
        if($data['project']->equipment){
            $equipment_name = '';
            $equipmentArray = explode(',',$data['project']->equipment);
            foreach($equipmentArray as $equipment){
                $equipmentName = $this->add_new_project_model->get_equipment_name($equipment);                    
                $equipment_name = $equipment_name.''.$equipmentName->equipment.' | ';
            }
        }

        $tag_number_name = '';
        $tagArray = explode(',',$data['project']->tag_number);        
        foreach($tagArray as $tag_number){                              
            $tag_number_name = $tag_number_name.''.$tag_number.' | ';
        }

        $equip_qty_nos = '';
        $tagArray = explode(',',$data['project']->equip_qty);        
        foreach($tagArray as $equip_qty){                              
            $equip_qty_nos = $equip_qty_nos.''.$equip_qty.' | ';
        }
        $data['equipment'] = rtrim($equipment_name,'| ');
        $data['tag_number'] = rtrim($tag_number_name,'| ');
        $data['equip_qty'] = rtrim($equip_qty_nos,'| ');
        // echo '<pre>'; print_r($data); exit; 
        echo json_encode($data);              
    }
 
    public function ajax_delete($id)
    {
        $this->add_new_project_model->delete_by_id($id);
        $this->add_new_project_model->delete_by_id_project_details($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->add_new_project_model->delete_by_id($id);
            $this->add_new_project_model->delete_by_id_project_details($id);
        }
        echo json_encode(array("status" => TRUE));
    }     

    public function update_status()
	{
        $this->add_new_project_model->update_status($this->input->post('id'), $this->input->post('status'));
	}   

    public function getEquipmentname(){        
        $equipmentId = $_POST['equipmentId'];        
        $getEquipmentName = $this->add_new_project_model->get_equipment_name($equipmentId);         
        echo $getEquipmentName->equipment;
    }

    public function getProjectEquipment(){ 
        $data = '';   
        $projectID = $_POST['projectID'];    
        $equipmentlist = $this->add_new_project_model->get_all_equipments($projectID);                             
// print_r($equipmentlist);
        // $equipment_array = explode(',',$equipmentlist->equipment);
         foreach($equipmentlist as $equipment){
            //  $projectEquipmentList = $this->add_new_project_model->get_equipment_name($value);  
             $data.= "<option value = '".$equipment->equipment."'>".$equipment->equipment_name."</option>";                                 
         } 
         echo json_encode($data);          
    }

    public function check_eqp_activity_exists(){
        $equipmentId = $_POST['equipmentId'];  
        $projectID = $_POST['projectID'];  
        // print_r($equipmentId);
        // print_r($projectID);
        $checkActivity = $this->add_new_project_model->check_if_eqp_activity_exists($projectID,$equipmentId);
        
        // print_r($checkActivity); exit;
        if($checkActivity > 0){
            echo "yes";
        }else{
            echo "no";
        }
    }

    public function check_activity_exists(){
        $equipmentId = $_POST['equipmentId'];  
        $projectID = $_POST['projectID']; 
        $dept_name = $_POST['dept_name'];
        // print_r($equipmentId);
        // print_r($projectID);
        $checkActivity = $this->add_new_project_model->check_if_eqp_activity_exists($projectID,$equipmentId);
        
        // print_r($checkActivity); exit;
        if($checkActivity > 0){
            echo "yes";
        }else{
            echo "no";
        }
    }

    public function export_project_data(){
        $project_data = $this->add_new_project_model->getProjectDetails();              
        // echo '<pre>';
        // print_r($project_data);exit;

		$filename = 'all_projects_'.date('d-m-Y').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
		$file = fopen('php://output','w');        		
		$header = array("pNo","Project No", "Client", "Manager", "Equipment",  "TAG Number",  "Equipment Qty", "PO date", "PO Number", "Delivery Date", "Completion Date", "Actual dispatch Date", "Project Status"); 
		fputcsv($file, $header);

		foreach ($project_data as $key=>$value)
		{                    
            $projectId = $value['id'];   
            if($value['isCompleted'] == 1){
                $value['isCompleted'] = 'Completed';
            }else{
                $value['isCompleted'] = 'Live';
            }

            $equipmentList = explode(',',$value['equipment']);          
            if(!empty($equipmentList)){
                foreach($equipmentList as $equip){                  
                    $equipName = $this->add_new_project_model->get_project_equipment_name($equip,$projectId);   
                    if(!empty($equipName)){ 
                        // echo '<pre>';
                        // print_r($equipName);                
                        $value['equipment'] = $equipName->equipment_name;
                        $value['equip_qty'] = $equipName->equip_qty;
                        $value['tag_number'] = $equipName->tag_number;
                        fputcsv($file,$value); 
                    }else{
                        fputcsv($file,$value); 
                    }
                }
            }else{
                fputcsv($file,$value); 
            }            
		}        
		fclose($file);		
		exit; 
    }
}
?>