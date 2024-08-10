<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Product extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('Product_model');
        $this->load->model('Finish_Good_model');
        $this->load->model('Semi_Finish_Good_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
        $this->global['pageTitle'] = 'Product';
        $data['finish_good'] = $this->Finish_Good_model->get_finish_good();     
       // $data['semi_finish_good'] = $this->Finish_Good_model->get_semi_finish_good();     
        // $data['semi_finish_good'] = array(); // Initialize empty array for semi finish goods

        // foreach ($data['finish_good'] as $fg) {
        //     // Fetch semi finish goods for each finish good
        //     $data['semi_finish_good'][$fg->id] = $this->Semi_Finish_Good_model->get_semi_finish_goods_by_fg_id($fg->id);
        // }
       // print_r($data); die();   
        $this->loadViews("master/product/product", $this->global, $data, NULL , NULL );
    }

    public function fetch_semi_finish_goods()
    {
        $fg_id = $this->input->post('fg_id');
        $sfg_name = $this->Semi_Finish_Good_model->get_semi_finish_goods_by_fg_id($fg_id);

      //  echo($sfg_name); die();

        // Return response as JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['sfg_name' => $sfg_name]));
    }

    // public function ajax_list()
    // {   
    //     $assign_id = $this->input->post('assign_id'); //is useed for filter by all assign_id is directly model
       
    //     $list = $this->Stamp_transfer_report_of_pipes_model->get_datatables();
    //     $pipe_material = $this->Stamp_transfer_report_of_pipes_model->get_pipe_material();
    //     $selected_heat_no_data = $this->Stamp_transfer_report_of_pipes_model->selected_heat_no_data($assign_id);
        
    // //  echo'<pre>'; print_r($selected_heat_no_data); die;
    //     $data = array();
    //     $no = $_POST['start'];
        
    //     foreach ($list as $lists)
    //     {
    //         $edit = base_url('quality_report/report/Stamp_transfer_report_of_pipes/edit_data/').$lists->id;
            
    //         $no++;
    //         $row = array();
    //         $row[] = '<input type="hidden" style="width:70%;" class="hidden" name="id[]" value='."'".$lists->id."'".' data-uk-tooltip >
    //                     <input type="checkbox" class="data-check" onchange="changeRowColorCheckbox(this)" name="checkbox_id" id="checkbox_id" value='."'".$lists->id."'".' data-uk-tooltip title="Select">';
    //         $row[] = $no;
                        

            
    //         $options1 = '<option value="0">Select</option>';
    //         foreach ($pipe_material as $pipe_mit) {
    //             $options1 .= '<option value="' . $pipe_mit->id . '" ' . ($lists->material == $pipe_mit->id ? 'selected' : '') . '>' . $pipe_mit->material_name . '</option>';  //here material_name is pipe material master field and material is main mir table field
    //         }
    //         $row[] = '<select name="material[]" id="material-' . $lists->id . '" value="' . $lists->material . '" data-uk-tooltip style="width:100%;" class="drop-down-custom1" required="" onchange="changeRowColor(this)">' . $options1 . '</select>';



    //         // $row[] = '<select name="required[]" id="required-' . $lists->id . '" data-uk-tooltip style="width:100%;" class="drop-down-custom1" required="" onchange="changeRowColor(this)">
    //         //             <option value="0" ' . ($lists->required == 0 ? 'selected' : '') . '>Select</option>
    //         //             <option value="1" ' . ($lists->required == 1 ? 'selected' : '') . '>SA 106 GR. B</option>
    //         //             <option value="2" ' . ($lists->required == 2 ? 'selected' : '') . '>SA 312 TP 304</option>
    //         //             <option value="3" ' . ($lists->required == 3 ? 'selected' : '') . '>SA 312 TP 304L</option>
    //         //             <option value="4" ' . ($lists->required == 4 ? 'selected' : '') . '>SA 312 TP 316</option>
    //         //             <option value="5" ' . ($lists->required == 5 ? 'selected' : '') . '>SA 312 TP 316L</option>
    //         //             <option value="6" ' . ($lists->required == 6 ? 'selected' : '') . '>SA 333</option>
    //         //             <option value="7" ' . ($lists->required == 7 ? 'selected' : '') . '>IS-1239</option>
    //         //             <option value="8" ' . ($lists->required == 8 ? 'selected' : '') . '>IS-3589</option>
    //         //         </select>';


    //         $row[] = '<input type="text"  oninput="changeRowColor(this)"  name="required[]"             id="required-' . $lists->id . '"                     value='."'".$lists->required."'".' data-uk-tooltip                 style="width:100%;" class="input-datatable-style"    >';
    //         // $row[] = '<input type="text"  name="material[]"             id="material-' . $lists->id . '"                     value='."'".$lists->material."'".' data-uk-tooltip                 style="width:100%;" class="input-datatable-style"    >';
    //         // $row[] = '<input type="text"  name="required[]"             id="required-' . $lists->id . '"                     value='."'".$lists->required."'".' data-uk-tooltip                 style="width:100%;" class="input-datatable-style"    >';
            
    //         $row[] = '<input type="text" oninput="changeRowColor(this)" name="actual[]"               id="actual-' . $lists->id . '"                       value='."'".$lists->actual."'".' data-uk-tooltip                   style="width:100%;" class="input-datatable-style"    >';
    //         $row[] = '<input type="text" oninput="changeRowColor(this)" name="quantity[]"             id="quantity-' . $lists->id . '"                     value='."'".$lists->quantity."'".' data-uk-tooltip                 style="width:100%;" class="input-datatable-style"    >';
    //         $row[] = '<input type="text" oninput="changeRowColor(this)" name="plate_lot_no_Id[]"      id="plate_lot_no_Id-' . $lists->id . '"              value='."'".$lists->plate_lot_no_Id."'".' data-uk-tooltip          style="width:100%;" class="input-datatable-style"    >';
         
    //         $options1 = '<option value="0">select Heat no</option>';
    //         foreach ($selected_heat_no_data as $heat_no_data) {
    //             $options1 .= '<option value="' . $heat_no_data->heat_id_no . '" ' . ($heat_no_data->heat_id_no == $lists->heat_id_no ? 'selected' : '') . '>' . $heat_no_data->heat_id_no . '</option>';
    //         }
            
    //         $row[] = '
    //                     <select name="heat_id_no_selector[]" id="heat_id_no_selector-' . $lists->id . '" style="width:50%;" class="heat_id_no_selector input-datatable-style drop-down-custom-heat-selection" row_data="' . $lists->id . '">
    //                         ' . $options1 . '
    //                         <!-- Add options here -->
    //                     </select>
    //                     <input type="text" oninput="changeRowColor(this)" name="heat_id_no[]" id="heat_id_no-' . $lists->id . '" value="' . $lists->heat_id_no . '" data-uk-tooltip style="width:50%;" class="input-datatable-style">
    //                 ';
            

            
           

            

            
            
    //         $row[] = '
    //         <a href="javascript:void(0)" data-uk-tooltip title="Update" onclick="update_single_row('."'".$lists->id."'".')"><i class="material-icons md-24 md-color-green-500">&#xe92d;</i></a> |
    //         <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data('."'".$lists->id."'".')"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
    //                 ';            
                
                

    //         $data[] = $row;
    //     }
    
    //     $output = array(
    //                 "draw" => $_POST['draw'],
    //                 "recordsTotal" => $this->Stamp_transfer_report_of_pipes_model->count_all(),
    //                 "recordsFiltered" => $this->Stamp_transfer_report_of_pipes_model->count_filtered(),
    //                 "data" => $data,
    //             );        
    //     echo json_encode($output);
    // }
 
    // public function ajax_edit($id)
    // {
    //     $data = $this->Raw_Material_model->get_by_id($id);
    //     echo json_encode($data);
    // }
 
    // public function ajax_add()
    // {
    //     $this->_validate();
    //     $data   = array(
    //                 'sfg_id' => $this->input->post('sfg_name'),
    //                 'rm_name'   => $this->input->post('rm_name'),
    //                 'createdDtm' => date('Y-m-d H:i:s'),
    //             );
    //     $insert = $this->Raw_Material_model->save($data);
    //     echo json_encode(array("status" => TRUE));
    // }

    // public function ajax_update()
    //     {
    //         $this->_validate();
    //         $data   = array(
    //             'sfg_id' => $this->input->post('sfg_name'),
    //             'rm_name'   => $this->input->post('rm_name'),
    //             'updatedDtm' => date('Y-m-d H:i:s') 
    //         );
    //         $this->Raw_Material_model->update(array('id' => $this->input->post('id')), $data);
    //         echo json_encode(array("status" => TRUE));
    //     }
    
    //     public function ajax_delete($id)
    //     {
    //         $this->Raw_Material_model->delete_by_id($id);
    //         echo json_encode(array("status" => TRUE));
    //     }
    
    //     public function ajax_bulk_delete()
    //     {
    //         $list_id = $this->input->post('id');
    //         foreach ($list_id as $id) {
    //             $this->Semi_Finish_Good_model->delete_by_id($id);
    //         }
    //         echo json_encode(array("status" => TRUE));
    //     }
    
    //     private function _validate()
    //     {
    //         $data = array();
    //         $data['error_string'] = array();
    //         $data['inputerror'] = array();
    //         $data['status'] = TRUE;
            
    //         if($this->input->post('rm_name') == '')
    //         {
    //             $data['inputerror'][] = 'rm_name';
    //             $data['error_string'][] = 'Raw Material name is required';
    //             $data['status'] = FALSE;
    //         }
    //         if($data['status'] === FALSE)
    //         {
    //             echo json_encode($data);
    //             exit();
    //         }
    //     }

    //     public function update_status()
    //     {
    //         $this->Raw_Material_model->update_status($this->input->post('id'), $this->input->post('status'));
    //     }

    }

?>