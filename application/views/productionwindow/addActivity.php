
<?php
    $activity_id_array = $assembly_id_array = array();    
    $project_id_global = 0;
    $project_eqpid_global = 0;
?>

<style>  

    #assembly-table-head-init{
        display:none;
    }

    #main-assembly-table-head-init{
        display:none;
    }

    #assembly-table-body-init{
        display:none;
    }

    #main-assembly-table-body-init{
        display:none;
    }

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
    
    .header_design_next{
        text-align:center !important;        
        color:#f88c3b !important;
        font-weight: 700 !important;
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

    .table-manpower-input {
        width: 100px !important;
        background-color: #fff !important;
        border: 1px solid #ccc !important;
    } 
    
    .table-text-box {
        width: 120px !important;
        background-color: #fff !important; 
        border: 1px solid #ccc !important;
    } 
    
    .table-text-box-time {
        width: 160px !important;
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

    .main-assembly{
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

    .updated_class{
        color:green;
    }

    .auto-field{
        pointer-events: none;
    }

/* Scroll lock for some columns starts here*/
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
        width: 90px;
        min-width: 90px;
        max-width: 90px;
        left: 30px;     
    }

    .second-col {
        width: 90px;
        min-width: 90px;
        max-width: 90px;
        left: 30px;
        background-color: #ddd;
    }

    .third-col-header {
        width: 210px;
        min-width: 210px;
        max-width: 210px;
        left: 120px;        
    }

    .third-col {
        width: 210px;
        min-width: 210px;
        max-width: 210px;
        left: 120px;        
        background-color: #ddd;
    }

    .uk-table td {
        border-bottom-color: #c7c0c0 !important;
    }   
   
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
                                    <input type="hidden" id="project_id" name="project_id" value="<?php echo $projectID; ?>"> 
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
                                    
                                    <div class="user-details">                                      
                                        <div class="input-box">                                           
                                            <span class="details"> Project Start Date (Planned)</span>
                                            <input type="date" class="save_timeline" id="productionProjectStartDate" name="productionProjectStartDate" value="<?=$productionProjectStartDate; ?>" onkeydown="return false">
                                        </div>

                                        <div class="input-box">
                                            <span class="details"> Project End Date (Planned)</span>
                                            <input type="date" class="save_timeline" id="productionProjectEndDate" name="productionProjectEndDate" value="<?=$productionProjectEndDate; ?>" onkeydown="return false">
                                        </div>  
                                    </div>

                                    <div class="user-details">                                      
                                        <div class="input-box">                                           
                                            <span class="details"> Project Start Date (Actual)</span>
                                            <input type="date" class="save_timeline" id="productionActualStartDate" name="productionActualStartDate" value="<?=$productionActualStartDate; ?>" onkeydown="return false">
                                        </div>

                                        <div class="input-box">
                                            <span class="details"> Project End Date (Actual)</span>
                                            <input type="date" class="save_timeline" id="productionActualEndDate" name="productionActualEndDate" value="<?=$productionActualEndDate; ?>" onkeydown="return false">
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
                                    <button type="submit" name="submit" class="md-btn reorder_component_class">Re-order</button>                                                                                                       
                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>   
                                    
                                </div>
                            </div> 
                            <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span>  
                        </div>                      
                    </div>                    

                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> List Component Activities</h1> 
                    </div>                   
                    
                    <div class="uk-overflow-container">                    
                        <form id="component_activity_form" name="component_activity_form" method="post">
                            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="header_design sticky-col first-col-header"><b>Sr.</b></th>                                                                                    
                                        <th class="header_design sticky-col second-col-header"><b>Order</b></th>                                                                                
                                        <th class="header_design sticky-col second-col-header"><b>Level</b></th>
                                        <th class="header_design sticky-col third-col-header"><b>Component</b></th>                                        
                                        <th class="fourth-col-header"><b>Quantity &nbsp;&nbsp;&nbsp; Total Time </b></th>                                        
                                        <th class="header_design fifth-col-header"><b>Supervisor</b></th>                                                                           
                                        <!-- <th class="header_design six-col-header"><b>Client Approval &nbsp;&nbsp;&nbsp;&nbsp; Release </b></th>                                         -->
                                        <th class="header_design six-col-header"><b>Client Approval &nbsp;&nbsp;&nbsp;&nbsp; </b></th> 
                                        <th class="header_design seven-col-header"><b>Mfg. Type</b></th> 
                                        <th class="eight-col-header"><b>Action</b></th>
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

                                            <td class="sticky-col second-col">
                                                <select name="row_order[]" id="row_order-<?php echo $activity->activityID.$number; ?>" class="table-select-dd">
                                                <?php
                                                    for($i = 1; $i <= $total_activity_count; $i++){
                                                ?>                                                                                                                             
                                                    <option value="<?php echo $i; ?>"<?=$activity->row_order == $i ? ' selected="selected"' : '';?>><?php echo $i; ?></option>                                                    
                                                <?php } ?>
                                                </select>
                                            </td>

                                            <td class="sticky-col second-col">
                                                <select name="level[]" id="level-<?php echo $activity->activityID.$number; ?>" class="table-select-level-dd activity_level">                                                                                  
                                                    <option value="-1"<?=$activity->level == -1 ? ' selected="selected"' : '';?>>L</option>                                      
                                                    <option value="0"<?=$activity->level == 0 ? ' selected="selected"' : '';?>>L0</option>                                      
                                                    <option value="1"<?=$activity->level == 1 ? ' selected="selected"' : '';?>>L1</option>                                      
                                                    <option value="2"<?=$activity->level == 2 ? ' selected="selected"' : '';?>>L2</option>                                      
                                                    <option value="3"<?=$activity->level == 3 ? ' selected="selected"' : '';?>>L3</option>                                      
                                                    <option value="4"<?=$activity->level == 4 ? ' selected="selected"' : '';?>>L4</option> 
                                                    <option value="5"<?=$activity->level == 5 ? ' selected="selected"' : '';?>>L5</option> 
                                                    <option value="6"<?=$activity->level == 6 ? ' selected="selected"' : '';?>>L6</option> 
                                                    <option value="7"<?=$activity->level == 7 ? ' selected="selected"' : '';?>>L7</option> 
                                                    <option value="8"<?=$activity->level == 8 ? ' selected="selected"' : '';?>>L8</option> 
                                                    <option value="9"<?=$activity->level == 9 ? ' selected="selected"' : '';?>>L9</option> 
                                                    <option value="10"<?=$activity->level == 10 ? ' selected="selected"' : '';?>>L10</option> 
                                                </select>                                           
                                            </td>  
<!-- id section -->
                                            <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                            <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                            <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >                                            
                                            <input type="hidden" id="activity_data-<?php echo $activity->activityID.$number; ?>" name="activity_data[]" value="<?php echo $activity->activity; ?>" >
                                            <input type="hidden" id="activity_data_id-<?php echo $activity->activityID.$number; ?>" name="activity_data_id[]" value="<?php echo $activity->activity; ?>" >                                                                                   

                                            <td class="sticky-col third-col">
                                                <a href="javascript:void(0)" id="component-<?php echo $activity->activityID.$number; ?>" data-component-row="<?php echo $activity->activityID.$number; ?>" name="component" class="md-btn md-btn-success main-component"><?php echo $activity->task; ?></a>
                                            </td>  
                                            
                                            <td class="fourth-col">
                                                <select name="quantity[]" id="quantity-<?php echo $activity->activityID.$number; ?>" class="table-select-dd get_total_time_class">
                                                    <option value="<?php echo '0,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 0 ? ' selected="selected"' : '';?>>0</option>     
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
                                            
                                                <input type="text" name="total_time[]" id="total_time-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time auto-field" value="<?php echo $activity->total_time; ?>">
                                                <input type="hidden" name="total_time_hidden[]" id="total_time_hidden-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time" value="<?php echo $activity->total_time_hidden; ?>">                                                
                                            </td>

                                            <td class="fifth-col">
                                                <select name="supervisor[]" id="supervisor-<?php echo $activity->activityID.$number; ?>" class="">
                                                    <?php
                                                        foreach($prod_dept_supervisors as $supervisor){
                                                    ?>
                                                        <option value="<?php echo $supervisor->userId; ?>"<?=$activity->supervisor == $supervisor->userId ? ' selected="selected"' : '';?>><?php echo $supervisor->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td class="six-col">
                                                <select name="clientApproval[]" id="clientApproval-<?php echo $activity->activityID.$number; ?>" class="approval-select-box component">                                                                                  
                                                    <option value="pending"<?=$activity->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                          
                                                    <option value="yes"<?=$activity->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                          
                                                    <option value="na"<?=$activity->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                                </select>                                            
                                            </td>

                                            <td class="seven-col">
                                                <select name="mfg_type[]" id="mfg_type-<?php echo $activity->activityID.$number; ?>" class="table-text-box component">                                                                                  
                                                    <option value="outsource"<?=$activity->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                              
                                                    <option value="inhouse"<?=$activity->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>Inhouse</option>                                                                                          
                                                    <option value="partoutsource"<?=$activity->mfg_type == 'partoutsource' ? ' selected="selected"' : '';?>>Partly Outsourced</option>                                                                                                                                                                          
                                                </select>
                                            </td>

                                            <td class="eight-col">
                                                <a href="javascript:void(0)" class="update_activity_class" data-uk-tooltip title="Update"  data-current-row="<?php echo $activity->activityID.$number; ?>" name="update_activity-<?php echo $activity->activityID; ?>" id="update_activity-<?php echo $activity->activityID; ?>" ><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                                <a href="javascript:void(0)" title="Duplicate Component" data-current-row-duplicate = "<?php echo $activity->activityID.$number; ?>" name="duplicate_component-<?php echo $activity->activityID; ?>" id="duplicate_component-<?php echo $activity->activityID; ?>" class="duplicate_current_component_class" ><i class="md-icon material-icons md-24">&#xE146;</i></a> 
                                                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_activity(<?php echo $activity->activityID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                                <a href="javascript:void(0)" class="all_update_assembly_class" data-uk-tooltip title="Update All"  data-current-row="<?php echo $activity->activityID.$number; ?>" name="all_update_assembly-<?php echo $activity->activityID; ?>" id="all_update_assembly-<?php echo $activity->activityID; ?>"><i class="material-icons md-24 md-color-orange-400">&#xe877;</i></a>
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

                            <!-- Sub activity listing -->
                                        <?php
                                            $this->load->model('production_window_model');
                                            $project_id = $activity->projectID;
                                            $project_equipment_id = $activity->projectequipment;
                                            $activity_id = $activity->activityID;
                                            $component_id = $activity->taskID;
                                            
                                            $get_assembly_data = $this->production_window_model->get_component_assembly_data($project_id, $project_equipment_id, $activity_id, $component_id);
                                            // echo "<pre>";
                                            // print_r($get_assembly_data);
                                            // die();
                                            if($get_assembly_data){
                                        ?>
                                        <!-- <table id="assembly_activity"> -->
                                            <thead class="assembly-table-head-<?php echo $activity->activityID.$number; ?> assembly-table-head-init" id="assembly-table-head-init">
                                                <tr>  
                                                    <th class="sticky-col first-col-header"></th>                                                                                                  
                                                    <th class="sticky-col second-col-header"></th>                                                       
                                                    <th class="header_design_next sticky-col third-col-header"> Sub Activity</th>                                                    
                                                    <th class="header_design_next">Activity Time Required</th>
                                                    <th class="header_design_next" >Start Date & Time</th>
                                                    <th class="header_design_next" >Target Date & Time</th>
                                                    <th class="header_design_next" >Manpower</th>                                                    
                                                    <th class="header_design_next" >Responsible Person</th>
                                                    <!-- <th class="header_design_next" >Quality Internal <br/> QC Date</th> -->
                                                    <!-- <th class="header_design_next" >Quality Internal <br/> QC Remark</th> -->
                                                    <!-- <th class="header_design_next" >TPI Internal <br/> QC Date</th> -->
                                                    <th class="header_design_next" >TPI Internal <br/> QC Remark</th> 
                                                    <th class="header_design_next" >Client <br/> Approval</th>                                                   
                                                    <!-- <th class="header_design_next" >Release for <br/> next operation</th> -->
                                                    <th class="header_design_next" >Manufacturing <br/> Type</th>
                                                    <th class="header_design_next">Action

                                                        
                                                    </th> 

                                                </tr>
                                            </thead>

                                            <tbody class="assembly-table-body-<?php echo $activity->activityID.$number; ?> assembly-table-body-init" id="assembly-table-body-init">                                              
                                                <!-- <form id="sub_activity_form" name="sub_activity_form" method="POST"> -->
                                                <?php
                                                    $sr_no_ass = 1;
                                                    $total_skill_cnt = 0;
                                                    $prev_target_date = '';
                                                    foreach($get_assembly_data as $assembly){
                                                        array_push($activity_id_array, $assembly->assemblyID);  
                                                        $total_skill_cnt = explode(",", $assembly->skill);
                                                        $total_skill_cnt = count($total_skill_cnt); 
                                                ?>  
                                                    <tr>
                                                        <!-- 2 -->
                                                        
                                                        <input type="hidden" id="activity_id-<?php echo $assembly->assemblyID; ?>" name="activity_id[]" value="<?php echo $activity->activityID; ?>" >
                                                        <input type="hidden" id="main_activity_id-<?php echo $assembly->assemblyID; ?>" name="main_activity_id[]" value="<?php echo $assembly->activity; ?>" >
                                                        <input type="hidden" id="sub_activity_id-<?php echo $assembly->assemblyID; ?>" name="sub_activity_id[]" value="<?php echo $assembly->sub_activity; ?>" >
                                                        <input type="hidden" id="activity_qty-<?php echo $assembly->assemblyID; ?>" value="<?php echo $activity->quantity; ?>" >
                                                        <td class="sticky-col first-col"></td>
                                                        <td class="sticky-col second-col"></td>

                                            <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                            <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                            <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >                                            
                                            <input type="hidden" id="activity_data-<?php echo $activity->activityID.$number; ?>" name="activity_data[]" value="<?php echo $activity->activity; ?>" >
                                            <input type="hidden" id="activity_data_id-<?php echo $activity->activityID.$number; ?>" name="activity_data_id[]" value="<?php echo $activity->activity; ?>" >                                                                                   

                                                        <!-- <td></td> -->
                                                        <!-- <td class="header_design"><?php //echo $sr_no_ass; ?></td> -->
                                                        <td class="sticky-col third-col">
                                                            <?php 
                                                                if($assembly->is_all_updated == 1){ ?>
                                                                    <div class="updated_class">
                                                                        <?php 
                                                                            echo $sr_no_ass.'.  '.wordwrap($assembly->task_data,30,'<br/>',false);
                                                                        ?>
                                                                    </div>
                                                                <?php }else{ ?>
                                                                    <div class="not_updated_class" id="not_updated_id-<?php echo $assembly->assemblyID; ?>">
                                                                        <?php echo $sr_no_ass.'.  '.wordwrap($assembly->task_data,30,'<br/>',false); ?>
                                                                    </div>
                                                            <?php } 
                                                                
                                                            ?>
                                                    
                                                            <input type="hidden" id="sub_activity-<?php echo $assembly->assemblyID; ?>" name="sub_activity[]" value="<?php echo $assembly->task_data; ?>">
                                                            <input type="hidden" id="assemblyID-<?php echo $assembly->assemblyID; ?>" name="assemblyID[]" value="<?php echo $assembly->assemblyID; ?>">
                                                        </td>                                                                                                                                        

                                                        <td>
                                                            <select name="activity_days[]" id="activity_days-<?php echo $assembly->assemblyID; ?>" class="table-select-dd activity_days_class">
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
                                                                    for($hours=0; $hours<=16; $hours++){                                                        
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
                                                            <?php 
                                                                $prev_start_date = '';
                                                                if(isset($assembly->startDate) && !empty($assembly->startDate)){
                                                                    $prev_start_date = $assembly->startDate;
                                                                }else{
                                                                    $prev_start_date = $prev_target_date;
                                                                }
                                                            ?>   
                                                            <div id="startDate_time-<?php echo $assembly->assemblyID; ?>" name="startDate_time">                                                                                                                                                                                            
                                                                <input class="startDate" type="text" name="startDate[]" id="startDate-<?php echo $assembly->assemblyID; ?>" value="<?php echo $prev_start_date; ?>" style="width:160px;">                                                                
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>
                                                                <a href="javascript:void(0)" data-current-row="<?php echo $assembly->assemblyID; ?>" name="get_target_date" id="get_target_date" class="get_target_date_class"><i class="md-icon material-icons" style="color:#f88c3b;">forward</i></a>
                                                            </div>                                            
                                                        </td>                                        
                                                        
                                                        <td>
                                                            <input type="text" data-current-row="<?php echo $assembly->assemblyID; ?>" name="targetDate[]" id="targetDate-<?php echo $assembly->assemblyID; ?>" class="target_date_class" value="<?php echo $assembly->targetDate; ?>" style="width:200px;">                                            
                                                        </td>
                                                    
                                                        <td>
                                                            <input type="text" name="manpower[]" id="manpower-<?php echo $assembly->assemblyID; ?>" class="table-manpower-input" value="<?php echo $assembly->manpower; ?>" >
                                                        </td>                                                       

                                                        <td id="hide-on-scroll">
                                                            <?php 
                                                                $activitySkills = $this->production_window_model->get_production_skill_employee($assembly->activity, $assembly->sub_activity);  // pass activity id to get that activity skills list

                                                                // echo '<pre>';
                                                                // print_r($activitySkills);                                                                              
                                                                $options        = array();
                                                                $options[""]    = "";
                                                                $selectedItemId = explode(',',$assembly->resp_persons);
                                                                foreach($activitySkills as $skills){
                                                                    // echo $skills->skill;
                                                                    // if($skills->totalSkills >= $total_skill_cnt){                                                        
                                                                        $options[$skills->userId] = $skills->name;
                                                                    // }  
                                                                    // print_r($skills->totalSkills);                                             
                                                                    // print_r($total_skill_cnt);            
                                                                }     
                                                                //  echo '<pre>';                                         
                                                                // print_r($options); 
                                                                echo form_multiselect("person_name_id[$assembly->assemblyID][]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown person_name_class", "data-row-number" => $assembly->assemblyID, 'id' => 'person_name_id-'.$assembly->assemblyID));                                                
                                                            ?>                                            
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
                                                            <select name="mfg_type[]" id="mfg_type-<?php echo $assembly->assemblyID; ?>" class="table-text-box">                                                                                  
                                                                <option value="inhouse"<?=$assembly->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>In House</option>                                      
                                                                <option value="outsource"<?=$assembly->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                          
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <a href="javascript:void(0)" class="update_assembly_class update_total_time-<?php echo $activity->activityID.$number; ?>" data-uk-tooltip title="Update" data-current-act-days="<?php echo $assembly->activity_days; ?>" data-current-act-hours ="<?php echo $assembly->activity_time_hours; ?>" data-current-act-minutes="<?php echo $assembly->activity_time_minutes; ?>" data-current-order="<?php echo $assembly->sub_act_order; ?>"  data-current-row="<?php echo $assembly->assemblyID; ?>" data-current-comp="<?php echo $activity->activityID.$number; ?>" name="update_assembly-<?php echo $assembly->assemblyID; ?>" id="update_assembly-<?php echo $assembly->assemblyID; ?>"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                                            <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_assembly(<?php echo $assembly->assemblyID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>,<?php echo $assembly->assemblyID; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                                        </td>                                                                                             
                                                    </tr>
                                                <?php
                                                    $sr_no_ass++;
                                                    $prev_target_date = $assembly->targetDate;
                                                } ?>
                                            <!-- </form> -->
                                            </tbody>
                                        <!-- </table> -->
                                    <?php }
                                    } 
                                }else{ ?>
                                        <script type="text/javascript">
                                            $('.update_all_activity_class').hide();
                                        </script>
                                    <?php } ?>
                                </tbody>
                            </table>                        
                        </form>                    
                    </div>
                    <br/>                               


<!-- List Assembly Activities -->


                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> List Assembly Activities</h1> 
                    </div> 

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">                                
                                <form id="add_production_assembly_activity_form" action="#" method="post" autocomplete="off">

                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">                                    
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">                                                                        
                                    
                                    <div class="input-box">
                                        <span class="assembly">Assembly <span class="req">*</span></span>                                            
                                        <?php echo $assembly_activitylist; ?>
                                    </div>

                                </form>
                            </div>                       

                            <div class="user-details" >
                                <div class="input-box">                                    
                                    <button type="submit" name="submit" onclick="save_assembly_activity()" class="md-btn md-btn-success add-activity">Add Assembly</button>
                                    <button type="submit" name="submit" class="md-btn reorder_assembly_class">Re-order</button>
                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>                                    
                                </div>
                            </div> 
                            <span class="uk-form-help-block uk-text-danger" id="all_field_validation_assembly"></span>  
                        </div>                      
                    </div>  

                    <div class="uk-overflow-container">                    
                        <form id="main_assembly_activity_form" name="main_assembly_activity_form" method="post">
                            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="header_design sticky-col first-col-header"><b>Sr.</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Order</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Level</b></th>
                                        <th class="header_design sticky-col third-col-header"><b>Assembly</b></th>                                        
                                        <th class="fourth-col-header"><b>Quantity &nbsp;&nbsp;&nbsp; Total Time </b></th>                                        
                                        <th class="header_design fifth-col-header"><b>Supervisor</b></th>                                                                                                                   
                                        <th class="header_design six-col-header"><b>Client Approval &nbsp;&nbsp;&nbsp;&nbsp; </b></th> 
                                        <th class="header_design seven-col-header"><b>Mfg. Type</b></th> 
                                        <th class="eight-col-header"><b>Action</b></th>
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

                                    <?php if(!empty($getAllProductionAssemblyActivity)) { 
                                        // echo '<pre>';
                                        // print_r($getAllProductionActivity);exit;
                                        $total_activity_count = count($getAllProductionAssemblyActivity);
                                        
                                        $this->load->model('production_window_model');
                                        $array_cnt = $srr_no = 0;
                                        $number = 100;
                                        $level_count = 0;
                                        $prev_target_date = '';
                                        foreach($getAllProductionAssemblyActivity as $activity){                                                                                                                                                                 
                                        ?>                                                                
                                        <tr class="group_order">

                                            <td class="sticky-col first-col" style="text-align:center;">
                                                <?php 
                                                    $number = $number + 1; 
                                                    echo $srr_no = $srr_no + 1; 
                                                    $project_id_global = $activity->projectID;
                                                    $project_eqpid_global = $activity->projectequipment;
                                                ?>
                                            </td>

                                            <td class="sticky-col second-col">
                                                <select name="row_order[]" id="row_order-<?php echo $activity->activityID.$number; ?>" class="table-select-dd">
                                                <?php
                                                    for($i = 1; $i <= $total_activity_count; $i++){
                                                ?>                                                                                                                             
                                                    <option value="<?php echo $i; ?>"<?=$activity->row_order == $i ? ' selected="selected"' : '';?>><?php echo $i; ?></option>                                                    
                                                <?php } ?>
                                                </select>
                                            </td>

                                            <td class="sticky-col second-col">
                                                <select name="level[]" id="level-<?php echo $activity->activityID.$number; ?>" class="table-select-level-dd activity_level">                                                                                  
                                                    <option value="-1"<?=$activity->level == -1 ? ' selected="selected"' : '';?>>L</option>                                      
                                                    <option value="0"<?=$activity->level == 0 ? ' selected="selected"' : '';?>>L0</option>                                      
                                                    <option value="1"<?=$activity->level == 1 ? ' selected="selected"' : '';?>>L1</option>                                      
                                                    <option value="2"<?=$activity->level == 2 ? ' selected="selected"' : '';?>>L2</option>                                      
                                                    <option value="3"<?=$activity->level == 3 ? ' selected="selected"' : '';?>>L3</option>                                      
                                                    <option value="4"<?=$activity->level == 4 ? ' selected="selected"' : '';?>>L4</option> 
                                                    <option value="5"<?=$activity->level == 5 ? ' selected="selected"' : '';?>>L5</option> 
                                                    <option value="6"<?=$activity->level == 6 ? ' selected="selected"' : '';?>>L6</option> 
                                                    <option value="7"<?=$activity->level == 7 ? ' selected="selected"' : '';?>>L7</option> 
                                                    <option value="8"<?=$activity->level == 8 ? ' selected="selected"' : '';?>>L8</option> 
                                                    <option value="9"<?=$activity->level == 9 ? ' selected="selected"' : '';?>>L9</option> 
                                                    <option value="10"<?=$activity->level == 10 ? ' selected="selected"' : '';?>>L10</option> 
                                                </select>                                           
                                            </td> 

                                            <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                            <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                            <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >                                            
                                            <input type="hidden" id="activity_data-<?php echo $activity->activityID.$number; ?>" name="activity_data[]" value="<?php echo $activity->activity; ?>" >
                                            <input type="hidden" id="activity_data_id-<?php echo $activity->activityID.$number; ?>" name="activity_data_id[]" value="<?php echo $activity->activity; ?>" >                                                                                   

                                            <td class="sticky-col third-col">
                                                <a href="javascript:void(0)" id="component-<?php echo $activity->activityID.$number; ?>" data-component-row="<?php echo $activity->activityID.$number; ?>" name="component" class="md-btn md-btn-success main-assembly"><?php echo $activity->assembly; ?></a>
                                            </td>  
                                            
                                            <td class="fourth-col">
                                                <select name="quantity[]" id="quantity-<?php echo $activity->activityID.$number; ?>" class="table-select-dd get_total_time_class_assembly">
                                                    <option value="<?php echo '0,'.$activity->activityID.','.$number; ?>"<?=$activity->quantity == 0 ? ' selected="selected"' : '';?>>0</option> 
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
                                            
                                                <input type="text" name="total_time[]" id="total_time-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time auto-field" value="<?php echo $activity->total_time; ?>">
                                                <input type="hidden" name="total_time_hidden[]" id="total_time_hidden-<?php echo $activity->activityID.$number;  ?>" class="table-text-box-time" value="<?php echo $activity->total_time_hidden; ?>">                                                
                                            </td>

                                            <td class="fifth-col">
                                                <select name="supervisor[]" id="supervisor-<?php echo $activity->activityID.$number; ?>" class="">
                                                    <?php
                                                        foreach($prod_dept_supervisors as $supervisor){
                                                    ?>
                                                        <option value="<?php echo $supervisor->userId; ?>"<?=$activity->supervisor == $supervisor->userId ? ' selected="selected"' : '';?>><?php echo $supervisor->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td class="six-col">
                                                <select name="clientApproval[]" id="clientApproval-<?php echo $activity->activityID.$number; ?>" class="approval-select-box">                                                                                  
                                                    <option value="pending"<?=$activity->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                          
                                                    <option value="yes"<?=$activity->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                          
                                                    <option value="na"<?=$activity->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                                </select>                                            
                                            </td>

                                            <td class="seven-col">
                                                <select name="mfg_type[]" id="mfg_type-<?php echo $activity->activityID.$number; ?>" class="table-text-box">                                                                                  
                                                    <option value="outsource"<?=$activity->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                              
                                                    <option value="inhouse"<?=$activity->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>Inhouse</option>                                                                                          
                                                    <option value="partoutsource"<?=$activity->mfg_type == 'partoutsource' ? ' selected="selected"' : '';?>>Partly Outsourced</option>                                                                                                                                                                          
                                                </select>
                                            </td>

                                            <td class="eight-col">
                                                <a href="javascript:void(0)" class="update_assembly_act_class" data-uk-tooltip title="Update"  data-current-row="<?php echo $activity->activityID.$number; ?>" name="update_activity-<?php echo $activity->activityID; ?>" id="update_activity-<?php echo $activity->activityID; ?>" ><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                                <a href="javascript:void(0)" class="duplicate_current_assembly_class" title="Duplicate Assembly" data-current-row-duplicate = "<?php echo $activity->activityID.$number; ?>" name="duplicate_component-<?php echo $activity->activityID; ?>" id="duplicate_component-<?php echo $activity->activityID; ?>"><i class="md-icon material-icons md-24">&#xE146;</i></a> 
                                                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_assembly_activity(<?php echo $activity->activityID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                                <a href="javascript:void(0)" class="all_update_sub_assembly_class" data-uk-tooltip title="Update All"  data-current-row="<?php echo $activity->activityID.$number; ?>" name="all_update_sub_assembly-<?php echo $activity->activityID; ?>" id="all_sub_assembly-<?php echo $activity->activityID; ?>"><i class="material-icons md-24 md-color-orange-400">&#xe877;</i></a>
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

                            <!-- Sub activity listing -->
                                        <?php
                                            $this->load->model('production_window_model');
                                            $project_id = $activity->projectID;
                                            $project_equipment_id = $activity->projectequipment;
                                            $activity_id = $activity->activityID;
                                            $component_id = $activity->subassemblyID; // from assembly activity master table
                                            
                                            $get_assembly_data = $this->production_window_model->get_sub_assembly_activity_data($project_id, $project_equipment_id, $activity_id, $component_id);
                                            if($get_assembly_data){
                                        ?>
                                        <!-- <table id="assembly_activity"> -->
                                            <thead class="main-assembly-table-head-<?php echo $activity->activityID.$number; ?> main-assembly-table-head-init" id="main-assembly-table-head-init">
                                                <tr>  
                                                    <th class="sticky-col first-col-header"></th>                                                                                                  
                                                    <th class="sticky-col second-col-header"></th>                                                       
                                                    <th class="header_design_next sticky-col third-col-header"> Sub Activity</th>                                                    
                                                    <th class="header_design_next">Activity Time Required</th>
                                                    <th class="header_design_next" >Start Date & Time</th>
                                                    <th class="header_design_next" >Target Date & Time</th>
                                                    <th class="header_design_next" >Manpower</th>                                                    
                                                    <th class="header_design_next" >Responsible Person</th>                                                   
                                                    <th class="header_design_next" >TPI Internal <br/> QC Remark</th> 
                                                    <th class="header_design_next" >Client <br/> Approval</th>                                                                                                       
                                                    <th class="header_design_next" >Manufacturing <br/> Type</th>
                                                    <th class="header_design_next">Action</th>                                            
                                                </tr>
                                            </thead>

                                            <tbody class="main-assembly-table-body-<?php echo $activity->activityID.$number; ?> main-assembly-table-body-init" id="main-assembly-table-body-init">                                              
                                                <!-- <form id="sub_activity_form" name="sub_activity_form" method="POST"> -->
                                                <?php
                                                    $sr_no_ass = 1;
                                                    $sr_no_for_assembly = 1000;
                                                    $total_skill_cnt = 0;
                                                    $prev_target_date = '';
                                                    foreach($get_assembly_data as $assembly){
                                                        array_push($assembly_id_array, $assembly->assemblyID);  
                                                        $total_skill_cnt = explode(",", $assembly->skill);
                                                        $total_skill_cnt = count($total_skill_cnt); 
                                                        $sr_no_for_assembly++;
                                                ?>  
                                                    <tr>
                                                        <input type="hidden" id="activity_id-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="activity_id[]" value="<?php echo $activity->activityID; ?>" >
                                                        <input type="hidden" id="main_activity_id-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="main_activity_id[]" value="<?php echo $assembly->activity; ?>" >
                                                        <input type="hidden" id="sub_activity_id-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="sub_activity_id[]" value="<?php echo $assembly->sub_activity; ?>" >
                                                        <input type="hidden" id="activity_qty-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" value="<?php echo $activity->quantity; ?>" >
                                                        <td class="sticky-col first-col"></td>
                                                        <td class="sticky-col second-col"></td>
                                            <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                            <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                            <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >                                            
                                            <input type="hidden" id="activity_data-<?php echo $activity->activityID.$number; ?>" name="activity_data[]" value="<?php echo $activity->activity; ?>" >
                                            <input type="hidden" id="activity_data_id-<?php echo $activity->activityID.$number; ?>" name="activity_data_id[]" value="<?php echo $activity->activity; ?>" >                                                                                   

                                                        <!-- <td></td> -->
                                                        <!-- <td class="header_design"><?php //echo $sr_no_ass; ?></td> -->
                                                        <td class="sticky-col third-col">
                                                            <?php 
                                                                if($assembly->is_all_updated == 1){ ?>
                                                                    <div class="updated_class">
                                                                        <?php 
                                                                            echo $sr_no_ass.'.  '.wordwrap($assembly->assembly_activity,30,'<br/>',false);
                                                                        ?>
                                                                    </div>
                                                                <?php }else{ ?>
                                                                    <div class="not_updated_class" id="not_updated_id-<?php echo $assembly->assemblyID; ?>">
                                                                        <?php echo $sr_no_ass.'.  '.wordwrap($assembly->assembly_activity,30,'<br/>',false); ?>
                                                                    </div>
                                                            <?php } 
                                                                
                                                            ?>
                                                    
                                                            <input type="hidden" id="sub_activity-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="sub_activity[]" value="<?php echo $assembly->assembly_activity; ?>">
                                                            <input type="hidden" id="assemblyID-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="assemblyID[]" value="<?php echo $assembly->assemblyID; ?>">
                                                        </td>                                                                                                                                        

                                                        <td>
                                                            <select name="activity_days[]" id="activity_days-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="table-select-dd activity_days_class">
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

                                                            <select name="activity_time_hours[]" id="activity_time_hours-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="table-select-dd activity_time_hours_class">                                                
                                                                <?php
                                                                    for($hours=0; $hours<=16; $hours++){                                                        
                                                                        if(strlen($hours) == 1)
                                                                            $hours = '0'.$hours;                                                                                      
                                                                ?>
                                                                    <option value="<?php echo $hours; ?>"<?=$assembly->activity_time_hours == $hours ? ' selected="selected"' : '';?>><?php echo $hours.' hrs'; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <select name="activity_time_minutes[]" id="activity_time_minutes-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="table-select-dd activity_time_minutes_class">                                                
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
                                                            <?php 
                                                                $prev_start_date = '';
                                                                if(isset($assembly->startDate) && !empty($assembly->startDate)){
                                                                    $prev_start_date = $assembly->startDate;
                                                                }else{
                                                                    $prev_start_date = $prev_target_date;
                                                                }
                                                            ?>   
                                                            <div id="assembly_startDate_time-<?php echo $assembly->assemblyID; ?>" name="assembly_startDate_time">                                                                                                                                                                                            
                                                                <input class="startDate" type="text" name="startDate[]" id="startDate-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" value="<?php echo $prev_start_date; ?>" style="width:160px;">                                                                
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>
                                                                <a href="javascript:void(0)" data-current-row="<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="get_target_date" id="get_target_date-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="get_assembly_target_date_class"><i class="md-icon material-icons" style="color:#f88c3b;">forward</i></a>
                                                            </div>                                            
                                                        </td>
                                                        
                                                        <td>
                                                            <input type="text" data-current-row="<?php echo $assembly->assemblyID; ?>" name="targetDate[]" id="targetDate-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="target_date_class" value="<?php echo $assembly->targetDate; ?>" style="width:200px;">                                            
                                                        </td>
                                                    
                                                        <td>
                                                            <input type="text" name="manpower[]" id="manpower-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="table-manpower-input" value="<?php echo $assembly->manpower; ?>" disabled>
                                                        </td>                                                       

                                                        <td id="hide-on-scroll">
                                                            <?php 
                                                                $activitySkills = $this->production_window_model->get_production_skill_assembly_employee($assembly->activity, $assembly->sub_activity);  // pass activity id to get that activity skills list

                                                                // echo '<pre>';
                                                                // print_r($activitySkills);                                                                                         
                                                                $options        = array();
                                                                $options[""]    = "";
                                                                $selectedItemId = explode(',',$assembly->resp_persons);
                                                                foreach($activitySkills as $skills){
                                                                    // echo $skills->skill;
                                                                    // if($skills->totalSkills >= $total_skill_cnt){                                                        
                                                                        $options[$skills->userId] = $skills->name;
                                                                    // }  
                                                                    // print_r($skills->totalSkills);                                             
                                                                    // print_r($total_skill_cnt);            
                                                                }     
                                                                //  echo '<pre>';                                         
                                                                // print_r($options); 
                                                                echo form_multiselect("person_name_id[$assembly->assemblyID][]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown person_name_class_assembly", "data-row-number" => $assembly->assemblyID.$sr_no_for_assembly, 'id' => 'person_name_id-'.$assembly->assemblyID.$sr_no_for_assembly));
                                                                // echo form_multiselect("person_name_id[$activity->activityID][]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown person_name_class", "data-row-number" => $activity->activityID.$number, 'id' => 'person_name_id-'.$activity->activityID.$number));                                                
                                                            ?>                                            
                                                        </td>                                                                                                                                                                        

                                                        <td>
                                                            <select id="tpi_qc_remark-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" name="tpi_qc_remark[]" class="table-text-box">                                                    
                                                                <option value="pending"<?=$assembly->tpi_qc_remark == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                                <option value="approved"<?=$assembly->tpi_qc_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>
                                                                <option value="na"<?=$assembly->tpi_qc_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                
                                                            </select>                                                
                                                        </td>

                                                        <td>
                                                            <select name="clientApproval[]" id="clientApproval-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="approval-select-box">                                                                                  
                                                                <option value="pending"<?=$assembly->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                      
                                                                <option value="yes"<?=$assembly->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                                      
                                                                <option value="na"<?=$assembly->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                                            </select>
                                                        </td>                                                       

                                                        <td>
                                                            <select name="mfg_type[]" id="mfg_type-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" class="table-text-box">                                                                                  
                                                                <option value="inhouse"<?=$assembly->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>In House</option>                                      
                                                                <option value="outsource"<?=$assembly->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                          
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <a href="javascript:void(0)" class="update_assembly_activity_class update_total_time-<?php echo $activity->activityID.$number; ?>" data-uk-tooltip title="Update" data-current-act-days="<?php echo $assembly->activity_days; ?>" data-current-act-hours ="<?php echo $assembly->activity_time_hours; ?>" data-current-act-minutes="<?php echo $assembly->activity_time_minutes; ?>" data-current-order="<?php echo $assembly->sub_act_order; ?>"  data-current-row="<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" data-current-comp="<?php echo $activity->activityID.$number; ?>" name="update_assembly-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>" id="update_assembly-<?php echo $assembly->assemblyID.$sr_no_for_assembly; ?>"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                                            <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_sub_assembly_data(<?php echo $assembly->assemblyID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>,<?php echo $assembly->assemblyID; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                                        </td>                                                                                             
                                                    </tr>
                                                <?php
                                                    $sr_no_ass++;
                                                    $prev_target_date = $assembly->targetDate;
                                                } ?>
                                            <!-- </form> -->
                                            </tbody>
                                        <!-- </table> -->
                                    <?php }
                                    } 
                                }else{ ?>                                        
                                    <?php } ?>
                                </tbody>
                            </table>                        
                        </form>                    
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
    var activityID = totalSkills = 0;        
    var js_activity_id_array = [];   
    js_activity_id_array =<?php echo json_encode($activity_id_array );?>;                   
    var js_assembly_id_array = [];   
    js_assembly_id_array =<?php echo json_encode($assembly_id_array );?>;                   

    $(document).ready(function(){           
        $('#add_production_activity_form').submit(function(){
            $("#add_production_activity_form :disabled").removeAttr('disabled');
        });         
        
        $('.person_name_class').on('change', function() {  
            var resp_persons_cnt = $(this).val();  // get no of responsible persons
            var get_row_id = $(this).attr("data-row-number");            
            var id = "#manpower-"+get_row_id;            
            if(resp_persons_cnt){
                resp_persons_cnt = resp_persons_cnt.length;                               
                $(id).val(resp_persons_cnt);               
            }else{
                var val = 0;
                $(id).val(val);
            }                       
        });  

        $('.person_name_class_assembly').on('change', function() {  
            var resp_persons_cnt = $(this).val();  // get no of responsible persons
            var get_row_id = $(this).attr("data-row-number");            
            var id = "#manpower-"+get_row_id;            
            if(resp_persons_cnt){
                resp_persons_cnt = resp_persons_cnt.length;                               
                $(id).val(resp_persons_cnt);               
            }else{
                var val = 0;
                $(id).val(val);
            }                       
        }); 

        $('.main-component').click(function(){        
            var get_row_id = $(this).attr("data-component-row");
            console.log(get_row_id);
            var table_head = '.assembly-table-head-'+get_row_id;
            var table_body = '.assembly-table-body-'+get_row_id;
            $(table_head).fadeToggle();
            $(table_body).fadeToggle();
        });  

        $('.main-assembly').click(function(){        
            var get_row_id = $(this).attr("data-component-row");
            console.log(get_row_id);
            var table_head = '.main-assembly-table-head-'+get_row_id;
            var table_body = '.main-assembly-table-body-'+get_row_id;
            $(table_head).fadeToggle();
            $(table_body).fadeToggle();
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

    // for assembly activity row re ordering
    $('.set_assembly_row_order').on('change', function() {
        var row_order_activityID = $(this).val();        
        var row_order = row_order_activityID.split(',')[0];
        var activityID = row_order_activityID.split(',')[1];
        // console.log(row_order);
        // console.log(activityID);

        if(row_order > 0 && activityID > 0){
            var aUrl = base_url+'productionwindow/updateAssemblyActivityOrder'; 
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
        console.log(get_row_id1);
        var get_row_id = activityID+number;        
        console.log(get_row_id);

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

    $('.get_total_time_class_assembly').on('change',function(){  
        // var get_row_id = $(this).attr("data-current-row-time");
        var get_row_id1 = $(this).val();
        var quantity = get_row_id1.split(',')[0];
        var activityID = get_row_id1.split(',')[1];
        var number = get_row_id1.split(',')[2];
        // console.log(get_row_id1);

        var get_row_id = activityID+number;        
        // console.log(get_row_id);

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

    $('.duplicate_current_assembly_class').click(function(){        
        var get_row_id = $(this).attr("data-current-row-duplicate");
        var activityID = '#activityID-'+get_row_id;
        activityID = $(activityID).val();
        // console.log(activityID);
        swal({
            title: "Are you sure to Duplicate Assembly Activity?",                            
            buttons: true,            
        }).then((willDelete) => {
        if(willDelete){
                if(activityID > 0){
                    var aUrl = base_url+'productionwindow/duplicateAssemblyActvt'; 
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
     
    var sdate_number=0;
    var id_rest = '';
    js_activity_id_array.forEach(function(item) {
        sdate_number++;                        
        id_rest = "#startDate_time-"+item;
        $(id_rest).datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'English',
            // useCurrent: false,
            // defaultDate: '',
            autoclose: true, 
            // changeMonth: true,
            // changeYear: true,        
        })
        .on("change", function() {
            $(this).datetimepicker('remove');
        });       
    });

    var sdate_number1 = 0;
    var id_rest1 = '';
    js_assembly_id_array.forEach(function(item) {
        sdate_number1++;                        
        id_rest1 = "#assembly_startDate_time-"+item;
        $(id_rest1).datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'English',
            // useCurrent: false,
            // defaultDate: '',
            autoclose: true, 
            // changeMonth: true,
            // changeYear: true,        
        })
        .on("change", function() {
            $(this).datetimepicker('remove');
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
    
    









// component
    $('.get_target_date_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");
        var startDate_time = "#startDate-"+get_row_id;
        var start_date = $(startDate_time).val(); 

        var targetDate = "#targetDate-"+get_row_id;        

        var activity_days = "#activity_days-"+get_row_id;
        activity_days = $(activity_days).val(); 

        var activity_time_hours = "#activity_time_hours-"+get_row_id;
        activity_time_hours = $(activity_time_hours).val(); 

        var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        activity_time_minutes = $(activity_time_minutes).val();  

        activity_time_minutes = Number(activity_time_minutes);        

        var total_act_hours = activity_days*16 + Number(activity_time_hours);
        total_act_hours = Number(total_act_hours);           
      
        var final_date = get_date = get_formt_hours = get_formt_minutes = '';       

        // if no of hours and minutes set for activity
        if((total_act_hours > 0 && activity_time_minutes > 0) || (total_act_hours > 0 && activity_time_minutes <= 0)){
            if(start_date != ''){
                $('#all_field_validation').html('');     
                var shift_start_time = 7;
                var shift_end_time = 23;
                var i = 0;
               
                var total_time_for_next_day = 1;
                var start_date_format = new Date(start_date);                                  
                for(i = 1; i <= total_act_hours; i++){
                    
                    var get_hours = start_date_format.setHours(start_date_format.getHours() + total_time_for_next_day);            
                    var get_minutes = start_date_format.setMinutes(start_date_format.getMinutes() + activity_time_minutes);
                        get_minutes = new Date(get_minutes);                        
                        get_minutes = convertToDateTime(get_minutes);

                        get_date =  get_minutes.substr(0,10);
                        get_formt_hours = get_minutes.substr(11,2);
                        get_formt_minutes = get_minutes.substr(14,2);    
                    
                    if(get_formt_hours <= shift_end_time){
                        final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes; 
                        start_date_format = new Date(final_date);
                        total_time_for_next_day = 1;                        
                    }else{
                        total_time_for_next_day = 22;                        
                        total_act_hours = total_act_hours+1;                        
                    }
                    activity_time_minutes = 0;                   
                }
                
                final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes;                                   
                $(targetDate).val(final_date); 

            }else{
                $('#all_field_validation').html('Please Select Start Date first..');
                $(targetDate).val(''); 
            }
        }
        // if activity time in minutes only
        else if(total_act_hours <= 0 && activity_time_minutes > 0){
            var start_date_format = new Date(start_date);
            var get_hours = start_date_format.setHours(start_date_format.getHours() + 0);            
            var get_minutes = start_date_format.setMinutes(start_date_format.getMinutes() + activity_time_minutes);
                get_minutes = new Date(get_minutes);
                get_minutes = convertToDateTime(get_minutes);

                get_date =  get_minutes.substr(0,10);
                get_formt_hours = get_minutes.substr(11,2);
                get_formt_minutes = get_minutes.substr(14,2);  
                final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes;                                   
                $(targetDate).val(final_date); 
        }else{
            $(targetDate).val(start_date); 
        }      
    });  
       

    $('.get_assembly_target_date_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");
        var startDate_time = "#startDate-"+get_row_id;
        var start_date = $(startDate_time).val(); 

        var targetDate = "#targetDate-"+get_row_id;        

        var activity_days = "#activity_days-"+get_row_id;
        activity_days = $(activity_days).val(); 

        var activity_time_hours = "#activity_time_hours-"+get_row_id;
        activity_time_hours = $(activity_time_hours).val(); 

        var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        activity_time_minutes = $(activity_time_minutes).val();  

        activity_time_minutes = Number(activity_time_minutes);        

        var total_act_hours = activity_days*16 + Number(activity_time_hours);
        total_act_hours = Number(total_act_hours);           
      
        var final_date = get_date = get_formt_hours = get_formt_minutes = '';       

        // if no of hours and minutes set for activity
        if((total_act_hours > 0 && activity_time_minutes > 0) || (total_act_hours > 0 && activity_time_minutes <= 0)){
            if(start_date != ''){
                $('#all_field_validation').html('');     
                var shift_start_time = 7;
                var shift_end_time = 23;
                var i = 0;
               
                var total_time_for_next_day = 1;
                var start_date_format = new Date(start_date);                                  
                for(i = 1; i <= total_act_hours; i++){
                    
                    var get_hours = start_date_format.setHours(start_date_format.getHours() + total_time_for_next_day);            
                    var get_minutes = start_date_format.setMinutes(start_date_format.getMinutes() + activity_time_minutes);
                        get_minutes = new Date(get_minutes);                        
                        get_minutes = convertToDateTime(get_minutes);

                        get_date =  get_minutes.substr(0,10);
                        get_formt_hours = get_minutes.substr(11,2);
                        get_formt_minutes = get_minutes.substr(14,2);    
                    
                    if(get_formt_hours <= shift_end_time){
                        final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes; 
                        start_date_format = new Date(final_date);
                        total_time_for_next_day = 1;                        
                    }else{
                        total_time_for_next_day = 22;                        
                        total_act_hours = total_act_hours+1;                        
                    }
                    activity_time_minutes = 0;                   
                }
                
                final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes;                                   
                $(targetDate).val(final_date); 

            }else{
                $('#all_field_validation').html('Please Select Start Date first..');
                $(targetDate).val(''); 
            }
        }
        // if activity time in minutes only
        else if(total_act_hours <= 0 && activity_time_minutes > 0){
            var start_date_format = new Date(start_date);
            var get_hours = start_date_format.setHours(start_date_format.getHours() + 0);            
            var get_minutes = start_date_format.setMinutes(start_date_format.getMinutes() + activity_time_minutes);
                get_minutes = new Date(get_minutes);
                get_minutes = convertToDateTime(get_minutes);

                get_date =  get_minutes.substr(0,10);
                get_formt_hours = get_minutes.substr(11,2);
                get_formt_minutes = get_minutes.substr(14,2);  
                final_date = get_date+' '+get_formt_hours+':'+get_formt_minutes;                                   
                $(targetDate).val(final_date); 
        }else{
            $(targetDate).val(start_date); 
        }
    });   
    

    $('.update_assembly_activity_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  
        // console.log(get_row_id);
        var get_comp_row = $(this).attr("data-current-comp");
        // console.log(get_comp_row);
        var this_sub_act_order = $(this).attr("data-current-order");
        
        var this_sub_act_days = $(this).attr("data-current-act-days");
        var this_sub_act_hours = $(this).attr("data-current-act-hours");
        var this_sub_act_minutes = $(this).attr("data-current-act-minutes");
        var total_sub_act_time_before_update = (Number(this_sub_act_days)*16*60) + (Number(this_sub_act_hours*60)) + Number(this_sub_act_minutes);            
        // console.log(total_sub_act_time_before_update);
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

        var total_sub_act_time_after_update = (Number(activity_days)*16*60) + (Number(activity_time_hours*60)) + Number(activity_time_minutes);            

        var activity_qty = "#activity_qty-"+get_row_id;
            activity_qty = $(activity_qty).val();             
            
        var startDate = "#startDate-"+get_row_id;
        startDate = $(startDate).val(); 

        var targetDate = "#targetDate-"+get_row_id;
            targetDate = $(targetDate).val(); 
            
        var manpower = "#manpower-"+get_row_id;
        manpower = $(manpower).val(); 
 
        var person_name_id = "#person_name_id-"+get_row_id;
            person_name_id = $(person_name_id).val();          
            
            var tpi_qc_remark = "#tpi_qc_remark-"+get_row_id;
            tpi_qc_remark = $(tpi_qc_remark).val(); 

        var clientApproval = "#clientApproval-"+get_row_id;
            clientApproval = $(clientApproval).val(); 

            // var prod_release = "#prod_release-"+get_row_id;
        //     prod_release = $(prod_release).val(); 

        var mfg_type = "#mfg_type-"+get_row_id;
            mfg_type = $(mfg_type).val();  

        var not_updated_id = "div#not_updated_id-"+get_row_id;
        var aUrl = base_url+'productionwindow/updateAssemblySubActivity';

        if(startDate != '' && targetDate != '' && manpower > 0){
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",           
                data: { 'projectID':projectID,'projectequipment':projectequipment, 'assemblyID':assemblyID, 'activity_id':activity_id, 'main_activity_id':main_activity_id, 'sub_activity_id':sub_activity_id, 'sub_activity':sub_activity, 'person_name_id':person_name_id, 'manpower':manpower,'targetDate':targetDate, 'startDate':startDate,'activity_time_minutes':activity_time_minutes, 'activity_time_hours':activity_time_hours,'activity_days':activity_days, 'tpi_qc_remark':tpi_qc_remark, 'clientApproval':clientApproval, 'mfg_type':mfg_type},

                success: function(data, textStatus, jqXHR){ 
                    if(data.assemblyID > 0){                                                      
                        $(not_updated_id).removeClass("not_updated_class");
                                
                        // get sum of all activity time and update it to main activity(component) total time
                        var aUrl_new = base_url+'productionwindow/updateAssemblyActivityTime';                              
                        $.ajax({
                            url : aUrl_new,
                            type: "POST",
                            dataType: "JSON",           
                            data: { 'projectID':projectID,'projectequipment':projectequipment, 'activity_id':activity_id, 'main_activity_id':main_activity_id, 'activity_qty':activity_qty, 'this_sub_act_order':this_sub_act_order, 'total_sub_act_time_before_update':total_sub_act_time_before_update,'total_sub_act_time_after_update':total_sub_act_time_after_update, 'targetDate':targetDate },
                            success: function(data, textStatus, jqXHR){ 
                                swal("Sub Assembly Activity Updated Successfully!!").then((value) => {
                                    var total_time = "#total_time-"+get_comp_row;
                                    var total_time_hidden = "#total_time_hidden-"+get_comp_row;
                                    
                                    $(total_time).val(data.total_time);
                                    $(total_time_hidden).val(data.final_time);


                                    window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                                                                                                                                                                                   
                                });
                            },                               
                            error: function (jqXHR, textStatus, errorThrown){                                        
                            }
                        });                                 
                    }else{
                        swal({
                            title: "Something went wrong.. Please try again33!",                        
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        });
                    }                                                                               
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal({
                        title: "Something went wrong.. Please try again22!!",                        
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }
            }); 
        }else{
            swal({
                title: "Please enter all fields and try again!!",                
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });
        }
        
        });  
    
    $('.update_activity_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  
        // console.log(get_row_id);
        
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

        // var ind_time = "#ind_time-"+get_row_id;
        // ind_time = $(ind_time).val();
        
        // var ind_time_hidden = "#ind_time_hidden-"+get_row_id;
        // ind_time_hidden = $(ind_time_hidden).val();

        var total_time = "#total_time-"+get_row_id;
        total_time = $(total_time).val(); 

        var total_time_hidden = "#total_time_hidden-"+get_row_id;
        total_time_hidden = $(total_time_hidden).val();  
        
        // var total_time_save = "#total_time_save-"+get_row_id;
        // $(total_time_save).removeAttr('disabled');
        // total_time_save = $(total_time_save).val();  

        var clientApproval = "#clientApproval-"+get_row_id;
        clientApproval = $(clientApproval).val();
        
        // var prod_release = "#prod_release-"+get_row_id;
        // prod_release = $(prod_release).val();

        var mfg_type = "#mfg_type-"+get_row_id;
        mfg_type = $(mfg_type).val();

        var aUrl = base_url+'productionwindow/updateActivity';        
        // console.log(clientApproval);
        // console.log(mfg_type);
        // console.log(supervisor);
        $.ajax({
            url : aUrl,
            type: "POST",
            dataType: "JSON",
            data: {'activityID':activityID, 'activity_data_id':activity_data_id, 'projectID':projectID, 'projectequipment':projectequipment, 'supervisor':supervisor, 'quantity':quantity, 'total_time_hidden':total_time_hidden, 'total_time':total_time, 'clientApproval':clientApproval, 'mfg_type':mfg_type},

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


    $('.update_assembly_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  
        var get_comp_row = $(this).attr("data-current-comp");
        var this_sub_act_order = $(this).attr("data-current-order");
    
        var this_sub_act_days = $(this).attr("data-current-act-days");
        var this_sub_act_hours = $(this).attr("data-current-act-hours");
        var this_sub_act_minutes = $(this).attr("data-current-act-minutes");
        var total_sub_act_time_before_update = (Number(this_sub_act_days)*16*60) + (Number(this_sub_act_hours*60)) + Number(this_sub_act_minutes);            
        // console.log(total_sub_act_time_before_update);
        
                                                    
    
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
    
        var total_sub_act_time_after_update = (Number(activity_days)*16*60) + (Number(activity_time_hours*60)) + Number(activity_time_minutes);            
    
        var activity_qty = "#activity_qty-"+get_row_id;
            activity_qty = $(activity_qty).val();             
    
        var startDate = "#startDate-"+get_row_id;
            startDate = $(startDate).val(); 
    
        var targetDate = "#targetDate-"+get_row_id;
            targetDate = $(targetDate).val(); 
    
        var manpower = "#manpower-"+get_row_id;
            manpower = $(manpower).val(); 
    
        var person_name_id = "#person_name_id-"+get_row_id;
            person_name_id = $(person_name_id).val();          
    
        var tpi_qc_remark = "#tpi_qc_remark-"+get_row_id;
            tpi_qc_remark = $(tpi_qc_remark).val(); 
    
        var clientApproval = "#clientApproval-"+get_row_id;
            clientApproval = $(clientApproval).val(); 
    
        // var prod_release = "#prod_release-"+get_row_id;
        //     prod_release = $(prod_release).val(); 
    
        var mfg_type = "#mfg_type-"+get_row_id;
            mfg_type = $(mfg_type).val();  
    
        var not_updated_id = "div#not_updated_id-"+get_row_id;
        var aUrl = base_url+'productionwindow/updateAssembly';                
    
        if(startDate != '' && targetDate != '' && manpower > 0){
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",           
                data: { 'projectID':projectID,'projectequipment':projectequipment, 'assemblyID':assemblyID, 'activity_id':activity_id, 'main_activity_id':main_activity_id, 'sub_activity_id':sub_activity_id, 'sub_activity':sub_activity, 'person_name_id':person_name_id, 'manpower':manpower,'targetDate':targetDate, 'startDate':startDate,'activity_time_minutes':activity_time_minutes, 'activity_time_hours':activity_time_hours,'activity_days':activity_days, 'tpi_qc_remark':tpi_qc_remark, 'clientApproval':clientApproval, 'mfg_type':mfg_type},
    
                success: function(data, textStatus, jqXHR){ 
                    console.log(data);
                    if(data.assemblyID >0){                                                      
                        $(not_updated_id).removeClass("not_updated_class");
                                
                        // get sum of all activity time and update it to main activity(component) total time
                        var aUrl_new = base_url+'productionwindow/updateComponentActivityTime';                              
                        $.ajax({
                            url : aUrl_new,
                            type: "POST",
                            dataType: "JSON",           
                            data: { 'projectID':projectID,'projectequipment':projectequipment, 'activity_id':activity_id, 'main_activity_id':main_activity_id, 'activity_qty':activity_qty, 'this_sub_act_order':this_sub_act_order, 'total_sub_act_time_before_update':total_sub_act_time_before_update,'total_sub_act_time_after_update':total_sub_act_time_after_update, 'targetDate':targetDate },
                            success: function(data, textStatus, jqXHR){ 
                                swal("Sub Activity Updated Successfully!!").then((value) => {
                                    var total_time = "#total_time-"+get_comp_row;
                                    var total_time_hidden = "#total_time_hidden-"+get_comp_row;
                                    
                                    $(total_time).val(data.total_time);
                                    $(total_time_hidden).val(data.final_time);
                                    
                                  window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                                                                                                                                                                                   
                                });
                            },                               
                            error: function (jqXHR, textStatus, errorThrown){                                        
                            }
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
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });
        }
    
    }); 
    
    



// update* 
$('.all_update_assembly_class').click(function() {
        // Create a new FormData object
        var formData = new FormData();
               
        var get_row_id = $(this).attr("data-current-row");
        
        // var projectID = "<?php echo $project_id_global; ?>";
        // var projectequipment = "<?php echo $project_eqpid_global; ?>"; 
        
        // var activity_id = "#activity_id-"+get_row_id; //prod window table activity id
        // activity_id = $(activity_id).val();

        // var main_activity_id = "#main_activity_id-"+get_row_id; // 
        //     main_activity_id = $(main_activity_id).val();
        
        // var activity_qty = "#activity_qty-"+get_row_id;
        // activity_qty = $(activity_qty).val(); 

        // var this_sub_act_order = $(this).attr("data-current-order");

        // var this_sub_act_days = $(this).attr("data-current-act-days");
        // var this_sub_act_hours = $(this).attr("data-current-act-hours");
        // var this_sub_act_minutes = $(this).attr("data-current-act-minutes");
        // var total_sub_act_time_before_update = (Number(this_sub_act_days)*16*60) + (Number(this_sub_act_hours*60)) + Number(this_sub_act_minutes);            
        
        // var activity_days = "#activity_days-"+get_row_id;
        //     activity_days = $(activity_days).val();  
    
        // var activity_time_hours = "#activity_time_hours-"+get_row_id;
        //     activity_time_hours = $(activity_time_hours).val();        
    
        // var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        //     activity_time_minutes = $(activity_time_minutes).val();    
    
        // var total_sub_act_time_after_update = (Number(activity_days)*16*60) + (Number(activity_time_hours*60)) + Number(activity_time_minutes);            
    
        // var targetDate = "#targetDate-"+get_row_id;
        // targetDate = $(targetDate).val();
        // {
        //         var supervisor = "#supervisor-"+get_row_id;
        //         supervisor = $(supervisor).val();        

        //         var quantity = "#quantity-"+get_row_id;
        //         quantity = $(quantity).val();
        //         quantity = quantity.split(',')[0];  

        //         var total_time = "#total_time-"+get_row_id;
        //         total_time = $(total_time).val(); 

        //         var total_time_hidden = "#total_time_hidden-"+get_row_id;
        //         total_time_hidden = $(total_time_hidden).val();  

        //         var clientApproval_act = "#clientApproval-"+get_row_id;
        //         clientApproval_act = $(clientApproval_act).val();

        //         var mfg_type_act = "#mfg_type-"+get_row_id;
        //         mfg_type_act = $(mfg_type_act).val();

        //         formData.append('mfg_type_act',mfg_type_act);
        //         formData.append('clientApproval_act',clientApproval_act);
        //         formData.append('total_time_hidden',total_time_hidden);
        //         formData.append('total_time',total_time);
        //         formData.append('quantity',quantity);
        //         formData.append('supervisor',supervisor);
        // }

     
    
    
    var tbodyClass = "assembly-table-body-" + $(this).attr("data-current-row"); 
    
    // Select all fields within tbody with the specified class
    $('tbody.' + tbodyClass + ' :input').each(function() {
        // Append each field to the FormData object
        formData.append($(this).attr('name'), $(this).val());
    });



    // Select all fields within tbody with the specified class
    $('tbody.' + tbodyClass).find('select').each(function() {
        // Append each field to the FormData object
        formData.append($(this).attr('name'), $(this).val());
    });

        // formData.append(activityID, activityID);

    // Now you can send formData to the server using AJAX or by submitting a form
    var aUrl = base_url+'productionwindow/all_updateActivity';   
    // Example of sending formData using AJAX
    $.ajax({
        url: aUrl,
        type: 'POST',
        data: formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function(data) {


                if(data.projectID >0){                                                      
                    swal("Activity Updated Successfully!!").then((value) => {
                        var firstButton = document.querySelector('.update_total_time-' + get_row_id);
                        if (firstButton) {
                            firstButton.click();
                        } else {
                            alert('Button Not Found!');
                        }
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
        error: function(xhr, status, error) {
            swal({
                title: "Please enter all fields and try again!!",
                // text: "Check if you have entered correct data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });
        }
        
    });
     
              
});

// ---------------------------------------------------------------------------------------------------
    $('.update_all_activity_class').click(function(){  
        $("#update_all_activity :disabled").removeAttr('disabled');
        $('.component').attr('disabled', true);                                                         
        var formData = new FormData($('#component_activity_form')[0]); 
        var aUrl = base_url+'productionwindow/updateAllActivityOnce';        
            swal({
                title: "Are you sure to update all activity?",                            
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
                                swal("Activity Updated Successfully.")
                                    .then((value) => {
                                        window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                                });
                            }else{
                                swal({
                                    title: "Please enter all fields and try again!!",                        
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
                                // text: "Check if you have entered correct data!",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            });
                        }                
                    }); 
                }
            });   
        });
     
    var i;
    var sdate_number=0;
    var id_rest = '';
    js_activity_id_array.forEach(function(item) {
        sdate_number++;                        
        id_rest = "#startDate_time-"+item+sdate_number;
        $(id_rest).datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'English',
            autoclose: true, 
            changeMonth: true,
            changeYear: true,        
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });
});














    $('.update_assembly_act_class').click(function(){  

        var get_row_id = $(this).attr("data-current-row");  
        // console.log(get_row_id);
        
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

        var total_time = "#total_time-"+get_row_id;
        total_time = $(total_time).val(); 

        var total_time_hidden = "#total_time_hidden-"+get_row_id;
        total_time_hidden = $(total_time_hidden).val();        

        var clientApproval = "#clientApproval-"+get_row_id;
        clientApproval = $(clientApproval).val();       

        var mfg_type = "#mfg_type-"+get_row_id;
        mfg_type = $(mfg_type).val();

        var aUrl = base_url+'productionwindow/updateAssemblyActivity';        
        // console.log(clientApproval);
        // console.log(mfg_type);
        // console.log(supervisor);
        $.ajax({
            url : aUrl,
            type: "POST",
            dataType: "JSON",
            data: {'activityID':activityID, 'activity_data_id':activity_data_id, 'projectID':projectID, 'projectequipment':projectequipment, 'supervisor':supervisor, 'quantity':quantity, 'total_time_hidden':total_time_hidden, 'total_time':total_time, 'clientApproval':clientApproval, 'mfg_type':mfg_type},

            success: function(data, textStatus, jqXHR){ 
                if(data.projectID > 0){
                    swal("Assembly Updated Successfully.")
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

    function save_assembly_activity(){
        var aUrl = base_url+'productionwindow/saveNewAssemblyActivity';
        var projectID = $('#projectID').val();
        var projectequipment = $('#projectequipment').val();
        var assembly = $('#assembly_id').val();       
        // console.log(activity);
        
        if(projectID > 0 && projectequipment > 0 && assembly != null){ 
            swal({
                title: "Are you sure to add assembly activity?",                
                // icon: "success",
                buttons: true,
                // dangerMode: true,
            }).then((willDelete) => {
                if(willDelete){
                    var formData = new FormData($('#add_production_assembly_activity_form')[0]);                                  
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
            $('#all_field_validation_assembly').html('Please Select Assembly..');
        }
    }

    // reorder level and order of component activity
    $('.reorder_component_class').click(function(){
        var formData = new FormData($('#component_activity_form')[0]); 
        var aUrl = base_url+'productionwindow/reorderComponentActivity';
                           
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
                    swal("Re-ordering Successfull.")
                        .then((value) => {
                            window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
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
                    title: "Something went wrong.. Please try again!!",
                    // text: "Check if you have entered correct data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            }                
        });             
    });
    
    // reorder level and order of assembly activity
    $('.reorder_assembly_class').click(function(){
        var formData = new FormData($('#main_assembly_activity_form')[0]); 
        var aUrl = base_url+'productionwindow/reorderAssemblyActivity';
                           
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
                    swal("Re-ordering Successfull.")
                        .then((value) => {
                            window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
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
                    title: "Something went wrong.. Please try again!!",
                    // text: "Check if you have entered correct data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            }                
        });             
    });


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

    function delete_assembly_activity(activityID,projectID,projectequipment)
    {
        var aUrl = base_url+'productionwindow/delete_new_assembly_activity';
        swal({
            title: "Are you sure to delete this assembly activity?",
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
            title: "Are you sure to delete sub activity?",            
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
    
    function delete_sub_assembly_data(assemblyID,projectID,projectequipment,get_row_id){         
        var aUrl = base_url+'productionwindow/delete_new_sub_assembly_data';
        swal({
            title: "Are you sure to delete sub assembly?",            
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

    $('.save_timeline').on('change', function(){        
        var aUrl = base_url+'productionwindow/saveProjectTimeline';
        var projectID = $('#project_id').val();
        var productionProjectStartDate = $('#productionProjectStartDate').val();
        var productionProjectEndDate = $('#productionProjectEndDate').val();  
        var productionActualStartDate = $('#productionActualStartDate').val();
        var productionActualEndDate = $('#productionActualEndDate').val();                
        
        // if(projectID > 0 && productionProjectStartDate <= productionProjectEndDate){                                                  
        if(projectID > 0){
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",               
                data: {'productionProjectStartDate':productionProjectStartDate, 'productionProjectEndDate':productionProjectEndDate, 'productionActualStartDate':productionActualStartDate, 'productionActualEndDate':productionActualEndDate, 'projectID':projectID },
                success: function(data){ 
                    $('#productionProjectStartDate').val(data.productionProjectStartDate);
                    $('#productionProjectEndDate').val(data.productionProjectEndDate);
                    $('#productionActualStartDate').val(data.productionActualStartDate);
                    $('#productionActualEndDate').val(data.productionActualEndDate);
                    // swal({
                    //     title: "Timeline saved..",                        
                    //     icon: "success",                                                
                    // });
                },

                error: function (jqXHR, textStatus, errorThrown){                       
                    swal({
                        title: "Something went wrong.. Please try again!!",
                        text: "Check if you have entered correct data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });              
                }
            });                
        }else{
            swal({                
                text: "Check if you have entered correct data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });  
        }
    });



    // update* 
$('.all_update_sub_assembly_class').click(function() {
        // Create a new FormData object
        var formData = new FormData();
               
        var get_row_id = $(this).attr("data-current-row");
        
        // var projectID = "<?php echo $project_id_global; ?>";
        // var projectequipment = "<?php echo $project_eqpid_global; ?>"; 
        
        // var activity_id = "#activity_id-"+get_row_id; //prod window table activity id
        // activity_id = $(activity_id).val();

        // var main_activity_id = "#main_activity_id-"+get_row_id; // 
        //     main_activity_id = $(main_activity_id).val();
        
        // var activity_qty = "#activity_qty-"+get_row_id;
        // activity_qty = $(activity_qty).val(); 

        // var this_sub_act_order = $(this).attr("data-current-order");

        // var this_sub_act_days = $(this).attr("data-current-act-days");
        // var this_sub_act_hours = $(this).attr("data-current-act-hours");
        // var this_sub_act_minutes = $(this).attr("data-current-act-minutes");
        // var total_sub_act_time_before_update = (Number(this_sub_act_days)*16*60) + (Number(this_sub_act_hours*60)) + Number(this_sub_act_minutes);            
        
        // var activity_days = "#activity_days-"+get_row_id;
        //     activity_days = $(activity_days).val();  
    
        // var activity_time_hours = "#activity_time_hours-"+get_row_id;
        //     activity_time_hours = $(activity_time_hours).val();        
    
        // var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        //     activity_time_minutes = $(activity_time_minutes).val();    
    
        // var total_sub_act_time_after_update = (Number(activity_days)*16*60) + (Number(activity_time_hours*60)) + Number(activity_time_minutes);            
    
        // var targetDate = "#targetDate-"+get_row_id;
        // targetDate = $(targetDate).val();
        // {
        //         var supervisor = "#supervisor-"+get_row_id;
        //         supervisor = $(supervisor).val();        

        //         var quantity = "#quantity-"+get_row_id;
        //         quantity = $(quantity).val();
        //         quantity = quantity.split(',')[0];  

        //         var total_time = "#total_time-"+get_row_id;
        //         total_time = $(total_time).val(); 

        //         var total_time_hidden = "#total_time_hidden-"+get_row_id;
        //         total_time_hidden = $(total_time_hidden).val();  

        //         var clientApproval_act = "#clientApproval-"+get_row_id;
        //         clientApproval_act = $(clientApproval_act).val();

        //         var mfg_type_act = "#mfg_type-"+get_row_id;
        //         mfg_type_act = $(mfg_type_act).val();

        //         formData.append('mfg_type_act',mfg_type_act);
        //         formData.append('clientApproval_act',clientApproval_act);
        //         formData.append('total_time_hidden',total_time_hidden);
        //         formData.append('total_time',total_time);
        //         formData.append('quantity',quantity);
        //         formData.append('supervisor',supervisor);
        // }

     
        
    
    var tbodyClass = "main-assembly-table-body-" + $(this).attr("data-current-row"); 
    
    // Select all fields within tbody with the specified class
    $('tbody.' + tbodyClass + ' :input').each(function() {
        // Append each field to the FormData object
        formData.append($(this).attr('name'), $(this).val());
    });



    // Select all fields within tbody with the specified class
    $('tbody.' + tbodyClass).find('select').each(function() {
        // Append each field to the FormData object
        formData.append($(this).attr('name'), $(this).val());
    });

        // formData.append(activityID, activityID);

    // Now you can send formData to the server using AJAX or by submitting a form
    var aUrl = base_url+'productionwindow/all_updateAssemblyActivity';
    // Example of sending formData using AJAX
    $.ajax({
        url: aUrl,
        type: 'POST',
        data: formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function(data) {


                if(data.projectID >0){                                                      
                    swal("Activity Updated Successfully!!").then((value) => {
                        var firstButton = document.querySelector('.update_total_time-' + get_row_id);
                        if (firstButton) {
                            firstButton.click();
                        } else {
                            alert('Button Not Found!');
                        }
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
        error: function(xhr, status, error) {
            swal({
                title: "Please enter all fields and try again!!",
                // text: "Check if you have entered correct data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });
        }
        
    });
     
              
});
</script>