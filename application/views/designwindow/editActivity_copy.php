
<style>
    .uk-grid>* {
        padding-left: 10px;
    }
    .uk-grid {
        text-align: left;
        margin: 0;
        padding: 0;
    } 
    .skill-box {
	    width: 26%;	
	    margin-left: 140px;
    }
</style>

<link type="text/css" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link type="text/css" href="<?php echo base_url(); ?>assets/date_time_picker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">                        
                        <h1 class="md-card-toolbar-heading-text update-activity"> Update Design Activity                        
                        </h1> 
                    </div>                   
                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        
                        <form id="add_design_activity_form" action="#" method="post" autocomplete="off">
                            <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">
                            <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">
                            <input type="hidden" id="activity_days" name="activity_days" value="<?php echo $activityTime->activity_days; ?>">
                            <input type="hidden" id="activity_time" name="activity_time" value="<?php echo $activityTime->activity_time; ?>">
                            <input type="hidden" id="activityID" name="activityID" value="<?php echo $act_data->activityID; ?>">

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="revisionNo">Client / Project No</label>
                                    <input type="text" id="project_no" name="project_no"  value="<?php echo $client_name; ?> / <?php echo $projectNo; ?>" disabled >                                      
                                </div>
                            </div>
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="projectequipments">Equipment / TAG No</label>                                   
                                    <input type="text" id="projectequipments" name="projectequipments"  value="<?php echo $projectequipmentName; ?> / <?php echo $tag_number; ?>" disabled>                                      
                                </div>
                            </div>                                                       
                            
                            <input type="hidden" id="activity_id" name="activity" value="<?php echo $activitylist->id; ?>">
                            <?php
                                $total_hours = substr($activitylist->activity_time, 0, 2);
                                $total_minutes = substr($activitylist->activity_time, 3, 2);
                            ?>
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="activity_time_reqd">Activity</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $activitylist->activity_data.' <b>Time</b>- '.$activitylist->activity_days.' days '.$total_hours.' hours '.$total_minutes.' minutes'; ?> </p>
                                </div>
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled multi-select">
                                    <label for="skill1">Skills</label>
                                    <div class="skill-box" style="margin: -43px 133px 10px !important;">
                                        <?php echo $skills_list; ?>
                                    </div>                                    
                                    <span id="errortag" class="uk-form-help-block uk-text-danger"></span>                                    
                                </div>
                            </div>                            
                                                       
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple"> 
                                    <label for="manpower1">Manpower Required</label>                                                                       
                                    <select name="manpower1" id="manpower1" >
                                        <?php
                                            for($i=1; $i <11; $i++){ ?>
                                                <option value="<?php echo $i; ?>"<?=$act_data->manpower1 == $i ? ' selected="selected"' : '';?>><?php echo $i; ?></option>
                                        <?php } ?>                                                                          
                                    </select>
                                    <span class="uk-form-help-block uk-text-danger" id="manpower1_validation"></span>
                                </div>
                            </div>   
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled multi-select">
                                    <label for="person1">Person</label>
                                    <div class="skill-box" style="margin: -43px 133px 10px !important;">
                                        <?php echo $persons_list; ?>
                                    </div>                                    
                                    <span id="errortag" class="uk-form-help-block uk-text-danger"></span>                                    
                                </div>
                            </div>                                                                                                                                                                       

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="datetimepicker1">                                                                        
                                    <label for="startDate">Start Date</label>   
                                    <div id="startDate_time" class="input-append date" style="margin: -31px 133px 10px !important;">                                                                    
                                        <input class="startDate" type="text" name="startDate" id="startDate" value="<?php echo ($this->input->post('startDate')?$this->input->post('startDate'):$act_data->startDate); ?>">
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                        </span>
                                        <a href="javascript:void(0)" id="get_target_date" class="md-btn md-btn-success" style="margin-left:5px; height:27px !important; padding-top:0px; font-size:10px;">Get Target Date</a>
                                    </div>
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("startDate");?></span>
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date1">                                                                        
                                    <label for="targetDate">Target Date</label>                                                                       
                                        <input class="targetDate" type="text" name="targetDate" id="targetDate" value="<?php echo ($this->input->post('targetDate')?$this->input->post('targetDate'):$act_data->targetDate); ?>">                                                                                                                
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("targetDate");?></span>
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="datetimepicker2">                                                                        
                                    <label for="taskCompDate">Activity Complete Date</label>                                                                       
                                        <input class="taskCompDate" type="text" name="taskCompDate" id="taskCompDate" value="<?php echo ($this->input->post('taskCompDate')?$this->input->post('taskCompDate'):$act_data->taskCompDate); ?>">                                                                                                                
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("taskCompDate");?></span>
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="datetimepicker2">                                                                        
                                    <label for="delayDays">Delay Days</label>                                                                       
                                    <input class="delayDays" type="text" name="delayDays" id="delayDays" value="<?php echo ($this->input->post('delayDays')?$this->input->post('delayDays'):$act_data->delayDays); ?>">
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-simple">                                                                        
                                    <label for="delayRemark">Remark for Delay</label>                                                                       
                                    <input class="delayRemark" type="text" name="delayRemark" id="delayRemark" value="<?php echo ($this->input->post('delayRemark')?$this->input->post('delayRemark'):$act_data->delayRemark); ?>">
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="clientApproval">Client Approval</label>
                                    <?php
                                        if($act_data->clientApproval == 'yes'){ ?>
                                            <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_yes" value="yes" checked > Yes </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_no" value="no" > No </input>  &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_pending" value="pending" > Pending </input>
                                    <?php }elseif($act_data->clientApproval == 'no'){ ?>
                                        <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_yes" value="yes" > Yes </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_no" value="no"checked > No </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_pending" value="pending" > Pending </input>
                                    <?php }else { ?>
                                        <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_yes" value="yes" > Yes </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_no" value="no" > No </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_pending" value="pending" checked> Pending </input>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="prod_release">Release for Production</label>
                                    <?php
                                        if($act_data->prod_release == 'yes'){ ?>
                                            <input type="radio" id="prod_release" name="prod_release" class="data-check-prod_release prod_release_yes" value="yes" checked > Yes </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" id="prod_release" name="prod_release" class="data-check-prod_release prod_release_no" value="no" > No </input>
                                    <?php }else{ ?>
                                        <input type="radio" id="prod_release" name="prod_release" class="data-check-prod_release prod_release_yes" value="yes" > Yes </input> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="prod_release" name="prod_release" class="data-check-prod_release prod_release_no" value="no"checked > No </input>
                                    <?php }?>                                                                        
                                </div>
                            </div>

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="clientApproval"></label>
                                    <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span> 
                                </div>
                            </div>                                                                                  
                        </form>
                        
                        <div class="uk-width-medium-1-1">                                                           
                            <div class="parsley-row md-input-filled input-simple">                                
                                <label for="submit"></label>                                
                                <button type="submit" name="submit" onclick="update_activity()" class="md-btn md-btn-success update-activity">Update</button>
                                <a href="<?php echo base_url('designwindow?projectID=').$projectID;?>" class="md-btn">Back</a>
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
    var base_url = "<?php echo base_url();?>";      
    
    var activity_days = $('#activity_days').val();                           
    var activity_time = $('#activity_time').val();      

    var activityID = $('#activityID').val(); 
    var update_activityID = $('#activityID').val(); 
    
    $(document).ready(function(){                                   
        $('#add_design_activity_form').submit(function(){
            $("#add_design_activity_form :disabled").removeAttr('disabled');
        });                                      
    });       
    
    function update_activity(){        
        var isValid = 0;        
        var aUrl = base_url+'designwindow/updateActivity';
        
        var projectID = $('#projectID').val();
        var projectequipment = $('#projectequipment').val();
        var activity1 = $('#activity_id').val();
        var skill1 = $('#skill1_id').val();
        var manpower1 = $('#manpower1').val();
        var person1 = $('#person_name_id').val();
        var startDate = $('#startDate').val();
        var targetDate = $('#targetDate').val();
        // var delayRemark = $('#delayRemark').val();
        // var clientApproval = $('#clientApproval').val();
        // console.log(skill1);
        if(activity1 > 0 && skill1 != null && manpower1 > 0 && person1 != null && startDate != null && targetDate != null){                
            isValid = 1;
            $('#all_field_validation').html('');
        }   
        else{
            $('#all_field_validation').html('Please Select All Mandatory Fields..');
            isValid = 0;            
        }

        if(projectID > 0 && projectequipment > 0 && isValid > 0){ 
            var formData = new FormData($('#add_design_activity_form')[0]); 
            // console.log(formData);
            // alert(projectID); 
            formData.append('activityID', activityID); 
            formData.append('activity', activity1); 
            // formData.append('update_activityID', update_activityID);                
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",
                // data: {'activityID':update_activityID, 'projectID':projectID, 'projectequipment':projectequipment, 'activity':activity, 'skill1':skill1, 'manpower1':manpower1, 'person1':person1, 'startDate':startDate, 'targetDate':targetDate, 'clientApproval':clientApproval},
                data:formData,  
                processData: false,
                contentType: false,     
                success: function(data, textStatus, jqXHR){ 
                    if(data.projectID > 0){
                        swal("Design Activity Updated Successfully.")
                            .then((value) => {
                                // console.log(value);
                                window.location = base_url+'designwindow/'+'?projectID='+projectID; 
                        });
                    }                                                             
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');                   
                }
            });    
        } else{
            
        }
    }
      
    $("#startDate_time").datetimepicker({
        format: 'yyyy-MM-dd hh:mm',
        language: 'English',
        autoclose: true, 
        changeMonth: true,
        changeYear: true,        
    })
    .on("change", function() {
        // $(this).datetimepicker('remove');
    });

    $("#targetDate").bind("propertychange change keyup paste input", function(){
        var startDate = $('#startDate').val();  
        var targetDate = $('#targetDate').val();            
        var startDate1 = new Date(startDate);
        var targetDate1 = new Date(targetDate);
        // console.log(targetDate1); 
        if(startDate == ''){
            $('#all_field_validation').html('Please Select Start Date first..');
            $('#targetDate').val(''); 
        }

        if(startDate1 > targetDate1){                
            $('#all_field_validation').html('Please Select Valid Target Date..');            
            // $('#targetDate').val(''); 
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

    function convertToDate(str) {
        var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);        
        return [ date.getFullYear(), mnth, day ].join("-");    
    }

    function target_date_format(target_date,time,minutes){
        var get_hours = target_date.setHours(target_date.getHours() + time);            
        var get_minutes = target_date.setMinutes(target_date.getMinutes() + minutes);                
        return new Date(get_minutes);
    }

    function get_date_difference(date1, date2){
        var holiday_start_date = convertToDate(date1);
        var holiday_target_date = convertToDate(date2);
        var date1 = new Date(holiday_start_date);
        var date2 = new Date(holiday_target_date);
        var diffTime = Math.abs(date2 - date1);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    }

    // function get_target_date(){
    $('#get_target_date').click(function(){                        
        var startDate = $('#startDate').val();    
        var act_hours = Number(activity_time.substr(0,2));
        var act_minutes = Number(activity_time.substr(3,2));
        var total_act_hours = activity_days*24 + act_hours;        
        // console.log(total_act_hours);
        if(total_act_hours > 0 || act_minutes > 0){
            if(startDate != ''){
                $('#all_field_validation').html('');                
                var start_date_format = new Date(startDate);
                var start_date_format_new = new Date(startDate);
                                           
                //check if start date is holiday                
                var check_holiday_start_date = new Date(start_date_format.setDate(start_date_format.getDate()));                
                if(check_holiday_start_date.getDay() != 0 && check_holiday_start_date.getDay() != 6)                   
                { 
                    var get_formated_date;                   
                    var get_target_date = target_date_format(start_date_format, total_act_hours, act_minutes);
                    
                    var check_holiday_target_date = new Date(get_target_date.setDate(get_target_date.getDate()));                
                    if(check_holiday_target_date.getDay() != 0 && check_holiday_target_date.getDay() != 6)                   
                    {
                        var if_holiday = 0;                                             
                        var total_days = get_date_difference(startDate, get_target_date);                         
                        var initial_start_date = start_date_format_new;

                        while(total_days > 0 ){                                                  
                            var get_target_date4 = target_date_format(initial_start_date, 24, 0);                                               
                            var check_holiday_target_date1 = new Date(get_target_date4.setDate(get_target_date4.getDate())); 
                            
                            if(check_holiday_target_date1.getDay() != 0 && check_holiday_target_date1.getDay() != 6){                                                                                           
                                if_holiday = 1;
                            }else{                                
                                if_holiday = 0; // yes                                  
                                break;
                            }
                            initial_start_date = get_target_date4;
                            total_days=total_days-1;
                        }
                        
                        if(if_holiday == 1){ //no in between holiday  
                            // console.log('no in between holiday');      
                            get_formated_date = convertToDateTime(get_target_date);   
                        }else{  
                            // console.log('In between holiday');      
                            var get_target_date1 = target_date_format(get_target_date, 48, 0);
                            get_formated_date = convertToDateTime(get_target_date1);                                                         
                        }
                                            
                    }else{    
                        // console.log('initial target date is holiday');                   
                        $get_target_date_formatted = target_date_format(get_target_date, 48, 0);
                        get_formated_date = convertToDateTime($get_target_date_formatted);                                              
                    }
                    // console.log(get_formated_date);
                    var get_date1 =  get_formated_date.substr(0,10);
                    var get_formt_hours1 = get_formated_date.substr(11,2);
                    var get_formt_minutes1 = get_formated_date.substr(14,2);
                    var final_date1 = get_date1+' '+get_formt_hours1+':'+get_formt_minutes1;
                    $('#targetDate').val(final_date1);
                   
                }else{
                    $('#all_field_validation').html('Please select working day..'); 
                    $('#startDate').val(''); 
                    $('#targetDate').val('');      
                }     
               
            }else{
                $('#all_field_validation').html('Please Select Start Date first..');
                $('#targetDate').val(''); 
            }
        }else{
            $('#all_field_validation').html('Please Select Activity First..');
            $('#startDate').val(''); 
            $('#targetDate').val(''); 
        }                
    });
    

    $(".taskCompDate").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true, 
        changeMonth: true,
        changeYear: true,
        onSelect: function(dateText) {
            // console.log(dateText);
            var taskCompDate = dateText;
            var targetDate = $('#targetDate').val();
            // console.log(taskCompDate);            
            targetDate = targetDate.substr(0,10);
            // console.log(targetDate);
            var date1 = new Date(targetDate);
            var date2 = new Date(taskCompDate);
            var diffTime = Math.abs(date2 - date1);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            // console.log(diffTime + " milliseconds");
            // console.log(diffDays + " days");
            if(targetDate > taskCompDate){
                // var diffDays1 = '-'+diffDays;
                $('#delayDays').val(0);
            }else{
                $('#delayDays').val(diffDays);
            }
            
        }
    }).on("change", function() {
        // $(this).datetimepicker('remove');
    });


           
</script>