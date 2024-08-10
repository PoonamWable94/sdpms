<style>
    .project_over{   
        color: green;
    }
    .project_progress{   
        color: black;
    }
    .project_delayed{   
        color: red;
    }
    .table_head{
        font-size: 16px;    
        background-color: #5f5e5c;
    }

</style>

<div id="page_content">    
    <div id="page_content_inner">        
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <div class="md-card-toolbar-heading-text"> Project List
                    <a href="<?php echo base_url('add_new_project/add_project');?>" class="spacing-tab" title="Add new project"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>&nbsp;&nbsp;<a href="<?php echo base_url('add_new_project/export_project_data');?>" title="Export Projects"><i class="md-icon material-icons md-color-white">archive</i></a>
                </div>
            </div>
            <div class="md-card-content task-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap uk-table-condensed tablesorter tablesorter-altair" id="ts_issues4">
                        <thead>
                            <tr class="table_head">
                                <!-- <th><input type="checkbox" id="check-all"></th> -->
                                <th class="uk-text-center" style="color:#fff">#</th>
                                <th style="color:#fff">Project No / Client</th>                                
                                <th style="color:#fff">Equipment</th>
                                <th style="color:#fff">TAG No</th>
                                <th style="color:#fff">QTY</th>
                                <th style="color:#fff">PO Number</th>
                                <th style="color:#fff">PO Date</th>
                                <th style="color:#fff">Delivery Date</th>   
                                <th style="color:#fff">Completion Date</th>    
                                <th style="color:#fff">Dispatch Date</th>                                
                                <th style="color:#fff">Project Head</th>
                                <th style="color:#fff">Job Allocated To</th>
                                <th style="color:#fff">Status</th>                                
                                <th style="color:#fff">Action</th>
                                <?php //} ?>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> 

                <!-- POPUP Form -->
                <div class="uk-modal" id="modal_default">
                    <div class="uk-modal-dialog">
                        <button type="button" class="uk-modal-close uk-close"></button>

                        <div class="uk-modal-header">
                            <h3 class="uk-modal-title">Project Details</h3>
                        </div>
                                        
                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="project_no"><h5>Project No.</h5></label>
                                    <input type="text" name="project_no" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="client"><h5>Client</h5></label>
                                    <input type="text" name="client" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="equipment"><h5>equipment</h5></label>
                                    <input type="text" name="equipment"  disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>
                        
                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="tag_number"><h5>Tag Number</h5></label>
                                    <input type="text" name="tag_number" disabled class="md-input label-fixed"  />                                
                                </div>
                            </div>
                        </div>

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="equip_qty"><h5>QTY</h5></label>
                                    <input type="text" name="equip_qty" disabled class="md-input label-fixed"  />                                
                                </div>
                            </div>
                        </div>

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="manager_name"><h5>Project Head</h5></label>
                                    <input type="text" name="manager_name" id="manager_name" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div id="po_date_time" class="parsley-row md-input-wrapper">
                                    <label for="po_date_time"><h5>PO Date</h5></label>
                                    <input type="text" name="po_date_time" id="po_date_time" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div id="del_date" class="parsley-row md-input-wrapper">
                                    <label for="del_date"><h5>Delivery Date</h5></label>                                
                                    <input type="text" id="del_date" name="del_date" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>   

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div id="proj_comp_date" class="parsley-row md-input-wrapper">
                                    <label for="proj_comp_date"><h5>Project Completion Date</h5></label>                                
                                    <input type="text" id="proj_comp_date" name="proj_comp_date" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>   
                        
                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div id="act_desp_date" class="parsley-row md-input-wrapper">
                                    <label for="act_desp_date"><h5>Actual Dispatch Date</h5></label>                                
                                    <input type="text" id="act_desp_date" name="act_desp_date" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div> 

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="jobvendor"><h5>Job Allocated To</h5></label>
                                    <input type="text" name="jobvendor" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>  

                        <div class="uk-grid">                        
                            <div class="uk-width-1-1">
                                <div class="parsley-row md-input-wrapper">
                                    <label for="description"><h5>Description</h5></label>
                                    <input type="text" name="description" disabled class="md-input label-fixed" />                                
                                </div>
                            </div>
                        </div>                

                        <div class="uk-modal-footer uk-text-right">
                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>                    
                        </div>
                    </div>
                </div>            
            </div>
        </div>          
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.pt-BR.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function() {            
        table = $('#ts_issues4').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "pageLength": 50,
            "order": [], 

            "ajax": {
                "url": "<?php echo site_url('add_new_project/ajax_list')?>",
                "type": "POST"
            },

            "columnDefs": [
                { 
                   //"targets": [ 0, -1, -2],
                   "targets": [ 0, -1, -2], 
                    "orderable": false,
                }
            ],
        });
    });

    function view_data(id)
    {    
        // console.log(eid);    
        $.ajax({
            url : "<?php echo site_url('add_new_project/view_data')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                // console.log(data);                
                $('[name="project_no"]').val(data.project.project_no);
                $('[name="equipment"]').val(data.equipment);
                $('[name="client"]').val(data.project.company_name);                
                $('[name="po_date_time"]').val(data.project.po_date_time);
                $('[name="del_date"]').val(data.project.del_date);
                $('[name="proj_comp_date"]').val(data.project.proj_comp_date);
                $('[name="act_desp_date"]').val(data.project.act_desp_date);                
                $('[name="tag_number"]').val(data.tag_number);
                $('[name="equip_qty"]').val(data.equip_qty);
                $('[name="jobvendor"]').val(data.project.jobvendor);  
                $('[name="description"]').val(data.project.description);  
                $('[name="manager_name"]').val(data.project.manager_name);                
                UIkit.modal($('.uk-modal')).show();
            },

            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

     $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status...
    $(document).on('click','.status_checks',function()
    {
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Passive' : 'Active';

        if(confirm("Are you sure to "+ msg + "this record"))
        {
            var current_element=$(this);
            var id = $(current_element).attr('data');
            var myurl="<?php echo base_url()."add_new_project/update_status"?>";
            // console.log(id);
            $.ajax({
                type:"POST",
                url:myurl,
                data:{"id":id,"status":status},
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
    function save()
    {

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('add_new_project/ajax_add')?>";
        } else {
            url = "<?php echo site_url('add_new_project/ajax_update')?>";
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data)
            {
    
                if(data.status) //if success close modal and reload ajax table
                {
                    UIkit.modal($('.uk-modal')).hide();
                    reload_table();

                    UIkit.notify({
                        message : 'Record saved!',
                        status  : 'success',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        if(data.status == false)
                        {
                            $('[name="'+data.inputerror[i]+'"]').next().addClass('parsley-required'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').addClass('md-input-danger');
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });

    }
    function delete_data(id)
    {
        UIkit.modal.confirm('Are you sure you want to delete this call?', function(){ 
            $.ajax({
                url : "<?php echo site_url('add_new_project/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    table.ajax.reload(null,false);
                    UIkit.notify({
                        message : 'Project removed successfully!',
                        status  : 'danger',
                        timeout : 1000,
                        pos     : 'bottom-center'
                    })
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error removing project!! please try again..');
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
            // if(confirm('Are you sure delete this '+list_id.length+' data?'))
            // {
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('add_new_project/ajax_bulk_delete')?>",
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
            UIkit.modal.alert('No record selected!');
        }
    }
</script>