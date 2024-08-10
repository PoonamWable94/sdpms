<?php
    $activity_id_array = array();       
?>

<style>         
    .header_design_next{
        text-align:center !important;        
        color:#f88c3b !important;
        font-weight: 300 !important;
    }        

    .input-simple span {
        margin-left: -139px;
    } 

    .container{
        margin-right: 80px !important;
        margin-left: 5px !important;
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

    .assembly-sr-no{
        width: 20px !important;
    } 

    .text-alignment-style{
        padding-left: 5px !important;
        padding-right: 10px !important;
    } 

    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        background-color: white;
    }

    .first-col-header {
        width: 200px;
        min-width: 200px;
        max-width: 200px;
        left: 0px;        
    }

    .first-col {
        width: 200px;
        min-width: 200px;
        max-width: 200px;
        left: 0px;
        background-color: #ddd;
    }       

</style>

<link type="text/css" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<div id="page_content">    
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-card">                                                       
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> Update Sub Assembly Activity</h1> 
                    </div>                   
                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;Project & Client:- &nbsp;&nbsp;<?php echo $projectNo.' / '.$client_name; ?></h5>
                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;Equipment & TAG No:- &nbsp;&nbsp;<?php echo $projectequipmentName.' / '.$tag_number; ?></h5>
                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;Main Assembly Activity:- &nbsp;&nbsp;<?php echo $main_activity_name; ?></h5>
                    
                    <div class="uk-overflow-container">                    
                        <form id="update_all_subactivity" name="update_all_subactivity" method="POST">
                            <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <input type="hidden" id="activityID" name="activityID" value="<?php echo $activityID; ?>" >
                                <input type="hidden" id="main_activity_id" name="main_activity_id" value="<?php echo $main_activity_id; ?>" >
                                <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>" >
                                <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>" >
                                <tbody>                                    
                                    <?php                                        
                                        if($get_assembly_data){
                                    ?>                                        
                                            <thead>
                                                <tr>                                                                                                            
                                                    <th class="header_design_next sticky-col first-col-header" > Sub Activity</th>                                                    
                                                    <th class="header_design_next" >Activity Time</th>
                                                    <th class="header_design_next" >Planned Start</th>
                                                    <th class="header_design_next" >Planned End</th>  
                                                    <th class="header_design_next" >Actual Start</th>
                                                    <th class="header_design_next" >Actual End</th>    
                                                    <th class="header_design_next" >Start Delay</th>
                                                    <th class="header_design_next" >End Delay</th>                                                                                                  
                                                    <th class="header_design_next" >Responsible Person</th>
                                                    <th class="header_design_next" >Quality Internal <br/> QC Date</th>
                                                    <th class="header_design_next" >Quality Internal <br/> QC Remark</th>
                                                    <th class="header_design_next" >TPI Internal <br/> QC Date</th>
                                                    <th class="header_design_next" >TPI Internal <br/> QC Remark</th> 
                                                    <?php if ($main_client_approval == 'yes'){ ?><th class="header_design_next" >Client <br/> Approval</th><?php } ?>
                                                    <th class="header_design_next" >Release for <br/> next operation</th>
                                                    <th class="header_design_next" >Manufacturing <br/> Type</th>                                                                                            
                                                </tr>
                                            </thead>

                                            <tbody>                                              
                                                <!-- <form id="sub_activity_form" name="sub_activity_form" method="POST"> -->
                                                <?php
                                                    $sr_no_ass = 1;                                                   
                                                    foreach($get_assembly_data as $assembly){
                                                        array_push($activity_id_array, $assembly->assemblyID);                                                          
                                                ?>  
                                                    <tr>                                                        
                                                        <input type="hidden" id="sub_activity_id" name="sub_activity_id[]" value="<?php echo $assembly->sub_activity; ?>" >                                                        
                                                        <input type="hidden" id="plannedStartDate" name="plannedStartDate[]" value="<?php echo $assembly->startDate; ?>">
                                                        <input type="hidden" id="plannedEndDate" name="plannedEndDate[]" value="<?php echo $assembly->targetDate; ?>">

                                                        <td class="sticky-col first-col">  
                                                            <div class="text-alignment-style">                                                          
                                                                <?php 
                                                                    echo $sr_no_ass.'.  '.wordwrap($assembly->assembly_activity,30,'<br/>',false);
                                                                ?>
                                                            </div>                                                                                                                        
                                                            <input type="hidden" id="sub_activity" name="sub_activity[]" value="<?php echo $assembly->assembly_activity; ?>">
                                                            <input type="hidden" id="assemblyID" name="assemblyID[]" value="<?php echo $assembly->assemblyID; ?>">
                                                        </td>                                                                                                                                        

                                                        <td>
                                                            <div class="text-alignment-style">
                                                                <?php
                                                                    echo $assembly->activity_days.' days '.$assembly->activity_time_hours.' hrs '.$assembly->activity_time_minutes.' mins';
                                                                ?>        
                                                            </div>                                                                                                                                                                            
                                                        </td>

                                                        <td>
                                                            <div class="text-alignment-style">
                                                                <?php                                                                 
                                                                    echo date('d/m/Y h:iA', strtotime($assembly->startDate));
                                                                ?>
                                                            </div>                                                                                                              
                                                        </td>                                        
                                                        
                                                        <td>
                                                            <div class="text-alignment-style">
                                                                <?php                                                                 
                                                                    echo date('d/m/Y h:iA', strtotime($assembly->targetDate));
                                                                ?>   
                                                            </div>
                                                        </td>   
                                                        
                                                        <td>
                                                            <div id="actual_start_date_time-<?php echo $assembly->assemblyID; ?>" name="actual_start_date_time" class="input-append date">                                                    
                                                                <input class="actual_start_date" type="text" name="actual_start_date[]" id="actual_start_date" value="<?php echo $assembly->actual_start_date; ?>" style="width:100px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>                                                    
                                                            </div>     
                                                        </td>

                                                        <td>
                                                            <div id="actual_end_date_time-<?php echo $assembly->assemblyID; ?>" name="actual_end_date_time" class="input-append date">                                                    
                                                                <input class="actual_end_date" type="text" name="actual_end_date[]" id="actual_end_date" value="<?php echo $assembly->actual_end_date; ?>" style="width:100px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>                                                    
                                                            </div>     
                                                        </td>

                                                        <td>
                                                            <div class="text-alignment-style">
                                                                <?php                                                                 
                                                                    echo $assembly->startDelay;
                                                                ?>   
                                                            </div>
                                                        </td> 

                                                        <td>
                                                            <div class="text-alignment-style">
                                                                <?php                                                                 
                                                                    echo $assembly->endDelay;
                                                                ?>   
                                                            </div>
                                                        </td> 

                                                        <td>
                                                            <?php 
                                                                $employee_name = '';
                                                                if($assembly->resp_persons){
                                                                    $get_name = explode(',',$assembly->resp_persons);
                                                                    foreach($get_name as $userId){
                                                                        $emp_name = $this->production_window_model->get_employee_names($userId);
                                                                        $employee_name = $emp_name->name.'<br/>'.$employee_name;
                                                                    }                                                                    
                                                                } 
                                                            ?>
                                                            <div class="text-alignment-style">
                                                                <?php
                                                                    echo $employee_name;                                                                                                                            
                                                                ?>
                                                            </div>                                            
                                                        </td> 
                                                        
                                                        <td>
                                                            <div id="quality_qc_date_time-<?php echo $assembly->assemblyID; ?>" name="quality_qc_date_time" class="input-append date">                                                    
                                                                <input class="quality_qc_date" type="text" name="quality_qc_date[]" id="quality_qc_date" value="<?php echo $assembly->quality_qc_date; ?>" style="width:100px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>                                                    
                                                            </div>     
                                                        </td>

                                                        <td>
                                                            <select id="quality_qc_remark" name="quality_qc_remark[]" class="table-text-box">                                                    
                                                                <option value="pending"<?=$assembly->quality_qc_remark == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                                <option value="approved"<?=$assembly->quality_qc_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>
                                                                <option value="na"<?=$assembly->quality_qc_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                
                                                            </select>                                                
                                                        </td>                                                                                                           

                                                        <td>
                                                            <div id="tpi_qc_date_time-<?php echo $assembly->assemblyID; ?>" name="tpi_qc_date_time" class="input-append date">                                                    
                                                                <input class="tpi_qc_date" type="text" name="tpi_qc_date[]" id="tpi_qc_date" value="<?php echo $assembly->tpi_qc_date; ?>" style="width:100px;">                                                    
                                                                <span class="add-on">
                                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                                </span>                                                    
                                                            </div>     
                                                        </td>

                                                        <td>
                                                            <select id="tpi_qc_remark" name="tpi_qc_remark[]" class="table-text-box">                                                    
                                                                <option value="pending"<?=$assembly->tpi_qc_remark == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                                <option value="approved"<?=$assembly->tpi_qc_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>
                                                                <option value="na"<?=$assembly->tpi_qc_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                
                                                            </select>                                                
                                                        </td>

                                                        <?php if($main_client_approval == 'yes'){  ?>
                                                            <td>
                                                                <select name="clientApproval[]" id="clientApproval" class="approval-select-box">                                                                                  
                                                                    <option value="pending"<?=$assembly->clientApproval == 'pending' ? ' selected="selected"' : '';?>>Pending</option>                                      
                                                                    <option value="yes"<?=$assembly->clientApproval == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                                      
                                                                    <option value="na"<?=$assembly->clientApproval == 'na' ? ' selected="selected"' : '';?>>NA</option>                                                                                     
                                                                </select>
                                                            </td>
                                                        <?php } ?>

                                                        <td>
                                                            <select name="prod_release[]" id="prod_release" class="approval-select-box">                                                                                  
                                                                <option value="no"<?=$assembly->prod_release == 'no' ? ' selected="selected"' : '';?>>No</option>                                                                                                                                                                          
                                                                <option value="yes"<?=$assembly->prod_release == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                                      
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select name="mfg_type[]" id="mfg_type" class="table-text-box">                                                                                  
                                                                <option value="inhouse"<?=$assembly->mfg_type == 'inhouse' ? ' selected="selected"' : '';?>>In House</option>                                      
                                                                <option value="outsource"<?=$assembly->mfg_type == 'outsource' ? ' selected="selected"' : '';?>>Outsource</option>                                                                                                                                                                          
                                                            </select>
                                                        </td>                                                                                                                                                  
                                                    </tr>
                                                <?php
                                                    $sr_no_ass++;                                                   
                                                } ?>
                                            <!-- </form> -->
                                            </tbody>
                                        <!-- </table> -->
                                    <?php } ?>
                                </tbody>
                            </table>                        
                        </form>  
                        <div class="uk-width-medium-1-1 sticky-col first-col">                                                           
                            <div class="parsley-row md-input-filled">                                
                                <label for="submit"></label>                                
                                <button type="submit" name="submit" onclick="update_sub_activity()" class="md-btn md-btn-success">Update All</button>
                                <a href="<?php echo base_url('productionwindow/assemblyList?projectID=').$projectID;?>" class="md-btn">Back</a>
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
    var js_activity_id_array = [];   
    js_activity_id_array =<?php echo json_encode($activity_id_array );?>; 

    $(document).ready(function(){                                                                                               

    });     
           
     
    var sdate_number=0;
    var id_rest = '';
    js_activity_id_array.forEach(function(item) {
        sdate_number++;                               

        var id_act_start_date = "#actual_start_date_time-"+item;
        $(id_act_start_date).datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'English',           
            autoclose: true, 
            // changeMonth: true,
            // changeYear: true,        
        })
        .on("change", function() {
            // $(this).datetimepicker('remove');
        });

        var id_act_end_date = "#actual_end_date_time-"+item;
        $(id_act_end_date).datetimepicker({
            format: 'yyyy-MM-dd hh:mm:ss',
            language: 'English',           
            autoclose: true, 
            // changeMonth: true,
            // changeYear: true,        
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

    
    function update_sub_activity(){
        var formData = new FormData($('#update_all_subactivity')[0]); 
        var aUrl = base_url+'productionwindow/update_all_assembly_subactivity';
                           
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
                    swal("Assembly Sub Activity data updated successfully.")
                        .then((value) => {
                            window.location = base_url+'productionwindow/assemblyList/'+'?projectID='+projectID; 
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
    }
</script>