<?php
    $set_start_date = $act_data->startDate;
    $set_target_date = $act_data->targetDate;
    $person_names = $person_names;
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
    .skill-box {
	    width: 26%;	
	    margin-left: 140px;
    }

    .disable_delay{
        pointer-events: none;
    }

    /* .input-simple{
        width: 50%!important;
    } */
    
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
                            <input type="hidden" id="activityID" name="activityID" value="<?php echo $act_data->activityID; ?>">

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="projectNo">Project No</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $projectNo; ?> </p>
                                </div>
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="client_name">Client</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $client_name; ?> </p>
                                </div>
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="projectequipmentName">Equipment</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $projectequipmentName; ?> </p>
                                </div>
                            </div> 
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="tag_number">TAG No</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $tag_number; ?> </p>
                                </div>
                            </div> 
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="activity_time_reqd">Activity</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $activity_name; ?> </p>
                                </div>
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="skills_list">Skills</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo rtrim($skills_list,'|'); ?> </p>
                                </div>
                            </div>                                                                                                              
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="person_names">Responsibles</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo rtrim($person_names,'|'); ?> </p>
                                </div>
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="activity_time_reqd">Time Required</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $act_data->activity_days.' days '.$act_data->activity_time_hours.' hours '.$act_data->activity_time_minutes.' minutes'; ?> </p>
                                </div>
                            </div> 
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="startDate">Start Date</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $act_data->startDate; ?> </p>
                                </div>
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="targetDate">Target Date</label>
                                    <p style="margin: -24px 133px 10px !important;"><?php echo $act_data->targetDate; ?> </p>
                                </div>
                            </div>                         

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="actual_start_date_time">                                                                        
                                    <label for="actual_start_date">Actual Start Date</label>                                                                       
                                        <input class="actual_start_date" type="text" name="actual_start_date" id="actual_start_date" value="<?php echo ($this->input->post('actual_start_date')?$this->input->post('actual_start_date'):$act_data->actual_start_date); ?>">                                                                                                                
                                    <span class="uk-form-help-block uk-text-danger add-on"><?=form_error("taskCompDate");?><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                </div>  
                            </div>                            

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="taskCompDate_time">                                                                        
                                    <label for="taskCompDate">Actual Completion Date</label>                                                                       
                                        <input class="taskCompDate" type="text" name="taskCompDate" id="taskCompDate" value="<?php echo ($this->input->post('taskCompDate')?$this->input->post('taskCompDate'):$act_data->taskCompDate); ?>">                                                                                                                
                                    <span class="uk-form-help-block uk-text-danger add-on"><?=form_error("taskCompDate");?><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="activity_time_reqd"></label>
                                    <a href="javascript:void(0)" name="get_total_delay" id="get_total_delay" class=" md-btn get_total_delay">Get Delay</a>
                                </div>
                            </div>
                            
                            
                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="datetimepicker2">                                                                        
                                    <label for="delayDays">Total Delay</label>                                                                       
                                    <input class="delayDays disable_delay" type="text" name="delayDays" id="delayDays" value="<?php echo ($this->input->post('delayDays')?$this->input->post('delayDays'):$act_data->delayDays); ?>">
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-calendar input-append date" id="datetimepicker2">                                                                        
                                    <label for="is_overtime">Over Time</label>                                                                                                                                          
                                        <input type="checkbox" id="is_overtime" class="is_overtime" checked="checked"  name="is_overtime" value="<?php echo ($this->input->post('is_overtime')?$this->input->post('is_overtime'):$act_data->is_overtime); ?>" >      
                                </div>  
                            </div> 
                            

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled input-simple">                                                                        
                                    <label for="delayRemark">Remark for Delay</label>                                                                       
                                    <input class="delayRemark disable_delay" type="text" name="delayRemark" id="delayRemark" value="<?php echo ($this->input->post('delayRemark')?$this->input->post('delayRemark'):$act_data->delayRemark); ?>">
                                </div>  
                            </div> 
    
                            <?php if ($act_data->clientApproval != 'na') { ?>
                                <div class="uk-width-medium-1-1">
                                    <div class="parsley-row md-input-filled input-simple">
                                        <label for="clientApproval">Client Approval</label>
                                        <select name="clientApproval" id="clientApproval" class="disable_delay">                                                                                  
                                            <option value="yes"<?=$act_data->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                      
                                            <option value="pending"<?=$act_data->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                      
                                            <option value="na"<?=$act_data->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                        </select>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" id="clientApproval" name="clientApproval" value="na">
                            <?php } ?>

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="prod_release">Release for Production</label>
                                    <select name="prod_release" id="prod_release" class="disable_delay">                                                                                  
                                        <option value="yes"<?=$act_data->prod_release == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                      
                                        <option value="no"<?=$act_data->prod_release == 'no' ? ' selected="selected"' : '';?>>No</option>                                                                              
                                    </select>                                                                       
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
    
    $(document).ready(function(){                                   
        $('#add_design_activity_form').submit(function(){
            $("#add_design_activity_form :disabled").removeAttr('disabled');
        });  
        
        var taskCompDate = $('#taskCompDate').val();
        if(taskCompDate != ''){
            $('#clientApproval').removeClass();
            $('#prod_release').removeClass();
            $('#delayRemark').removeClass();
        }
        
        $('.is_overtime').on('change',function(){            
            var chk = $("#is_overtime");
            var IsChecked = chk[0].checked;
            if (IsChecked) {
                chk.attr('checked', 'checked')
            } 
            else {
                chk.removeAttr('checked')                            
            }
            chk.attr('value', IsChecked);                
        });
       
    });       
    
    function update_activity(){                     
        var aUrl = base_url+'designwindow/updateActivityData';
        
        var activityID = $('#activityID').val();
        var projectID = $('#projectID').val();
        var projectequipment = $('#projectequipment').val();
        var actual_start_date = $('#actual_start_date').val();
        var taskCompDate = $('#taskCompDate').val();
        var delayDays = $('#delayDays').val();
        var delayRemark = $('#delayRemark').val();
        var clientApproval = $('#clientApproval').val();
        var prod_release = $('#prod_release').val();  
        var is_overtime = $('#is_overtime').val();       
        var person_names = "<?php echo $person_names; ?>";
        var set_start_date = "<?php echo $set_start_date; ?>";
        var set_target_date = "<?php echo $set_target_date; ?>";
        // console.log(is_overtime);
        
        if(projectID > 0 && projectequipment > 0 && taskCompDate != '' && actual_start_date != '' && person_names !='' && set_start_date!='' && set_target_date!='' ){                            
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",
                data: {'activityID':activityID, 'projectID':projectID, 'projectequipment':projectequipment, 'actual_start_date':actual_start_date, 'taskCompDate':taskCompDate, 'delayDays':delayDays, 'delayRemark':delayRemark, 'clientApproval':clientApproval, 'prod_release':prod_release, 'is_overtime':is_overtime },                   
                success: function(data){ 
                    // console.log(data);
                    if(data.projectID > 0){
                        swal("Design Activity Updated Successfully.").then((value) => {                                
                                window.location = base_url+'designwindow/'+'?projectID='+projectID; 
                        });
                    }else{
                        $('#all_field_validation').html('Something went wrong.. Please try again!!');
                    }
                }
            });    
        } else{
            $('#all_field_validation').html('Please fill all fields..');
        }
    }

    
    $('.get_total_delay').click(function(){   
        $('#all_field_validation').html('');        
        var targetDate = "<?php echo $act_data->targetDate; ?>";   // actual date
        var taskCompDate = $('#taskCompDate').val();               // completion date   

        start_actual_time = new Date(targetDate);
        end_actual_time = new Date(taskCompDate);

        var diff = end_actual_time - start_actual_time;

        var seconds = Number(diff/1000);
        // var hours = Math.floor(diffSeconds/3600);
        // var minutes = Math.floor(diffSeconds%3600)/60;
        // var diffDays = hours+' hrs '+minutes+' mins';
       // get total seconds between the times
        //    var seconds = parseInt(123456, 10);

        var days = Math.floor(seconds / (3600*24));
            seconds  -= days*3600*24;
        var hrs   = Math.floor(seconds / 3600);
            seconds  -= hrs*3600;
        var mnts = Math.floor(seconds / 60);
            seconds  -= mnts*60;
        diffDays = days+" day, "+hrs+" hrs, "+mnts+" min";

        // diffDays = days + hours + minutes + seconds;
        if(targetDate > taskCompDate){
            // var diffDays1 = '-'+diffDays;
            $('#delayDays').val(0);
        }else{
            $('#delayDays').val(diffDays);
            $('#clientApproval').removeClass();
            $('#prod_release').removeClass();
            $('#delayRemark').removeClass();
        }                    
    });  
    
    $("#actual_start_date_time").datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'English',
        autoclose: true,                   
    })
    .on("change", function() {
        // $(this).datetimepicker('remove');
    });    

    $("#taskCompDate_time").datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'English',
        autoclose: true,    
        changeMonth: true,
        changeYear: true,
        // onSelect: function(dateText) {
        //     alert('hello');
        // }               
    })
    .on("change", function() {
        // $(this).datetimepicker('remove');
    });         
</script>