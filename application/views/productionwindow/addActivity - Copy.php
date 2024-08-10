<?php
    $activity_id_array = array();    
    $project_id_global = 0;
    $project_eqpid_global = 0;
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
        /* justify-content: space-between; */
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

    .group_order_init{
        color:black;
    }

    .group_order1, .group_order4, .group_order7{
        color:red;
    }

    .group_order2, .group_order5, .group_order8{        
        color:green;
    }

    .group_order3, .group_order6, .group_order9{        
        color:blue;
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
    
    .table-text-box {
        width: 120px !important;
        background-color: #fff !important; 
        border: 1px solid #ccc !important;
    } 
    
    .table-text-box-time {
        width: 100px !important;
        background-color: #fff !important; 
        border: 1px solid #ccc !important;
    } 

    .approval-select-box {
        width: 100px !important;
        background-color: #fff !important; 
        border: 1px solid #ccc !important;
    } 

    .padding-fordropdown {
	    padding-top: 0px !important;
    }

    /* .activity_data_col{
        padding-left:8px !important;
        padding-right:8px !important;
    } */

    .main-component{
        width:200px !important;
        padding: 0px !important;
        margin: 0px !important;
    }

    .assembly-sr-no{
        width: 20px !important;
    }

    .not_updated_class{
        color: red;
    }

    .auto-field{
        pointer-events: none;
    }

/* Scroll lock for some columns starts here*/
    /* .sticky-col { */
        /* position: -webkit-sticky; */
        /* position: sticky; */
        /* background-color: white; */
    /* } */

    /* .first-col {
        width: 30px;
        min-width: 30px;
        max-width: 30px;
        left: 0px;
    }

    .second-col {
        width: 40px;
        min-width: 40px;
        max-width: 40px;
        left: 35px;
    }

    .third-col {
        width: 40px;
        min-width: 40px;
        max-width: 40px;
        left: 100px;
    }

    .fourth-col {
        width: 300px;
        min-width: 260px;
        max-width: 300px;
        left: 160px;          
       
    }
    
    .fifth-col {
        margin-left: 45px;
    }             */
/* Scroll lock for some columns ends here*/
</style>

<link type="text/css" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<div id="page_content">    
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text add-activity"> Add Production Activity
                        <a href="<?=base_url();?>add_new_project/add_project" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                        </h1>                          
                    </div>  

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">
                                <form id="add_production_activity_form" action="#" method="post" autocomplete="off">

                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">                                    
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">                                    

                                    <div class="user-details">
                                        <div class="input-box">
                                            <span class="details">Client / Project No</span>
                                            <input type="text" id="project_no" name="project_no"  value="<?php echo $client_name; ?> / <?php echo $projectNo; ?>" disabled>
                                        </div>

                                        <div class="input-box">
                                            <span class="details">Equipment / TAG No</span>
                                            <input type="text" id="projectequipments" name="projectequipments"  value="<?php echo $projectequipmentName; ?> / <?php echo $tag_number; ?>" disabled>
                                        </div>                                                                                                                     
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Component <span class="req">*</span></span>                                            
                                        <?php echo $activitylist; ?>
                                    </div>                                    
                                </form>
                            </div>                       

                            <div class="user-details" >
                                <div class="input-box">
                                    <button type="submit" name="submit" onclick="save_activity()" class="md-btn md-btn-success add-activity">Add Component</button>                                                                        
                                    <!-- <button type="submit" onclick="reorder()" class="md-btn reset_form">Reorder Drag</button> -->
                                    <!-- <button type="submit" name="submit" class="md-btn reorder_activity_class">Re-order</button> -->
                                    <!-- <button type="submit" name="submit" class="md-btn md-btn-success update_all_activity_class">Update All</button>                                     -->
                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>
                                </div>
                            </div> 
                            <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span>  
                        </div>                      
                    </div>

                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> List Activities</h1> 
                    </div>                   
                    
                    <div class="uk-overflow-container">                    
                        <form id="update_all_activity" name="update_all_activity" method="post">
                            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="header_design"><b>Sr.</b></th>                                                                                    
                                        <th class="header_design"><b>Order</b></th>                                                                                
                                        <th class="header_design"><b>Component</b></th>                                        
                                        <th class="header_design"><b>Quantity</b></th>                                        
                                        <th class="header_design"><b>Activity Time &nbsp;&nbsp;&nbsp;&nbsp; Total Time </b></th>
                                        <!-- <th class="header_design"><b>Total Time</b></th>                                         -->
                                        <th class="header_design"><b>Supervisor</b></th>                                                                           
                                        <th class="header_design"><b>Client Approval &nbsp;&nbsp;&nbsp;&nbsp; Release </b></th>
                                        <!-- <th class="header_design"><b>Release for <br/> Next Operation</b></th> -->
                                        <th class="header_design"><b>Manufacturing Type</b></th> 
                                        <th class="header_design"><b>Action</b></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                        <th class="header_design"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if(!empty($getAllProductionActivity)) { 
                                        // echo '<pre>';
                                        // print_r($getAllProductionActivity);exit;
                                        $total_activity_count = count($getAllProductionActivity);
                                        
                                        $this->load->model('production_window_model');
                                        $number = $array_cnt = 0;
                                        $level_count = 0;
                                        $prev_target_date = '';
                                        foreach($getAllProductionActivity as $activity) {                                                                                                                     
                                            
                                        ?>                                                                
                                        <tr class="group_order">                                                                               

                                            <td class="sticky-col first-col" style="text-align:center;">
                                                <?php 
                                                    echo $number = $number + 1; 
                                                    $project_id_global = $activity->projectID;
                                                    $project_eqpid_global = $activity->projectequipment;
                                                ?>
                                            </td>
                                            <td>
                                                <select name="row_order[]" id="row_order-<?php echo $activity->activityID.$number; ?>" class="table-select-dd set_row_order">
                                                <?php
                                                    for($i = 1; $i <= $total_activity_count; $i++){
                                                ?>                                                                                                                             
                                                    <option value="<?php echo $i.','.$activity->activityID; ?>"<?=$activity->row_order == $i ? ' selected="selected"' : '';?>><?php echo $i; ?></option>                                                    
                                                <?php } ?>
                                                </select>
                                            </td>

                                            <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                            <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                            <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >                                            
                                            <input type="hidden" id="activity_data-<?php echo $activity->activityID.$number; ?>" name="activity_data[]" value="<?php echo $activity->activity; ?>" >
                                            <input type="hidden" id="activity_data_id-<?php echo $activity->activityID.$number; ?>" name="activity_data_id[]" value="<?php echo $activity->activity; ?>" >                                                                                   

                                            <td>
                                                <a href="javascript:void(0)" id="component-<?php echo $activity->activityID.$number; ?>" data-component-row="<?php echo $activity->activityID.$number; ?>" name="component" class="md-btn md-btn-success main-component"><?php echo $activity->task; ?></a>
                                            </td>  
                                            
                                            <td>
                                                <select name="quantity[]" id="quantity-<?php echo $activity->activityID.$number; ?>" class="table-select-dd get_total_time_class">
                                                    <option value="<?php echo '1,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 1 ? ' selected="selected"' : '';?>>1</option> 
                                                    <option value="<?php echo '2,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 2 ? ' selected="selected"' : '';?>>2</option> 
                                                    <option value="<?php echo '3,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 3 ? ' selected="selected"' : '';?>>3</option> 
                                                    <option value="<?php echo '4,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 4 ? ' selected="selected"' : '';?>>4</option> 
                                                    <option value="<?php echo '5,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 5 ? ' selected="selected"' : '';?>>5</option> 
                                                    <option value="<?php echo '6,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 6 ? ' selected="selected"' : '';?>>6</option> 
                                                    <option value="<?php echo '7,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 7 ? ' selected="selected"' : '';?>>7</option> 
                                                    <option value="<?php echo '8,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 8 ? ' selected="selected"' : '';?>>8</option> 
                                                    <option value="<?php echo '9,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 9 ? ' selected="selected"' : '';?>>9</option> 
                                                    <option value="<?php echo '10,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 10 ? ' selected="selected"' : '';?>>10</option>                                                                   
                                                </select>
                                            </td>

                                            <td>
                                                <input type="text" name="ind_time[]" id="ind_time-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time auto-field" value="<?php echo $activity->ind_time; ?>">                                                
                                                <input type="hidden" name="ind_time_hidden[]" id="ind_time_hidden-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time" value="<?php echo $activity->ind_time_hidden; ?>">
                                            <!-- </td>

                                            <td> -->
                                                <input type="text" name="total_time[]" id="total_time-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time auto-field" value="<?php echo $activity->total_time; ?>">
                                                <input type="hidden" name="total_time_hidden[]" id="total_time_hidden-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time" value="<?php echo $activity->total_time_hidden; ?>">                                                
                                            </td>

                                            <td>
                                                <select name="supervisor[]" id="supervisor-<?php echo $activity->activityID.$number; ?>" class="">
                                                    <?php
                                                        foreach($prod_dept_supervisors as $supervisor){
                                                    ?>
                                                        <option value="<?php echo $supervisor->userId; ?>"<?=$activity->supervisor == $supervisor->userId ? ' selected="selected"' : '';?>><?php echo $supervisor->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="clientApproval[]" id="clientApproval-<?php echo $activity->activityID.$number; ?>" class="approval-select-box">                                                                                  
                                                    <option value="pending"<?=$activity->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                          
                                                    <option value="yes"<?=$activity->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                          
                                                    <option value="na"<?=$activity->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                                </select>
                                            <!-- </td>

                                            <td> -->
                                                <select name="prod_release[]" id="prod_release-<?php echo $activity->activityID.$number; ?>" class="approval-select-box">                                                                                  
                                                    <option value="no"<?=$activity->prod_release == 'no' ? ' selected="selected"' : '';?>>No</option>                                                                                                                                                                              
                                                    <option value="yes"<?=$activity->prod_release == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                          
                                                </select>
                                            </td>

                                            <td>
                                                <select name="mfg_type[]" id="mfg_type-<?php echo $activity->activityID.$number; ?>" class="table-text-box">                                                                                  
                                                    <option value="outsource"<?=$activity->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                              
                                                    <option value="inhouse"<?=$activity->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>Inhouse</option>                                                                                          
                                                    <option value="partoutsource"<?=$activity->mfg_type == 'partoutsource' ? ' selected="selected"' : '';?>>Partly Outsourced</option>                                                                                                                                                                          
                                                </select>
                                            </td>

                                            <td>
                                                <a href="javascript:void(0)" data-uk-tooltip title="Update"  data-current-row="<?php echo $activity->activityID.$number; ?>" name="update_activity-<?php echo $activity->activityID; ?>" id="update_activity-<?php echo $activity->activityID; ?>" class="update_activity_class" ><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                                <a href="javascript:void(0)" title="Duplicate Component" data-current-row-duplicate = "<?php echo $activity->activityID.$number; ?>" name="duplicate_component-<?php echo $activity->activityID; ?>" id="duplicate_component-<?php echo $activity->activityID; ?>" class="duplicate_current_component_class" ><i class="md-icon material-icons md-24">&#xE146;</i></a> 
                                                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_activity(<?php echo $activity->activityID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> 

                    <!-- Assembly activity listing -->
                                        <?php
                                            $this->load->model('production_window_model');
                                            $project_id = $activity->projectID;
                                            $project_equipment_id = $activity->projectequipment;
                                            $activity_id = $activity->activityID;
                                            $component_id = $activity->taskID;
                                            
                                            $get_assembly_data = $this->production_window_model->get_component_assembly_data($project_id, $project_equipment_id, $activity_id, $component_id);
                                            if($get_assembly_data){
                                        ?>
                                        <!-- <table id="assembly_activity"> -->
                                            <thead class="assembly-table-head-<?php echo $activity->activityID.$number; ?> assembly-table-head-init">
                                                <tr>  
                                                    <th></th>                                                                                                  
                                                    <th></th>                                                                                                  
                                                    <th></th>
                                                    <th class="header_design" style="color:#f88c3b">Sr.No</th>                                                    
                                                    <th style="color:#f88c3b">Assembly Activity</th>
                                                    <th class="header_design" style="color:#f88c3b">Activity Time</th>
                                                    <th class="header_design" style="color:#f88c3b">Start Date</th>
                                                    <th class="header_design" style="color:#f88c3b">Target Date</th>
                                                    <th class="header_design" style="color:#f88c3b">Manpower</th>
                                                    <!-- <th class="header_design" style="color:#f88c3b">Skills</th> -->
                                                    <th class="header_design" style="color:#f88c3b">Responsible Person</th>
                                                    <th class="header_design" style="color:#f88c3b">Quality Internal <br/> QC Date</th>
                                                    <th class="header_design" style="color:#f88c3b">Quality Internal <br/> QC Remark</th>
                                                    <th class="header_design" style="color:#f88c3b">TPI Internal <br/> QC Date</th>
                                                    <th class="header_design" style="color:#f88c3b">TPI Internal <br/> QC Remark</th> 
                                                    <th class="header_design" style="color:#f88c3b">Client <br/> Approval</th>                                                   
                                                    <th class="header_design" style="color:#f88c3b">Release for <br/> next operation</th>
                                                    <th class="header_design" style="color:#f88c3b">Manufacturing <br/> Type</th>
                                                    <th class="header_design" style="color:#f88c3b">Action</th>                                            
                                                </tr>
                                            </thead>

                                            <tbody class="assembly-table-body-<?php echo $activity->activityID.$number; ?> assembly-table-body-init">                                              
                                                <?php
                                                    $sr_no_ass = 1;
                                                    $total_skill_cnt = 0;
                                                    foreach($get_assembly_data as $assembly){
                                                        array_push($activity_id_array, $assembly->assemblyID);  
                                                        $total_skill_cnt = explode(",", $assembly->skill);
                                                        $total_skill_cnt = count($total_skill_cnt); 
                                                ?>  
                                                    <tr>
                                                        <input type="hidden" id="activity_id-<?php echo $assembly->assemblyID; ?>" name="activity_id[]" value="<?php echo $activity->activityID; ?>" >
                                                        <input type="hidden" id="main_activity_id-<?php echo $assembly->assemblyID; ?>" name="main_activity_id[]" value="<?php echo $assembly->activity; ?>" >
                                                        <input type="hidden" id="sub_activity_id-<?php echo $assembly->assemblyID; ?>" name="sub_activity_id[]" value="<?php echo $assembly->sub_activity; ?>" >
                                                        <input type="hidden" id="activity_qty-<?php echo $assembly->assemblyID; ?>" value="<?php echo $activity->quantity; ?>" >
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="header_design"><?php echo $sr_no_ass; ?></td>
                                                        <td class="">
                                                            <?php 
                                                                if($assembly->is_all_updated == 1){
                                                                    echo wordwrap($assembly->task_data,30,'<br/>',false);
                                                                }else{ ?>
                                                                    <div class="not_updated_class" id="not_updated_id-<?php echo $assembly->assemblyID; ?>">
                                                                    <?php echo wordwrap($assembly->task_data,30,'<br/>',false); ?>
                                                                    </div>
                                                            <?php } 
                                                                
                                                            ?>
                                                            <input type="hidden" id="sub_activity-<?php echo $assembly->assemblyID; ?>" name="sub_activity[]" value="<?php echo $assembly->task_data; ?>">
                                                            <input type="hidden" id="assemblyID-<?php echo $assembly->assemblyID; ?>" name="assemblyID[]" value="<?php echo $assembly->assemblyID; ?>">
                                                        </td>                                                                                                                                        

                                                        <td>
                                                            <select name="activity_days[]" id="activity_days-<?php echo $assembly->assemblyID; ?>" class="table-select-dd activity_days_class fifth-col">
                                                                <option value="0"<?=$assembly->activity_days == 0 ? ' selected="selected"' : '';?>>0 Day</option> 
                                                                <option value="1"<?=$assembly->activity_days == 1 ? ' selected="selected"' : '';?>>1 Day</option> 
                                                                <option value="2"<?=$assembly->activity_days == 2 ? ' selected="selected"' : '';?>>2 Days</option> 
                                                                <option value="3"<?=$assembly->activity_days == 3 ? ' selected="selected"' : '';?>>3 Days</option> 
                                                                <option value="4"<?=$assembly->activity_days == 4 ? ' selected="selected"' : '';?>>4 Days</option> 
                                                                <option value="5"<?=$assembly->activity_days == 5 ? ' selected="selected"' : '';?>>5 Days</option> 
                                                                <option value="6"<?=$assembly->activity_days == 6 ? ' selected="selected"' : '';?>>6 Days</option> 
                                                                <option value="7"<?=$assembly->activity_days == 7 ? ' selected="selected"' : '';?>>7 Days</option> 
                                                                <option value="8"<?=$assembly->activity_days == 8 ? ' selected="selected"' : '';?>>8 Days</option> 
                                                                <option value="9"<?=$assembly->activity_days == 9 ? ' selected="selected"' : '';?>>9 Days</option> 
                                                                <option value="10"<?=$assembly->activity_days == 10 ? ' selected="selected"' : '';?>>10 Days</option>                                                                   
                                                            </select>

                                                            <select name="activity_time_hours[]" id="activity_time_hours-<?php echo $assembly->assemblyID; ?>" class="table-select-dd activity_time_hours_class">                                                
                                                                <?php
                                                                    for($hours=0; $hours<24; $hours++){                                                        
                                                                        if(strlen($hours) == 1)
                                                                            $hours = '0'.$hours;                                                                                      
                                                                ?>
                                                                    <option value="<?php echo $hours; ?>"<?=$assembly->activity_time_hours == $hours ? ' selected="selected"' : '';?>><?php echo $hours.' hrs'; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <select name="activity_time_minutes[]" id="activity_time_minutes-<?php echo $assembly->assemblyID; ?>" class="table-select-dd activity_time_minutes_class">                                                
                                                                <?php                                                    
                                                                    for($mins=0; $mins<60; $mins++){                                                                      
                                                                        if(strlen($mins) == 1)
                                                                            $mins = '0'.$mins;                
                                                                ?>
                                                                    <option value="<?php echo $mins; ?>"<?=$assembly->activity_time_minutes == $mins ? ' selected="selected"' : '';?>><?php echo $mins.' min'; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <div id="startDate_time-<?php echo $assembly->assemblyID; ?>" name="startDate_time" class="input-append date" >
                                                                
                                                                <input class="startDate" type="text" name="startDate[]" id="startDate-<?php echo $assembly->assemblyID; ?>" value="<?php echo $assembly->startDate; ?>" style="width:160px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>
                                                                <a href="javascript:void(0)" data-current-row="<?php echo $assembly->assemblyID; ?>" name="get_target_date" id="get_target_date" class="get_target_date_class"><i class="md-icon material-icons" style="color:#f88c3b;">forward</i></a>
                                                            </div>                                            
                                                        </td>                                        
                                                        
                                                        <td>
                                                            <input type="text" data-current-row="<?php echo $assembly->assemblyID; ?>" name="targetDate[]" id="targetDate-<?php echo $assembly->assemblyID; ?>" class="target_date_class" value="<?php echo $assembly->targetDate; ?>" style="width:140px;">                                            
                                                        </td>
                                                    
                                                        <td>
                                                            <input type="text" name="manpower[]" id="manpower-<?php echo $assembly->assemblyID; ?>" class="table-select-dd" value="<?php echo $assembly->manpower; ?>" disabled>
                                                        </td>                                                       

                                                        <td>
                                                            <?php 
                                                                $activitySkills = $this->production_window_model->get_production_skill_employee($assembly->activity, $assembly->sub_activity);  // pass activity id to get that activity skills list

                                                                // echo '<pre>';
                                                                // print_r($activitySkills);                                                                                         
                                                                $options        = array();
                                                                $options[""]    = "";
                                                                $selectedItemId = explode(',',$assembly->resp_persons);
                                                                foreach($activitySkills as $skills){
                                                                    // echo $skills->skill;
                                                                    if($skills->totalSkills >= $total_skill_cnt){                                                        
                                                                        $options[$skills->userId] = $skills->name;
                                                                    }  
                                                                    // print_r($skills->totalSkills);                                             
                                                                    // print_r($total_skill_cnt);            
                                                                }     
                                                                //  echo '<pre>';                                         
                                                                // print_r($options); 
                                                                echo form_multiselect("person_name_id[$assembly->assemblyID][]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown person_name_class", "data-row-number" => $assembly->assemblyID, 'id' => 'person_name_id-'.$assembly->assemblyID));                                                
                                                            ?>                                            
                                                        </td>                                                                                                                

                                                        <td>
                                                            <div id="quality_qc_date_time-<?php echo $assembly->assemblyID; ?>" name="quality_qc_date_time" class="input-append date">                                                    
                                                                <input class="quality_qc_date" type="text" name="quality_qc_date[]" id="quality_qc_date-<?php echo $assembly->assemblyID; ?>" value="<?php echo $assembly->quality_qc_date; ?>" style="width:100px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>                                                    
                                                            </div>     
                                                        </td>

                                                        <td>
                                                            <select id="quality_qc_remark-<?php echo $assembly->assemblyID; ?>" name="quality_qc_remark[]" class="table-text-box">                                                    
                                                                <option value="pending"<?=$assembly->quality_qc_remark == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                                <option value="approved"<?=$assembly->quality_qc_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>
                                                                <option value="na"<?=$assembly->quality_qc_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                
                                                            </select>                                                
                                                        </td>

                                                        <td>
                                                            <div id="tpi_qc_date_time-<?php echo $assembly->assemblyID; ?>" name="tpi_qc_date_time" class="input-append date">                                                    
                                                                <input class="tpi_qc_date" type="text" name="tpi_qc_date[]" id="tpi_qc_date-<?php echo $assembly->assemblyID; ?>" value="<?php echo $assembly->tpi_qc_date; ?>" style="width:100px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>                                                    
                                                            </div>     
                                                        </td>

                                                        <td>
                                                            <select id="tpi_qc_remark-<?php echo $assembly->assemblyID; ?>" name="tpi_qc_remark[]" class="table-text-box">                                                    
                                                                <option value="pending"<?=$assembly->tpi_qc_remark == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                                <option value="approved"<?=$assembly->tpi_qc_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>
                                                                <option value="na"<?=$assembly->tpi_qc_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                
                                                            </select>                                                
                                                        </td>

                                                        <td>
                                                            <select name="clientApproval[]" id="clientApproval-<?php echo $assembly->assemblyID; ?>" class="approval-select-box">                                                                                  
                                                                <option value="pending"<?=$assembly->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                      
                                                                <option value="yes"<?=$assembly->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                                      
                                                                <option value="na"<?=$assembly->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select name="prod_release[]" id="prod_release-<?php echo $assembly->assemblyID; ?>" class="approval-select-box">                                                                                  
                                                                <option value="no"<?=$assembly->prod_release == 'no' ? ' selected="selected"' : '';?>>No</option>                                                                                                                                                                          
                                                                <option value="yes"<?=$assembly->prod_release == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                                      
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select name="mfg_type[]" id="mfg_type-<?php echo $assembly->assemblyID; ?>" class="table-text-box">                                                                                  
                                                                <option value="inhouse"<?=$assembly->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>In House</option>                                      
                                                                <option value="outsource"<?=$assembly->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                          
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <a href="javascript:void(0)" data-uk-tooltip title="Update"  data-current-row="<?php echo $assembly->assemblyID; ?>" data-current-comp="<?php echo $activity->activityID.$number; ?>" name="update_assembly-<?php echo $assembly->assemblyID; ?>" id="update_assembly-<?php echo $assembly->assemblyID; ?>" class="update_assembly_class" ><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                                            <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_assembly(<?php echo $assembly->assemblyID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>,<?php echo $assembly->assemblyID; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                                        </td>                                                                                             
                                                    </tr>
                                                <?php
                                                    $sr_no_ass++;
                                                } ?>
                                            
                                            </tbody>
                                        <!-- </table> -->
                                    <?php }
                                    } 
                                }else{ ?>
                                        <script type="text/javascript">
                                            // $('.update_all_activity_class').hide();
                                        </script>
                                    <?php } ?>
                                </tbody>
                            </table>                        
                        </form>                    
                    </div>
                    <br/><br/>                    

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
    var activityID = totalSkills = 0;    
    var update_activityID = 0; 
    var js_activity_id_array = [];   
    js_activity_id_array =<?php echo json_encode($activity_id_array );?>;           
    $('.assembly-table-head-init').hide();      
    $('.assembly-table-body-init').hide();

    $(document).ready(function(){                     

        $('#add_production_activity_form').submit(function(){
            $("#add_production_activity_form :disabled").removeAttr('disabled');
        });         
        
        $('.person_name_class').on('change', function() {  
            var resp_persons_cnt = $(this).val();  // get no of responsible persons
            var get_row_id = $(this).attr("data-row-number");            
            var id = "#manpower-"+get_row_id;
            // console.log(resp_persons_cnt);
            // console.log(get_row_id);
            if(resp_persons_cnt){
                resp_persons_cnt = resp_persons_cnt.length;                               
                $(id).val(resp_persons_cnt);               
            }else{
                var val = 0;
                $(id).val(val);
            }                       
        });                                                                 

    }); 

    $('.set_row_order').on('change', function() {
        var row_order_activityID = $(this).val();        
        var row_order = row_order_activityID.split(',')[0];
        var activityID = row_order_activityID.split(',')[1];
        // console.log(row_order);
        // console.log(activityID);

        if(row_order > 0 && activityID > 0){
            var aUrl = base_url+'productionwindow/updateOrder'; 
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",           
                data: {'row_order':row_order, 'activityID':activityID},

                success: function(data, textStatus, jqXHR){ 
                    if(data.activityID > 0){      
                        var projectID = "<?php echo $project_id_global; ?>";
                        var projectequipment = "<?php echo $project_eqpid_global; ?>";                                                                                           
                        window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
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

    $('.get_total_time_class').on('change',function(){  
        // var get_row_id = $(this).attr("data-current-row-time");
        var get_row_id1 = $(this).val();
        var quantity = get_row_id1.split(',')[0];
        var activityID = get_row_id1.split(',')[1];
        var number = get_row_id1.split(',')[2];
        
        var get_row_id = activityID+number;        

        var ind_time_hidden = "#ind_time_hidden-"+get_row_id;
            ind_time_hidden = $(ind_time_hidden).val();

        var total_time_id = "#total_time-"+get_row_id; 
        var total_time_hidden = "#total_time_hidden-"+get_row_id;        
                       
        // var not_updated_id = "div#not_updated_id-"+get_row_id;
        // console.log(ind_time_hidden);
        // console.log(quantity);

        if(quantity > 0 && ind_time_hidden > 0){                      
            var total_time = Number(quantity)*Number(ind_time_hidden);  
                     
            var time_in_hrs = 0;
            // if(total_time >= 60){
                time_in_hrs = total_time / 60;
                time_in_hrs = time_in_hrs.toString().split(".")[0];
            // }else{   
            //     time_in_hrs = total_time;  
            // }

            var time_in_mnts = total_time % 60;            
            var final_total_time = time_in_hrs+'hr '+time_in_mnts+'m';  
            // console.log(time_in_hrs); 
            // console.log(time_in_mnts); 
            $(total_time_id).val(final_total_time);
            $(total_time_hidden).val(total_time); // hidden time
        }else{
            // $(not_updated_id).addClass("not_updated_class");
            $(total_time).val('');
            $(total_time_hidden).val(''); // hidden time
        }
    });
       
    $('.duplicate_current_component_class').click(function(){        
        var get_row_id = $(this).attr("data-current-row-duplicate");
        var activityID = '#activityID-'+get_row_id;
        activityID = $(activityID).val();
        // console.log(activityID);
        swal({
            title: "Are you sure to duplicate Component Activity?",                            
            buttons: true,            
        }).then((willDelete) => {
        if(willDelete){
                if(activityID > 0){
                    var aUrl = base_url+'productionwindow/duplicateComponent'; 
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",           
                        data: {'activityID':activityID},

                        success: function(data, textStatus, jqXHR){ 
                            if(data.activityID > 0){      
                                var projectID = "<?php echo $project_id_global; ?>";
                                var projectequipment = "<?php echo $project_eqpid_global; ?>";                                                                                           
                                window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
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
            }
        });
    });     
    
    $('.main-component').click(function(){        
        var get_row_id = $(this).attr("data-component-row");
        // console.log(get_row_id);
        var table_head = '.assembly-table-head-'+get_row_id;
        var table_body = '.assembly-table-body-'+get_row_id;
        $(table_head).fadeToggle();
        $(table_body).fadeToggle();
    });            
     
    var sdate_number=0;
    var id_rest = '';
    js_activity_id_array.forEach(function(item) {
        sdate_number++;                        
        id_rest = "#startDate_time-"+item;
        $(id_rest).datetimepicker({
            format: 'yyyy-MM-dd hh:mm',
            language: 'English',
            autoclose: true, 
            changeMonth: true,
            changeYear: true,        
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_quality = "#quality_qc_date_time-"+item;
        $(id_quality).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true, 
            changeMonth: true,
            changeYear: true,        
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_tpi = "#tpi_qc_date_time-"+item;
        $(id_tpi).datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'English',
            autoclose: true, 
            changeMonth: true,
            changeYear: true,        
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });
    });

    $(".target_date_class").bind("propertychange change keyup paste input", function(){
        var get_row_id = $(this).attr("data-current-row");

        var startDate_time = "#startDate-"+get_row_id;
        var start_date = $(startDate_time).val(); 

        var targetDate_time = "#targetDate-"+get_row_id;
        var target_date = $(targetDate_time).val(); 
                   
        start_date = new Date(start_date);
        target_date = new Date(target_date);        

        if(start_date > target_date){                
            $('#all_field_validation').html('Please Select Valid Target Date..');            
            // $(targetDate_time).val(''); 
        } else{
            $('#all_field_validation').html('');
        }    
    });
        
    function convertToDateTime(str) {
        var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
        hours  = ("0" + date.getHours()).slice(-2);
        minutes = ("0" + date.getMinutes()).slice(-2);
        return [ date.getFullYear(), mnth, day, hours, minutes ].join("-");    
    }        

    $('.get_target_date_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");

        var activity_qty = "#activity_qty-"+get_row_id;
            activity_qty = $(activity_qty).val();
// console.log(activity_qty);
        var startDate_time = "#startDate-"+get_row_id;
        var start_date = $(startDate_time).val(); 

        var targetDate = "#targetDate-"+get_row_id;        

        var activity_days = "#activity_days-"+get_row_id;
        activity_days = $(activity_days).val(); 

        var activity_time_hours = "#activity_time_hours-"+get_row_id;
        activity_time_hours = $(activity_time_hours).val(); 

        var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        activity_time_minutes = $(activity_time_minutes).val();  

        activity_time_minutes = Number(activity_time_minutes)*Number(activity_qty);
        var total_act_hours = activity_days*24 + Number(activity_time_hours);
        total_act_hours = Number(total_act_hours)*Number(activity_qty);           
        
        if(total_act_hours >= 0 || activity_time_minutes > 0){
            if(start_date != ''){
                $('#all_field_validation').html('');       
                var start_date_format = new Date(start_date);

                var get_hours = start_date_format.setHours(start_date_format.getHours() + total_act_hours);            
                var get_minutes = start_date_format.setMinutes(start_date_format.getMinutes() + activity_time_minutes);
                get_minutes = new Date(get_minutes);
                get_minutes = convertToDateTime(get_minutes);

                var get_date =  get_minutes.substr(0,10);
                var get_formt_hours = get_minutes.substr(11,2);
                var get_formt_minutes = get_minutes.substr(14,2);
                var final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes;
                // console.log(final_date);
                $(targetDate).val(final_date); 

            }else{
                $('#all_field_validation').html('Please Select Start Date first..');
                $(targetDate).val(''); 
            }
        }else{
            $('#all_field_validation').html('Please Select Valid Time..');
            $(startDate_time).val(''); 
        }      
    });    

    $('.update_assembly_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  
        var get_comp_row = $(this).attr("data-current-comp");

        var projectID = "<?php echo $project_id_global; ?>";
        var projectequipment = "<?php echo $project_eqpid_global; ?>";             
        
        var assemblyID = "#assemblyID-"+get_row_id; // where sub activity store
        assemblyID = $(assemblyID).val();                   

        var activity_id = "#activity_id-"+get_row_id; //prod window table activity id
        activity_id = $(activity_id).val();
        
        var main_activity_id = "#main_activity_id-"+get_row_id; // 
        main_activity_id = $(main_activity_id).val();
        
        var sub_activity_id = "#sub_activity_id-"+get_row_id;
        sub_activity_id = $(sub_activity_id).val();

        var sub_activity = "#sub_activity-"+get_row_id;
        sub_activity = $(sub_activity).val();   

        var activity_days = "#activity_days-"+get_row_id;
        activity_days = $(activity_days).val();  

        var activity_time_hours = "#activity_time_hours-"+get_row_id;
        activity_time_hours = $(activity_time_hours).val();        

        var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        activity_time_minutes = $(activity_time_minutes).val();                 

        var startDate = "#startDate-"+get_row_id;
        startDate = $(startDate).val(); 

        var targetDate = "#targetDate-"+get_row_id;
        targetDate = $(targetDate).val(); 

        var manpower = "#manpower-"+get_row_id;
        manpower = $(manpower).val(); 
 
        var person_name_id = "#person_name_id-"+get_row_id;
        person_name_id = $(person_name_id).val(); 

        var quality_qc_date = "#quality_qc_date-"+get_row_id;
        quality_qc_date = $(quality_qc_date).val(); 

        var quality_qc_remark = "#quality_qc_remark-"+get_row_id;
        quality_qc_remark = $(quality_qc_remark).val(); 

        var tpi_qc_date = "#tpi_qc_date-"+get_row_id;
        tpi_qc_date = $(tpi_qc_date).val(); 

        var tpi_qc_remark = "#tpi_qc_remark-"+get_row_id;
        tpi_qc_remark = $(tpi_qc_remark).val(); 

        var clientApproval = "#clientApproval-"+get_row_id;
        clientApproval = $(clientApproval).val(); 

        var prod_release = "#prod_release-"+get_row_id;
        prod_release = $(prod_release).val(); 

        var mfg_type = "#mfg_type-"+get_row_id;
        mfg_type = $(mfg_type).val();  

        var not_updated_id = "div#not_updated_id-"+get_row_id;

        var aUrl = base_url+'productionwindow/updateAssembly';        
        //    console.log(total_time);

        if(startDate != '' && targetDate != '' && manpower > 0 && quality_qc_date != '' && tpi_qc_date != ''){
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",           
                data: { 'projectID':projectID,'projectequipment':projectequipment, 'assemblyID':assemblyID, 'activity_id':activity_id, 'main_activity_id':main_activity_id, 'sub_activity_id':sub_activity_id, 'sub_activity':sub_activity, 'person_name_id':person_name_id, 'manpower':manpower,'targetDate':targetDate, 'startDate':startDate,'activity_time_minutes':activity_time_minutes, 'activity_time_hours':activity_time_hours,'activity_days':activity_days, 'quality_qc_date':quality_qc_date, 'quality_qc_remark':quality_qc_remark, 'tpi_qc_date':tpi_qc_date, 'tpi_qc_remark':tpi_qc_remark, 'clientApproval':clientApproval, 'prod_release':prod_release, 'mfg_type':mfg_type},

                success: function(data, textStatus, jqXHR){ 
                    if(data.assemblyID > 0){
                        swal("Assembly Activity Updated Successfully.")
                            .then((value) => {                                
                                $(not_updated_id).removeClass("not_updated_class");
                                
                        // get sum of all activity yime and update it to main activity(component)
                            var aUrl_new = base_url+'productionwindow/updateComponentActivityTime';  
                            $.ajax({
                                url : aUrl_new,
                                type: "POST",
                                dataType: "JSON",           
                                data: { 'projectID':projectID,'projectequipment':projectequipment, 'activity_id':activity_id, 'main_activity_id':main_activity_id},
                                success: function(data, textStatus, jqXHR){ 
                                    // console.log(get_comp_row);
                                    // console.log(data.activity_time);
                                    
                                    var quantity = "#quantity-"+get_comp_row;
                                    var ind_time = "#ind_time-"+get_comp_row;
                                    var ind_time_hidden = "#ind_time_hidden-"+get_comp_row;
                                    var total_time = "#total_time-"+get_comp_row;
                                    var total_time_hidden = "#total_time_hidden-"+get_comp_row;
                                    $(ind_time).val(data.activity_time);
                                    $(ind_time_hidden).val(data.activity_time_hidden);
                                    $(total_time).val(data.total_time);
                                    $(total_time_hidden).val(data.final_time);
                                    console.log(data.quantity);
                                    console.log(quantity);
                                    $(quantity+' '+'selected').val(data.quantity);
                                    // window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                                                                                                                                                  
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {                                        
                                }
                            });                                 
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
                        // text: "Check if you have entered correct data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }
            }); 
        }else{
            swal({
                title: "Please enter all fields and try again!!",
                // text: "Check if you have entered correct data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });
        }

    });

    $('.update_activity_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  

        var activityID = "#activityID-"+get_row_id;
        activityID = $(activityID).val();

        var activity_data_id = "#activity_data_id-"+get_row_id;
        activity_data_id = $(activity_data_id).val();        

        var projectID = "#projectID-"+get_row_id;
        projectID = $(projectID).val();

        var projectequipment = "#projectequipment-"+get_row_id;
        projectequipment = $(projectequipment).val();                

        var supervisor = "#supervisor-"+get_row_id;
        supervisor = $(supervisor).val();        

        var quantity = "#quantity-"+get_row_id;
        quantity = $(quantity).val();
        quantity = quantity.split(',')[0];        

        var ind_time = "#ind_time-"+get_row_id;
        ind_time = $(ind_time).val();

        var ind_time_hidden = "#ind_time_hidden-"+get_row_id;
        ind_time_hidden = $(ind_time_hidden).val();

        var total_time = "#total_time-"+get_row_id;
        total_time = $(total_time).val(); 

        var total_time_hidden = "#total_time_hidden-"+get_row_id;
        total_time_hidden = $(total_time_hidden).val();  

        var total_time_save = "#total_time_save-"+get_row_id;
        $(total_time_save).removeAttr('disabled');
        total_time_save = $(total_time_save).val();  

        var clientApproval = "#clientApproval-"+get_row_id;
        clientApproval = $(clientApproval).val();

        var prod_release = "#prod_release-"+get_row_id;
        prod_release = $(prod_release).val();

        var mfg_type = "#mfg_type-"+get_row_id;
        mfg_type = $(mfg_type).val();

        var aUrl = base_url+'productionwindow/updateActivity';        

        $.ajax({
            url : aUrl,
            type: "POST",
            dataType: "JSON",
            data: {'activityID':activityID, 'activity_data_id':activity_data_id, 'projectID':projectID, 'projectequipment':projectequipment, 'supervisor':supervisor, 'quantity':quantity, 'ind_time':ind_time,'ind_time_hidden':ind_time_hidden, 'total_time_hidden':total_time_hidden, 'total_time':total_time, 'clientApproval':clientApproval, 'prod_release':prod_release, 'mfg_type':mfg_type},

            success: function(data, textStatus, jqXHR){ 
                if(data.projectID > 0){
                    swal("Component Updated Successfully.")
                        .then((value) => {
                            window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
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
                    // text: "Check if you have entered correct data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            }
        }); 
    }); 

    function save_activity(){
        
        var aUrl = base_url+'productionwindow/saveNewActivity';
        var projectID = $('#projectID').val();
        var projectequipment = $('#projectequipment').val();
        var activity = $('#activity_id').val();       
        // console.log(activity);
        
        if(projectID > 0 && projectequipment > 0 && activity != null){ 
            swal({
                title: "Are you sure to add activity?",                
                // icon: "success",
                buttons: true,
                // dangerMode: true,
            }).then((willDelete) => {
                if(willDelete){
                    var formData = new FormData($('#add_production_activity_form')[0]);                                  
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",
                        // data: {'projectID':projectID, 'projectequipment':projectequipment, 'activity':activity, 'skill1':skill1, 'manpower1':manpower1, 'person1':person1, 'startDate':startDate, 'targetDate':targetDate, 'completionDate':completionDate, 'releaseDate':releaseDate, 'clientApproval':clientApproval},
                        data:formData,  
                        processData: false,
                        contentType: false,     
                        success: function(data, textStatus, jqXHR){ 

                            if(data.projectID > 0){
                                swal("Production Activity Added Successfully.")
                                    .then((value) => {
                                        window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
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

                        error: function (jqXHR, textStatus, errorThrown){                       
                            swal({
                                title: "Unable to add activity.. Please try again!!",
                                text: "Check if you have entered correct data!",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            });              
                        }
                    }); 
                }
            });   
        }else{            
            $('#all_field_validation').html('Please Select Component..');
        }
    } 

    function delete_activity(activityID,projectID,projectequipment)
    {
        var aUrl = base_url+'productionwindow/delete_new_activity';
        swal({
            title: "Are you sure to delete component?",
            // text: "Once deleted, you will not be able to recover this imaginary file!",
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
                        data: {'activityID':activityID,'projectID':projectID,'projectequipment':projectequipment},
                        success: function(data)
                        {                                                          
                            window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
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
    
    function delete_assembly(assemblyID,projectID,projectequipment,get_row_id)
    {
        // var get_row_id = $(this).attr("data-current-row");
        // console.log(get_row_id);
        // var table_head = '.assembly-table-head-'+get_row_id;
        // var table_body = '.assembly-table-body-'+get_row_id;        

        var aUrl = base_url+'productionwindow/delete_new_assembly';
        swal({
            title: "Are you sure to delete assembly activity?",            
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                if(assemblyID > 0){
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",
                        data: {'assemblyID':assemblyID},
                        success: function(data)
                        {                                
                            window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                                                     
                            // $(table_head).show();
                            // $(table_body).show();
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