<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Activity_notification_log_model extends CI_Model
{   
    var $table = 'tg_activity_notification_log';     
    
    var $column_order = array(''); 
    var $column_search = array('');  
    var $order = array('id' => 'DESC'); 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function _get_datatables_query() {
        $this->db->select('
            p.*, 

            p2.projectNo as projectNo_add, 
            p3.activity_data as noti_name_add,

            p4.projectNo as projectNo_update, 
            p5.activity_data as noti_name_update,



            p6.projectNo as projectNo_pac, 
            p7.task as noti_name_pac,

            p10.projectNo as projectNo_puc, 
            p11.task_data as noti_name_puc,
            


            p8.projectNo as projectNo_aas, 
            p9.assembly as noti_name_aas,

            p12.projectNo as projectNo_uas, 
            p13.assembly_activity as noti_name_uas,


            p14.project_no as new_projectNo, 


            p15.projectNo as projectNo_ub, 
            p15.description as noti_name_ub,

        ');
        $this->db->from('tg_activity_notification_log as p');
            

        


        // Design activity add
        $this->db->join('tg_design_window as p2', 'p2.activityID = p.design_window_aa_id', 'left');
        $this->db->join('tg_activity_data as p3', 'p3.id = p2.activity', 'left');
    
        // Design activity update
        $this->db->join('tg_design_window as p4', 'p4.activityID = p.design_window_au_id', 'left');
        $this->db->join('tg_activity_data as p5', 'p5.id = p4.activity', 'left');



        // Production activity add component
        $this->db->join('tg_production_window as p6', 'p6.activityID = p.production_window_ac_id', 'left');
        $this->db->join('tg_production_task as p7', 'p7.id = p6.activity', 'left');

        // Production compnent sub activity update 
        $this->db->join('tg_production_comp_assembly as p10', 'p10.assemblyID = p.production_comp_assembly_ua_id', 'left');
        $this->db->join('tg_production_task_data as p11', 'p11.id = p10.activity', 'left');



        // Production activity add assembl
        $this->db->join('tg_production_window_assembly as p8', 'p8.activityID = p.production_window_assembly_aas_id', 'left');
        $this->db->join('tg_production_assembly as p9', 'p9.id = p8.activity', 'left');
    
        // Production assembl sub activity update activity
        $this->db->join('tg_production_sub_assembly_list as p12', 'p12.assemblyID = p.production_sub_assembly_list_uas_id', 'left');
        $this->db->join('tg_production_sub_assembly as p13', 'p13.id = p12.activity', 'left');



        // project add
        $this->db->join('tg_project_detail as p14', 'p14.id = p.project_detail_ap_id', 'left');



        // Purchase 
        $this->db->join('tg_purchase_window as p15', 'p15.activityID = p.purchase_window_ub_id', 'left');
        


        $this->db->where('p.isDeleted', 0);
    
        // Search functionality
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    
        // Order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    public function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    

    public function count_all()
    {
        // Return the total count of records
        return $this->db->count_all('tg_activity_notification_log');
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
      
    }


    public function all_notification() {
        $this->db->select('
            p.*, 

            p2.projectNo as projectNo_add, 
            p3.activity_data as noti_name_add,

            p4.projectNo as projectNo_update, 
            p5.activity_data as noti_name_update,



            p6.projectNo as projectNo_pac, 
            p7.task as noti_name_pac,

            p10.projectNo as projectNo_puc, 
            p11.task_data as noti_name_puc,
            


            p8.projectNo as projectNo_aas, 
            p9.assembly as noti_name_aas,

            p12.projectNo as projectNo_uas, 
            p13.assembly_activity as noti_name_uas,

            
            p14.project_no as new_projectNo, 


            p15.projectNo as projectNo_ub, 
            p15.description as noti_name_ub,

        ');
        $this->db->from('tg_activity_notification_log as p');
            

        


        // Design activity add
        $this->db->join('tg_design_window as p2', 'p2.activityID = p.design_window_aa_id', 'left');
        $this->db->join('tg_activity_data as p3', 'p3.id = p2.activity', 'left');
    
        // Design activity update
        $this->db->join('tg_design_window as p4', 'p4.activityID = p.design_window_au_id', 'left');
        $this->db->join('tg_activity_data as p5', 'p5.id = p4.activity', 'left');



        // Production activity add component
        $this->db->join('tg_production_window as p6', 'p6.activityID = p.production_window_ac_id', 'left');
        $this->db->join('tg_production_task as p7', 'p7.id = p6.activity', 'left');

        // Production compnent sub activity update 
        $this->db->join('tg_production_comp_assembly as p10', 'p10.assemblyID = p.production_comp_assembly_ua_id', 'left');
        $this->db->join('tg_production_task_data as p11', 'p11.id = p10.activity', 'left');



        // Production activity add assembl
        $this->db->join('tg_production_window_assembly as p8', 'p8.activityID = p.production_window_assembly_aas_id', 'left');
        $this->db->join('tg_production_assembly as p9', 'p9.id = p8.activity', 'left');
    
        // Production assembl sub activity update activity
        $this->db->join('tg_production_sub_assembly_list as p12', 'p12.assemblyID = p.production_sub_assembly_list_uas_id', 'left');
        $this->db->join('tg_production_sub_assembly as p13', 'p13.id = p12.activity', 'left');



        // project add
        $this->db->join('tg_project_detail as p14', 'p14.id = p.project_detail_ap_id', 'left');



        // Purchase 
        $this->db->join('tg_purchase_window as p15', 'p15.activityID = p.purchase_window_ub_id', 'left');
        


        $this->db->where('p.isDeleted', 0);

        $query = $this->db->get();
        return $query->result();   
       
    }

    // public function get_by_id($id)
    // {   
    //     $this->db->from($this->table);
    //     $this->db->where('id',$id);
    //     $query = $this->db->get();
 
    //     return $query->row();
    // }   
  
    // public function get_client_view($id){
    //     $this->db->select('*');
    //     $this->db->from($this->table);  
    //     $this->db->where('id',$id);                      
    //     $query = $this->db->get();
 
    //     return $query->row();
    // }  
 
    // public function save($data)
    // {

    //     $this->db->insert($this->table,$data);
    //     return $this->db->insert_id();
    // }   
 
    // public function update($where, $data)
    // {       
    //     $this->db->update($this->table, $data, $where);
    //     return $this->db->affected_rows();
    // }
 
    // public function delete_by_id($id)
    // {
    //     $data = array( 
    //         'isDeleted' => 1
    //     );
    //     $this->db->where('id', $id);
    //     $this->db->update($this->table,$data);
    // }

    // public function update_status($id,$status)
    // {
    //     $data['status'] = $status;
    //     $this->db->where('id', $id);
    //     $this->db->update($this->table, $data);
    // }
    
    // public function notificationLoglist(){
    //     // $this->db->select('p2.assembly_activity, p1.assemblyID, p1.skill, p1.activity_days, p1.activity_time_hours, p1.activity_time_minutes, p1.total_time,p1.total_time_save, p1.startDate, p1.targetDate, p1.actual_start_date, p1.actual_end_date,p1.startDelay,p1.endDelay, p1.manpower, p1.resp_persons, p1.quality_qc_date, p1.quality_qc_remark, p1.tpi_qc_date, p1.tpi_qc_remark,p1.clientApproval, p1.prod_release, p1.mfg_type, p1.is_all_updated, p1.activity, p1.sub_activity, p1.sub_act_order');        
        
    //    $table_firstColumn = array('tg_production_window' => 'activityID','tg_production_comp_assembly' => 'assemblyID');
        
    //    // Get all rows from tg_activity_notification_log
    //    $query = $this->db->get('tg_activity_notification_log');
    //    $log_data = $query->result_array();
    //    $results = [];

    //    foreach ($log_data as $row) {
    //        $table_to_join = $row['mul_tbl_coordinator'];
    //        $mul_tbl_id = $row['mul_tbl_id'];

        
    //        // Ensure the log_name is a valid table name to prevent SQL injection
    //        if (in_array($table_to_join, ['tg_production_window', 'tg_production_comp_assembly'])) { //here check that table has value or not
    //            $this->db->select('tg_production_task.*, tg_activity_notification_log.*, ' . $table_to_join . '.*');
    //            $this->db->from('tg_activity_notification_log');


    //            $this->db->join($table_to_join, 'tg_activity_notification_log.mul_tbl_id = ' . $table_to_join . '.'. $table_firstColumn[$table_to_join]);
    //            $this->db->join('tg_production_task', 'tg_production_task.id =' . $table_to_join . '.activity');
                  


    //            $this->db->where('tg_activity_notification_log.mul_tbl_id', $mul_tbl_id);
    //            $query = $this->db->get();
    //            $result = $query->result_array();

    //            if (!empty($result)) {
    //                $results[] = $result;
    //            }
    //        }
    //    }

    //    return $results; 


    // }


}

  