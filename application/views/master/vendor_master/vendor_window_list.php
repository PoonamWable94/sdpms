<style>
     .table_head{
        font-size: 16px;    
        background-color: #5f5e5c;
        /*padding-left: 20px!important;*/
    }
</style>

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">
        <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
            <h1 class="md-card-toolbar-heading-text"> Vendor Outsource
                <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New Oursource"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                <a href="<?=base_url();?>add_new_project/add_project" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
            </h1>
        </div>
            <div class="md-card-content">
                <!-- <div class="dt_colVis_buttons"></div> -->
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr class="table_head">
                            <th><input type="checkbox" id="check-all"></th>
                            <th style="color:#fff">#</th>                            
                            <th style="color:#fff">Project</th>
                             <th style="color:#fff">Client</th> 
                            <th style="color:#fff">Vendor</th>
                             <th style="color:#fff">Location</th> 
                            <th style="color:#fff">Grade</th>
                            <th style="color:#fff">Material <br/> Description</th>                           
                            <th style="color:#fff">Work Scope</th>                            
                            <th style="color:#fff">Qty</th>
                            <th style="color:#fff">Pending Qty</th>
                            <th style="color:#fff">Material <br/> Send Date</th>
                            <th style="color:#fff">Material <br/> Required Date</th>
                            <th style="color:#fff">Actual Material <br/> Received date</th>
                            <th style="color:#fff">Status</th>                            
                            <th style="color:#fff">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

        <!-- POPUP Form -->
        <div class="uk-modal" id="modal_default">
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>

                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Vendor Details</h3>
                </div>
                
                <form action="#" id="form" class="uk-margin-top">
                    <input type="hidden" value="" name="id"/>                      
                    <input type="hidden" value="<?php echo $projectID; ?>" name="projectID" id="projectID"/>                      
                    
                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <label for="vendor_name">Vendor Name<span class="req">*</span></label>
                            <div class="parsley-row md-input-wrapper">                                
                                <select name="vendor_name" id="vendor_name" data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  >
                                    <!-- <option value="">Select Vendor</option>   -->
                                    <?php                                        
                                        foreach ($vendor_name as $data):                                        
                                            echo '<option value="'.$data->id.'">'.$data->name.'</option>';
                                        endforeach; 
                                    ?>                                 
                                </select>
                                <!-- <span id="errortag" class="uk-text-danger"><?php echo form_error('vendor_name');?></span> -->
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <label for="location">Vendor location<span class="req">*</span></label>
                            <div class="parsley-row md-input-wrapper">                               
                                <select name="location" id="location" class="location" data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  >                                    
                                    <option value="">Select Location</option>  
                                    <?php                                        
                                        foreach ($vendor_location as $location):                                        
                                            echo '<option value="'.$location->id.'">'.$location->location.'</option>';
                                        endforeach; 
                                    ?>
                                </select>
                                <!-- <span id="errortag" class="uk-text-danger"><?php echo form_error('location');?></span> -->
                            </div>
                        </div>
                    </div>                    

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <label for="grade">Material Grade<span class="req">*</span></label>
                            <div class="parsley-row md-input-wrapper">                                
                                <select name="grade" id="grade" data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  >
                                    <option value="MS"> MS </option>
                                    <option value="SS"> SS </option>
                                </select>
                                <!-- <span id="errortag" class="uk-text-danger"></span> -->
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <label for="description">Material Description<span class="req">*</span></label>
                            <div class="parsley-row md-input-wrapper">                                
                                <select name="description" id="description" data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  >                                    
                                    <option value="">Select Material</option>  
                                    <?php                                        
                                        foreach ($materail_description as $data):                                        
                                            echo '<option value="'.$data->id.'">'.$data->description.'</option>';
                                        endforeach; 
                                    ?>
                                </select>
                                <!-- <span id="errortag" class="uk-text-danger"></span> -->
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <label for="work_scope">Work Scope<span class="req">*</span></label>
                            <div class="parsley-row md-input-wrapper">                                
                                <select name="work_scope" id="work_scope" data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  >                                    
                                    <option value="">Select Work Scope</option>  
                                    <?php                                        
                                        foreach ($work_scope as $work):                                        
                                            echo '<option value="'.$work->id.'">'.$work->work.'</option>';
                                        endforeach; 
                                    ?>
                                </select>
                                <!-- <span id="errortag" class="uk-text-danger"></span> -->
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="qty">Total Quantity<span class="req">*</span></label>
                                <input type="text" id="qty" name="qty" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="pending_qty">Pending Quantity<span class="req">*</span></label>
                                <input type="text" id="pending_qty" name="pending_qty" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="send_date">Material Send Date<span class="req">*</span></label>
                                <input type="date" id="send_date" name="send_date" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="reqd_date">Material Required Date<span class="req">*</span></label>
                                <input type="date" id="reqd_date" name="reqd_date" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                    
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="actual_rec_date">Actual Material Received Date<span class="req">*</span></label>
                                <input type="date" id="actual_rec_date" name="actual_rec_date" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                    <button class="md-btn md-btn-flat md-btn-flat-primary" id="btnSave" onclick="save()" type="button">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url();?>';
    // var projectID = $('#projectID').val();
    var projectID = "<?php echo $projectID; ?>";
    
    $(document).ready(function() {
    
        var table_url = base_url+'vendor_window/ajax_list'+'?projectID='+projectID;

        table = $('#dt_mytable').DataTable({ 
    
            "processing": true, 
            "serverSide": true,
            "order": [], 
            "pageLength": 50,
    
            "ajax": {
                "url": table_url,
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ -1, -2, 0, 1,2,3,4,5,6,7,8,9,10,11,12,13 ],                     
                    "orderable": false,
                }
            ],
            // "dom": "<'uk-grid'<'uk-width-medium-1-1'tr>>" +
            //         "<'uk-grid'<'uk-width-small-1-4'f><'uk-width-small-1-4 text-center'l><'uk-width-small-1-4 uk-margin-small-top'i><'uk-width-small-1-4'p>>",
        });
    });

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status...
    $(document).on('click','.status_checks',function()
    {
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Passive' : 'Active';

        if(confirm("Are you sure to "+ msg))
        {
            var current_element=$(this);
            var id = $(current_element).attr('data');
            var myurl="<?php echo base_url()."vendor_window/update_status"?>";

            $.ajax({
                type:"POST",
                url:myurl,
                data:{"id":id,"status":status},
                success:function(data)
                {   
                    reload_table()
                }
            });
        }      
    });
    
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

    function add_data()
    {
        save_method = 'add';

        $('#form')[0].reset(); // reset form on modals
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string

        $("#btnSave").show();
         
        
        UIkit.modal($('.uk-modal'), {bgclose: false}).show();
    }

    function save()
    {

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('vendor_window/ajax_add')?>";
        } else {
            url = "<?php echo site_url('vendor_window/ajax_update')?>";
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
    
    function edit_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $("#btnSave").show();

        $('.parsley-row').removeClass('parsley-required'); // clear error class
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string        
            
        $.ajax({
            url : "<?php echo site_url('vendor_window/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                // console.log(data);
                $('[name="id"]').val(data.id);                
                $('[name="actual_rec_date"]').val(data.actual_rec_date);
                $('[name="reqd_date"]').val(data.reqd_date);
                $('[name="pending_qty"]').val(data.pending_qty);
                $('[name="send_date"]').val(data.send_date);
                $('[name="qty"]').val(data.qty);
                $('[name="grade"]')[0].selectize.setValue(data.grade);    
                // $('[name="job_no"]')[0].selectize.setValue(data.projectId);    
                // $('[name="client"]')[0].selectize.setValue(data.clientId);    
                $('[name="vendor_name"]')[0].selectize.setValue(data.vendorId);    
                $('[name="location"]')[0].selectize.setValue(data.locationId);    
                $('[name="description"]')[0].selectize.setValue(data.descId);    
                $('[name="work_scope"]')[0].selectize.setValue(data.workid);                
                UIkit.modal($('.uk-modal'), {bgclose: false}).show();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }        

    function delete_data(id)
    {
        UIkit.modal.confirm('Are you sure delete?', function(){ 
            $.ajax({
                url : "<?php echo site_url('vendor_window/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
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
            // if(confirm('Are you sure delete this '+list_id.length+' data?'))
            // {
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('vendor_window/ajax_bulk_delete')?>",
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
    
    // $('.location').on('change',function(){
    //     var location = $(this).val();
    //     // console.log(categoryId);
    //     console.log(location);       
    //     if(location > 0){                   
    //         $.ajax({
    //             url : base_url+'vendor_window/get_vendors',
    //             type: "POST",
    //             data: {'location':location},
    //             dataType: "json",                    
    //             success: function(data){ 
    //                 console.log(data);                                                 
    //                 $('#vendor_name').html(data);
    //             },
    //         });    
    //     } 
    // }); 

</script>
