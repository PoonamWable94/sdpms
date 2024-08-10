<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Report extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Projects Reports';           
        $this->loadViews("reports/completed_projects", $this->global);
    }

    public function completed_projects(){
        $list = $this->report_model->get_datatables();
    //    echo'<pre>'; print_r($list); die;
        $data = array();
        $no = $_POST['start'];
        $todays_date = date("Y-m-d");

        foreach ($list as $lists)
        {            
            $no++;
            $row = array();
            $equipmentList1 = $tag_number = '';
            
            $row[] = $no;
            
            $row[] = $lists->project_year;

            $row[] = $lists->project_no.' / '.$lists->company_name;   
            
            // $managerlist = $this->report_model->get_manager_by_id($lists->manager_name);
            $row[] = $lists->name;  

            $equipmentlist = $this->report_model->get_Equipment_tag_by_id($lists->id);
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

            $row[] = $lists->designProjectStartDate;
            $row[] = $lists->designActualStartDate;
            $row[] = $lists->designProjectEndDate;
            $row[] = $lists->designActualEndDate;

            $row[] = $lists->purchaseProjectStartDate;
            $row[] = $lists->purchaseActualStartDate;
            $row[] = $lists->purchaseProjectEndDate;
            $row[] = $lists->purchaseActualEndDate;

            $row[] = $lists->productionProjectStartDate;
            $row[] = $lists->productionActualStartDate;
            $row[] = $lists->productionProjectEndDate;
            $row[] = $lists->productionActualEndDate;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all(),
            "recordsFiltered" => $this->report_model->count_filtered(),
            "data" => $data,
        );        
        echo json_encode($output);
    }

    public function Department_progress()
    {
        $this->global['pageTitle'] = 'Department Progress';      
        $data['projects'] = $this->report_model->get_all_projects();          
        $this->loadViews("reports/dept_report", $this->global, $data , NULL);
    }    

    // For Department wise progress report (Design)
    public function getDesignProjects(){
        $projectNo = $_GET['projectNo'];
        $getData = $this->report_model->get_design_projects($projectNo);  

        $table = '<h4>&nbsp;&nbsp; Design Department</h4>';
        $table.= '
            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>
                        <th class="header_design" style="color:#fff"><b>Activity</b></th>                                        
                        <th class="header_design" style="color:#fff"><b>Start date</b></th>                                        
                        <th class="header_design" style="color:#fff"><b>End date</b></th>
                        <th class="header_design" style="color:#fff"><b>Actual Start Date</b></th>                                        
                        <th class="header_design" style="color:#fff"><b>Actual End Date</b></th>                                   
                        <th class="header_design" style="color:#fff"><b>Delay</b></th>                        
                    </tr>
                </thead>
                <tbody>';

        foreach($getData as $data){
            $startDate = date("j/m/Y h:i a", strtotime($data->startDate));
            $targetDate = date("j/m/Y h:i a", strtotime($data->targetDate));
            $actual_start_date = date("j/m/Y h:i a", strtotime($data->actual_start_date));
            $taskCompDate = date("j/m/Y h:i a", strtotime($data->taskCompDate));

            $table.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->activityID.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>
                    <td class="header_design"> 
                        '.$data->activity_data.'
                    </td>
                    <td class="header_design">
                        '.$startDate.'
                    </td>
                    <td class="header_design">
                        '.$targetDate.'
                    </td>
                    <td class="header_design">
                        '.$actual_start_date.'
                    </td>
                    <td class="header_design">
                        '.$taskCompDate.'
                    </td>
                    <td class="header_design">
                        '.$data->delayDays.'
                    </td>                
                </tr>';            
        }        
        $table.= '</tbody>
                </table>';

        echo json_encode($table);
    }

    // For Department wise progress report (Production)
    public function getProductionProjects(){
        $projectNo = $_GET['projectNo'];

        $getComponentData = $this->report_model->get_production_component_projects($projectNo);  

        $table = '<h4>&nbsp;&nbsp; Component Activity</h4>';
        $table.= '
            <table id="prod_component_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>
                        <th class="header_design" style="color:#fff"><b>Activity</b></th>                                                                                           
                        <th class="header_design" style="color:#fff"><b>Total Time</b></th>
                    </tr>
                </thead>
                <tbody>';

        foreach($getComponentData as $data){
            $table.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->activityID.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>
                    <td class="header_design"> 
                        '.$data->task.'
                    </td>
                    
                    <td class="header_design">
                        '.$data->total_time.'
                    </td>                
                </tr>';            
        }        
        $table.= '</tbody>
                </table>';        


        $getAssemblyData = $this->report_model->get_production_assembly_projects($projectNo);  
        $table.= '<h4>&nbsp;&nbsp; Assembly Activity</h4>';
        $table.= '
            <table id="prod_assembly_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>
                        <th class="header_design" style="color:#fff"><b>Activity</b></th>                                                                                           
                        <th class="header_design" style="color:#fff"><b>Total Time</b></th>
                    </tr>
                </thead>
                <tbody>';

        foreach($getAssemblyData as $data){           
            $table.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->activityID.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>
                    <td class="header_design"> 
                        '.$data->assembly.'
                    </td>
                    
                    <td class="header_design">
                        '.$data->total_time.'
                    </td>                
                </tr>';            
        }        
        $table.= '</tbody>
                </table>';

        echo json_encode($table);
    }

    // Department wise progress report (Purchase)
    public function getPurchaseProjects(){
        $projectNo = $_GET['projectNo'];
        $getData = $this->report_model->get_purchase_projects($projectNo);  

        $table = '<h4>&nbsp;&nbsp; Purchase Department </h4>';
        $table.= '
            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>                                                   
                        <th class="header_design" style="color:#fff"><b>Uploaded On</b></th>                        
                    </tr>
                </thead>
                <tbody>';

        foreach($getData as $data){
            $createdOn = date("j/m/Y h:i a", strtotime($data->createdOn));

            $table.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->id.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>                    
                    <td class="header_design">
                        '.$createdOn.'
                    </td>                                
                </tr>';            
        }        
        $table.= '</tbody>
                </table>';

        echo json_encode($table);
    }

    public function All_projects()
    {
        $this->global['pageTitle'] = 'All Projects';      
        $data['projects'] = $this->report_model->get_all_projects();          
        $this->loadViews("reports/all_projects", $this->global, $data , NULL);
    }

    public function getAllProjectsData(){
        $projectNo = $_GET['projectNo'];
        $getDesignData = $this->report_model->get_design_projects($projectNo);  

        $design_data = '<h4>&nbsp;&nbsp; Design Department </h4>';
        $design_data.= '
            <table id="design_dept" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>
                        <th class="header_design" style="color:#fff"><b>Activity</b></th>                                        
                        <th class="header_design" style="color:#fff"><b>Start date</b></th>                                        
                        <th class="header_design" style="color:#fff"><b>End date</b></th>
                        <th class="header_design" style="color:#fff"><b>Actual Start Date</b></th>                                        
                        <th class="header_design" style="color:#fff"><b>Actual End Date</b></th>                                   
                        <th class="header_design" style="color:#fff"><b>Delay</b></th>                        
                    </tr>
                </thead>
                <tbody>';

        foreach($getDesignData as $data){
            $startDate = date("j/m/Y h:i a", strtotime($data->startDate));
            $targetDate = date("j/m/Y h:i a", strtotime($data->targetDate));
            $actual_start_date = date("j/m/Y h:i a", strtotime($data->actual_start_date));
            $taskCompDate = date("j/m/Y h:i a", strtotime($data->taskCompDate));

            $design_data.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->activityID.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>
                    <td class="header_design"> 
                        '.$data->activity_data.'
                    </td>
                    <td class="header_design">
                        '.$startDate.'
                    </td>
                    <td class="header_design">
                        '.$targetDate.'
                    </td>
                    <td class="header_design">
                        '.$actual_start_date.'
                    </td>
                    <td class="header_design">
                        '.$taskCompDate.'
                    </td>
                    <td class="header_design">
                        '.$data->delayDays.'
                    </td>                
                </tr>';            
        }        
        $design_data.= '</tbody>
                </table>';
        
        $getPurchaseData = $this->report_model->get_purchase_projects($projectNo);  

        $purchase_data = '<h4>&nbsp;&nbsp; Purchase Department </h4>';
        $purchase_data.= '
            <table id="purchase_dept" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>                                                   
                        <th class="header_design" style="color:#fff"><b>Uploaded On</b></th>                        
                    </tr>
                </thead>
                <tbody>';

        foreach($getPurchaseData as $data){           
            $createdOn = date("j/m/Y h:i a", strtotime($data->createdOn));

            $purchase_data.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->id.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>                    
                    <td class="header_design">
                        '.$createdOn.'
                    </td>                                
                </tr>';            
        }        
        $purchase_data.= '</tbody>
                </table>';
        
        $getComponentData = $this->report_model->get_production_component_projects($projectNo);  

        $production_data = '<h4>&nbsp;&nbsp; Production & Planning- Component Activity </h4>';
        $production_data.= '
            <table id="prod_component_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>
                        <th class="header_design" style="color:#fff"><b>Activity</b></th>                                                                                           
                        <th class="header_design" style="color:#fff"><b>Total Time</b></th>
                    </tr>
                </thead>
                <tbody>';

        foreach($getComponentData as $data){           
            $production_data.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->activityID.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>
                    <td class="header_design"> 
                        '.$data->task.'
                    </td>
                    
                    <td class="header_design">
                        '.$data->total_time.'
                    </td>                
                </tr>';            
        }        
        $production_data.= '</tbody>
                </table>';        

        $getAssemblyData = $this->report_model->get_production_assembly_projects($projectNo);  
        $production_data.= '<h4>&nbsp;&nbsp; Production & Planning- Assembly Activity</h4>';
        $production_data.= '
            <table id="prod_assembly_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                <thead>
                    <tr class="table_head">
                        <th class="header_design" style="color:#fff"><b>Sr.</b></th>
                        <th class="header_design" style="color:#fff"><b>Equipment</b></th>
                        <th class="header_design" style="color:#fff"><b>Activity</b></th>                                                                                           
                        <th class="header_design" style="color:#fff"><b>Total Time</b></th>
                    </tr>
                </thead>
                <tbody>';

        foreach($getAssemblyData as $data){           
            $production_data.= '                           
                <tr>
                    <td class="header_design">
                        '.$data->activityID.'
                    </td>
                    <td class="header_design">
                        '.$data->equipment_name.'
                    </td>
                    <td class="header_design"> 
                        '.$data->assembly.'
                    </td>
                    
                    <td class="header_design">
                        '.$data->total_time.'
                    </td>                
                </tr>';            
        }        
        $production_data.= '</tbody>
                </table>';

        echo json_encode(array('design'=>$design_data,'purchase'=>$purchase_data, 'production'=>$production_data));
    }

    // Export all Projects
    public function export_project_data(){
        $project_year = $_GET['id'];
        $project_data = $this->report_model->getProjectDetails($project_year);              
        // echo '<pre>'; print_r($project_data);exit;

		$filename = 'all_projects_'.date('d-m-Y').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
		$file = fopen('php://output','w');        		
		$header = array("pNo","Project No", "Client", "Manager", "Equipment",  "TAG Number",  "Equipment Qty", "PO date", "PO Number", "Delivery Date", "Completion Date", "Actual dispatch Date", "Project Status", "Design Start(Planned)", "Design Start(Actual)", "Design End(Planned)", "Design End(Actual)", "Purchase Start(Planned)", "Purchase Start(Actual)", "Purchase End(Planned)", "Purchase End(Actual)", "Production Start(Planned)", "Production Start(Actual)", "Production End(Planned)", "Production End(Actual)"); 
		fputcsv($file, $header);

		foreach ($project_data as $key=>$value)
		{
            $projectId = $value['id'];   
            if($value['isCompleted'] == 1){
                $value['isCompleted'] = 'Completed';
            }else{
                $value['isCompleted'] = 'In Progress';
            }

            $equipmentList = explode(',',$value['equipment']);   
            $all_equipment = $all_equip_qty = $all_tag_number = '';

            if(!empty($equipmentList)){
                foreach($equipmentList as $equip){                  
                    $equipName = $this->report_model->get_project_equipment_name($equip,$projectId);                                                       
                    $all_equipment = $all_equipment.''.$equipName->equipment_name.', ';
                    $all_equip_qty = $all_equip_qty.''.$equipName->equip_qty.', ';
                    $all_tag_number = $all_tag_number.''.$equipName->tag_number.', ';                                            
                }

                $value['equipment'] = $all_equipment;
                $value['equip_qty'] = $all_equip_qty;
                $value['tag_number'] = $all_tag_number;
                fputcsv($file,$value); 
            }else{
                fputcsv($file,$value); 
            }                         
		}
		fclose($file);		
		exit; 
    }

    // Export department progress Projects
    public function export_dept_project_data(){
        $projectNo = $_GET['projectNo'];
        $department = $_GET['department'];
        $project_data = '';       

        if($department == 1){
            $project_data = $this->report_model->getDesignProjectDetails($projectNo);            

            $filename = 'Design_progress_report_'.date('d-m-Y').'.csv'; 
            header("Content-Description: File Transfer"); 
            header("Content-Disposition: attachment; filename=$filename"); 
            header("Content-Type: application/csv; ");

            // file creation 
            $file = fopen('php://output','w');        		
            $header = array("Equipment",  "Activity",  "Start Date", "End Date", "Actual Start Date", "Actual End Date", "Delay"); 
            fputcsv($file, $header);

            foreach ($project_data as $key=>$value)
            {            
                fputcsv($file,$value);             
            }
            fclose($file);		
            exit; 

        }else if($department == 2){
            $project_data = $this->report_model->getPurchaseProjectDetails($projectNo);
            
            $filename = 'Purchase_progress_report_'.date('d-m-Y').'.csv'; 
            header("Content-Description: File Transfer"); 
            header("Content-Disposition: attachment; filename=$filename"); 
            header("Content-Type: application/csv; ");

            // file creation 
            $file = fopen('php://output','w');        		
            $header = array("Sr No","Equipment",  "Uploaded On"); 
            fputcsv($file, $header);

            foreach ($project_data as $key=>$value)
            {            
                fputcsv($file,$value);             
            }
            fclose($file);		
            exit; 

        }else{
            // $project_data = $this->report_model->getProductionProjectDetails($projectNo);

            $filename = 'Production_progress_report_'.date('d-m-Y').'.csv'; 
            header("Content-Description: File Transfer"); 
            header("Content-Disposition: attachment; filename=$filename"); 
            header("Content-Type: application/csv; ");

            // file creation 
            $file = fopen('php://output','w'); 
  
            $production_comp_header_blank = array(""); 
            fputcsv($file, $production_comp_header_blank);
            $prod_comp_header = array("Production Department- Component Activity"); 
            fputcsv($file, $prod_comp_header);
            $prod_comp_data = array("Sr. No","Equipment", "Activity", "Supervisor","QTY","Total Time","Client Approval","Release for Production","Manufacturing Type"); 
            fputcsv($file, $prod_comp_data);
    
            $prod_comp_export_data = $this->report_model->get_prod_comp_export_projects($projectNo);
            // echo '<pre>'; print_r($prod_comp_export_data);exit;
            foreach ($prod_comp_export_data as $key=>$value)
            {
                $personList = explode(',',$value['supervisor']);   
                $person_name = '';
    
                if(!empty($personList)){
                    foreach($personList as $person){      
                        if($person > 0){
                            $personName = $this->report_model->get_manager_by_id($person);
                            $person_name = $person_name.''.$personName->name.', '; 
                        }else{
                            $person_name = $person_name.' ';
                        }                                                                                   
                    }                
                    $value['supervisor'] = $person_name;               
                    fputcsv($file,$value); 
                }else{
                    fputcsv($file,$value); 
                }   
                     
                // Component SUB Activity
                    // $prod_sub_comp_header = array(" "," ","Component Sub Activity"); 
                    // fputcsv($file, $prod_sub_comp_header);
                    $prod_sub_comp_data = array("","","", "Activity", "Employee","Planned Start","Planned Target","Actual Start","Actual End","Start Delay","End Delay","QTY QC Date","QTY QC Remark","TPI QC Date","TPI QC Remark","Client Approval","Release for Production","Manufacturing Type","Total Time"); 
                    fputcsv($file, $prod_sub_comp_data);
    
                    $prod_sub_comp_export_data = $this->report_model->get_prod_sub_comp_export_projects($value['activityID'],$projectNo);
                    $srno_sub_comp = 0;
                    foreach ($prod_sub_comp_export_data as $key1 => $value1)
                    {
                        $srno_sub_comp++;
                        $personList = explode(',',$value1['resp_persons']);   
                        $person_name = '';
                        $total_time = $value1['activity_days'].' days '.$value1['activity_time_hours'].' hrs '.$value1['activity_time_minutes'].' min';
                        $value1['activity_days'] = $total_time;
                        $value1['activity_time_hours'] = '';
                        $value1['activity_time_minutes'] = '';
                        $value1['status'] = '';
                        $value1['isDeleted'] = '';
                        $value1['sub_act_order'] = $srno_sub_comp;
    
                        if(!empty($personList) && $personList != NULL){
                            foreach($personList as $person){
                                if($person > 0){
                                    $personName = $this->report_model->get_emp_details($person);
                                    $person_name = $person_name.''.$personName->name.', '; 
                                }else{
                                    $person_name = $person_name.' ';
                                }                                                                                   
                            }                
                            $value1['resp_persons'] = $person_name;               
                            fputcsv($file,$value1); 
                        }else{
                            fputcsv($file,$value1); 
                        } 
                    }
                    $prod_sub_comp_header_blank = array(""); 
                    fputcsv($file, $prod_sub_comp_header_blank);
            }
    
            $production_assembly_header_blank = array(""); 
            fputcsv($file, $production_assembly_header_blank);
            $prod_asss_header = array("Production Department- Assembly Activity"); 
            fputcsv($file, $prod_asss_header);
            $prod_ass_data = array("Sr. No","Equipment", "Activity", "Supervisor","QTY","Total Time","Client Approval","Release for Production","Manufacturing Type"); 
            fputcsv($file, $prod_ass_data);
    
            $prod_assembly_export_data = $this->report_model->get_prod_assembly_export_projects($projectNo);
            // echo '<pre>'; print_r($prod_assembly_export_data);exit;
            foreach($prod_assembly_export_data as $key=>$value)
            {
                $personList = explode(',',$value['supervisor']);   
                $person_name = '';
    
                if(!empty($personList)){
                    foreach($personList as $person){
                        if($person > 0){
                            $personName = $this->report_model->get_manager_by_id($person);
                            $person_name = $person_name.''.$personName->name.', ';  
                        }else{
                            $person_name = '';
                        }                                                                                  
                    }                
                    $value['supervisor'] = $person_name;               
                    fputcsv($file,$value); 
                }else{
                    fputcsv($file,$value); 
                }
                // Assembly SUB Activity
                    // $prod_sub_comp_header = array(" "," ","Assembly Sub Activity"); 
                    // fputcsv($file, $prod_sub_comp_header);
                    $prod_sub_assembly_data = array("","","", "Activity", "Employee","Planned Start","Planned Target","Actual Start","Actual End","Start Delay","End Delay","QTY QC Date","QTY QC Remark","TPI QC Date","TPI QC Remark","Client Approval","Release for Production","Manufacturing Type","Total Time"); 
                    fputcsv($file, $prod_sub_assembly_data);
    
                    $prod_sub_assembly_export_data = $this->report_model->get_prod_sub_assembly_export_projects($value['activityID'],$projectNo);
                    $srno_sub_ass = 0;
                    foreach ($prod_sub_assembly_export_data as $key1 => $value2)
                    {
                        $srno_sub_ass++;
                        $personList = explode(',',$value2['resp_persons']);   
                        $person_name = '';
                        $total_time = $value2['activity_days'].' days '.$value2['activity_time_hours'].' hrs '.$value2['activity_time_minutes'].' min';
                        $value2['activity_days'] = $total_time;
                        $value2['activity_time_hours'] = '';
                        $value2['activity_time_minutes'] = '';
                        $value2['status'] = '';
                        $value2['isDeleted'] = '';
                        $value2['sub_act_order'] = $srno_sub_ass;
    
                        if(!empty($personList) && $personList != NULL){
                            foreach($personList as $person){      
                                if($person > 0){
                                    $personName = $this->report_model->get_emp_details($person);
                                    $person_name = $person_name.''.$personName->name.', '; 
                                }else{
                                    $person_name = $person_name.' ';
                                }                                                                                   
                            }
                            $value2['resp_persons'] = $person_name;               
                            fputcsv($file,$value2); 
                        }else{
                            fputcsv($file,$value2); 
                        } 
                    }
                    $prod_sub_comp_header_blank = array(""); 
                    fputcsv($file, $prod_sub_comp_header_blank);                        
            }
            fclose($file);		
            exit; 
        }        
        // echo '<pre>'; print_r($project_data); exit;		        
    }

    public function export_completed_project_data(){
        $projectNo = $_GET['id'];        

		$filename = 'project_'.$projectNo.date('d-m-Y').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
		$file = fopen('php://output','w');   
     
		$design_header = array("Design Department"); 
		fputcsv($file, $design_header);
        $design_header_data = array("Sr. No","Order","Level", "Equipment", "Activity", "Person", "Start Date","End Date", "Actual Start Date", "Actual End Date","Delay","Client Approval","Release for Production"); 
		fputcsv($file, $design_header_data);

        $design_export_data = $this->report_model->get_design_export_projects($projectNo);
        // echo '<pre>'; print_r($design_export_data);exit;
		foreach ($design_export_data as $key=>$value)
		{
            if($value['level'] == 0){
                $value['level'] = 'L0';
            }else if($value['level'] == 1){
                $value['level'] = 'L1';
            }else if($value['level'] == 2){
                $value['level'] = 'L2';
            }else if($value['level'] == 3){
                $value['level'] = 'L3';
            }else if($value['level'] == 4){
                $value['level'] = 'L4';
            }else if($value['level'] == 5){
                $value['level'] = 'L5';
            }else{
                $value['level'] = 'L';
            }

            $personList = explode(',',$value['person1']);   
            $person_name = '';

            if(!empty($personList)){
                foreach($personList as $person){                  
                    if($person > 0){
                        $personName = $this->report_model->get_manager_by_id($person);
                        $person_name = $person_name.''.$personName->name.', ';  
                    }else{
                        $person_name = $person_name.' ';
                    }                                                              
                }                
                $value['person1'] = $person_name;               
                fputcsv($file,$value); 
            }else{
                fputcsv($file,$value); 
            }                         
		}

        $purchase_header_blank = array(""); 
		fputcsv($file, $purchase_header_blank);
        $purchase_header = array("Purchase Department"); 
		fputcsv($file, $purchase_header);
        $purchase_header_data = array("Sr. No","Equipment", "File Name", "Uploaded on"); 
		fputcsv($file, $purchase_header_data);

        $purchase_export_data = $this->report_model->get_purchase_export_projects($projectNo);
        // echo '<pre>'; print_r($purchase_export_data);exit;
        foreach ($purchase_export_data as $key => $value)
		{
            fputcsv($file,$value);                                      
		}

        $production_comp_header_blank = array(""); 
		fputcsv($file, $production_comp_header_blank);
        $prod_comp_header = array("Production Department- Component Activity"); 
		fputcsv($file, $prod_comp_header);
        $prod_comp_data = array("Sr. No","Equipment", "Activity", "Supervisor","QTY","Total Time","Client Approval","Release for Production","Manufacturing Type"); 
		fputcsv($file, $prod_comp_data);

        $prod_comp_export_data = $this->report_model->get_prod_comp_export_projects($projectNo);
        // echo '<pre>'; print_r($prod_comp_export_data);exit;
		foreach ($prod_comp_export_data as $key=>$value)
		{
            $personList = explode(',',$value['supervisor']);   
            $person_name = '';

            if(!empty($personList)){
                foreach($personList as $person){      
                    if($person > 0){
                        $personName = $this->report_model->get_manager_by_id($person);
                        $person_name = $person_name.''.$personName->name.', '; 
                    }else{
                        $person_name = $person_name.' ';
                    }                                                                                   
                }                
                $value['supervisor'] = $person_name;               
                fputcsv($file,$value); 
            }else{
                fputcsv($file,$value); 
            }   
                 
            // Component SUB Activity
                // $prod_sub_comp_header = array(" "," ","Component Sub Activity"); 
                // fputcsv($file, $prod_sub_comp_header);
                $prod_sub_comp_data = array("","","", "Activity", "Employee","Planned Start","Planned Target","Actual Start","Actual End","Start Delay","End Delay","QTY QC Date","QTY QC Remark","TPI QC Date","TPI QC Remark","Client Approval","Release for Production","Manufacturing Type","Total Time"); 
                fputcsv($file, $prod_sub_comp_data);

                $prod_sub_comp_export_data = $this->report_model->get_prod_sub_comp_export_projects($value['activityID'],$projectNo);
                $srno_sub_comp = 0;
                foreach ($prod_sub_comp_export_data as $key1 => $value1)
                {
                    $srno_sub_comp++;
                    $personList = explode(',',$value1['resp_persons']);   
                    $person_name = '';
                    $total_time = $value1['activity_days'].' days '.$value1['activity_time_hours'].' hrs '.$value1['activity_time_minutes'].' min';
                    $value1['activity_days'] = $total_time;
                    $value1['activity_time_hours'] = '';
                    $value1['activity_time_minutes'] = '';
                    $value1['status'] = '';
                    $value1['isDeleted'] = '';
                    $value1['sub_act_order'] = $srno_sub_comp;

                    if(!empty($personList) && $personList != NULL){
                        foreach($personList as $person){
                            if($person > 0){
                                $personName = $this->report_model->get_emp_details($person);
                                $person_name = $person_name.''.$personName->name.', '; 
                            }else{
                                $person_name = $person_name.' ';
                            }                                                                                   
                        }                
                        $value1['resp_persons'] = $person_name;               
                        fputcsv($file,$value1); 
                    }else{
                        fputcsv($file,$value1); 
                    } 
                }
                $prod_sub_comp_header_blank = array(""); 
                fputcsv($file, $prod_sub_comp_header_blank);
		}

        $production_assembly_header_blank = array(""); 
		fputcsv($file, $production_assembly_header_blank);
        $prod_asss_header = array("Production Department- Assembly Activity"); 
		fputcsv($file, $prod_asss_header);
        $prod_ass_data = array("Sr. No","Equipment", "Activity", "Supervisor","QTY","Total Time","Client Approval","Release for Production","Manufacturing Type"); 
		fputcsv($file, $prod_ass_data);

        $prod_assembly_export_data = $this->report_model->get_prod_assembly_export_projects($projectNo);
        // echo '<pre>'; print_r($prod_assembly_export_data);exit;
		foreach($prod_assembly_export_data as $key=>$value)
		{
            $personList = explode(',',$value['supervisor']);   
            $person_name = '';

            if(!empty($personList)){
                foreach($personList as $person){
                    if($person > 0){
                        $personName = $this->report_model->get_manager_by_id($person);
                        $person_name = $person_name.''.$personName->name.', ';  
                    }else{
                        $person_name = '';
                    }                                                                                  
                }                
                $value['supervisor'] = $person_name;               
                fputcsv($file,$value); 
            }else{
                fputcsv($file,$value); 
            }
            // Assembly SUB Activity
                // $prod_sub_comp_header = array(" "," ","Assembly Sub Activity"); 
                // fputcsv($file, $prod_sub_comp_header);
                $prod_sub_assembly_data = array("","","", "Activity", "Employee","Planned Start","Planned Target","Actual Start","Actual End","Start Delay","End Delay","QTY QC Date","QTY QC Remark","TPI QC Date","TPI QC Remark","Client Approval","Release for Production","Manufacturing Type","Total Time"); 
                fputcsv($file, $prod_sub_assembly_data);

                $prod_sub_assembly_export_data = $this->report_model->get_prod_sub_assembly_export_projects($value['activityID'],$projectNo);
                $srno_sub_ass = 0;
                foreach ($prod_sub_assembly_export_data as $key1 => $value2)
                {                                        
                    $srno_sub_ass++;
                    $personList = explode(',',$value2['resp_persons']);   
                    $person_name = '';
                    $total_time = $value2['activity_days'].' days '.$value2['activity_time_hours'].' hrs '.$value2['activity_time_minutes'].' min';
                    $value2['activity_days'] = $total_time;
                    $value2['activity_time_hours'] = '';
                    $value2['activity_time_minutes'] = '';
                    $value2['status'] = '';
                    $value2['isDeleted'] = '';
                    $value2['sub_act_order'] = $srno_sub_ass;

                    if(!empty($personList) && $personList != NULL){
                        foreach($personList as $person){      
                            if($person > 0){
                                $personName = $this->report_model->get_emp_details($person);
                                $person_name = $person_name.''.$personName->name.', '; 
                            }else{
                                $person_name = $person_name.' ';
                            }                                                                                   
                        }
                        $value2['resp_persons'] = $person_name;               
                        fputcsv($file,$value2); 
                    }else{
                        fputcsv($file,$value2); 
                    } 
                }
                $prod_sub_comp_header_blank = array(""); 
                fputcsv($file, $prod_sub_comp_header_blank);                        
		}

		fclose($file);		
		// exit; 
    }
}
?>