<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Purchase_doc extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_doc_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Purchase Documents';
        // $data['design_activity'] = $this->design_activity_model->get_design_activity();
        //print_r($data); die;
        $this->loadViews("master/purchase_master/purchase_doc", $this->global, NULL);
    }

    public function ajax_list()
    {
        $list = $this->purchase_doc_model->get_datatables();
       // print_r($list); die();
      
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $doc)
        {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$doc->id.'" >';
            $row[] = $no;
            $row[] = $doc->document;
             
            if($doc->status == 1)
                $status_class = "md-btn-success";
            else if($doc->status == 0)
                $status_class = "md-btn-danger";    

            $status = ($doc->status? "Active" : "Inactive");

            $row[] = '<i data='."'".$doc->id."'".' class="status_checks md-btn md-btn-mini '.$status_class.'">'.$status.'</i>';

            // $row[] = $doc->createdDtm;

            //add html for action
            $row[] = '
                <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_data('."'".$doc->id."'".')"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |
                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$doc->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a> |
                <a href="'.site_url('purchase_doc/download/' . urlencode($doc->document)).'" data-uk-tooltip title="Download">
                   <i class="material-icons">file_download</i>
                </a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->purchase_doc_model->count_all(),
                        "recordsFiltered" => $this->purchase_doc_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function download($filename) {
        $this->load->helper('download');
    
        $filename = urldecode($filename); // Decode the filename
        $file_path = 'uploads/purchase_doc/' . $filename;
    
        if (file_exists($file_path)) {
            force_download($file_path, NULL);
        } else {
            echo "File not found!";
        }
    }

    public function download_multiple() {
        $this->load->helper('download');
        $this->load->library('zip');
    
        // Get the IDs of the documents to be downloaded
        $ids = $this->input->post('ids');
    
        if (empty($ids)) {
            show_error('No documents selected.');
            return;
        }
    
        // Get document details from the database
        $documents = $this->purchase_doc_model->get_documents_by_ids($ids);
    
        if (empty($documents)) {
            show_error('No documents found.');
            return;
        }
    
        // Add selected files to the ZIP archive
        foreach ($documents as $doc) {
            $file_path = './uploads/purchase_doc/' . $doc->document;
            if (file_exists($file_path)) {
                $this->zip->read_file($file_path, $doc->document); // Add file with original name
            }
        }
    
        // Force download the ZIP file
        $zip_name = 'documents_' . date('YmdHis') . '.zip';
        $this->zip->download($zip_name);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->purchase_doc_model->get_by_id($id);
       // print_r($data); die();
        echo json_encode($data);
    }
 
   
    public function ajax_add() {
        $this->_validate();
        // Define the upload path
        $upload_path = 'uploads/purchase_doc/';
    
        // Check if the upload path is valid
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true); // Create the directory if it does not exist
        }
    
        // Initialize the upload configuration
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => '*',
            'max_size' => 0
        );
    
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
    
        if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
            // Set the file name to the original name
            $config['file_name'] = $_FILES['document']['name'];
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('document')) {
                $dt = $this->upload->data();
                $uploaded_file_name = $dt['file_name'];
                $original_file_name = $dt['orig_name'];
                $_POST['document'] = $uploaded_file_name;
            } else {
                $data['error'] = $this->upload->display_errors();
                echo json_encode(array("status" => FALSE, "error" => $data['error']));
                return;
            }
        } else {
            $_POST['document'] = "";
            echo json_encode(array("status" => FALSE, "error" => "No file uploaded"));
            return;
        }
    
        // Save the file name and other details to the database
        $data = array(
           // "document" => $uploaded_file_name,
            "document" => $original_file_name
        );
    
        $insert = $this->purchase_doc_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
    
    
 
    public function ajax_update()
    {
       // $this->_validate();
        // Define the upload path
        $upload_path = 'uploads/purchase_doc/';
    
        // Check if the upload path is valid
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true); // Create the directory if it does not exist
        }
    
        // Initialize the upload configuration
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => '*',
            'max_size' => 0
        );
    
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
    
        $old_document = $this->input->post('old_doc'); // Get the name of the existing document if any

        if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
            // Set the file name to the original name
            $config['file_name'] = $_FILES['document']['name'];
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('document')) {
                $dt = $this->upload->data();
                $uploaded_file_name = $dt['file_name'];
                $original_file_name = $dt['orig_name'];
            } else {
                $data['error'] = $this->upload->display_errors();
                echo json_encode(array("status" => FALSE, "error" => $data['error']));
                return;
            }
        } else {
            // If no file is uploaded, use the existing document
            $uploaded_file_name = $old_document;
            $original_file_name = $old_document;
        }
    
        // Save the file name and other details to the database
        $data = array(
           // "document" => $uploaded_file_name,
            "document" => $original_file_name
        );
    
        $this->purchase_doc_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->purchase_doc_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->purchase_doc_model->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
       
        if (empty($_FILES['document']['name']))
        {
            $data['inputerror'][] = 'document';
            $data['error_string'][] = 'Document is required';
            $data['status'] = FALSE;
        }
        // if($this->input->post('dept') == '')
        // {
        //     $data['inputerror'][] = 'dept';
        //     $data['error_string'][] = 'Department name is required';
        //     $data['status'] = FALSE;
        // }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function update_status()
	{
        $this->purchase_doc_model->update_status($this->input->post('id'), $this->input->post('status'));
	}
}

?>