<?php
    $activity_id_array = array();  
    $total_activity_count = 0;  
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
        width: calc(100% / 4);
    }

    form .input-box-new{
        margin-bottom: 10px;
        width: 100%;
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

    .padding-fordropdown {
	    padding-top: 0px !important;
    }

    .activity_data_col{
        padding-left:8px !important;
        padding-right:8px !important;
    }

/* Scroll lock for some columns starts here*/
    .sticky-col {
        /* position: -webkit-sticky; */
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
        width: 60px;
        min-width: 60px;
        max-width: 60px;
        left: 30px;        
    }

    .second-col {
        width: 60px;
        min-width: 60px;
        max-width: 60px;
        left: 30px;
        background-color: #ddd;
    }

    .third-col-header {
        width: 60px;
        min-width: 60px;
        max-width: 60px;
        left: 90px;        
    }

    .third-col {
        width: 60px;
        min-width: 60px;
        max-width: 60px;
        left: 90px;
        background-color: #ddd;
    }

    .fourth-col-header {
        width: 300px;
        min-width: 260px;
        max-width: 300px;
        left: 150px;                  
    }

    .fourth-col {
        width: 300px;
        min-width: 260px;
        max-width: 300px;
        left: 150px;          
        background-color: #ddd;        
    }
    
    .fifth-col {
        /* margin-left: 45px; */
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
                        <h1 class="md-card-toolbar-heading-text add-activity"> Add Design Activity
                        <a href="<?=base_url();?>add_new_project/add_project" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                        </h1>                          
                    </div>  

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">         
                                <form id="add_project_timeline" name="add_project_timeline" action="#" method="post" autocomplete="off">                       
                                    <div class="user-details">                                    
                                        <input type="hidden" id="project_id" name="project_id" value="<?php echo $projectID; ?>">                                    
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
                                            <span class="details"> Project Start Date (Planned) </span>
                                            <input type="date" class="save_timeline" id="designProjectStartDate" name="designProjectStartDate" value="<?=$designProjectStartDate; ?>" onkeydown="return false">
                                        </div>

                                        <div class="input-box">
                                            <span class="details"> Project End Date (Planned)</span>
                                            <input type="date" class="save_timeline" id="designProjectEndDate" name="designProjectEndDate" value="<?=$designProjectEndDate; ?>" onkeydown="return false">
                                        </div>  

                                        <div class="input-box">                                           
                                            <span class="details"> Project Start Date (Actual)</span>
                                            <input type="date" class="save_timeline" id="designActualStartDate" name="designActualStartDate" value="<?=$designActualStartDate; ?>" onkeydown="return false">
                                        </div>

                                        <div class="input-box">
                                            <span class="details"> Project End Date (Actual)</span>
                                            <input type="date" class="save_timeline" id="designActualEndDate" name="designActualEndDate" value="<?=$designActualEndDate; ?>" onkeydown="return false">
                                        </div>                                                                           
                                    </div> 
                                </form>                               
                            </div>                                                            

                            <div class="content">
                                <form id="add_design_activity_form" action="#" method="post" autocomplete="off">
                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">
                                    
                                    <div class="user-details">                                                                                  
                                        <div class="input-box-new">
                                            <span class="details">Activity <span class="req">*</span></span>                                            
                                            <?php echo $activitylist; ?>
                                        </div>   
                                    </div>
                                                                     
                                </form>
                            </div>  
                            
                            <div class="user-details" >
                                <div class="input-box">
                                    <button type="submit" name="submit" onclick="save_activity()" class="md-btn md-btn-success add-activity">Add Activity</button>                                                                        
                                    <!-- <button type="submit" onclick="reorder()" class="md-btn reset_form">Reorder Drag</button> -->
                                    <button type="submit" name="submit" class="md-btn reorder_activity_class">Re-order</button>
                                    <button type="submit" name="submit" class="md-btn md-btn-success update_all_activity_class">Update All</button>                                    
                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>
                                </div>
                            </div> 
                            <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span>                                                          
                            
                        </div>                      
                    </div>

                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> List Activities</h1> 
                    </div>

                    <!-- <div class="uk-overflow-container wrapper1">                        
                    </div> -->
                    
                    <div class="uk-overflow-container">                    
                        <form id="update_all_activity" name="update_all_activity" method="post">
                            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="header_design sticky-col first-col-header"><b>Sr.</b></th>
                                        <th class="header_design sticky-col second-col-header"><b>Order</b></th>
                                        <th class="header_design sticky-col third-col-header"><b>Level</b></th>                                        
                                        <th class="header_design sticky-col fourth-col-header"><b>Activity</b></th>                                        
                                        <th class="header_design"><b>Activity Time Required</b></th>
                                        <th class="header_design"><b>Start Date</b></th>                                        
                                        <th class="header_design"><b>Target Date</b></th>                                   
                                        <th class="header_design"><b>Man Power</b></th>
                                        <th class="header_design"><b>Responsible Person</b></th>
                                        <th class="header_design"><b>Approval</b></th>                                        
                                        <th class="header_design"><b>Action</b></th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(!empty($getAllDesignActivity)) { 
                                    // echo '<pre>';
                                    // print_r($getAllDesignActivity);exit;
                                    $total_activity_count = count($getAllDesignActivity);
                                    
                                    $this->load->model('design_window_model');
                                    $number = $array_cnt = 0;
                                    $level_count = 0;
                                    $prev_target_date = '';
                                    foreach($getAllDesignActivity as $activity) { 
                                        array_push($activity_id_array, $activity->activityID);  
                                        $total_skill_cnt = explode(",", $activity->skill1);
                                        $total_skill_cnt = count($total_skill_cnt);  
                                        if($activity->level == 0){                                  
                                        $level_count++; 
                                    ?>                                                                
                                    <tr class="group_order<?php echo $level_count; ?>  ">                                        
                                        <?php }else if($activity->level == -1) { ?>
                                            <tr class="group_order_init"> 
                                        <?php }
                                            else{ ?>
                                                <tr class="group_order<?php echo $level_count; ?> ">                                        
                                            <?php } 
                                        ?>

                                        <td class="sticky-col first-col" style="text-align:center;">
                                            <?php echo $number = $number + 1; ?>
                                        </td>
                                        
                                        <input type="hidden" id="activityID-<?php echo $activity->activityID.$number; ?>" name="activityID[]" value="<?php echo $activity->activityID; ?>" >
                                        <input type="hidden" id="projectID-<?php echo $activity->activityID.$number; ?>" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                        <input type="hidden" id="projectequipment-<?php echo $activity->activityID.$number; ?>" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >
                                        <input type="hidden" id="total_skill_cnt-<?php echo $activity->activityID.$number; ?>" name="total_skill_cnt[]" value="<?php echo $total_skill_cnt; ?>" >
                                        <input type="hidden" id="activity_data-<?php echo $activity->activityID.$number; ?>" name="activity_data[]" value="<?php echo $activity->activity; ?>" >
                                        <input type="hidden" id="activity_data_id-<?php echo $activity->activityID.$number; ?>" name="activity_data_id[]" value="<?php echo $activity->activity; ?>" >

                                        <td class="sticky-col second-col">
                                            <select name="row_order[]" id="row_order-<?php echo $activity->activityID.$number; ?>" class="table-select-level-dd row_order" > 
                                                <?php
                                                    for($i = 0; $i <= $total_activity_count; $i++){
                                                ?>                                                                                                                             
                                                    <option value="<?php echo $i; ?>"<?=$activity->row_order == $i ? ' selected="selected"' : '';?>><?php echo $i; ?></option>                                                    
                                                <?php } ?>
                                            </select>                                           
                                        </td>

                                        <td class="sticky-col third-col">
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

                                        <td class="activity_data_col sticky-col fourth-col"><?php echo wordwrap($activity->activity_data, 40, '<br/>', false); ?></td>                                                                                                                                   
                                        
                                        <td>
                                            <select name="activity_days[]" id="activity_days-<?php echo $activity->activityID.$number; ?>" class="table-select-dd activity_days_class fifth-col">
                                                <option value="0"<?=$activity->activity_days == 0 ? ' selected="selected"' : '';?>>0 Day</option> 
                                                <option value="1"<?=$activity->activity_days == 1 ? ' selected="selected"' : '';?>>1 Day</option> 
                                                <option value="2"<?=$activity->activity_days == 2 ? ' selected="selected"' : '';?>>2 Days</option> 
                                                <option value="3"<?=$activity->activity_days == 3 ? ' selected="selected"' : '';?>>3 Days</option> 
                                                <option value="4"<?=$activity->activity_days == 4 ? ' selected="selected"' : '';?>>4 Days</option> 
                                                <option value="5"<?=$activity->activity_days == 5 ? ' selected="selected"' : '';?>>5 Days</option> 
                                                <option value="6"<?=$activity->activity_days == 6 ? ' selected="selected"' : '';?>>6 Days</option> 
                                                <option value="7"<?=$activity->activity_days == 7 ? ' selected="selected"' : '';?>>7 Days</option> 
                                                <option value="8"<?=$activity->activity_days == 8 ? ' selected="selected"' : '';?>>8 Days</option> 
                                                <option value="9"<?=$activity->activity_days == 9 ? ' selected="selected"' : '';?>>9 Days</option> 
                                                <option value="10"<?=$activity->activity_days == 10 ? ' selected="selected"' : '';?>>10 Days</option>                                                                   
                                            </select>

                                            <select name="activity_time_hours[]" id="activity_time_hours-<?php echo $activity->activityID.$number; ?>" class="table-select-dd activity_time_hours_class">                                                
                                                <?php
                                                    for($hours=0; $hours<=8; $hours++){                                                        
                                                        if(strlen($hours) == 1)
                                                            $hours = '0'.$hours;                                                                                      
                                                ?>
                                                    <option value="<?php echo $hours; ?>"<?=$activity->activity_time_hours == $hours ? ' selected="selected"' : '';?>><?php echo $hours.' hrs'; ?></option>
                                                <?php } ?>
                                            </select>

                                            <select name="activity_time_minutes[]" id="activity_time_minutes-<?php echo $activity->activityID.$number; ?>" class="table-select-dd activity_time_minutes_class">                                                
                                                <?php                                                    
                                                    for($mins=0; $mins<60; $mins++){                                                                      
                                                        if(strlen($mins) == 1)
                                                            $mins = '0'.$mins;                
                                                ?>
                                                    <option value="<?php echo $mins; ?>"<?=$activity->activity_time_minutes == $mins ? ' selected="selected"' : '';?>><?php echo $mins.' min'; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>

                                        <td>
                                            <div id="startDate_time-<?php echo $activity->activityID.$number; ?>" name="startDate_time">
                                                <?php 
                                                    $start_date = '';
                                                    if($activity->level == 0){ 
                                                        $start_date = $activity->startDate;
                                                    }elseif(isset($activity->startDate) && !empty($activity->startDate)){
                                                        $start_date = $activity->startDate;
                                                    }else{
                                                        $start_date = $prev_target_date;
                                                    }
                                                ?>
                                                <input class="startDate" type="text" name="startDate[]" id="startDate-<?php echo $activity->activityID.$number; ?>" value="<?php echo $start_date; ?>" style="width:150px;">                                                    
                                                <span class="add-on">
                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                </span>
                                                <a href="javascript:void(0)" data-current-row="<?php echo $activity->activityID.$number; ?>" name="get_target_date" id="get_target_date" class="get_target_date_class"><i class="md-icon material-icons" style="color:#f88c3b;">forward</i></a>
                                            </div>                                            
                                        </td>                                        
                                        
                                        <td>
                                            <input type="text" data-current-row="<?php echo $activity->activityID.$number; ?>" name="targetDate[]" id="targetDate-<?php echo $activity->activityID.$number; ?>" class="target_date_class" value="<?php echo $activity->targetDate; ?>" style="width:150px;">                                            
                                        </td>
                                        <?php $prev_target_date = $activity->targetDate; ?>

                                        <td>
                                            <input type="text" name="manpower1[]" id="manpower1-<?php echo $activity->activityID.$number; ?>" class="table-select-dd" value="<?php echo $activity->manpower1; ?>" disabled>
                                        </td>

                                        <td>
                                            <?php 
                                                $activitySkills = $this->design_window_model->get_design_activity_wise_skill($activity->activity);  // pass activity id to get that activity skills list
                                                // echo '<pre>';
                                                // print_r($activitySkills);                                                                                         
                                                $options        = array();
                                                $options[""]    = "";
                                                $selectedItemId = explode(',',$activity->person1);
                                                foreach($activitySkills as $skills){
                                                    if($skills->totalSkills >= $total_skill_cnt){                                                        
                                                        $options[$skills->userId] = $skills->name;
                                                    }  
                                                    // print_r($skills->totalSkills);                                             
                                                    // print_r($total_skill_cnt);            
                                                }     
                                                //  echo '<pre>';                                         
                                                // print_r($options); 
                                                echo form_multiselect("person_name_id[$activity->activityID][]", $options, $selectedItemId, array("data-md-selectize"=>"", "data-md-selectize-bottom"=>"", "class"=>"md-input label-fixed padding-fordropdown person_name_class", "data-row-number" => $activity->activityID.$number, 'id' => 'person_name_id-'.$activity->activityID.$number));                                                
                                            ?>                                            
                                        </td> 

                                        <td>
                                            <select name="clientApproval[]" id="clientApproval-<?php echo $activity->activityID.$number; ?>" class="table-select-dd">                                                                                  
                                                <option value="yes"<?=$activity->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                      
                                                <option value="pending"<?=$activity->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                      
                                                <option value="na"<?=$activity->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                            </select>
                                        </td>                                       

                                        <td>
                                            <a href="javascript:void(0)" class="update_activity_class" data-uk-tooltip title="Update"  data-current-row="<?php echo $activity->activityID.$number; ?>" name="update_activity-<?php echo $activity->activityID; ?>" id="update_activity-<?php echo $activity->activityID; ?>"><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a>                                            
                                            <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_activity(<?php echo $activity->activityID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                        </td>
                                    </tr>
                                <?php } 
                            }else{ ?>
                                    <script type="text/javascript">
                                        $('.update_all_activity_class').hide();
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

    $(document).ready(function(){                   

        $('#add_design_activity_form').submit(function(){
            $("#add_design_activity_form :disabled").removeAttr('disabled');
        });         
        
        $('.person_name_class').on('change', function() {  
            var resp_persons_cnt = $(this).val();  // get no of responsible persons
            var get_row_id = $(this).attr("data-row-number");            
            var id = "#manpower1-"+get_row_id;

            if(resp_persons_cnt){
                resp_persons_cnt = resp_persons_cnt.length;                               
                $(id).val(resp_persons_cnt);               
            }else{
                var val = 0;
                $(id).val(val);
            }                       
        });
        
        $('.activity_level').on('change', function() { 
            var level = $(this).val();            
        });                                                       

    });         

    // reorder level and order
    $('.reorder_activity_class').click(function(){
        var formData = new FormData($('#update_all_activity')[0]); 
        var aUrl = base_url+'designwindow/reorderActivity';
                           
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
                            window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                    });
                }else{
                    swal({
                        title: "Something wen twrong.. Please try again!!",                        
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }                                                             
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal({
                    title: "No data found!!",
                    // text: "Check if you have entered correct data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            }                
        });             
    });

    // update all activity data at once
    $('.update_all_activity_class').click(function(){  
        $("#update_all_activity :disabled").removeAttr('disabled');
        var formData = new FormData($('#update_all_activity')[0]); 
        var aUrl = base_url+'designwindow/updateAllActivityOnce';        
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
                                    window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
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

        var total_act_hours = activity_days*8 + Number(activity_time_hours);
        total_act_hours = Number(total_act_hours);           
      
        var final_date = get_date = get_formt_hours = get_formt_minutes = '';       

// if no of hours and minutes set for activity
        if((total_act_hours > 0 && activity_time_minutes > 0) || (total_act_hours > 0 && activity_time_minutes <= 0)){
            if(start_date != ''){
                $('#all_field_validation').html('');     
                var shift_start_time = 9;
                var shift_end_time = 17;
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
                        total_time_for_next_day = 16;                        
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

    $('.update_activity_class').click(function(){  
        var get_row_id = $(this).attr("data-current-row");  

        var activityID = "#activityID-"+get_row_id;
        activityID = $(activityID).val();

        var activity_data_id = "#activity_data-"+get_row_id;
        activity_data_id = $(activity_data_id).val();        

        var projectID = "#projectID-"+get_row_id;
        projectID = $(projectID).val();

        var projectequipment = "#projectequipment-"+get_row_id;
        projectequipment = $(projectequipment).val();

        var level = "#level-"+get_row_id;
        level = $(level).val();

        var row_order = "#row_order-"+get_row_id;
        row_order = $(row_order).val();

        var activity_days = "#activity_days-"+get_row_id;
        activity_days = $(activity_days).val();

        var activity_time_hours = "#activity_time_hours-"+get_row_id;
        activity_time_hours = $(activity_time_hours).val();

        var activity_time_minutes = "#activity_time_minutes-"+get_row_id;
        activity_time_minutes = $(activity_time_minutes).val();
        // activity_time_minutes = Number(activity_time_minutes.substr(0,2));
        
        var manpower1 = "#manpower1-"+get_row_id;
        manpower1 = $(manpower1).val();

        var startDate = "#startDate-"+get_row_id;
        startDate = $(startDate).val();

        var targetDate = "#targetDate-"+get_row_id;
        targetDate = $(targetDate).val();

        var clientApproval = "#clientApproval-"+get_row_id;
        clientApproval = $(clientApproval).val();

        // var prod_release = "#prod_release-"+get_row_id;
        // prod_release = $(prod_release).val();

        var person_name_id = "#person_name_id-"+get_row_id;
        person_name_id = $(person_name_id).val();
                
        var aUrl = base_url+'designwindow/updateActivity';        
        var total_activity_count = "<?php echo $total_activity_count; ?>";
        
        $.ajax({
            url : aUrl,
            type: "POST",
            dataType: "JSON",
            data: {'activityID':activityID, 'activity_data_id':activity_data_id,'person_name_id':person_name_id, 'projectID':projectID, 'projectequipment':projectequipment,'level':level, 'activity_days':activity_days, 'activity_time_hours':activity_time_hours, 'activity_time_minutes':activity_time_minutes, 'row_order':row_order, 'manpower1':manpower1,  'startDate':startDate, 'targetDate':targetDate, 'clientApproval':clientApproval },

            success: function(data, textStatus, jqXHR){ 
                if(data.projectID > 0){
                    // update start date for next activity based on previous activity.
                    var aUrl = base_url+'designwindow/updateNextActivityStartDate';
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",
                        data: {'activityID':activityID, 'row_order':row_order, 'total_activity_count':total_activity_count, 'startDate':startDate, 'targetDate':targetDate, 'projectID':projectID, 'projectequipment':projectequipment},

                        success: function(data, textStatus, jqXHR){ 
                            if(data.activityID > 0){
                                // update start date for next activity based on previous activity.                                
                                swal("Activity Updated Successfully.").then((value) => {                        
                                    window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                                });
                            }else{
                                swal({
                                    title: "Something went wrong.. Please try Again!",                        
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
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            });
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
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            }
        }); 
    }); 

    function save_activity(){
        
        var aUrl = base_url+'designwindow/saveNewActivity';
        var projectID = $('#projectID').val();
        var projectequipment = $('#projectequipment').val();
        var activity = $('#activity_id').val();               
        
        if(projectID > 0 && projectequipment > 0 && activity != null){ 
            swal({
                title: "Are you sure to add activity?",                
                // icon: "success",
                buttons: true,
                // dangerMode: true,
            }).then((willDelete) => {
                if(willDelete){
                    var formData = new FormData($('#add_design_activity_form')[0]);                                  
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
                                swal("Design Activity Added Successfully.")
                                    .then((value) => {
                                        window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
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
            $('#all_field_validation').html('Please Select Activity..');
        }
    }
    
   $('.save_timeline').on('change', function(){
        var aUrl = base_url+'designwindow/saveProjectTimeline';
        var projectID = $('#project_id').val();                
        var designProjectStartDate = $('#designProjectStartDate').val();
        var designProjectEndDate = $('#designProjectEndDate').val();
        var designActualStartDate = $('#designActualStartDate').val();
        var designActualEndDate = $('#designActualEndDate').val();
        // var save_timeline = $('.save_timeline').val();
        // console.log(save_timeline);

        if(projectID > 0 ){            
            var formData = new FormData($('#add_project_timeline')[0]);                                  
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",               
                data:formData,  
                processData: false,
                contentType: false,     
                success: function(data, textStatus, jqXHR){ 
                    $('#designProjectStartDate').val(data.designProjectStartDate);
                    $('#designProjectEndDate').val(data.designProjectEndDate);
                    $('#designActualStartDate').val(data.designActualStartDate);
                    $('#designActualEndDate').val(data.designActualEndDate);
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

    function delete_activity(activityID,projectID,projectequipment)
    {
        var aUrl = base_url+'designwindow/delete_new_activity';
        swal({
            title: "Are you sure to delete activity?",
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
                        data: {'activityID':activityID},
                        success: function(data)
                        {                                                          
                            window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
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