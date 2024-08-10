<?php    
    $csvPath = base_url().'productionwindow/export_csv/'.$projectID;
?>

<style>
    .projectNoText{
        text-align: center;
    }
</style>

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> List Production Component Activity
                    <a href="<?php echo base_url('add_new_project/add_project');?>" data-uk-tooltip="{pos:'bottom'}" title="Add New Project"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                    <!-- <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>                     -->
                    <a href="<?=base_url();?>add_new_project/myactivities" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                 </h1>
            </div>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Project & Client:- &nbsp;&nbsp;<?php echo $project_info->project_no.' / '.$project_info->company_name; ?></h5>
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>#</th>                                                        
                            <th>Equipment</th>
                            <th>TAG No</th>
                            <th>Activity</th>
                            <th>Quantity</th>
                            <!-- <th>Activity Time</th> -->
                            <th>Total Time</th>
                            <th>Supervisor</th>                                                       
                            <th>Client Approval</th>
                            <th>Release</th>
                            <th>Manufacturing Type</th> 
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="uk-modal" id="modal_default">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <div class="uk-modal-header">
                <h3 class="uk-modal-title">Production Component Activity Details</h3>
            </div>
            
            <form action="#" id="show_call_details" class="uk-margin-top">
                <div class="uk-grid"> 
                    <div class="uk-width-1-1">
                        <div class="parsley-row md-input-wrapper">
                            <label for="projectNo">Project Number</label>
                            <input type="text" name="projectNo" class="md-input label-fixed"/>                                
                        </div>
                   
                        <div class="parsley-row md-input-wrapper">
                            <label for="equipment">Equipment</label>
                            <input type="text" name="equipment" class="md-input label-fixed"/>                                
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="tag_number">TAG Number</label>
                            <input type="text" name="tag_number" class="md-input label-fixed"/>                                
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="activity">Activity Name</label>
                            <input type="text" name="activity" class="md-input label-fixed"/>                                
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="skill1">Activity Skills</label>
                            <input type="text" name="skill1" class="md-input label-fixed"/>                                
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="manpower1">Manpower Required</label>
                            <input type="text" name="manpower1" class="md-input label-fixed"> 
                        </div>
                   
                        <div class="parsley-row md-input-wrapper">
                            <label for="person1">Person Name</label>
                            <input type="text" name="person1" class="md-input label-fixed"> 
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="startDate">Start Date</label>
                            <input type="text" name="startDate" class="md-input label-fixed"/>                                                         
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="targetDate">Target Date</label>
                            <input type="text" name="targetDate" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="taskCompDate">Completion Date</label>
                            <input type="text" name="taskCompDate" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="delayDays">Activity Delay (in days) </label>
                            <input type="text" name="delayDays" class="md-input label-fixed" />                               
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="clientApproval">Client Approval</label>
                            <input type="text" name="clientApproval" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="prod_release">Release for Production</label>
                            <input type="text" name="prod_release" class="md-input label-fixed" />                               
                        </div>
                    </div>                                                            
                </div>                   
            </form>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>                
            </div>
        </div>
    </div>
    
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var table;
    var base_url = '<?php echo base_url();?>';
    var projectID = "<?php echo $projectID; ?>";

    $(document).ready(function() {
        var projectID = "<?php echo $projectID; ?>";
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('productionwindow/list_activity'); ?>",
                "data": {"projectID":projectID},
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, 1, -1, -2], 
                    "orderable": false,
                }
            ],           
        });        
       
        $(document).on('change','.client_approval_class',function(){           
        // $('.client_approval_class').on('change',function(){           
            var clientApproval = $(this).val();
            var activityID = $(this).attr("data-activityId");  
            var dataApprovalType = $(this).attr("data-approval-type");  
            // console.log(clientApproval);  
            // console.log(dataApprovalType);    
            
            if(clientApproval != dataApprovalType){
                var myurl= base_url+'productionwindow/update_client_approval';            
                $.ajax({
                    type:"POST",
                    url:myurl,
                    data:{"activityID":activityID,"clientApproval":clientApproval},
                    success:function(data){ 
                        // window.location = base_url+'productionwindow/'+'?projectID='+projectID; 
                        reload_table();   
                    // swal({
                    //         title: "Client Approval Updated Successfully!!",                        
                    //         icon: "success",                        
                    //     });                    
                    }
                });
            }
        });

        $(document).on('change','.prod_release_class',function(){        
            var prod_release = $(this).val();
            var activityID = $(this).attr("data-activityId");  
            var dataApprovalType = $(this).attr("data-approval-type");  
            // console.log(prod_release); 
            // console.log(dataApprovalType); 
            if(prod_release != dataApprovalType){
                var myurl="<?php echo base_url()."productionwindow/update_prod_release"?>";            
                $.ajax({
                    type:"POST",
                    url:myurl,
                    data:{"activityID":activityID,"prod_release":prod_release},
                    success:function(data){    
                        // window.location = base_url+'productionwindow/'+'?projectID='+projectID;  
                        reload_table();                 
                    }
                });
            }
        });
    });

    

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status to Active or Passive
    $(document).on('click','.status_checks',function(){
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Passive' : 'Active';

        if(confirm("Are you sure to "+ msg + " this record"))
        {            
            var activityID = $(this).attr('data');
            // console.log(activityID);
            var myurl="<?php echo base_url()."productionwindow/update_status"?>";

            $.ajax({
                type:"POST",
                url:myurl,
                data:{"activityID":activityID,"status":status},
                success:function(data)
                {    
                    // console.log(data);
                    reload_table();
                }
            });
        }      
    });
    
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

    function view_activity_data(activityID,projectequipment)
    {
        $('#show_call_details')[0].reset(); // reset form on modals
        $('.form-group').removeClass('parsley-required'); // clear error class
        $('.parsley-required').empty(); // clear error string
        $('.md-input').removeClass('md-input-danger'); // clear error class
        
        if(activityID > 0 && projectequipment > 0){
            $.ajax({
                url : base_url+'productionwindow/get_activity_detail',
                type: "GET",
                dataType: "JSON",
                data:{'projectequipment':projectequipment, 'activityID':activityID},
                success: function(data)
                {
                    // console.log(data);
                    var clientApproval = 'YES';
                    if(data.activity_details.clientApproval == 'no'){
                        clientApproval = 'NO';
                    }
                    
                    $('[name="projectNo"]').val(data.activity_details.projectNo);
                    $('[name="equipment"]').val(data.activity_details.equipment);
                    $('[name="tag_number"]').val(data.activity_details.tag_number);
                    $('[name="activity"]').val(data.activity_details.activity);               
                    $('[name="skill1"]').val(data.skill1);
                    $('[name="manpower1"]').val(data.activity_details.manpower1);               
                    $('[name="person1"]').val(data.person1);
                    $('[name="startDate"]').val(data.activity_details.startDate);
                    $('[name="targetDate"]').val(data.activity_details.targetDate);
                    $('[name="taskCompDate"]').val(data.activity_details.taskCompDate);
                    $('[name="clientApproval"]').val(data.activity_details.clientApproval);
                    $('[name="delayDays"]').val(data.activity_details.delayDays);
                    $('[name="prod_release"]').val(data.activity_details.prod_release);
                
                    // Disable text box...
                    $('[name="projectNo"]').attr("disabled", "disabled");
                    $('[name="equipment"]').attr("disabled", "disabled");
                    $('[name="tag_number"]').attr("disabled", "disabled");
                    $('[name="activity"]').attr("disabled", "disabled");
                    $('[name="skill1"]').attr("disabled", "disabled");
                    $('[name="manpower1"]').attr("disabled", "disabled");
                    $('[name="person1"]').attr("disabled", "disabled");
                    $('[name="startDate"]').attr("disabled", "disabled");
                    $('[name="targetDate"]').attr("disabled", "disabled");
                    $('[name="taskCompDate"]').attr("disabled", "disabled");
                    $('[name="clientApproval"]').attr("disabled", "disabled");
                    $('[name="delayDays"]').attr("disabled", "disabled");
                    $('[name="prod_release"]').attr("disabled", "disabled");

                    // $("#btnSave").hide();
                    UIkit.modal($('.uk-modal')).show();
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error get data from database');
                }
            });
        }
    }

    function delete_data(activityID)
    {
        UIkit.modal.confirm('Are you sure delete?', function(){ 
            $.ajax({
                url : "<?php echo site_url('productionwindow/delete_new_activity')?>",
                type: "POST",
                dataType: "JSON",
                data: {'activityID':activityID},
                success: function(data)
                {
                    UIkit.modal(('.uk-modal')).hide();
                    reload_table();
                    UIkit.notify({
                        message : 'Record deleted!',
                        status  : 'danger',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        });
    }

    function bulk_delete()
    {
        var list_id = [];
        $(".data-check:checked").each(function() {
                list_id.push(this.value);
        });
        if(list_id.length > 0)
        {
            UIkit.modal.confirm('Are you sure delete this '+list_id.length+' data?', function(){             
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('productionwindow/ajax_bulk_delete')?>",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            reload_table();
                            UIkit.notify({
                        message : 'Records deleted!',
                        status  : 'danger',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                        }
                        else
                        {
                            alert('Failed.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            });
        }
        else
        {
            UIkit.modal.alert('No record selected!')
        }
    }
</script>