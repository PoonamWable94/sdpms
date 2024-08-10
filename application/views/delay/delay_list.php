<?php defined('BASEPATH') OR exit('No direct script access allowed');  
    $name = $this->session->userdata('uname');        
    $dept_name = $this->session->userdata('dept_name');  
?>
<div id="page_content">

    <!-- <div id="page_heading" data-uk-sticky="{ top: 40, media: 960 }">
        <div class="heading_actions">
            <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New Equipment"><i class="md-icon material-icons md-color-green-400">&#xE146;</i></a>
            <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
            <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons">&#xE5D5;</i></a>
        </div>
        <?php 
        $depts = $this->session->dept_name;
        ?>
        <h1>Activity List: <?= $depts?> Design</h1>
       
    </div> -->

    <div id="page_content_inner">
        
        <!-- DataTable -->
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> Add Delay 
                    <a href="javascript:void(0)"  onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add Delay"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                      <!--<a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                          <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons md-color-white">&#xE5D5;</i></a>-->
                </h1>
            </div>
            
             <div class="md-card-content">                    
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row md-input-filled input-simple">
                            <label for="projectNo">Projects : </label>
                            <select id="project_No" name="project_No" class="dept_progress">
                                <option value="">Select Project</option>
                                <?php                                        
                                    foreach ($projects as $project):                                    
                                    echo '<option value="'.$project->project_no.'">'.$project->project_no.'</option>';
                                    endforeach; 
                                ?>                                       
                            </select>                            
                          
                        
                       
                            <label for="dept_name">Departments : </label>
                            <select id="dept_name" name="dept_name" class="dept_progress">
                                <option value="">Select Department</option>
                                <?php                                        
                                    foreach ($departments as $department):                                    
                                    echo '<option value="'.$department->dept_name.'">'.$department->dept_name.'</option>';
                                    endforeach; 
                                ?>                                       
                            </select>                            
                        </div>  
                    </div>                          
                </div>

            <div class="md-card-content">
                <!-- <div class="dt_colVis_buttons"></div> -->
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>#</th>
                            <th>Action</th>
                            <th>Delay</th>
                            <th>Project</th>
                            <!--<th>Delay Time</th>-->
                            <th>Raised By</th>
                            <th>Raised On</th>
                            <th>Description</th>
                            <!--<th>Created Date</th>-->
                            <th>Pass on</th>
                            <th>Action Taken</th>
                            <th>Status</th>
                            <!--<th>Action</th>-->
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
                    <h3 class="uk-modal-title">Delay Details</h3>
                </div>
                
                <form action="#" id="form" class="uk-margin-top">
                    
                        <div class="uk-grid" >
                            <input type="hidden" value="" name="id"/>
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper" id="delay">
                                <label for="delay">Delay<span class="req">*</span></label>
                                 
                                <input type="text" id="delay" name="delay" required class="md-input label-fixed "/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                             <div class="parsley-row md-input-wrapper" id="projectNo"  >
                                <label for="project_no">Project No.<span class="req">*</span></label>
                                <select id="projectNo" name="projectNo" class="md-input" data-uk-tooltip="{pos:'top'}"   required>
                                <option value="" disabled="" selected="" hidden="">Select Project</option>
                                <?php                                       
                                    foreach ($projects as $project):                                    
                                    echo '<option value="'.$project->project_no.'">'.$project->project_no.'</option>';
                                    endforeach; 
                                 ?>                                       
                            </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="raised_by">
                                <label for="raised_by">Raised By<span class="req">*</span></label>
                                 <input type="text" id="raised_by" name="raised_by" value="<?php echo $dept_name; ?>" required class="md-input label-fixed "/>
                               
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            
                            
                            
                             <div class="parsley-row md-input-wrapper" id="raised_by_person">
                                <label for="raised_by_person">Person Name<span class="req">*</span></label>
                                 
                                <input type="text" id="raised_by_person" name="raised_by_person"  required class="md-input label-fixed lettersOnly"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                             
                             <div class="parsley-row md-input-wrapper" id="raised_on">
                                <label for="raised_on">Raised On<span class="req">*</span></label>
                                 <select id="raised_on" name="raised_on" class="md-input" data-uk-tooltip="{pos:'top'}" required>
                                    <option value="" disabled="" selected="" hidden="">Select Department</option>
                                                <?php                                        
                                    foreach ($departments as $department):                                    
                                    echo '<option value="'.$department->dept_name.'">'.$department->dept_name.'</option>';
                                    endforeach; 
                                ?>  
                                </select>
                               
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            
                            
                             <div class="parsley-row md-input-wrapper" id="raised_on_person">
                                <label for="raised_on_person">Person Name<span class="req">*</span></label>
                                 
                                <input type="text" id="raised_on_person" name="raised_on_person"  required class="md-input label-fixed lettersOnly"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                           
                            <div class="parsley-row md-input-wrapper" id="description">
                                <label for="description">Description<span class="req">*</span></label>
                                 
                                <textarea id="description" name="description" required class="md-input label-fixed lettersOnly"/></textarea>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="createdDtm" >
                                <label for="createdDtm">Delay Created Date<span class="req">*</span></label>
                                 
                                <input type="date" id="createdDtm" name="createdDtm" value="<?php echo date('Y-m-d'); ?>" required class="md-input label-fixed"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="pass_on">
                                <label for="pass_on">Pass On<span class="req">*</span></label>
                                <select id="pass_on" name="pass_on" class="md-input" data-uk-tooltip="{pos:'top'}" required>
                                    <option value="" disabled="" selected="" hidden="">Select Department</option>
                                                <?php                                        
                                    foreach ($departments as $department):                                    
                                    echo '<option value="'.$department->dept_name.'">'.$department->dept_name.'</option>';
                                    endforeach; 
                                ?>  
                                </select>
                                <!--<input type="text" id="pass_on" name="pass_on" required class="md-input label-fixed"/>-->
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="pass_on_person">
                                <label for="pass_on_person">Person Name<span class="req">*</span></label>
                                 
                                <input type="text" id="pass_on_person" name="pass_on_person" required class="md-input label-fixed"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                         
                            
                            <div class="parsley-row md-input-wrapper" id="action">
                                <label for="action">Action<span class="req">*</span></label>
                                 
                                <input type="text" id="action" name="action" required class="md-input label-fixed"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="complete_date" >
                                <label for="complete_date">Completion Date<span class="req">*</span></label>
                                 
                                <input type="date" id="complete_date" name="complete_date" value="<?php echo date('Y-m-d'); ?>" required class="md-input label-fixed"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="responsible_person">
                                <label for="responsible_person">Responsible Person<span class="req">*</span></label>
                                 
                                <input type="text" id="responsible_person" name="responsible_person" required class="md-input label-fixed"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div class="parsley-row md-input-wrapper" id="no_of_delay_days">
                                <label for="no_of_delay_days">No. Of Delay Days<span class="req">*</span></label>
                                 
                                <input type="text" id="no_of_delay_days" name="no_of_delay_days" required class="md-input label-fixed"/>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                            
                            <div id="outerdiv"></div>
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
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>

