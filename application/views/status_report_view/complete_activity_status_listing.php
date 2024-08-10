

<style>
    .projectNoText{
        text-align: center;
    }
</style>

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> List Complete Activity Status
                    <!-- <a href="<?php echo base_url('add_new_project/add_project');?>" data-uk-tooltip="{pos:'bottom'}" title="Add New Design Activity"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                    <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                    <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons md-color-white">&#xE5D5;</i></a>
                    <a href="<?php echo $csvPath; ?>" data-uk-tooltip="{pos:'bottom'}" title="Export Data"><i class="md-icon material-icons md-color-white">archive</i></a>
                    <a href="<?=base_url();?>add_new_project/myactivities" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a> -->
                 </h1>
            </div>

            <div class="uk-width-medium-1-2 md-card-content ">
                <div class="uk-grid"> 
                   
                    <label for="projectNo">Project Number</label>
                   <!-- <?php print_r($project_list); ?> -->
                    <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <select name="projects_id" id="projects_id" value="<?php echo $this->input->post('projects_id'); ?>">
                                    <option value="">Select Project No</option>
                                    <?php foreach($project_list as $project){?>
                                        <option value="<?php echo $project['id'];?>"><?php echo $project['project_no'];?></option>

                                     <?php } ?>   
                                </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>    
            
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th>Project No</th>
                            <th>Design</th>
                            <th>Purchase</th>
                            <th>Production</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    
        
</div>

