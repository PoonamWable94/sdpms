<?php


class Indexdd extends CI_Controller {
   public function __construct() { 
      parent::__construct();
      $this->load->database();
   }


  
   public function index() {
      $units = $this->db->get("tg_cl_unit")->result();
      $this->load->view('myview', array('units' => $units )); 
   } 

   public function myformAjax() { 
    //$id=1;
     $postData = $this->input->post('unitId');
    echo '<pre>';
    print_r($postData);
    exit;

       $result = $this->db->where("unitId",$postData)->get("tg_cl_visit_type")->result();
       echo json_encode($result);
   }


} 


?>