<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Purchasewindow extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_window_model');        
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
        $sr_no = 1;        
        foreach ($list as $activity)
        {            
            $row = array();            
            $row[] = $sr_no;
            $row[] = $activity->equipment;            
            $row[] = $activity->fileName;
            $row[] = $activity->createdBy;                       
            $row[] = $activity->createdOn;                                                                                                    
           $row[] = '<a href="uploads/purchase_files/'.$activity->fileName.'" title="Download"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a>';
         $row[] = '<a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$activity->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>';            
            $data[] = $row;
            $sr_no++;
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

        $get_equipment_tag_no = $this->purchase_window_model->get_equipment_tag_no($projectequipment, $projectID);
        $client_name = $this->purchase_window_model->get_client_name($projectID); 
        $project_no = $this->purchase_window_model->get_Project_no_by_pid($projectID); 
        
        $projectNo = $project_no->project_no; 
        $client_id = $client_name->id;
        $clientName = $client_name->company_name;

        $equipmentName = $get_equipment_tag_no->equipment_name;
        $tag_number = $get_equipment_tag_no->tag_number;                
        
        $data['getAllPurchaseActivity'] = $this->purchase_window_model->getPurchaseEqpActivity($projectID,$projectequipment,$client_id);        

        $data['projectID'] = $projectID;
        $data['projectNo'] = $projectNo;
        $data['projectequipment'] = $projectequipment;  // equipment in no format
        $data['projectequipmentName'] = $equipmentName;  // equipment in text
        $data['client_id']= $client_id;
        $data['client_name']= $clientName;
        $data['tag_number'] = $tag_number; 
        $data['purchaseProjectStartDate'] = $project_no->purchaseProjectStartDate;
        $data['purchaseProjectEndDate'] = $project_no->purchaseProjectEndDate;
        $data['purchaseActualStartDate'] = $project_no->purchaseActualStartDate;
        $data['purchaseActualEndDate'] = $project_no->purchaseActualEndDate;
        // echo '<pre>';
        // print_r($data['getAllPurchaseActivity']); exit;
        // $data["links"] = $this->pagination->create_links();
       
        $this->loadViews("purchasewindow/addActivity", $this->global, $data);                  
    }

    public function uploadPurchaseFile(){

        $projectID = $_POST['projectID'];
        $projectequipment = $_POST['projectequipment'];
        $projectNo = $_POST['projectNo'];
        $client_id = $_POST['client_id'];
        $tag_number = $_POST['tag_number'];        
        if($tag_number == ''){
            $tag_number = 'test';
        }
        $file_name = $projectNo.'_'.$tag_number.'_'.rand(1,9999);

        $config=array(
            'upload_path'=>'uploads/purchase_files/',
            'allowed_types'=>'xls|xlsx|csv',
            'file_name'=> $file_name,
            'max_size'=>0
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config); 

        if($_FILES['fileName']['name']!='')
        {
            if($this->upload->do_upload('fileName'))
            {
                $dt=$this->upload->data();
                $_POST['fileName']=$dt['file_name'];
            }else{
                $_POST['fileName'] = $_POST['old_fileName'];
                $data['error']=$this->upload->display_errors();

            }
        }else{
            $_POST['fileName'] = "";
        }

        $data_array = array(
            'projectID' => $projectID,
            'projectNo' => $projectNo,
            'client' => $client_id,
            'projectequipment' => $projectequipment,
            'tag_number' => $tag_number,
            'fileName' => $_POST['fileName'],
            'createdBy' => $this->session->userId            
        );
        
        $insert_purchase = $this->purchase_window_model->saveActivity($data_array); 
        if($insert_purchase > 0){
            $data['projectID'] = $projectID;                   
            echo json_encode($data);  
        }else{
            $data['projectID'] = 0;            
            echo json_encode($data);  
        }
        
    }

    public function saveProjectTimeline(){
        // print_r($_POST);
        $purchaseProjectStartDate = $_POST['purchaseProjectStartDate'];
        $purchaseProjectEndDate = $_POST['purchaseProjectEndDate'];
        $purchaseActualStartDate = $_POST['purchaseActualStartDate'];
        $purchaseActualEndDate = $_POST['purchaseActualEndDate'];
        $project_id = $_POST['project_id'];

        $dataArray = array(
            'purchaseProjectStartDate' => $purchaseProjectStartDate,
            'purchaseProjectEndDate' => $purchaseProjectEndDate,
            'purchaseActualStartDate' => $purchaseActualStartDate,
            'purchaseActualEndDate' => $purchaseActualEndDate,
        );
        $this->purchase_window_model->updateProjectTimeline($project_id,$dataArray); 
        
        $data['purchaseProjectStartDate'] = $purchaseProjectStartDate;                    
        $data['purchaseProjectEndDate'] = $purchaseProjectEndDate;
        $data['purchaseActualStartDate'] = $purchaseActualStartDate;                    
        $data['purchaseActualEndDate'] = $purchaseActualEndDate;
        echo json_encode($data); 
    }

    public function deleteFile(){
        $id = $_POST['id'];
        $isDeleted = $this->purchase_window_model->delete_by_id($id);        

        if($isDeleted > 0){            
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
        } 
    }
}
?>