<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class My_company extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('my_company_model');
        $this->isLoggedIn();   
        $this->global['pageTitle'] = 'Konark Engineers';
    }
    
    public function index()
    {
        $data = $this->company_data();
        $data["isEdit"] = 0;

        $this->loadViews("master/my_company", $this->global, $data, NULL);
    }

    public function save()
    {
        // pre($this->input->post());

        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('name','Company name','required|max_length[128]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('email2','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('area','Area','required|max_length[128]');
        $this->form_validation->set_rules('address','address','required|max_length[128]');
        $this->form_validation->set_rules('phone_no','Company phone number','required|min_length[10]');
        $this->form_validation->set_rules('phone_no_2','Company phone number','required|min_length[10]');
        $this->form_validation->set_rules('parent_company_name','Parent Company name','required|max_length[128]');
        $this->form_validation->set_rules('report_email','Email for report receiveing','required|valid_email|max_length[128]');
        

        if($this->form_validation->run() == false)
        {
            $data = $this->company_data();
            $data["isEdit"] = 1;

            $this->loadViews("master/my_company", $this->global, $data, NULL);
        }
        else {

            // Get form data...
            $data = $this->input->post();

            if($_FILES['company_logo']['name'] != "")
                $data['company_logo'] = $this->do_upload('company_logo');

            if($_FILES['parent_company_logo']['name'] != "")
                $data['parent_company_logo'] = $this->do_upload('parent_company_logo');

            $this->my_company_model->save_data($data);

            $data = $this->company_data();
            $data["isEdit"] = 0;
            $this->loadViews("master/my_company", $this->global, $data, NULL);
        }
    }

    public function do_upload($fileName)
    {
        $config['upload_path']          = APPPATH. '../uploads/my_company/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 1024;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileName))
        {
            $error = array('error' => $this->upload->display_errors());
            pre($error);
        }
        else
        {
            //file is uploaded successfully
            //now get the file uploaded data
            $upload_data = $this->upload->data();

            //get the uploaded file name
            return $data['company_logo'] = $upload_data['file_name'];
        }
    }

    private function company_data()
    {
        $result = $this->my_company_model->get_company();

        $data["id"]                     = $result[0]->id;
        $data["name"]                   = $result[0]->name;
        $data["email"]                  = $result[0]->email;
        $data["email2"]                 = $result[0]->email2;
        $data["area"]                   = $result[0]->area;
        $data["address"]                = $result[0]->address;
        $data["phone_no"]               = $result[0]->phone_no;
        $data["phone_no_2"]             = $result[0]->phone_no_2;
        $data["company_logo"]           = $result[0]->company_logo;
        $data["parent_company_name"]    = $result[0]->parent_company_name;
        $data["parent_company_logo"]    = $result[0]->parent_company_logo;
        $data["report_email"]           = $result[0]->report_email;

        return $data;
    }
}
?>