<script type="text/javascript">
    var table;
    var base_url = '<?php echo base_url();?>';
    
    $(document).ready(function() {
        // // var projectID = "5";
        // var projects_id = $('#projects_id').val();
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('status_report/complete_activity_status/list_activity'); ?>",
                // "data": {projects_id:projects_id},
                // "data": function(d) {
                //     d.projects_id = $('#projects_id').val();
                // },
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, -1, -2], 
                    "orderable": false,
                }
            ],           
        });
         $('#projects_id').change(function() {
            // table.ajax.reload();
            // var projectID = "5";
            $('#dt_mytable').DataTable().destroy(); 
         var projects_id = $('#projects_id').val();
       
         table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('status_report/complete_activity_status/list_activity'); ?>",
                "data": {projects_id:projects_id},
                // "data": function(d) {
                //     d.projects_id = $('#projects_id').val();
                // },
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, -1, -2], 
                    "orderable": false,
                }
            ],           
        });
        });

    });
   
    // $("#check-all").click(function () {
    //     $(".data-check").prop('checked', $(this).prop('checked'));
    // });

    // // Change the Status to Active or Passive
    // $(document).on('click','.status_checks',function(){
    //     var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
    //     var msg=(status=='0')? 'Passive' : 'Active';

    //     if(confirm("Are you sure to "+ msg + " this record"))
    //     {            
    //         var activityID = $(this).attr('data');
    //         // console.log(activityID);
    //         var myurl="<?php echo base_url()."status_report/design_material_status/update_status"?>";

    //         $.ajax({
    //             type:"POST",
    //             url:myurl,
    //             data:{"activityID":activityID,"status":status},
    //             success:function(data)
    //             {    
    //                 // console.log(data);
    //                 reload_table()
    //             }
    //         });
    //     }      
    // });
    
    // function reload_table()
    // {
    //     table.ajax.reload(null,false); //reload datatable ajax 
    // }

    // function view_activity_data(activityID,projectequipment)
    // {
    //     $('#show_call_details')[0].reset(); // reset form on modals
    //     $('.form-group').removeClass('parsley-required'); // clear error class
    //     $('.parsley-required').empty(); // clear error string
    //     $('.md-input').removeClass('md-input-danger'); // clear error class
        
    //     if(activityID > 0 && projectequipment > 0){
    //         $.ajax({
    //             url : base_url+'status_report/design_material_status/get_activity_detail',
    //             type: "GET",
    //             dataType: "JSON",
    //             data:{'projectequipment':projectequipment, 'activityID':activityID},
    //             success: function(data)
    //             {
    //                 // console.log(data);
    //                 var clientApproval = 'YES';
    //                 if(data.activity_details.clientApproval == 'no'){
    //                     clientApproval = 'NO';
    //                 }
                    
    //                 $('[name="projectNo"]').val(data.activity_details.projectNo);
    //                 $('[name="equipment"]').val(data.activity_details.equipment);
    //                 $('[name="tag_number"]').val(data.activity_details.tag_number);
    //                 $('[name="activity"]').val(data.activity_details.activity);               
    //                 $('[name="skill1"]').val(data.skill1);
    //                 $('[name="manpower1"]').val(data.activity_details.manpower1);               
    //                 $('[name="person1"]').val(data.person1);
    //                 $('[name="startDate"]').val(data.activity_details.startDate);
    //                 $('[name="targetDate"]').val(data.activity_details.targetDate);
    //                 $('[name="taskCompDate"]').val(data.activity_details.taskCompDate);
    //                 $('[name="clientApproval"]').val(data.activity_details.clientApproval);
    //                 $('[name="delayDays"]').val(data.activity_details.delayDays);
    //                 $('[name="prod_release"]').val(data.activity_details.prod_release);
                
    //                 // Disable text box...
    //                 $('[name="projectNo"]').attr("disabled", "disabled");
    //                 $('[name="equipment"]').attr("disabled", "disabled");
    //                 $('[name="tag_number"]').attr("disabled", "disabled");
    //                 $('[name="activity"]').attr("disabled", "disabled");
    //                 $('[name="skill1"]').attr("disabled", "disabled");
    //                 $('[name="manpower1"]').attr("disabled", "disabled");
    //                 $('[name="person1"]').attr("disabled", "disabled");
    //                 $('[name="startDate"]').attr("disabled", "disabled");
    //                 $('[name="targetDate"]').attr("disabled", "disabled");
    //                 $('[name="taskCompDate"]').attr("disabled", "disabled");
    //                 $('[name="clientApproval"]').attr("disabled", "disabled");
    //                 $('[name="delayDays"]').attr("disabled", "disabled");
    //                 $('[name="prod_release"]').attr("disabled", "disabled");

    //                 // $("#btnSave").hide();
    //                 UIkit.modal($('.uk-modal')).show();
    //             },
    //             error: function (jqXHR, textStatus, errorThrown){
    //                 alert('Error get data from database');
    //             }
    //         });
    //     }
    // }

    // function delete_data(activityID)
    // {
    //     UIkit.modal.confirm('Are you sure delete?', function(){ 
    //         $.ajax({
    //             url : "<?php echo site_url('designwindow/delete_new_activity')?>",
    //             type: "POST",
    //             dataType: "JSON",
    //             data: {'activityID':activityID},
    //             success: function(data)
    //             {
    //                 UIkit.modal(('.uk-modal')).hide();
    //                 reload_table();
    //                 UIkit.notify({
    //                     message : 'Record deleted!',
    //                     status  : 'danger',
    //                     timeout : 5000,
    //                     pos     : 'bottom-center'
    //                 })
    //             },
    //             error: function (jqXHR, textStatus, errorThrown)
    //             {
    //                 alert('Error deleting data');
    //             }
    //         });
    //     });
    // }

    // function bulk_delete()
    // {
    //     var list_id = [];
    //     $(".data-check:checked").each(function() {
    //             list_id.push(this.value);
    //     });
    //     if(list_id.length > 0)
    //     {
    //         UIkit.modal.confirm('Are you sure delete this '+list_id.length+' data?', function(){             
    //             $.ajax({
    //                 type: "POST",
    //                 data: {id:list_id},
    //                 url: "<?php echo site_url('designwindow/ajax_bulk_delete')?>",
    //                 dataType: "JSON",
    //                 success: function(data)
    //                 {
    //                     if(data.status)
    //                     {
    //                         reload_table();
    //                         UIkit.notify({
    //                     message : 'Records deleted!',
    //                     status  : 'danger',
    //                     timeout : 5000,
    //                     pos     : 'bottom-center'
    //                 })
    //                     }
    //                     else
    //                     {
    //                         alert('Failed.');
    //                     }
    //                 },
    //                 error: function (jqXHR, textStatus, errorThrown)
    //                 {
    //                     alert('Error deleting data');
    //                 }
    //             });
    //         });
    //     }
    //     else
    //     {
    //         UIkit.modal.alert('No record selected!')
    //     }
    // }
</script>