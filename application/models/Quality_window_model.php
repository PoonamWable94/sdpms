<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Quality_window_model extends CI_Model
{   
    public function __construct(){
        parent::__construct();
    }

    var $table = 'tg_production_window';         
    var $column_order = array(null,'p3.equipment', 'p.tag_number', 'p1.task','p.quantity','p5.name','p.clientApproval','p.prod_release','p.mfg_type');
    var $column_search = array('p3.equipment', 'p.tag_number', 'p1.task','p.quantity','p5.name','p.clientApproval','p.prod_release','p.mfg_type'); 
    var $order = array('p.activityID' => 'desc');

    var $column_order1 = array(null,'p3.equipment', 'p.tag_number', 'p1.assembly','p.quantity','p5.name','p.clientApproval','p.prod_release','p.mfg_type');
    var $column_search1 = array('p3.equipment', 'p.tag_number', 'p1.assembly','p.quantity','p5.name','p.clientApproval','p.prod_release','p.mfg_type'); 
    var $order1 = array('p.activityID' => 'desc');
 
    private function _get_datatables_query($projectID)
    {          
        $this->db->select('p.activityID, p4.company_name, p3.equipment, p5.name, p1.task as activity, p.projectNo, p.status, p.quantity, p.ind_time, p.total_time, p.projectequipment, p.tag_number,p.clientApproval, p.prod_release, p.mfg_type');
        $this->db->from('tg_production_window as p');
        $this->db->join('tg_production_task as p1','p1.id = p.activity');        
        $this->db->join('tg_equipment as p3','p3.id = p.projectequipment');
        $this->db->join('tg_client as p4','p4.id = p.client');
        $this->db->join('tg_users as p5','p5.userId = p.supervisor');
        $this->db->where('p.isDeleted',1);
        $this->db->where('p.projectID',$projectID);        
        
        $i = 0;
        foreach ($this->column_search as $item) 
        {
            if($_POST['search']['value']) 
            {                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_datatables_query_assembly($projectID)
    {          
        $this->db->select('p.activityID, p4.company_name, p3.equipment, p5.name, p1.assembly as activity, p.projectNo, p.status, p.quantity, p.ind_time, p.total_time, p.projectequipment, p.tag_number,p.clientApproval, p.prod_release, p.mfg_type');
        $this->db->from('tg_production_window_assembly as p');
        $this->db->join('tg_production_assembly as p1','p1.id = p.activity');        
        $this->db->join('tg_equipment as p3','p3.id = p.projectequipment');
        $this->db->join('tg_client as p4','p4.id = p.client');
        $this->db->join('tg_users as p5','p5.userId = p.supervisor');
        $this->db->where('p.isDeleted',1);
        $this->db->where('p.projectID',$projectID);        
        
        $i = 0;
        foreach ($this->column_search1 as $item) 
        {
            if($_POST['search']['value']) 
            {                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order1))
        {
            $order = $this->order1;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables($projectID)
    {
        $this->_get_datatables_query($projectID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_datatables_assembly($projectID)
    {
        $this->_get_datatables_query_assembly($projectID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered($projectID)
    {
        $this->_get_datatables_query($projectID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_filtered_assembly($projectID)
    {
        $this->_get_datatables_query_assembly($projectID);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($projectID)
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
    }

    public function count_all_assembly($projectID){
        $this->db->from('tg_production_window_assembly');
        $this->db->where('isDeleted',1);
        return $this->db->count_all_results();
    }

    public function check_dossier_doc($projectID){             
        $this->db->where('projectID',$projectID);
        $this->db->where('isExists','1');
        $this->db->where('isDeleted','1');
        return $this->db->get('tg_quality_dossier_docs')->num_rows();
    } 

    public function get_dossier_doc_details($projectID)
    {   
        $this->db->select('id, projectID, name_doc_id, name_doc, status, remark');
        $this->db->from('tg_quality_dossier_docs');
        $this->db->where('projectID',$projectID);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_all_dossier_docs()
    {   
        $this->db->select('id, name_doc');
        $this->db->from('tg_name_of_document');
        $this->db->where('status','1');
        $this->db->where('isDeleted','0');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function saveDossierDocs($data)
    {
        $this->db->insert('tg_quality_dossier_docs',$data);
        return $this->db->insert_id();
    }

    public function updateDossierDocs($data, $projectID,$name_doc_id)
    {        
        $this->db->where('projectID', $projectID);
        $this->db->where('name_doc_id', $name_doc_id);
        $this->db->update('tg_quality_dossier_docs', $data);        
        return $this->db->affected_rows();
    }

    public function get_production_activity()
    {
        $this->db->from('tg_production_task');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_production_assembly_activity()
    {
        $this->db->from('tg_production_assembly');
        $this->db->where('status',1);
        $this->db->where('isDeleted',1);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_design_skill()
    {
        $this->db->from('tg_design_skills');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_activity_by_id($id)
    {                  
        $this->db->where('activityID',$id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->row();
    }   

    public function get_assembly_activity_by_id($id)
    {                  
        $this->db->where('activityID',$id);
        $this->db->from('tg_production_window_assembly');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_project_details($projectNo)
    {          
        $this->db->where('id', $projectNo);
        $this->db->from('tg_project_detail');
        $query = $this->db->get();
        return $query->row();
    }
 
    public function saveActivity($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    public function saveAssemblyActvt($data)
    {
        $this->db->insert('tg_production_window_assembly',$data);
        return $this->db->insert_id();
    }

    public function saveAssembly($data)
    {
        $this->db->insert('tg_production_window_assembly',$data);
        return $this->db->insert_id();
    }

    public function saveCompAssembly($data)
    {
        $this->db->insert('tg_production_comp_assembly',$data);
        return $this->db->insert_id();
    }

    public function saveAssemblyActivityList($data)
    {
        $this->db->insert('tg_production_sub_assembly_list',$data);
        return $this->db->insert_id();
    }

    public function saveSubAssemblyActivity($data)
    {
        $this->db->insert('tg_production_sub_assembly_list',$data);
        return $this->db->insert_id();
    }

    public function get_duplicate_assembly($activityID){       
        $this->db->from('tg_production_comp_assembly');
        $where = array('isDeleted'=>'1','status'=>'1','activityId'=>$activityID);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_duplicate_assembly_activity($activityID){       
        $this->db->from('tg_production_sub_assembly_list');
        $where = array('isDeleted'=>'1','status'=>'1','activityId'=>$activityID);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->result();
    }
    
    

    public function updateActivity($data, $activityID)
    {        
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table, $data);        
        return $this->db->affected_rows();
    }

    public function updateAssemblyDataActivity($data, $activityID)
    {        
        $this->db->where('activityID', $activityID);
        $this->db->update('tg_production_sub_assembly_list', $data);        
        return $this->db->affected_rows();
    }

    public function updateAssemblyActvt($data, $activityID)
    {        
        $this->db->where('activityID', $activityID);
        $this->db->update('tg_production_window_assembly', $data);        
        return $this->db->affected_rows();
    }
    
    public function updateAssemblyActivity($data, $assemblyID)
    {        
        $this->db->where('assemblyID', $assemblyID);
        $this->db->update('tg_production_comp_assembly', $data);        
        return $this->db->affected_rows();
    }

    public function update_all_assembly_subactivity($data, $assemblyID)
    {        
        $this->db->where('assemblyID', $assemblyID);
        $this->db->update('tg_production_sub_assembly_list', $data);        
        return $this->db->affected_rows();
    }

    public function updateSubAssemblyActivityData($data, $assemblyID)
    {        
        $this->db->where('assemblyID', $assemblyID);
        $this->db->update('tg_production_sub_assembly_list', $data);        
        return $this->db->affected_rows();
    }

    public function update_row_order($row_order, $activityID)
    {        
        $data = array(
            'row_order' => $row_order
        );
        $this->db->where('activityID', $activityID);
        $this->db->update('tg_production_window', $data);        
        return $this->db->affected_rows();
    }

    public function updateAssemblyActivityOrder($row_order, $activityID)
    {        
        $data = array(
            'row_order' => $row_order
        );
        $this->db->where('activityID', $activityID);
        $this->db->update('tg_production_window_assembly', $data);        
        return $this->db->affected_rows();
    }
    

    public function get_activity_detail_by_id($activityID,$projectequipment){
        $this->db->select('p4.company_name, p.activityID, p.projectNo, p.activity, p.skill1,p.person1, p.manpower1, p.startDate, p.targetDate, p.delayDays,p.taskCompDate,p.prod_release, p.status , p1.activity_data AS activity, p2.skills,p.projectequipment,p3.equipment,p.tag_number,p.clientApproval');
        $this->db->from('tg_production_window as p');
        $this->db->join('tg_activity_data as p1','p1.id = p.activity');
        $this->db->join('tg_design_skills as p2','p2.id = p.skill1');
        $this->db->join('tg_equipment as p3','p3.id = p.projectequipment');
        $this->db->join('tg_client as p4','p4.id = p.client');

        $where = array('p.isDeleted'=>'1', 'p.activityID'=>$activityID, 'p.projectequipment'=>$projectequipment);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->row();
    }
     
    public function delete_by_id($activityID)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table,$data);
        return 1;
    }

    public function delete_main_assembly_by_id($activityID)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('activityID', $activityID);
        // $this->db->set($data);
        $this->db->update('tg_production_window_assembly',$data);
        return 1;
    }

    public function delete_assembly_by_id($activityID,$projectID,$projectequipment)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $where = array('activityID'=>$activityID,'projectID'=>$projectID,'projectequipment'=>$projectequipment);
        $this->db->where($where);
        
        $this->db->update('tg_production_comp_assembly',$data);
        return 1;
    }

    public function delete_sub_assembly_by_id($activityID,$projectID,$projectequipment)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $where = array('activityID'=>$activityID,'projectID'=>$projectID,'projectequipment'=>$projectequipment);
        $this->db->where($where);
        // $this->db->set($data);
        $this->db->update('tg_production_sub_assembly_list',$data);
        return 1;
    }

    public function delete_persons_curr_activity($activityID,$projectID,$projectequipment)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $where = array('activityId'=>$activityID,'projectID'=>$projectID,'projectequipment'=>$projectequipment);
        $this->db->where($where);
        $this->db->update('tg_production_person_activities',$data);
        return 1;
    }

    public function delete_one_assembly_by_id($assemblyID)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('assemblyID', $assemblyID);
        $this->db->update('tg_production_comp_assembly',$data);
        return 1;
    }

    public function delete_one_sub_assembly_by_id($assemblyID)
    {
        $data = array( 
            'isDeleted' => 0
        );
        $this->db->where('assemblyID', $assemblyID);
        $this->db->update('tg_production_sub_assembly_list',$data);
        return 1;
    }

    public function update_status($activityID,$status)
    {
        $data['status'] = $status;
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table, $data);
    } 

    public function update_client_approval($activityID,$clientApproval)
    {
        $data['clientApproval'] = $clientApproval;
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table, $data);
    } 

    public function update_prod_release($activityID,$prod_release)
    {
        $data['prod_release'] = $prod_release;
        $this->db->where('activityID', $activityID);
        $this->db->update($this->table, $data);
    } 

    public function getActivityDetails($projectID){
        $this->db->select('p3.company_name, design.projectNo, p4.equipment, design.tag_number, p1.activity_data AS activity, p2.skills AS skill1, design.person1, design.manpower1, design.startDate, design.targetDate,  design.completionDate, design.releaseDate, design.clientApproval, design.revisionNo, design.delay, design.reason');
        // $this->db->from('tg_production_window as design');
        $this->db->join('tg_activity_data as p1','p1.id = design.activity');
        $this->db->join('tg_design_skills as p2','p2.id = design.skill1');
        $this->db->join('tg_client as p3','p3.id = design.client');
        $this->db->join('tg_equipment as p4','p4.id = design.projectequipment');

        $this->db->where('design.isDeleted', '1');
        $this->db->where('design.status', '1');
        $this->db->where('design.projectID', $projectID);
        $query = $this->db->get('tg_production_window as design');
        return $query->result_array();
		// $query = $this->db->get();
        // return $query->result();
    }
    public function get_equipment_name($id)
    {   
        $this->db->select('equipment');
        $this->db->from('tg_equipment');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_main_activity_name($id)
    {   
        $this->db->select('task');
        $this->db->from('tg_production_task');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_main_assembly_activity_name($id)
    {   
        $this->db->select('assembly');
        $this->db->from('tg_production_assembly');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }


    public function get_client_name($projectID)
    {   
        $this->db->select('tg_client.id, tg_client.company_name');        
        $this->db->join('tg_client','tg_client.id=tg_project_detail.client');                
        $this->db->where('tg_project_detail.id',$projectID);
        $this->db->from('tg_project_detail');

        $query = $this->db->get();
        return $query->row();
    }   
    
    public function get_equipment_tag_no($projectequipment, $projectID){
        $this->db->select('projectID,equipment,tag_number,equipment_name');
        $this->db->from('tg_project_equipment');
        $this->db->where('projectID',$projectID);
        $this->db->where('equipment',$projectequipment);
        $this->db->where('status','1');
        $this->db->where('isDeleted','1');
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_skill_name($id)
    {   
        $this->db->select('id,skills');
        $this->db->from('tg_design_skills');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_Project_no_by_pid($projectID)
    {   
        $this->db->select('project_no');
        $this->db->from('tg_project_detail');
        $this->db->where('id',$projectID);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_skills_name($id)
    {   
        $this->db->select('skills');
        $this->db->from('tg_design_skills');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_person_user_name($userId)
    {   
        $this->db->select('name');
        $this->db->from('tg_users');
        $this->db->where('userId',$userId);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_employee_names($userId)
    {   
        $this->db->select('name');
        $this->db->from('tg_production_emp');
        $this->db->where('userId',$userId);
        $query = $this->db->get();
        return $query->row();
    }

    public function getProductionActivityData($projectID,$projectequipment,$client_id){
        $this->db->select('p.activityID, p.activity, p.projectID, p.projectequipment, p1.id as taskID, p1.task, p.row_order, p.supervisor, p.quantity, p.ind_time, p.total_time, p.clientApproval, p.prod_release, p.mfg_type, p.total_time_hidden, p.ind_time_hidden');        
        $this->db->from('tg_production_window as p');
        $this->db->join('tg_production_task as p1','p1.id = p.activity');                  
        $where = array('p.isDeleted'=>'1','p.status'=>'1','p.projectID'=>$projectID,'p.projectequipment'=>$projectequipment,'p.client'=>$client_id);
        $this->db->where($where);         
        $this->db->order_by('p.row_order','ASC');          
        $query = $this->db->get();
        return $query->result();
    } 

    public function getProductionAssemblyActivityData($projectID,$projectequipment,$client_id){
        $this->db->select('p.activityID, p.activity, p.projectID, p.projectequipment, p1.id as subassemblyID, p1.assembly, p.row_order, p.supervisor, p.quantity, p.ind_time, p.total_time, p.clientApproval, p.prod_release, p.mfg_type, p.total_time_hidden, p.ind_time_hidden');        
        $this->db->from('tg_production_window_assembly as p');
        $this->db->join('tg_production_assembly as p1','p1.id = p.activity');                  
        $where = array('p.isDeleted'=>'1','p.status'=>'1','p.projectID'=>$projectID,'p.projectequipment'=>$projectequipment,'p.client'=>$client_id);
        $this->db->where($where);         
        $this->db->order_by('p.row_order','ASC');          
        $query = $this->db->get();
        return $query->result();
    } 
    
    public function get_component_assembly_data($project_id, $project_equipment_id, $activity_id, $component_id){
        $this->db->select('p2.task_data, p1.assemblyID, p1.skill, p1.activity_days, p1.activity_time_hours, p1.activity_time_minutes, p1.total_time,p1.total_time_save, p1.startDate, p1.targetDate, p1.manpower, p1.resp_persons, p1.quality_qc_date, p1.quality_qc_remark, p1.tpi_qc_date, p1.tpi_qc_remark,p1.clientApproval, p1.prod_release, p1.mfg_type, p1.is_all_updated, p1.activity, p1.sub_activity, p1.sub_act_order');        
        $this->db->from('tg_production_window as p');
        $this->db->join('tg_production_comp_assembly as p1','p1.activityID = p.activityID');
        $this->db->join('tg_production_task_data as p2','p2.id = p1.sub_activity');                       
        
        $where = array('p.isDeleted'=>'1','p.status'=>'1','p1.projectID'=>$project_id,'p1.projectequipment'=>$project_equipment_id,'p1.activityID'=>$activity_id, 'p1.activity'=>$component_id, 'p1.isDeleted'=>'1','p1.status'=>'1');
        $this->db->where($where);         
        $this->db->order_by('p1.assemblyID','DESC');                      
        $query = $this->db->get();
        return $query->result();
    }

    public function get_sub_assembly_activity_data($project_id, $project_equipment_id, $activity_id, $component_id){
        $this->db->select('p2.assembly_activity, p1.assemblyID, p1.skill, p1.activity_days, p1.activity_time_hours, p1.activity_time_minutes, p1.total_time,p1.total_time_save, p1.startDate, p1.targetDate, p1.manpower, p1.resp_persons, p1.quality_qc_date, p1.quality_qc_remark, p1.tpi_qc_date, p1.tpi_qc_remark,p1.clientApproval, p1.prod_release, p1.mfg_type, p1.is_all_updated, p1.activity, p1.sub_activity, p1.sub_act_order');        
        $this->db->from('tg_production_window_assembly as p');
        $this->db->join('tg_production_sub_assembly_list as p1','p1.activityID = p.activityID');
        $this->db->join('tg_production_sub_assembly as p2','p2.id = p1.sub_activity');                       
        
        $where = array('p.isDeleted'=>'1','p.status'=>'1','p1.projectID'=>$project_id,'p1.projectequipment'=>$project_equipment_id,'p1.activityID'=>$activity_id, 'p1.activity'=>$component_id, 'p1.isDeleted'=>'1','p1.status'=>'1');
        $this->db->where($where);         
        $this->db->order_by('p1.assemblyID','DESC');                      
        $query = $this->db->get();
        return $query->result();
    }

    public function get_production_sub_activity($activityID)
    {   
        $this->db->from('tg_production_task_data');
        $where = array('isDeleted'=>'0','status'=>'1','task'=>$activityID);
        $this->db->where($where); 
        $this->db->order_by('id','DESC');         
        $query = $this->db->get();
        return $query->result();
    }

    public function get_production_sub_assembly($activityID)
    {   
        $this->db->from('tg_production_sub_assembly');
        $where = array('isDeleted'=>'1','status'=>'1','assembly_id'=>$activityID);
        $this->db->where($where); 
        $this->db->order_by('id','DESC');         
        $query = $this->db->get();
        return $query->result();
    }

    public function get_production_sub_activity_skills($taskID,$activityID){
        $this->db->from('tg_production_skills');
        $where = array('isDeleted'=>'0','status'=>'1','task'=>$taskID,'activityId'=>$activityID);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_production_sub_assemly_skills($assembly,$activityID){
        $this->db->from('tg_production_assembly_skills');
        $where = array('isDeleted'=>'0','status'=>'1','assembly'=>$assembly,'activityId'=>$activityID);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_production_activity_wise_skill($activityID,$sub_activity_id)
    {           
        $select =   array(
            'p3.name', 'p1.userId', 'count(p1.skillId) as totalSkills','p1.skill'
        ); 
        $this->db->SELECT($select);
        $this->db->from('tg_user_skills AS p1');
        $this->db->join('tg_production_skills as p2','p2.skill_master_id = p1.skillId');
        $this->db->join('tg_users as p3','p3.userId = p1.userId');
        $where = array('p3.dept_id'=>'4','p2.task'=>$activityID, 'p2.activityId'=>$sub_activity_id, 'p1.status'=>'1', 'p1.isDeleted'=>'1', 'p2.status'=>'1', 'p2.isDeleted'=>'0', 'p3.status'=>'1', 'p3.isDeleted'=>'0');
        $this->db->where($where);
        $this->db->group_by('p1.userId');   
        $query = $this->db->get();
        return $query->result();     
    }

    public function get_production_skill_employee($activityID,$sub_activity_id)
    {           
        $select =   array(
            'p3.name', 'p1.userId', 'count(p1.skillId) as totalSkills','p1.skill'
        ); 
        $this->db->SELECT($select);
        $this->db->from('tg_production_emp_skills AS p1');
        $this->db->join('tg_production_skills as p2','p2.skill_master_id = p1.skillId');
        $this->db->join('tg_production_emp as p3','p3.userId = p1.userId');
        $where = array('p2.task'=>$activityID, 'p2.activityId'=>$sub_activity_id, 'p1.status'=>'1', 'p1.isDeleted'=>'1', 'p2.status'=>'1', 'p2.isDeleted'=>'0', 'p3.status'=>'1', 'p3.isDeleted'=>'0');
        $this->db->where($where);
        $this->db->group_by('p1.userId');   
        $query = $this->db->get();
        return $query->result();     
    }

    public function get_production_dept_supervisors() // team leader and engineers
    {                   
        $this->db->SELECT('userId, uname, name');
        $this->db->from('tg_users');        
        $where = array('dept_id'=>'4','status'=>'1','isDeleted'=>'0');
        $this->db->where($where)->where("(roleId='4' OR roleId='5')");
        $query = $this->db->get();
        return $query->result();     
    }

    public function get_production_dept_supervisors_persons() // only team leader
    {                   
        $this->db->SELECT('userId, uname, name');
        $this->db->from('tg_users');        
        $where = array('dept_id'=>'4','status'=>'1','isDeleted'=>'0');
        $this->db->where($where)->where("(roleId='4' OR roleId='5')");
        $query = $this->db->get();
        return $query->result();     
    }

    public function saveDesignActivityPersons($data)
    {
        $this->db->insert('tg_production_person_activities');
        return $this->db->insert_id();
    }

    public function get_person_name($userId)
    {   
        $this->db->select('name');
        $this->db->from('tg_users');
        $this->db->where('userId',$userId);
        $query = $this->db->get(); 
        return $query->row();
    }

    public function get_design_activity_time($activityID)
    {   
        $this->db->select('activity_days, activity_time');
        $this->db->from('tg_activity_data');
        $where = array('isDeleted'=>'0','status'=>'1','id'=>$activityID);
        $this->db->where($where);        
        $query = $this->db->get();
        return $query->row();
    }

    public function beforeEditPeronsActivitySkills($assembly_id, $projectID, $projectequipment){
        $where = array('assembly_id'=>$assembly_id,'projectID'=>$projectID,'projectequipment'=>$projectequipment);
        $this->db->where($where);
        $this->db->delete('tg_production_person_activities');
    }

    public function get_activity_skills_count($activity){             
        $this->db->where('design_activity',$activity);
        return $this->db->get('tg_design_skills')->num_rows();
    } 

    public function get_activity_details($id)
    {   
        $this->db->select('activity_data');
        $this->db->from('tg_activity_data');
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function check_person_activity_entry($personData){        
        $this->db->where($personData);
        return $this->db->get('tg_design_person_activities')->num_rows();        
    }

    public function get_project_info($projectID){
        $this->db->select('p1.project_no, p2.company_name');
        $this->db->from('tg_project_detail as p1');       
        $this->db->join('tg_client as p2','p2.id = p1.client');                
        $this->db->where('p1.id',$projectID);   
        $query = $this->db->get();
        return $query->row();     
    }

    public function get_all_assembly_time($projectID, $projectequipment,$activity_id,$main_activity_id){
        $select = array(
            'SUM(activity_days) as days','SUM(activity_time_hours) as hours', 'SUM(activity_time_minutes) as minutes'
        );
        $this->db->select($select);
        $this->db->from('tg_production_comp_assembly');       
        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id, 'status'=>'1', 'isDeleted'=> '1');        
        $this->db->where($where);   
        $query = $this->db->get();
        return $query->row();   
    }

    public function get_all_assembly_data_time($projectID, $projectequipment,$activity_id,$main_activity_id){
        $select = array(
            'SUM(activity_days) as days','SUM(activity_time_hours) as hours', 'SUM(activity_time_minutes) as minutes'
        );
        $this->db->select($select);
        $this->db->from('tg_production_sub_assembly_list');       
        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id, 'status'=>'1', 'isDeleted'=> '1');        
        $this->db->where($where);   
        $query = $this->db->get();
        return $query->row();   
    }

    public function update_component_inv_time($projectID, $projectequipment,$activity_id,$main_activity_id,$final_time,$final_time_formated){

        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id);        
        $data = array(
            // 'ind_time_hidden'   => $total_time,
            // 'ind_time'          => $toal_time_formated,
            'total_time'        => $final_time_formated,
            'total_time_hidden' => $final_time
        );
        $this->db->where($where);
        $this->db->update('tg_production_window', $data);        
        return $this->db->affected_rows();
    }

    public function update_assembly_inv_time($projectID, $projectequipment,$activity_id,$main_activity_id,$final_time,$final_time_formated){

        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id);        
        $data = array(
            // 'ind_time_hidden'   => $total_time,
            // 'ind_time'          => $toal_time_formated,
            'total_time'        => $final_time_formated,
            'total_time_hidden' => $final_time
        );
        $this->db->where($where);
        $this->db->update('tg_production_window_assembly', $data);        
        return $this->db->affected_rows();
    }

    public function get_all_component_qty($projectID, $projectequipment,$activity_id,$main_activity_id){       
        $this->db->select('quantity');
        $this->db->from('tg_production_window');       
        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id);        
        $this->db->where($where);   
        $query = $this->db->get();
        return $query->row(); 
    }

    public function get_sub_activity_details_by_order($projectID, $projectequipment,$activity_id,$main_activity_id,$i){
        $this->db->select('assemblyID, activity_days, activity_time_hours, activity_time_minutes, startDate, targetDate');
        $this->db->from('tg_production_comp_assembly');       
        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id, 'sub_act_order'=>$i, 'isDeleted'=> 1, 'status'=> 1);        
        $this->db->where($where);   
        $query = $this->db->get();
        return $query->row(); 
    }

    public function get_sub_assembly_details_by_order($projectID, $projectequipment,$activity_id,$main_activity_id,$i){
        $this->db->select('assemblyID, activity_days, activity_time_hours, activity_time_minutes, startDate, targetDate');
        $this->db->from('tg_production_sub_assembly_list');       
        $where = array('projectID'=>$projectID, 'projectequipment'=>$projectequipment, 'activityID'=>$activity_id, 'activity'=>$main_activity_id, 'sub_act_order'=>$i, 'isDeleted'=> 1, 'status'=> 1);        
        $this->db->where($where);   
        $query = $this->db->get();
        return $query->row(); 
    }

    public function update_sub_activity_start_target_date($startDate, $new_target_date_time,$assemblyID){
        $data = array(            
            'startDate'  => $startDate,
            'targetDate' => $new_target_date_time,
        );
        $this->db->where('assemblyID',$assemblyID);
        $this->db->update('tg_production_comp_assembly', $data);        
        return $this->db->affected_rows();
    }

    public function update_sub_assembly_start_target_date($startDate, $new_target_date_time,$assemblyID){
        $data = array(            
            'startDate'  => $startDate,
            'targetDate' => $new_target_date_time,
        );
        $this->db->where('assemblyID',$assemblyID);
        $this->db->update('tg_production_sub_assembly_list', $data);        
        return $this->db->affected_rows();
    }
}