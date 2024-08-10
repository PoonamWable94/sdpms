<div id="page_content">
    <div id="page_content_inner">        
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> project notification 
                    <!-- <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New Activity"><i class="md-icon material-icons md-color-white">&#xE146;</i></a> -->
                    <!-- <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a> -->
                    <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons md-color-white">&#xE5D5;</i></a>
                </h1>
            </div>

            <div class="md-card-content">
                <!-- <div class="dt_colVis_buttons"></div> -->
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>#</th>
                            <th>Activity</th>
                            <th>Activity Data</th>
                            <!-- <th>Time Required</th>
                            <th>Status</th>
                            <th>CreatedDate Time</th> -->
                            <!-- <th>Action</th> -->
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
                    <h3 class="uk-modal-title">Design Activity Data</h3>
                </div>
            
                <form action="#" id="form" class="uk-margin-top">
                     <div class="uk-grid">
                        <input type="hidden" value="" name="id"/>
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <select name="activity" id="activity_id dept" required data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  title="Select Activity">
                                    <option value="">Select Activity</option>
                                   <?php                                    
                                        foreach ($design_activity as $activity):
                                           
                                            echo '<option value="'.$activity->id.'">'.$activity->design_activity.'</option>';
                                        endforeach; 
                                    ?>
                                </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>

                        </div>
                    </div>

                    <div class="uk-grid">                            
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="activity_data">Activity Data<span class="req">*</span></label>                                 
                                <input type="text" id="activity_data" name="activity_data" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid">                            
                        <div class="uk-width-1-2">
                            <div class="parsley-row md-input-wrapper">
                                <label for="activity_days">Activity Days<span class="req">*</span></label>                                 
                                <select name="activity_days" id="activity_days" required data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  title="Select Days">
                                    <option value="0">0 Day</option> 
                                    <option value="1">1 Day</option> 
                                    <option value="2">2 Days</option> 
                                    <option value="3">3 Days</option> 
                                    <option value="4">4 Days</option> 
                                    <option value="5">5 Days</option> 
                                    <option value="6">6 Days</option> 
                                    <option value="7">7 Days</option> 
                                    <option value="8">8 Days</option> 
                                    <option value="9">9 Days</option> 
                                    <option value="10">10 Days</option> 
                                    <?php
                                        // for($days = 1; $days < 30; $days++)                                        
                                            // echo '<option>'.str_pad($days,2,'0',STR_PAD_LEFT).'</option>';
                                    ?>                                
                                </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                        <div class="uk-width-1-2">
                            <div class="parsley-row md-input-wrapper">
                                <label for="activity_time">Activity Time</label>                                 
                                <select name="activity_time" id="activity_time" required data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  title="Select Time">
                                    <!-- <option value="">Select Time</option> -->
                                    <?php
                                        for($hours=0; $hours<24; $hours++){
                                            for($mins=0; $mins<60; $mins+=30){ 
                                                if(strlen($hours) == 1)
                                                    $hours = '0'.$hours;            
                                                if(strlen($mins) == 1)
                                                    $mins = '0'.$mins;                
                                    ?>
                                                <option value="<?php echo $hours.':'.$mins.':00'; ?>"><?php echo $hours.' hours '.$mins.' min'; ?></option>
                                    <?php        }
                                        }                                        
                                            // echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                            //                .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
                                    ?>
                                </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>

                        <div class="uk-width-1-2">
                            <div class="parsley-row md-input-wrapper">                                
                                <span id="errortag" class="uk-text-danger activity_validation"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                    <button class="md-btn md-btn-flat md-btn-flat-primary" id="btnSave" onclick="save()" type="button">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url();?>';
    
    $(document).ready(function() {    
        table = $('#dt_mytable').DataTable({     
            "processing": true, 
            "serverSide": true,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('Project_notification/ajax_list')?>",
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ -1, -2, 0, 1 ], 
                    "orderable": false,
                }
            ],           
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
            var myurl="<?php echo base_url()."design_activity_data/update_status"?>";

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

    // function add_data()
    // {
    //     save_method = 'add';
    //     $('#form')[0].reset(); // reset form on modals
    //     $('.md-input').removeClass('md-input-danger'); // clear error class
    //     $('.parsley-required').empty(); // clear error string
    //     $("#btnSave").show();                
    //     UIkit.modal($('.uk-modal'), {bgclose: false}).show();
    // }
    
    function save()
    {
        var url;
        var formData = new FormData($('#form')[0]);
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable         

        if(save_method == 'add') {
            url = "<?php echo site_url('design_activity_data/ajax_add')?>";
        } else {
            url = "<?php echo site_url('design_activity_data/ajax_update')?>";
        }
              
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data)
            {    
                if(data.status) 
                {
                    UIkit.modal($('.uk-modal')).hide();
                    reload_table();

                    UIkit.notify({
                        message : 'Design Activity Data Saved!',
                        status  : 'success',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                }
                else
                {
                    $('.activity_validation').html('Please enter all mandatory fields..');
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
            url : "<?php echo site_url('design_activity_data/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {                
                $('[name="id"]').val(data.id);
                $('[name="activity"]')[0].selectize.setValue(data.design_activity);
                $('[name="activity_data"]').val(data.activity_data);
                $('[name="activity_days"]')[0].selectize.setValue(data.activity_days);                
                $('[name="activity_time"]')[0].selectize.setValue(data.activity_time);                

                UIkit.modal($('.uk-modal'), {bgclose: false}).show();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }        

    function view_data(id)
    {
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('parsley-required'); // clear error class
        $('.parsley-required').empty(); // clear error string
        $('.md-input').removeClass('md-input-danger'); // clear error class

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('design_activity_data/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data.dept_name);
                $('[name="id"]').val(data.id);
                $('[name="activity"]')[0].selectize.setValue(data.design_activity);
                $('[name="activity_data"]').val(data.activity_data);
               
                $("#btnSave").hide();
                UIkit.modal($('.uk-modal')).show();

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
                url : "<?php echo site_url('design_activity_data/ajax_delete')?>/"+id,
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
                    url: "<?php echo site_url('design_activity_data/ajax_bulk_delete')?>",
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