<script type="text/javascript">

        
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url();?>';
    
    $(document).ready(function() {
    
        table = $('#dt_mytable').DataTable({ 
    
            "processing": true, 
            "serverSide": true,
            "pageLength": 50,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('delay/ajax_list')?>",
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ -1, -2, 0, 1 ], 
                    "orderable": false,
                }
            ],
            // "dom": "<'uk-grid'<'uk-width-medium-1-1'tr>>" +
            //         "<'uk-grid'<'uk-width-small-1-4'f><'uk-width-small-1-4 text-center'l><'uk-width-small-1-4 uk-margin-small-top'i><'uk-width-small-1-4'p>>",
        });
    });
    
    $("#project_No").on('change', function(){   
     var project_No = $('#project_No').val();
    // var dept_name = $('#dept_name').val();   
         
         console.log(projectNo);
             $('#dt_mytable').DataTable().destroy(); 
            
            table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "pageLength": 50,
            "order": [], 

            "ajax": {
                "url": "<?php echo site_url('delay/ajax_list')?>",
                 "data":{'project_No':project_No},
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
   
   $("#dept_name").on('change', function(){   
    // var project_No = $('#project_No').val();
     var dept_name = $('#dept_name').val();   
         
         console.log(dept_name);
             $('#dt_mytable').DataTable().destroy(); 
            
            table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "pageLength": 50,
            "order": [], 

            "ajax": {
                "url": "<?php echo site_url('delay/ajax_list')?>",
                 "data":{'dept_name':dept_name},
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

    // $("#check-all").click(function () {
    //     $(".data-check").prop('checked', $(this).prop('checked'));
    // });

    // // Change the Status...
    // $(document).on('click','.status_checks',function()
    // {
    //     var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
    //     var msg=(status=='0')? 'Passive' : 'Active';

    //     if(confirm("Are you sure to "+ msg))
    //     {
    //         var current_element=$(this);
    //         var id = $(current_element).attr('data');
    //         var myurl="<?php echo base_url()."delay/update_status"?>";

    //         $.ajax({
    //             type:"POST",
    //             url:myurl,
    //             data:{"id":id,"status":status},
    //             success:function(data)
    //             {   
    //                 reload_table()
    //             }
    //         });
    //     }      
    // });
    
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
         $('#delay').show();
        $('#projectNo').show();
        $('#delay_time').show();
        $('#raised_by').show();
        $('#raised_on').show();
        $('#description').show();
        $('#createdDtm').hide();
        $('#pass_on').hide();
        $('#pass_on_person').hide();
        $('#complete_date').hide();
        $('#action').hide();
         $('#responsible_person').hide();
          $('#no_of_delay_days').hide();
        $("#btnSave").show();
        
        
        UIkit.modal($('.uk-modal'), {bgclose: false}).show();
    }
    
    function edit_data(id)
    {
        
        save_method = 'update';
        
        $('#form')[0].reset(); // reset form on modals
       
        $('#delay').hide();
        $('#projectNo').hide();
        $('#delay_time').hide();
        $('#raised_by').hide();
        $('#raised_by_person').hide();
        $('#raised_on').hide();
        $('#raised_on_person').hide();
        $('#description').hide();
        $('#createdDtm').hide();
        $('#action').hide();
        $('#complete_date').hide();
         $('#responsible_person').hide();
         $('#pass_on').show();
         $('#pass_on_person').show();
          $('#no_of_delay_days').hide();
        $("#btnSave").show();
        
        $('.parsley-row').removeClass('parsley-required'); // clear error class
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string
       
      
        
    
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('delay/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
               
                $('[name="delay"]').val(data.delay);
                $('[name="delay"]').attr("disabled", "disabled");
                $('[name="projectNo"]').val(data.projectNo);
                $('[name="projectNo"]').attr("disabled", "disabled");
                // $('[name="delay_time"]').val(data.delay_time);
                // $('[name="delay_time"]').attr("disabled", "disabled");
                $('[name="raised_by"]').val(data.raised_by);
                $('[name="raised_by"]').attr("disabled", "disabled");
                $('[name="raised_by_person"]').val(data.raised_by_person);
                $('[name="raised_by_person"]').attr("disabled", "disabled");
                $('[name="raised_on"]').val(data.raised_on);
                $('[name="raised_on"]').attr("disabled", "disabled");
                $('[name="description"]').val(data.description);
                $('[name="description"]').attr("disabled", "disabled");
                UIkit.modal($('.uk-modal'), {bgclose: false}).show();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
     function action_data(id)
    {
        
        save_method = 'action';
        
        $('#form')[0].reset(); // reset form on modals
        $('#delay').hide();
        $('#projectNo').hide();
        $('#delay_time').hide();
        $('#raised_by').hide();
        $('#raised_on').hide();
        $('#description').hide();
        $('#createdDtm').hide();
        $('#pass_on').hide();
        $('#pass_on_person').hide();
        $('#raised_on_person').hide();
        $('#raised_by_person').hide();
        $('#action').show();
        $('#complete_date').show();
        $('#responsible_person').show();
         $('#no_of_delay_days').hide();
        $("#btnSave").show();
        
        $('.parsley-row').removeClass('parsley-required'); // clear error class
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string
       
      
        
    
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('delay/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
               
                $('[name="delay"]').val(data.delay);
                $('[name="delay"]').attr("disabled", "disabled");
                $('[name="projectNo"]').val(data.projectNo);
                $('[name="projectNo"]').attr("disabled", "disabled");
                $('[name="delay_time"]').val(data.delay_time);
                $('[name="delay_time"]').attr("disabled", "disabled");
                $('[name="raised_by"]').val(data.raised_by);
                $('[name="raised_by"]').attr("disabled", "disabled");
                $('[name="raised_on"]').val(data.raised_on);
                $('[name="raised_on"]').attr("disabled", "disabled");
                $('[name="description"]').val(data.description);
                $('[name="description"]').attr("disabled", "disabled");
                UIkit.modal($('.uk-modal'), {bgclose: false}).show();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    function save()
    {

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('delay/ajax_add')?>";
        } else if(save_method == 'update') {
            url = "<?php echo site_url('delay/ajax_update')?>";
        }else{
            url = "<?php echo site_url('delay/ajax_take_action')?>";
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

    function view_data(id)
    {
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('parsley-required'); // clear error class
        $('.parsley-required').empty(); // clear error string
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('#delay').show();
        $('#projectNo').show();
        $('#delay_time').show();
        $('#raised_by').show();
        $('#raised_on').show();
        $('#description').show();
        $('#pass_on').show();
        $('#pass_on_person').show();
        $('#createdDtm').show();
        $('#complete_date').show();
        $('#action').show();
         $('#responsible_person').show();
          $('#no_of_delay_days').show();
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('delay/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data.dept_name);
                $('[name="id"]').val(data.id);
                $('[name="delay"]').val(data.delay);
                // Disable text box...
                $('[name="delay"]').attr("disabled", "disabled");
                $('[name="projectNo"]').val(data.projectNo);
                // Disable text box...
                $('[name="projectNo"]').attr("disabled", "disabled");
                $('[name="delay_time"]').val(data.delay_time);
                // Disable text box...
                $('[name="delay_time"]').attr("disabled", "disabled");
                $('[name="raised_by"]').val(data.raised_by);
                // Disable text box...
                $('[name="raised_by"]').attr("disabled", "disabled");
                $('[name="raised_by_person"]').val(data.raised_by_person);
                // Disable text box...
                $('[name="raised_by_person"]').attr("disabled", "disabled");
                $('[name="raised_on"]').val(data.raised_on);
                // Disable text box...
                $('[name="raised_on"]').attr("disabled", "disabled");
                $('[name="raised_on_person"]').val(data.raised_on_person);
                // Disable text box...
                $('[name="raised_on_person"]').attr("disabled", "disabled");
                $('[name="description"]').val(data.description);
                // Disable text box...
                $('[name="description"]').attr("disabled", "disabled");
                 $('[name="createdDtm"]').val(data.createdDtm);
                // Disable text box...
                $('[name="createdDtm"]').attr("disabled", "disabled");
                $('[name="pass_on"]').val(data.pass_on);
                // Disable text box...
                $('[name="pass_on"]').attr("disabled", "disabled");
                $('[name="pass_on_person"]').val(data.pass_on_person);
                // Disable text box...
                $('[name="pass_on_person"]').attr("disabled", "disabled");
                $('[name="complete_date"]').val(data.complete_date);
                // Disable text box...
                $('[name="complete_date"]').attr("disabled", "disabled");
                $('[name="action"]').val(data.action);
                // Disable text box...
                $('[name="action"]').attr("disabled", "disabled");
                $('[name="no_of_delay_days"]').val(data.no_of_delay_days);
                // Disable text box...
                $('[name="no_of_delay_days"]').attr("disabled", "disabled");
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
                url : "<?php echo site_url('delay/ajax_delete')?>/"+id,
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
                    url: "<?php echo site_url('delay/ajax_bulk_delete')?>",
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
            
            var logo = document.querySelector('#logo');
            logo.addEventListener('click', (event) => {
            var d = new Date()
            var yr=d.getFullYear();
            var month=d.getMonth()+1

            if (month<10)
            {
                month='0'+month
            }

            var date=d.getDate();

            if (date<10)
            {
                date='0'+date
            }

            var c_date=yr+"-"+month+"-"+date;
            document.getElementById('.complete_date').value=c_date;
            });
            console.log('c_date');
</script>
