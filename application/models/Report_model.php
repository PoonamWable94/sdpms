<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model
{   
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    var $table = 'tg_project_detail';     
    
    var $column_order = array('p2.company_name', 'p1.project_no', 'p1.equipment', 'p1.tag_number', 'p1.equip_qty', 'p1.po_number', 'p1.po_date_time', 'p1.del_date', 'p1.proj_comp_date','p1.act_desp_date', 'p1.isCompleted', 'p3.name', 'p1.status'); 
    var $column_search = array('p2.company_name', 'p1.project_no', 'p1.equipment', 'p1.tag_number', 'p1.equip_qty', 'p1.po_number', 'p1.po_date_time', 'p1.del_date', 'p1.proj_comp_date','p1.act_desp_date', 'p1.isCompleted','p3.name', 'p1.status'); 
    var $order = array('p1.project_no' => 'ASC');    
 
    private function _get_datatables_query()
    {           
        $this->db->select('p2.company_name, p1.id,p1.project_no,p1.project_year, p3.name, p1.po_date_time, p1.po_number, p1.del_date, p1.proj_comp_date,p1.act_desp_date,p1.isCompleted, p1.tag_number, p1.equip_qty, p1.description,p1.status,p1.createdDtm, p1.designProjectStartDate, p1.designActualStartDate, p1.designProjectEndDate, p1.designActualEndDate, p1.purchaseProjectStartDate, p1.purchaseActualStartDate, p1.purchaseProjectEndDate, p1.purchaseActualEndDate, p1.productionProjectStartDate, p1.productionActualStartDate, p1.productionProjectEndDate, p1.productionActualEndDate');
        $this->db->from('tg_project_detail as p1');
        $this->db->join('tg_client as p2','p2.id = p1.client'); 
        $this->db->join('tg_users as p3','p3.userId = p1.manager_name');
        $this->db->where('p1.isDeleted',0);  
        $this->db->where('p1.isCompleted',1);                  
               
        $i = 0;    
        
        if($this->input->post('project_year') > 0)
        {
            $this->db->where("p1.project_year", $this->input->post('project_year'));
        }

        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
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
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',0);
        return $this->db->count_all_results();
    }
    public function get_Equipment_tag_by_id($projectID)
    {   
        $this->db->from('tg_project_equipment');
        $this->db->where('status',1);
        $this->db->where('isDeleted',1);
        $this->db->where('projectID',$projectID);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_manager_by_id($id)
    {   
        $this->db->select('name');
        $this->db->from('tg_users');
        $this->db->where('userId',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_all_projects()
    {
        $this->db->select('id,project_no');
        $this->db->from('tg_project_detail');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $this->db->where('isCompleted',1);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_design_projects($projectNo)
    {
        $this->db->select('p3.activityID, p1.project_no, p2.equipment_name, p4.activity_data, p3.startDate, p3.targetDate, p3.actual_start_date, p3.taskCompDate, p3.delayDays');
        $this->db->from('tg_project_detail AS p1');
        $this->db->join('tg_project_equipment as p2','p2.projectID = p1.id');
        $this->db->join('tg_design_window as p3','p3.projectequipment = p2.equipment');
        $this->db->join('tg_activity_data as p4','p4.id = p3.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p2.status',1);
        $this->db->where('p2.isDeleted',1);
        $this->db->where('p1.id',$projectNo);
        $this->db->where('p2.projectID',$projectNo);
        $this->db->where('p3.projectID',$projectNo);
        $this->db->order_by('p3.activityID','ASC');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_production_component_projects($projectNo)
    {
        $this->db->select('p3.activityID, p1.project_no, p2.equipment_name, p4.task,p3.total_time');
        $this->db->from('tg_project_detail AS p1');
        $this->db->join('tg_project_equipment as p2','p2.projectID = p1.id');
        $this->db->join('tg_production_window as p3','p3.projectequipment = p2.equipment');
        $this->db->join('tg_production_task as p4','p4.id = p3.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p2.status',1);
        $this->db->where('p2.isDeleted',1);
        $this->db->where('p1.id',$projectNo);
        $this->db->where('p2.projectID',$projectNo);
        $this->db->where('p3.projectID',$projectNo);
        $this->db->order_by('p3.activityID','ASC');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_production_assembly_projects($projectNo)
    {
        $this->db->select('p3.activityID, p1.project_no, p2.equipment_name, p4.assembly,p3.total_time');
        $this->db->from('tg_project_detail AS p1');
        $this->db->join('tg_project_equipment as p2','p2.projectID = p1.id');
        $this->db->join('tg_production_window_assembly as p3','p3.projectequipment = p2.equipment');
        $this->db->join('tg_production_assembly as p4','p4.id = p3.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p2.status',1);
        $this->db->where('p2.isDeleted',1);
        $this->db->where('p1.id',$projectNo);
        $this->db->where('p2.projectID',$projectNo);
        $this->db->where('p3.projectID',$projectNo);
        $this->db->order_by('p3.activityID','ASC');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_purchase_projects($projectNo)
    {
        $this->db->select('p3.id, p1.project_no, p2.equipment_name, p3.createdOn');
        $this->db->from('tg_project_detail AS p1');
        $this->db->join('tg_project_equipment as p2','p2.projectID = p1.id');
        $this->db->join('tg_purchase_window as p3','p3.projectequipment = p2.equipment');        
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p2.status',1);
        $this->db->where('p2.isDeleted',1);
        $this->db->where('p1.id',$projectNo);
        $this->db->where('p2.projectID',$projectNo);
        $this->db->where('p3.projectID',$projectNo);
        $this->db->order_by('p3.id','ASC');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function getPurchaseProjectDetails($projectNo)
    {
        $this->db->select('p3.id, p2.equipment_name, p3.createdOn');
        $this->db->from('tg_project_detail AS p1');
        $this->db->join('tg_project_equipment as p2','p2.projectID = p1.id');
        $this->db->join('tg_purchase_window as p3','p3.projectequipment = p2.equipment');        
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p2.status',1);
        $this->db->where('p2.isDeleted',1);
        $this->db->where('p1.id',$projectNo);
        $this->db->where('p2.projectID',$projectNo);
        $this->db->where('p3.projectID',$projectNo);
        $this->db->order_by('p3.id','ASC');
        $query = $this->db->get();
 
        return $query->result_array();
    }

    //for project export
    public function getProjectDetails($project_year){
        $this->db->select('p1.id, p1.project_no, p2.company_name, p3.name as manager, p1.equipment, p1.tag_number, p1.equip_qty, p1.po_date_time, p1.po_number, p1.del_date, p1.proj_comp_date, p1.act_desp_date, p1.isCompleted, p1.designProjectStartDate, p1.designActualStartDate, p1.designProjectEndDate, p1.designActualEndDate, p1.purchaseProjectStartDate, p1.purchaseActualStartDate, p1.purchaseProjectEndDate, p1.purchaseActualEndDate, p1.productionProjectStartDate, p1.productionActualStartDate, p1.productionProjectEndDate, p1.productionActualEndDate');
        $this->db->from('tg_project_detail as p1');
        $this->db->join('tg_client as p2','p2.id = p1.client'); 
        $this->db->join('tg_users as p3','p3.userId = p1.manager_name'); 
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p1.isCompleted',1);
        if($project_year > 0){
            $this->db->where('p1.project_year',$project_year);
        }
        $this->db->order_by('p1.id ASC'); 
        $query = $this->db->get();
 
        return $query->result_array();
    }

    // for dept wise progress report
    public function getDesignProjectDetails($projectNo){        
        $this->db->select('p2.equipment_name, p4.activity_data, p3.startDate, p3.targetDate, p3.actual_start_date, p3.taskCompDate, p3.delayDays');
        $this->db->from('tg_project_detail AS p1');
        $this->db->join('tg_project_equipment as p2','p2.projectID = p1.id');
        $this->db->join('tg_design_window as p3','p3.projectequipment = p2.equipment');
        $this->db->join('tg_activity_data as p4','p4.id = p3.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',0);
        $this->db->where('p2.status',1);
        $this->db->where('p2.isDeleted',1);
        $this->db->where('p1.id',$projectNo);
        $this->db->where('p2.projectID',$projectNo);
        $this->db->where('p3.projectID',$projectNo);
        $this->db->order_by('p3.activityID','ASC');
        $query = $this->db->get();
 
        return $query->result_array();
    
    }

    public function get_project_equipment_name($equipmentId,$projectId)
    {   
        $this->db->select('equipment_name,equip_qty,tag_number');
        $this->db->from('tg_project_equipment');
        $this->db->where('projectID',$projectId);
        $this->db->where('equipment',$equipmentId);        
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_design_export_projects($projectNo){
        $this->db->select('p1.activityID,p1.row_order, p1.level,p2.equipment, p3.activity_data,p1.person1, p1.startDate,p1.targetDate, p1.actual_start_date,p1.taskCompDate, p1.delayDays, p1.clientApproval, p1.prod_release');
        $this->db->from('tg_design_window AS p1');
        $this->db->join('tg_equipment as p2','p2.id = p1.projectequipment');        
        $this->db->join('tg_activity_data as p3','p3.id = p1.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',1);       
        $this->db->where('p1.projectID',$projectNo);       
        $this->db->order_by('p1.activityID','ASC');
        $query = $this->db->get();
 
        return $query->result_array();
    }

    public function get_purchase_export_projects($projectNo){
        $this->db->select('p1.id, p2.equipment, p1.fileName, p1.createdOn');
        $this->db->from('tg_purchase_window AS p1');
        $this->db->join('tg_equipment as p2','p2.id = p1.projectequipment');                
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',1);       
        $this->db->where('p1.projectID',$projectNo);       
        $this->db->order_by('p1.id','ASC');
        $query = $this->db->get();
 
        return $query->result_array();
    }

    public function get_prod_comp_export_projects($projectNo){
        $this->db->select('p1.activityID,p2.equipment,p3.task,p1.supervisor, p1.quantity, p1.total_time, p1.clientApproval, p1.prod_release, p1.mfg_type');
        $this->db->from('tg_production_window AS p1');
        $this->db->join('tg_equipment as p2','p2.id = p1.projectequipment');        
        $this->db->join('tg_production_task as p3','p3.id = p1.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',1);       
        $this->db->where('p1.projectID',$projectNo);
        $this->db->order_by('p1.row_order','ASC');
        $query = $this->db->get();
 
        return $query->result_array();
    }

    public function get_prod_assembly_export_projects($projectNo){
        $this->db->select('p1.activityID,p2.equipment,p3.assembly,p1.supervisor, p1.quantity, p1.total_time, p1.clientApproval, p1.prod_release, p1.mfg_type');
        $this->db->from('tg_production_window_assembly AS p1');
        $this->db->join('tg_equipment as p2','p2.id = p1.projectequipment');        
        $this->db->join('tg_production_assembly as p3','p3.id = p1.activity');
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',1);       
        $this->db->where('p1.projectID',$projectNo);
        $this->db->order_by('p1.activityID','ASC');
        $query = $this->db->get();
 
        return $query->result_array();
    }

    public function get_prod_sub_comp_export_projects($activityID,$projectID){
        $this->db->select('p1.status, p1.isDeleted,p1.sub_act_order, p2.task_data,p1.resp_persons,p1.startDate,p1.targetDate,p1.actual_start_date,p1.actual_end_date, p1.startDelay, p1.endDelay, p1.quality_qc_date,p1.quality_qc_remark,p1.tpi_qc_date,p1.tpi_qc_remark,p1.clientApproval,p1.prod_release,p1.mfg_type, p1.activity_days,p1.activity_time_hours,p1.activity_time_minutes');
        $this->db->from('tg_production_comp_assembly AS p1');
        $this->db->join('tg_production_task_data as p2','p2.id = p1.sub_activity');                
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',1);       
        $this->db->where('p1.activityID',$activityID);
        $this->db->where('p1.projectID',$projectID);
        $this->db->order_by('p1.assemblyID','DESC');
        $query = $this->db->get();
 
        return $query->result_array();
    }

    public function get_emp_details($userId)
    {   
        $this->db->select('name');
        $this->db->from('tg_production_emp');
        $this->db->where('userId',$userId);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_prod_sub_assembly_export_projects($activityID,$projectID){
        $this->db->select('p1.status, p1.isDeleted,p1.sub_act_order, p2.assembly_activity,p1.resp_persons,p1.startDate,p1.targetDate,p1.actual_start_date,p1.actual_end_date,p1.startDelay,p1.endDelay, p1.quality_qc_date,p1.quality_qc_remark,p1.tpi_qc_date,p1.tpi_qc_remark,p1.clientApproval,p1.prod_release,p1.mfg_type, p1.activity_days,p1.activity_time_hours,p1.activity_time_minutes');
        $this->db->from('tg_production_sub_assembly_list AS p1');
        $this->db->join('tg_production_sub_assembly as p2','p2.id = p1.sub_activity');                
        $this->db->where('p1.status',1);
        $this->db->where('p1.isDeleted',1);       
        $this->db->where('p1.activityID',$activityID);
        $this->db->where('p1.projectID',$projectID);
        $this->db->order_by('p1.assemblyID','DESC');
        $query = $this->db->get();
 
        return $query->result_array();
    }
}
?>