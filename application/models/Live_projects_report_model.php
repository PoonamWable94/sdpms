<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Live_projects_report_model extends CI_Model
{   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLiveProjects(){

        $where = array('p1.isCompleted'=>'0', 'p1.status'=>'1', 'p1.isDeleted'=>'0');
        $this->db->select('p1.id, p1.project_no, p1.tag_number, p1.del_date, p1.po_date_time, p2.company_name, p3.equipment, p3.id as projectequipmentId');
        $this->db->from('tg_project_detail as p1');
        $this->db->join('tg_client as p2','p2.id = p1.client');
        $this->db->join('tg_equipment as p3','FIND_IN_SET(p3.id, p1.equipment)','RIGHT');
        $this->db->where($where);      
        $this->db->order_by('p1.project_no asc');
        $query = $this->db->get();
 
        return $query->result();
    }

    public function getDesignProjectEqpStartDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.startDate, p1.targetDate, p1.row_order');
        $this->db->from('tg_design_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.row_order asc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getActualDesignProjectEqpStartDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.actual_start_date, p1.taskCompDate, p1.row_order');
        $this->db->from('tg_design_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.row_order asc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getDesignProjectEqpTargetDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.startDate, p1.targetDate, p1.row_order');
        $this->db->from('tg_design_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.row_order desc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getActualDesignProjectEqpTargetDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.actual_start_date, p1.taskCompDate, p1.row_order');
        $this->db->from('tg_design_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.row_order desc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getPurchaseProjectEqpStartDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.po_release_date, p1.exp_material_rec_date, p1.sort_order');
        $this->db->from('tg_purchase_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.sort_order asc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getActualPurchaseProjectEqpStartDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.actual_po_date, p1.actual_material_rec_date, p1.sort_order');
        $this->db->from('tg_purchase_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.sort_order asc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getPurchaseProjectEqpTargetDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.po_release_date, p1.exp_material_rec_date, p1.sort_order');
        $this->db->from('tg_purchase_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.sort_order desc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getActualPurchaseProjectEqpTargetDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.actual_po_date, p1.actual_material_rec_date, p1.sort_order');
        $this->db->from('tg_purchase_window as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.sort_order desc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getproductionProjectEqpStartDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.startDate, p1.targetDate, p1.assemblyID');
        $this->db->from('tg_production_comp_assembly as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.assemblyID asc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getActualproductionProjectEqpStartDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.startDate, p1.targetDate, p1.assemblyID');
        $this->db->from('tg_production_comp_assembly as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.assemblyID asc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getProductionProjectEqpTargetDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.startDate, p1.targetDate, p1.assemblyID');
        $this->db->from('tg_production_comp_assembly as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.assemblyID desc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getActualProductionProjectEqpTargetDate($projectID,$projectequipment){
        $where = array('p1.projectID'=>$projectID, 'p1.projectequipment'=>$projectequipment);
        $this->db->select('p1.startDate, p1.targetDate, p1.assemblyID');
        $this->db->from('tg_production_comp_assembly as p1');       
        $this->db->where($where);      
        $this->db->order_by('p1.assemblyID desc');
        $this->db->limit(1);
        $query = $this->db->get();
 
        return $query->row();
    }

}


?>