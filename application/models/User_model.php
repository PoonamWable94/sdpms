<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    var $table = 'tg_users';         
    var $column_order = array(null,'p2.dept_name', 'p3.role', 'p1.name', 'p1.email', 'p1.uname','p1.mobile','p1.skill_name');
    var $column_search = array('p2.dept_name', 'p3.role', 'p1.name', 'p1.email', 'p1.uname','p1.mobile','p1.skill_name'); 
    var $order = array('p1.dept_id' => 'asc');
 
    private function _get_datatables_query()
    {          
        $this->db->select('p2.dept_name, p3.role, p1.*');
        $this->db->from('tg_users as p1');
        $this->db->join('tg_department as p2','p2.dept_id = p1.dept_id');
        $this->db->join('tg_roles as p3','p3.roleId = p1.roleId');                
        $this->db->where('p1.isDeleted',0);    
       // $this->db->where('p1.roleId!=',1);        
        
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
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('isDeleted',0);
        $this->db->where('roleId!=',1); 
        return $this->db->count_all_results();
    }
    
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tg_roles');
        $this->db->where('roleId !=', 1);
        // $this->db->where('roleId !=', 2);
        $this->db->where('status','1');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    function getUserDepts()
    {
        $this->db->select('dept_id, dept_name');
        $this->db->from('tg_department');
        // $where = array('dept_id !='=>'7');
        $this->db->where('status', '1');
        // $this->db->where('isDeleted','0');
        $query = $this->db->get();
        
        return $query->result();
    }   

    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tg_users");
        $this->db->where("email", $email);   
        $this->db->where("status", 1);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tg_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        // $this->db->select('userId, name, email, mobile, roleId, password, emp_signature,dept_id');
        $this->db->from('tg_users');
        $this->db->where('status', 1);
		$this->db->where('roleId !=', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
        
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tg_users', $userInfo);
        
        return TRUE;
    }

    public function getUserSignature($userId)
    {
        $this->db->select('emp_signature');
        $this->db->from('tg_users');
        $this->db->where('status', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->row();
    }
        
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tg_users', $userInfo);        
        return $this->db->affected_rows();
    }

    function update_user_status($userId, $status)
    {
        $data = array( 
            'status' => $status,
        );
        $this->db->where('userId', $userId);
        $this->db->update('tg_users', $data);        
        return $this->db->affected_rows();
    }

    function deleteUserSkills($userId,$userSkillsInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tg_user_skills', $userSkillsInfo);        
        return $this->db->affected_rows();
    }

    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('status', 1);
        $query = $this->db->get('tg_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('status', 1);
        $this->db->update('tg_users', $userInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tg_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
   
    function loginHistory($userId, $searchText, $fromDate, $toDate, $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.uname, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tg_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tg_users');
        $this->db->where('status', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tg_users as BaseTbl');
        $this->db->join('tg_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.status', 1);
        $query = $this->db->get();
        
        return $query->row();
    }

    public function get_all_client_count()
    {
        // $this->db->from('tg_client');
        // $this->db->where('status',1);
        // $this->db->where('isDeleted',0);
        // $query = $this->db->get('tg_client');
        $result = $this->db->get('tg_client')->num_rows();
        return $result;
    }

    public function get_design_skill()
    {
        $this->db->from('tg_design_skills_master');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_purchase_skill()
    {
        $this->db->from('tg_purchase_skills');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function get_production_skill()
    {
        $this->db->from('tg_production_skill_master');
        $this->db->where('status',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
 
        return $query->result();
    }

    public function addUserSkills($data)
    {
        $this->db->insert('tg_user_skills',$data);
        return $this->db->insert_id();
    }

    public function getDesignSkillName($skillId){
        $this->db->select('skills');
        $this->db->from('tg_design_skills_master');
        $this->db->where('id',$skillId);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getPurchaseSkillName($skillId){
        $this->db->select('skills,purchase_activity');
        $this->db->from('tg_purchase_skills');
        $this->db->where('id',$skillId);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function getProductionSkillName($skillId){
        $this->db->select('skills,id');
        $this->db->from('tg_production_skill_master');
        $this->db->where('id',$skillId);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function delete_skills_after_update($userId,$deptId){
        $this->db->where('userId', $userId);
        $this->db->where('deptId', $deptId);
        $this->db->delete('tg_user_skills'); 
    }

    public function check_unique_uname($uname){ 
        $this->db->select('uname');       
        $this->db->from('tg_users');
        $this->db->where('uname',$uname);        
        $query = $this->db->get();        
        return $query->num_rows();
    }
}

  