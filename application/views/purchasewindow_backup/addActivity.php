<?php
    $activity_id_array = array();  
    $projectID = $projectID;
    $projectequipment = $projectequipment;
    $projectNo = $projectNo;
    $client_id = $client_id;
    $tag_number = $tag_number;
?>

<style>
    .uk-grid>* {
        padding-left: 10px;
    }

    .uk-grid {
        text-align: left;
        margin: 0;
        padding: 0;
    }     

    .content form .user-details{
        display: flex;
        flex-wrap: wrap;        
        margin: -1px 0 -15px 0;        
    }

    form .user-details .input-box{
        margin-bottom: 10px;
        width: calc(100% / 3);
    }

    form .input-box span.details{
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .user-details .input-box input{
        height: 20px;
        width: 87%;
        outline: none;
        font-size: 14px;
        border-radius: 5px;
        padding-left: 8px;
        border: 1px solid #ccc;
        border-bottom-width: 2px;
        transition: all 0.3s ease;
    }

    .user-details .d input{
        /* height: 20px; */
        width: 47%;
    }

    .user-details .input-box select{
        height: 31px;
        width: 90%;
        outline: none;
        font-size: 14px;
        border-radius: 5px;
        padding-left: 8px;
        border: 1px solid #ccc;
        border-bottom-width: 2px;
        transition: all 0.3s ease;
    }

    .user-details .input-box input:focus,
    .user-details .input-box input:valid{
    /* border-color: #9b59b6; */
    }

    form .gender-details .gender-title{
        font-size: 14px;
        font-weight: 500;
    }

    form .category{
    display: flex;
    width: 10%;
    margin: 14px 0 ;
    justify-content: space-between;
    }

    form .category label{
    display: flex;
    align-items: center;
    cursor: pointer;
    }

    form .category label .dot{
        height: 5px;
        width: 5px;
        border-radius: 50%;
        margin-right: 10px;
        background: #d9d9d9;
        border: 5px solid transparent;
        transition: all 0.3s ease;
    }

    form input[type="radio"]{
    /* display: none; */
    }

    form .button{
        height: 45px;
        margin: 35px 0
    }

    form .button input{
        height: 100%;
        width: 100%;
        border-radius: 5px;
        border: none;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
    }

    form .button input:hover{
        /* transform: scale(0.99); */
        background: linear-gradient(-135deg, #71b7e6, #9b59b6);
    }

    @media(max-width: 584px){
        .container{
        max-width: 100%;
    }

    form .user-details .input-box{
        margin-bottom: 15px;
        width: 100%;
    }

    form .category{
        width: 100%;
    }

    .content form .user-details{
        max-height: 300px;
        overflow-y: scroll;
    }

    .user-details::-webkit-scrollbar{
        width: 5px;
    }

    }

    @media(max-width: 459px){
    .container .content .category{
        flex-direction: column;
    }
    }

    .container .title{
    font-size: 25px;
    font-weight: 500;
    position: relative;
    }

    .container .title::before{
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 30px;
        border-radius: 5px;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
    }    

    .header_design{
        text-align:center !important;
    }    

    .input-simple span {
        margin-left: -139px;
    } 

    .container{
        margin-right: 80px !important;
        margin-left: 5px !important;
    }   
    
    .table-select-level-dd {
        width: 55px !important;
        background-color: #fff !important;
        border: 1px solid #ccc !important;
    }

    .table-select-dd {
        width: 80px !important;
        background-color: #fff !important;
        border: 1px solid #ccc !important;
    }

    .padding-fordropdown {
	    padding-top: 0px !important;
    }

    .activity_data_col{
        padding-left:10px !important;
        padding-right:10px !important;
    } 
    
    .input_long{
        width: 220px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .input_long_long{
        width: 140px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .input_short{
        width: 80px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }
    
    .in_stock_disable{
        pointer-events: none;
    }

    .select_class{
        width: 120px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .select_release_class{
        width: 160px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .date-input-design{
        margin-left: 2px !important;
        margin-right: 2px !important;
    }

    .parent_node{
        color:red;
        font-size: 14px;
        /* pointer-events: none; */
    }

    .sticky-col {        
        position: -webkit-sticky;
        position: sticky;
        background-color: white;   
    }

    .first-col-header {
        width: 30px;
        min-width: 30px;
        max-width: 30px;
        left: 0px;        
    }

    .first-col {
        width: 30px;
        min-width: 30px;
        max-width: 30px;
        left: 0px; 
        background-color: #ddd;
    }

    .second-col-header {
        width: 160px;
        min-width: 160px;
        max-width: 160px;
        left: 30px;        
    }

    .second-col {
        width: 160px;
        min-width: 160px;
        max-width: 160px;
        left: 30px; 
        background-color: #ddd;
    }

    /* .response_loader {
        display:none;
    }

    .response_loader {
        align-items: center;
        background: rgb(23, 22, 22);
        display: flex;
        height: 100vh;
        justify-content: center;
        left: 0;
        position: fixed;
        top: 0;
        transition: opacity 0.3s linear;
        width: 100%;
        z-index: 9999;
    }    */

    .uk-table td {
        border-bottom-color: #c7c0c0 !important;
    }

</style>

<link type="text/css" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text add-activity"> Add Purchase 
                            <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                            <a href="<?=base_url();?>add_new_project/add_project" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                        </h1>                         
                    </div>  

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">
                                <form id="add_purchase_activity_form" name="add_purchase_activity_form" action="<?php echo base_url().'purchasewindow/importPurchaseFile'?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">                                    
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">                                    
                                    <input type="hidden" id="projectNo" name="projectNo" value="<?php echo $projectNo; ?>">                                    
                                    <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
                                    <input type="hidden" id="tag_number" name="tag_number" value="<?php echo $tag_number; ?>">

                                    <div class="user-details">
                                        <div class="input-box">
                                            <span class="details">Client / Project No</span>
                                            <input type="text" id="project_no" name="project_no"  value="<?php echo $client_name; ?> / <?php echo $projectNo; ?>" disabled>
                                        </div>

                                        <div class="input-box">
                                            <span class="details">Equipment / TAG No</span>
                                            <input type="text" id="projectequipments" name="projectequipments"  value="<?php echo $projectequipmentName; ?> / <?php echo $tag_number; ?>" disabled>
                                        </div>                                                                            

                                         <div class="input-box">
                                            <span class="details">Excel File<span class="req">*</span></span>
                                            <input class="" style="border: 0; width:80%; height: 30px;" type="file" name="file" id="file" accept=".csv,.xls,.xlsx" >
                                        </div>
                                        
                                        <div class="uk-width-medium-1-1" >
                                            <div class="parsley-row md-input-filled input-simple">
                                                <label for="material_tc"></label>
                                                <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span> 
                                            </div>
                                        </div> 
                                    </div>                                      
                                </form>
                            </div>                       
                        
                            <div class="user-details" >
                                <div class="input-box">                                    
                                    <button type="submit" name="submit" onclick="upload_activity()" class="md-btn md-btn-success add-activity">Upload</button>
                                    <!-- <button type="submit" name="submit" class="md-btn md-btn-success update_all_purchase_class">Update All</button>                                     -->
                                    <!-- <button type="submit" name="submit" onclick="bulk_delete()" class="md-btn" > Delete</button> -->
                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>                                                                        
                                </div>
                            </div>  
                        </div>                      
                    </div>

                    <!-- <div class="response_loader">
                        <img src="<?php // echo base_url()."assets/images/spinner.png" ?>" alt="spinner" style="display:none">
                    </div> -->

                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> List Purchase</h1> 
                    </div>

                    <div class="uk-overflow-container">
                        <form id="purchase_list_form" name="purchase_list_form" method="post">
                            <table id="purchase_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check-all"></th>
                                        <th class="header_design sticky-col first-col-header"><b>Sr.</b></th>                                        
                                        <th class="header_design sticky-col second-col-header"><b>TAG Number</b></th>                                                                            
                                        <th class="header_design sticky-col second-col-header"><b>Description</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Material Specification</b></th>
                                        <th class="header_design sticky-col second-col-header "><b>BOM Issue Date</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Width</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Length</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Thickness</b></th>  
                                        <!-- <th class="header_design"><b>Weight</b></th>   -->
                                        <th class="header_design sticky-col second-col-header"><b>Qty</b></th>           
                                        <!-- <th class="header_design"><b>Price</b></th>                         -->
                                        <th class="header_design sticky-col second-col-header"><b>Change as per <br/> Revised ODL</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Stock</b></th>
                                        <th class="header_design"><b>Final Vendor</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Expected PO <br/> Release Date</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Actual PO Date</b></th>                                        
                                        <th class="header_design sticky-col second-col-header"><b>QAP Approved Date</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>QAP Given/Sample</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Material Required <br/> by Production On</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Expected M.R Date</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Actual M.R Date</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>TC Available</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Remark</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Quality Remark</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Release for <br/> Production</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Availability of TC</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Action</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($getAllPurchaseActivity)) {                                 
                                    $number = $sr_no = $revision_no = 0;
                                    foreach($getAllPurchaseActivity as $activity) {                                         
                                        array_push($activity_id_array, $activity->activityID);   
                                        $stock_class = ''; 
                                        if($activity->stock == 1){
                                            $stock_class = "in_stock_disable";
                                        }else{
                                            $stock_class = "";
                                        }

                                        // for revision purpose disable all parent fields
                                        $disable_parent = '';
                                        if($activity->is_disabled == 1){
                                            $disable_parent = 'in_stock_disable';
                                        }
                                        

                                        $parent_node = '';
                                        if($activity->parent_activity_id == 0){
                                            $parent_node = 'parent_node';   
                                            $revision_no = 0;                                         
                                        }else{
                                            $revision_no++;
                                        }
                                            
                                    ?>
                                        <tr>                                        
                                            <td><input type="checkbox" class="data-check" value="<?php echo $activity->activityID; ?>" ></td>
                                            <td class="<?php echo $parent_node; ?> sticky-col first-col">
                                                <?php 
                                                    if($activity->parent_activity_id == 0){  // sr no to only parents
                                                        $sr_no++;
                                                        echo $sr_no;
                                                    }else{
                                                        echo 'R'.$revision_no;
                                                    }                                                        
                                                    $number = $number + 1; 
                                                ?>
                                            </td>

                                            <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                            <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                            <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >                                            
                                            <input type="hidden" id="sort_order-<?php echo $activity->activityID.$number; ?>" name="sort_order" value="<?php echo $activity->sort_order; ?>" >                                                                                                                                    

                                            <td class="<?php echo $disable_parent; ?> sticky-col second-col">
                                                <input type="text" class="input_long_long" id="tag_no-<?php echo $activity->activityID.$number; ?>" name="tag_no[]" value="<?php echo $activity->tag_no; ?>" title="TAG Number" placeholder="TAG Number">
                                            </td>                                                                                         
                                    
                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_long" id="description-<?php echo $activity->activityID.$number; ?>" name="description[]" value="<?php echo $activity->description; ?>" title="Description" placeholder="Description">
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_long" id="tech_req-<?php echo $activity->activityID.$number; ?>" name="tech_req[]" value="<?php echo $activity->tech_req; ?>" title="Material Specification" placeholder="Material Specification">
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <div id="bom_date_date_time-<?php echo $activity->activityID.$number; ?>" name="bom_date_date_time" class=" date-input-design" >     <!-- input-append date -->
                                                    <input class="bom_date" type="text" name="bom_date[]" id="bom_date-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->bom_date; ?>" style="width:100px;" title="BOM date" placeholder="BOM">
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>
                                            
                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_short" id="dim_width-<?php echo $activity->activityID.$number; ?>" name="dim_width[]" value="<?php echo $activity->dim_width; ?>" title="Width" placeholder="Width">
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_short" id="dim_length-<?php echo $activity->activityID.$number; ?>" name="dim_length[]" value="<?php echo $activity->dim_length; ?>" title="Length" placeholder="Length">
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_short" id="dim_thickness-<?php echo $activity->activityID.$number; ?>" name="dim_thickness[]" value="<?php echo $activity->dim_thickness; ?>" title="Thickness" placeholder="Thickness">
                                            </td>                                          

                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_short" id="qty-<?php echo $activity->activityID.$number; ?>" name="qty[]" value="<?php echo $activity->qty; ?>" title="Quantity" placeholder="Quantity">
                                            </td>                                          

                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_short" id="rev_odl-<?php echo $activity->activityID.$number; ?>" name="rev_odl[]" value="<?php echo $activity->rev_odl; ?>" title="Change as per Revised ODL" placeholder="Revised ODL">
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <select id="stock-<?php echo $activity->activityID.$number; ?>" name="stock[]" data-stock-num="<?php echo $activity->activityID.$number; ?>" class="in_stock_class select_class" title="Stock/Purchase" placeholder="">
                                                    <option value="1"<?=$activity->stock == 1 ? ' selected="selected"' : '';?>>Stock</option>
                                                    <option value="2"<?=$activity->stock == 2 ? ' selected="selected"' : '';?>>Purchase</option>
                                                </select>                                                
                                            </td>
                                            
                                            <td class="<?php echo $disable_parent; ?>">
                                                <input class="<?php echo $stock_class; ?>" type="text" id="vendor-<?php echo $activity->activityID.$number; ?>" name="vendor[]" value="<?php echo $activity->vendor; ?>" title="Vendor" placeholder="Vendor">
                                            </td>
                                            
                                            <td>
                                                <div id="po_release_date_time-<?php echo $activity->activityID.$number; ?>" name="po_release_date_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>">                                                    
                                                    <input class="po_release_date" type="text" name="po_release_date[]" id="po_release_date-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->po_release_date; ?>" style="width:100px;" title="Expected PO release date" placeholder="Expected PO">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>     
                                            </td>
                                            
                                            <td>
                                                <div id="actual_po_date_time-<?php echo $activity->activityID.$number; ?>" name="actual_po_date_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="actual_po_date" type="text" name="actual_po_date[]" id="actual_po_date-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->actual_po_date; ?>" style="width:100px;" title="Actual PO Date" placeholder="Actual PO">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>                                                                                        

                                            <td>
                                                <div id="appr_date_time-<?php echo $activity->activityID.$number; ?>" name="appr_date_time" class="  date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="appr_date" type="text" name="appr_date[]" id="appr_date-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->appr_date; ?>" style="width:100px;" title="QAP Approved Date" placeholder="QAP Approved Date">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>

                                            <td>
                                                <div id="qap_given_time-<?php echo $activity->activityID.$number; ?>" name="qap_given_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="qap_given" type="text" name="qap_given[]" id="qap_given-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->qap_given; ?>" style="width:100px;" title="QAP Given/Sample" placeholder="QAP Given/Sample">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>

                                            <td>
                                                <div id="material_reqd_prod_time-<?php echo $activity->activityID.$number; ?>" name="material_reqd_prod_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="material_reqd_prod" type="text" name="material_reqd_prod[]" id="material_reqd_prod-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->material_reqd_prod; ?>" style="width:100px;" title="Material reqd on production on" placeholder="Material reqd on production">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>                                                                                                                                   

                                            <td>
                                                <div id="exp_material_rec_date_time-<?php echo $activity->activityID.$number; ?>" name="exp_material_rec_date_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="exp_material_rec_date" type="text" name="exp_material_rec_date[]" id="exp_material_rec_date-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->exp_material_rec_date; ?>" style="width:100px;" title="Expeted MR date" placeholder="Expeted MR">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <div id="actual_material_rec_date_time-<?php echo $activity->activityID.$number; ?>" name="actual_material_rec_date_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="actual_material_rec_date" type="text" name="actual_material_rec_date[]" id="actual_material_rec_date-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->actual_material_rec_date; ?>" style="width:100px;" title="Actual MR date" placeholder="Actual MR">                                                    
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <div id="tc_rec_time-<?php echo $activity->activityID.$number; ?>" name="tc_rec_time" class=" date-input-design <?php echo $stock_class; ?> <?php echo $disable_parent; ?>" >                                                    
                                                    <input class="tc_rec" type="text" name="tc_rec[]" id="tc_rec-<?php echo $activity->activityID.$number; ?>" value="<?php echo $activity->tc_rec; ?>" style="width:100px;" title="TC Available" placeholder="TC Available">
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>                                                    
                                                </div>
                                            </td>                                            

                                            <td class="<?php echo $disable_parent; ?>">
                                                <input type="text" class="input_long" id="remark-<?php echo $activity->activityID.$number; ?>" name="remark[]" value="<?php echo $activity->remark; ?>" title="Remark" placeholder="Remark">
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <select id="quality_remark-<?php echo $activity->activityID.$number; ?>" name="quality_remark[]" class="select_class" title="Quality remark">
                                                    <option value="">-Select Quality Remark-</option>
                                                    <option value="approved"<?=$activity->quality_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>
                                                    <option value="notapproved"<?=$activity->quality_remark == 'notapproved' ? ' selected="selected"' : '';?>>Not Approved</option>
                                                    <option value="na"<?=$activity->quality_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>
                                                </select>                                                
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <select id="release_for_prod-<?php echo $activity->activityID.$number; ?>" name="release_for_prod[]" class="select_release_class" title="Release for production">
                                                    <option value="">-Select Production Release-</option>
                                                    <option value="design_hold"<?=$activity->release_for_prod == 'design_hold' ? ' selected="selected"' : '';?>>Hold from Design</option>
                                                    <option value="prod_release"<?=$activity->release_for_prod == 'prod_release' ? ' selected="selected"' : '';?>>Release for Production</option>
                                                    <option value="on_hold"<?=$activity->release_for_prod == 'on_hold' ? ' selected="selected"' : '';?>>On hold</option>
                                                </select>                                                
                                            </td>

                                            <td class="<?php echo $disable_parent; ?>">
                                                <select id="mtc-<?php echo $activity->activityID.$number; ?>" name="mtc[]" class="select_class" title="TC availability">
                                                    <option value="">-Select TC-</option>
                                                    <option value="original"<?=$activity->mtc == 'original' ? ' selected="selected"' : '';?>>Original</option>
                                                    <option value="photocopy"<?=$activity->mtc == 'photocopy' ? ' selected="selected"' : '';?>>Photocopy</option>
                                                    <option value="pending"<?=$activity->mtc == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                    <option value="na"<?=$activity->mtc == 'na' ? ' selected="selected"' : '';?>>NA</option>
                                                </select>                                                
                                            </td>

                                            <td>
                                                <?php if($activity->is_disabled == 0){ ?>
                                                    <a href="javascript:void(0)" title="Add" data-current-row-add = "<?php echo $activity->activityID.$number; ?>" name="add_activity-<?php echo $activity->activityID; ?>" id="add_activity-<?php echo $activity->activityID; ?>" class="add_single_purchase_class" ><i class="md-icon material-icons md-24">&#xE146;</i></a> 
                                                    <a href="javascript:void(0)" title="Update" data-current-row = "<?php echo $activity->activityID.$number; ?>" name="update_activity-<?php echo $activity->activityID; ?>" id="update_activity-<?php echo $activity->activityID; ?>" class="update_single_purchase_class" ><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>
                                                    <a href="javascript:void(0)" title="Delete" onclick="delete_purchase(<?php echo $activity->activityID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                                    <a href="javascript:void(0)" title="View" onclick="view_purchase(<?php echo $activity->activityID; ?>)"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php } } ?>
                                </tbody>
                            </table>                                      
                        </form>
                    </div>
                    <br/><br/>

                <!-- modal for view data -->
                    <div class="uk-modal" id="modal_default">
                        <div class="uk-modal-dialog">
                            <button type="button" class="uk-modal-close uk-close"></button>

                            <div class="uk-modal-header">
                                <h3 class="uk-modal-title">Purchase Details</h3>
                            </div>
                                            
                            <div class="uk-grid">                                                        
                                <label for="tag_no"><h5>TAG No.</h5><input type="text" name="tag_no" disabled class="md-input label-fixed" /> </label>                                                                    
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="description"><h5>Description</h5> <input type="text" name="description" disabled class="md-input label-fixed" /></label>                                        
                            </div>

                            <div class="uk-grid">                                                    
                                <label for="tech_req"><h5>Material Specification</h5><input type="text" name="tech_req" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="dim_width"><h5>Dimensions as Per Original ODL (L, W, T)</h5> <input type="text" name="dim_width" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="qty"><h5>Quantity</h5><input type="text" name="qty" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                       
                                <label for="rev_odl"><h5>Change as per Revised ODL</h5><input type="text" name="rev_odl" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="stock"><h5>Stock / Purchase</h5><input type="text" name="stock" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="vendor"><h5>Vendor</h5><input type="text" name="vendor" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="po_release_date"><h5>Expected PO Release Date</h5><input type="text" name="po_release_date" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="actual_po_date"><h5>Actual PO Date</h5><div class="parsley-row md-input-wrapper"><input type="text" name="actual_po_date" disabled class="md-input label-fixed" /></label>
                            </div>                           

                            <div class="uk-grid">                                                        
                                <label for="appr_date"><h5>QAP APPROVED DATE</h5><input type="text" name="appr_date" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="material_reqd_prod"><h5>Material Required by Production On</h5><input type="text" name="material_reqd_prod" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                       
                                <label for="exp_material_rec_date"><h5>Expected Material Receipt Date </h5><input type="text" name="exp_material_rec_date" disabled class="md-input label-fixed" /></label>                                
                            </div>

                            <div class="uk-grid">                        
                                <label for="actual_material_rec_date"><h5>Actual Material Receipt Date</h5><input type="text" name="actual_material_rec_date" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="tc_rec"><h5>TC Available </h5><input type="text" name="tc_rec" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                
                                <label for="remark"><h5>Remark</h5><input type="text" name="remark" disabled class="md-input label-fixed" /></label>                                   
                            </div>         

                            <div class="uk-modal-footer uk-text-right">
                                <button type="button" style="align:right" class="md-btn uk-modal-close">Close</button>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.pt-BR.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url();?>';    
    var projectID = "<?php echo $projectID; ?>";
    var projectequipment = "<?php echo $projectequipment; ?>";
    var projectNo = "<?php echo $projectNo; ?>";
    var client_id = "<?php echo $client_id; ?>";
    var tag_number = "<?php echo $tag_number; ?>";

    var js_activity_id_array = [];   
    js_activity_id_array =<?php echo json_encode($activity_id_array );?>;        

    $(document).ready(function(){                 
        $('.update-activity').hide();                            

        $('#add_purchase_activity_form').submit(function(){
            $("#add_purchase_activity_form :disabled").removeAttr('disabled');
        });   
        
        $('.reset_form').click(function(){
            location.reload();           
        });                      
    });    
    
    $('.in_stock_class').on('change', function() {  
        var in_stock = $(this).val();
        var get_row_id = $(this).attr("data-stock-num");                    
        // console.log(in_stock);
        // console.log(get_row_id);
        var vendor_id = "#vendor-"+get_row_id;
        var po_release_date = "#po_release_date_time-"+get_row_id;
        var actual_po_date = "#actual_po_date_time-"+get_row_id;
        // var price = "#price-"+get_row_id;
        var appr_date = "#appr_date_time-"+get_row_id;
        var qap_given = "#qap_given_time-"+get_row_id;
        var material_reqd_prod = "#material_reqd_prod_time-"+get_row_id;
        var exp_material_rec_date = "#exp_material_rec_date_time-"+get_row_id;
        var actual_material_rec_date = "#actual_material_rec_date_time-"+get_row_id;
        var tc_rec = "#tc_rec_time-"+get_row_id;
        // var remark = "#remark-"+get_row_id;
        // var quality_remark = "#quality_remark-"+get_row_id;
        // var mtc = "#mtc-"+get_row_id;

        if(in_stock == 1){            
            $(vendor_id).addClass("in_stock_disable");
            $(po_release_date).addClass("in_stock_disable");
            $(actual_po_date).addClass("in_stock_disable");
            // $(price).addClass("in_stock_disable");
            $(appr_date).addClass("in_stock_disable");
            $(qap_given).addClass("in_stock_disable");
            $(material_reqd_prod).addClass("in_stock_disable");
            $(exp_material_rec_date).addClass("in_stock_disable");
            $(actual_material_rec_date).addClass("in_stock_disable");
            $(tc_rec).addClass("in_stock_disable");
            // $(remark).addClass("in_stock_disable");
            // $(quality_remark).addClass("in_stock_disable");
            // $(mtc).addClass("in_stock_disable");
        }else{
            $(vendor_id).removeClass("in_stock_disable");
            $(po_release_date).removeClass("in_stock_disable");
            $(actual_po_date).removeClass("in_stock_disable");
            // $(price).removeClass("in_stock_disable");
            $(appr_date).removeClass("in_stock_disable");
            $(qap_given).removeClass("in_stock_disable");
            $(material_reqd_prod).removeClass("in_stock_disable");
            $(exp_material_rec_date).removeClass("in_stock_disable");
            $(actual_material_rec_date).removeClass("in_stock_disable");
            $(tc_rec).removeClass("in_stock_disable");
            // $(remark).removeClass("in_stock_disable");
            // $(quality_remark).removeClass("in_stock_disable");
            // $(mtc).removeClass("in_stock_disable");
        }
                            
    });

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // update all activity data at once
    $('.update_all_purchase_class').click(function(){  

        var formData = new FormData($('#purchase_list_form')[0]); 
        var aUrl = base_url+'purchasewindow/updateAllPurchaseOnce';

        swal({
            title: "Are you sure to update all Purchase?",                            
            buttons: true,            
        }).then((willUpdate) => {
            if(willUpdate){                    
                $.ajax({
                    url : aUrl,
                    type: "POST",
                    dataType: "JSON",
                    data:formData,  
                    processData: false,
                    contentType: false, 

                    success: function(data, textStatus, jqXHR){ 
                        if(data.projectID > 0){
                            var projectID = data.projectID;
                            var projectequipment = data.projectequipment;
                            swal("Purchase Updated Successfully.").then((value) => {
                                    window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                            });
                        }else{
                            swal({
                                title: "Something went wrong.. Please try again!!",                        
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            });
                        }                                                             
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({
                            title: "Please enter all fields and try again!!",                            
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        });
                    }                
                }); 
            }
        });   
    });
    
    $('.add_single_purchase_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row-add");  
        // console.log(get_row_id);

        var sort_order = "#sort_order-"+get_row_id;
        sort_order = $(sort_order).val(); 
        
        var activityID = "#activityID-"+get_row_id;
        activityID = $(activityID).val();              

        var projectID = "#projectID-"+get_row_id;
        projectID = $(projectID).val();

        var projectequipment = "#projectequipment-"+get_row_id;
        projectequipment = $(projectequipment).val();

        var tag_no = "#tag_no-"+get_row_id;
        tag_no = $(tag_no).val();

        var bom_date = "#bom_date-"+get_row_id;
        bom_date = $(bom_date).val();
        
        var description = "#description-"+get_row_id;
        description = $(description).val();

        var tech_req = "#tech_req-"+get_row_id;
        tech_req = $(tech_req).val();

        var dim_width = "#dim_width-"+get_row_id;
        dim_width = $(dim_width).val();

        var dim_length = "#dim_length-"+get_row_id;
        dim_length = $(dim_length).val();        

        var dim_thickness = "#dim_thickness-"+get_row_id;
        dim_thickness = $(dim_thickness).val();

        // var weight = "#weight-"+get_row_id;
        // weight = $(weight).val();

        var qty = "#qty-"+get_row_id;
        qty = $(qty).val();

        var rev_odl = "#rev_odl-"+get_row_id;
        rev_odl = $(rev_odl).val();

        var stock = "#stock-"+get_row_id;
        stock = $(stock).val();

        var vendor = "#vendor-"+get_row_id;
        vendor = $(vendor).val();

        var po_release_date = "#po_release_date-"+get_row_id;
        po_release_date = $(po_release_date).val();

        var actual_po_date = "#actual_po_date-"+get_row_id;
        actual_po_date = $(actual_po_date).val();

        var po_release_date = "#po_release_date-"+get_row_id;
        po_release_date = $(po_release_date).val();

        // var price = "#price-"+get_row_id;
        // price = $(price).val();

        var appr_date = "#appr_date-"+get_row_id;
        appr_date = $(appr_date).val();

        var qap_given = "#qap_given-"+get_row_id;
        qap_given = $(qap_given).val();

        var material_reqd_prod = "#material_reqd_prod-"+get_row_id;
        material_reqd_prod = $(material_reqd_prod).val();

        var exp_material_rec_date = "#exp_material_rec_date-"+get_row_id;
        exp_material_rec_date = $(exp_material_rec_date).val();

        var actual_material_rec_date = "#actual_material_rec_date-"+get_row_id;
        actual_material_rec_date = $(actual_material_rec_date).val();

        var tc_rec = "#tc_rec-"+get_row_id;
        tc_rec = $(tc_rec).val();

        var remark = "#remark-"+get_row_id;
        remark = $(remark).val();

        var quality_remark = "#quality_remark-"+get_row_id;
        quality_remark = $(quality_remark).val();

        var release_for_prod = "#release_for_prod-"+get_row_id;
        release_for_prod = $(release_for_prod).val();

        var mtc = "#mtc-"+get_row_id;
        mtc = $(mtc).val();
                
        var aUrl = base_url+'purchasewindow/addSinglePurchase'; 

        swal({
            title: "Are you sure to duplicate this Purchase?",                            
            buttons: true,            
        }).then((willUpdate) => {
            if(willUpdate){ 

                $.ajax({
                    url : aUrl,
                    type: "POST",
                    dataType: "JSON",
                    data: {'activityID':activityID, 'sort_order':sort_order, 'projectID':projectID, 'projectequipment':projectequipment, 'projectNo': projectNo, 'client_id':client_id,'tag_number':tag_number, 'tag_no':tag_no, 'bom_date':bom_date, 'description':description, 'tech_req':tech_req, 'dim_width':dim_width, 'dim_length':dim_length, 'dim_thickness':dim_thickness, 'qty':qty, 'rev_odl':rev_odl, 'stock':stock, 'vendor':vendor, 'po_release_date':po_release_date, 'actual_po_date':actual_po_date, 'appr_date':appr_date, 'material_reqd_prod':material_reqd_prod, 'exp_material_rec_date':exp_material_rec_date, 'actual_material_rec_date':actual_material_rec_date, 'tc_rec':tc_rec, 'remark':remark, 'release_for_prod':release_for_prod, 'quality_remark':quality_remark, 'qap_given':qap_given, 'mtc':mtc },

                    success: function(data, textStatus, jqXHR){ 
                        if(data.projectID > 0){
                            // swal("Purchase added Successfully.")
                                // .then((value) => {
                                    window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                            // });
                        }else{
                            swal({
                                title: "Something went wrong.. Please try again!",                        
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            });
                        }                                                             
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({
                            title: "Something went wrong.. Please try again!",                    
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        });
                    }
                });
            }
        });
    });
    
    $('.update_single_purchase_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  

        var activityID = "#activityID-"+get_row_id;
        activityID = $(activityID).val();              

        var projectID = "#projectID-"+get_row_id;
        projectID = $(projectID).val();

        var projectequipment = "#projectequipment-"+get_row_id;
        projectequipment = $(projectequipment).val();

        var tag_no = "#tag_no-"+get_row_id;
        tag_no = $(tag_no).val();

        var bom_date = "#bom_date-"+get_row_id;
        bom_date = $(bom_date).val();
        
        var description = "#description-"+get_row_id;
        description = $(description).val();

        var tech_req = "#tech_req-"+get_row_id;
        tech_req = $(tech_req).val();

        var dim_width = "#dim_width-"+get_row_id;
        dim_width = $(dim_width).val();

        var dim_length = "#dim_length-"+get_row_id;
        dim_length = $(dim_length).val();        

        var dim_thickness = "#dim_thickness-"+get_row_id;
        dim_thickness = $(dim_thickness).val();

        // var weight = "#weight-"+get_row_id;
        // weight = $(weight).val();

        var qty = "#qty-"+get_row_id;
        qty = $(qty).val();

        var rev_odl = "#rev_odl-"+get_row_id;
        rev_odl = $(rev_odl).val();

        var stock = "#stock-"+get_row_id;
        stock = $(stock).val();

        var vendor = "#vendor-"+get_row_id;
        vendor = $(vendor).val();

        var po_release_date = "#po_release_date-"+get_row_id;
        po_release_date = $(po_release_date).val();

        var actual_po_date = "#actual_po_date-"+get_row_id;
        actual_po_date = $(actual_po_date).val();

        var po_release_date = "#po_release_date-"+get_row_id;
        po_release_date = $(po_release_date).val();

        // var price = "#price-"+get_row_id;
        // price = $(price).val();

        var appr_date = "#appr_date-"+get_row_id;
        appr_date = $(appr_date).val();

        var qap_given = "#qap_given-"+get_row_id;
        qap_given = $(qap_given).val();

        var material_reqd_prod = "#material_reqd_prod-"+get_row_id;
        material_reqd_prod = $(material_reqd_prod).val();

        var exp_material_rec_date = "#exp_material_rec_date-"+get_row_id;
        exp_material_rec_date = $(exp_material_rec_date).val();

        var actual_material_rec_date = "#actual_material_rec_date-"+get_row_id;
        actual_material_rec_date = $(actual_material_rec_date).val();

        var tc_rec = "#tc_rec-"+get_row_id;
        tc_rec = $(tc_rec).val();

        var remark = "#remark-"+get_row_id;
        remark = $(remark).val();

        var quality_remark = "#quality_remark-"+get_row_id;
        quality_remark = $(quality_remark).val();

        var release_for_prod = "#release_for_prod-"+get_row_id;
        release_for_prod = $(release_for_prod).val();

        var mtc = "#mtc-"+get_row_id;
        mtc = $(mtc).val();
                
        var aUrl = base_url+'purchasewindow/updateSinglePurchase';        

        $.ajax({
            url : aUrl,
            type: "POST",
            dataType: "JSON",
            data: {'activityID':activityID, 'projectID':projectID, 'projectequipment':projectequipment,'tag_no':tag_no, 'bom_date':bom_date, 'description':description, 'tech_req':tech_req, 'dim_width':dim_width, 'dim_length':dim_length, 'dim_thickness':dim_thickness, 'qty':qty, 'rev_odl':rev_odl, 'stock':stock, 'vendor':vendor, 'po_release_date':po_release_date, 'actual_po_date':actual_po_date, 'appr_date':appr_date, 'material_reqd_prod':material_reqd_prod, 'exp_material_rec_date':exp_material_rec_date, 'actual_material_rec_date':actual_material_rec_date, 'tc_rec':tc_rec, 'remark':remark, 'release_for_prod':release_for_prod, 'quality_remark':quality_remark, 'qap_given':qap_given, 'mtc':mtc },

            success: function(data, textStatus, jqXHR){ 
                if(data.projectID > 0){
                    swal("Purchase Updated Successfully.")
                        .then((value) => {
                            window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                    });
                }else{
                    swal({
                        title: "Something went wrong.. Please try again!",                        
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }                                                             
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({
                    title: "Please Enter all fields and try again!!",                    
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            }
        }); 
    }); 

    var i;
    var sdate_number=0;
    var id_rest = '';
    js_activity_id_array.forEach(function(item) {
        sdate_number++;                        
        id_rest = "#po_release_date_time-"+item+sdate_number;
        $(id_rest).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                   
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_act_po = "#actual_po_date_time-"+item+sdate_number;
        $(id_act_po).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_appr_date = "#appr_date_time-"+item+sdate_number;
        $(id_appr_date).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_exp_material = "#exp_material_rec_date_time-"+item+sdate_number;
        $(id_exp_material).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_act_material = "#actual_material_rec_date_time-"+item+sdate_number;
        $(id_act_material).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_tc_rec_time = "#tc_rec_time-"+item+sdate_number;
        $(id_tc_rec_time).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        }).on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_material_reqd_prod_time = "#material_reqd_prod_time-"+item+sdate_number;
        $(id_material_reqd_prod_time).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        }).on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_qap_given_time = "#qap_given_time-"+item+sdate_number;
        $(id_qap_given_time).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        }).on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var bom_date = "#bom_date_date_time-"+item+sdate_number;
        $(bom_date).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true,                    
        }).on("change", function() {
            // $(this).datetimepicker('remove');
        });
        


    });       
    
    function view_purchase(activityID){
        var aUrl = base_url+'purchasewindow/view_purchase';
        $.ajax({
            url : aUrl,
            type: "GET",
            dataType: "JSON",   
            data: { 'activityID':activityID },
            success: function(data){
                // console.log(data);                
                var dim = data.dim_width+' | '+data.dim_length+' | '+data.dim_thickness;
                $('[name="tag_no"]').val(data.tag_no);
                $('[name="description"]').val(data.description);
                $('[name="tech_req"]').val(data.tech_req);
                $('[name="dim_width"]').val(dim);
                $('[name="qty"]').val(data.qty);
                $('[name="rev_odl"]').val(data.rev_odl);
                $('[name="stock"]').val(data.stock);
                $('[name="vendor"]').val(data.vendor);
                $('[name="po_release_date"]').val(data.po_release_date);
                $('[name="actual_po_date"]').val(data.actual_po_date);
                // $('[name="price"]').val(data.price);
                $('[name="appr_date"]').val(data.appr_date);
                $('[name="material_reqd_prod"]').val(data.material_reqd_prod);
                $('[name="exp_material_rec_date"]').val(data.exp_material_rec_date);
                $('[name="actual_material_rec_date"]').val(data.actual_material_rec_date);
                $('[name="tc_rec"]').val(data.tc_rec);
                $('[name="remark"]').val(data.remark);                

                UIkit.modal($('.uk-modal')).show();
            },
            error: function(data){
                console.log('error');
            }
        });                 

    }

    function upload_activity(){
        var file = $('#file').val();
        if(file!= ''){
            // console.log(file);
            $('#all_field_validation').html('');

            var projectID = $('#projectID').val();
            var projectequipment = $('#projectequipment').val();

            var aUrl = base_url+'purchasewindow/importPurchaseFile';

            if(projectID > 0 && projectequipment > 0){    
                var formData = new FormData($('#add_purchase_activity_form')[0]);          
            
                swal({
                    title: "Are you sure to upload this excel file?",                            
                    buttons: true,            
                }).then((willUpdate) => {
                    if(willUpdate){  
                        $.ajax({
                            url : aUrl,
                            type: "POST",
                            dataType: "text",
                            // data: {'projectID':projectID, 'projectequipment':projectequipment, 'file':file },
                            data:formData,  
                            processData: false,
                            contentType: false,  
                            // beforeSend: function(){
                            //     $('.response_loader').show();
                            // },    
                            success: function(data, textStatus, jqXHR){ 
                                // console.log(data);
                                if(projectID > 0){
                                    swal("Purchase Added Successfully.")
                                        .then((value) => {
                                            window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                                    });
                                }else{
                                    swal({
                                        title: "Something went wrong.. Please try again!",                        
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    });
                                }                                                             
                            },
                            // complete: function(){
                            //     $('.response_loader').hide();
                            // },
                            error: function (jqXHR, textStatus, errorThrown)
                            {                       
                                swal({
                                    title: "Unable to add purchase.. Please try again!!",
                                    text: "Check if you have uploaded correct data!",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                });              
                            }
                        });
                    }
                });                    
                      
            }else{
                
            }

        }else{
            $('#all_field_validation').html('Please upload excel file first..');
        }        
    } 

    function bulk_delete()
    {
        var list_id = [];
        $(".data-check:checked").each(function() {
                list_id.push(this.value);
        });
        if(list_id.length > 0)
        {
            var aUrl = base_url+'purchasewindow/ajax_bulk_delete';

            swal({
                title: "Are you sure to delete this purchase?",            
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {                    
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",
                        data: { id:list_id},
                        success: function(data)
                        {                                                        
                            window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
                        },                
                    });                                
                }
            });  
        }else
        {
            UIkit.modal.alert('No record selected!')
        }         
    }

    function delete_purchase(activityID,projectID,projectequipment){
        var aUrl = base_url+'purchasewindow/delete_new_activity';

        swal({
            title: "Are you sure to delete this purchase?",            
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                if(activityID > 0){
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",
                        data: {'activityID':activityID},
                        success: function(data)
                        {                                                        
                            window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
                        },                
                    });
                }else{
                    swal({
                        title: "Something went wrong.. Please try again!",                        
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }                
            }
        });
    }          
</script>