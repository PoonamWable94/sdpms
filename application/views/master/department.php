<div id="page_content">    
    <div id="page_content_inner">        
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> 
                <a href="javascript:void(0);"  onclick="goBack()" title="Back" ><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a> 
                    List Of All Department
                    <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New Department"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>                    
                    <!-- <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons md-color-white">&#xE5D5;</i></a>   
                                       -->
                                       <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                 </h1>
            </div>
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>Sr.No.</th>
                            <th>Department</th>
                            <th>Status</th>
                            <!-- <th>Created on</th> -->
                            <th>Action</th>
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
                    <h3 class="uk-modal-title">Department Details</h3>
                </div>
                
                <form action="#" id="form" class="uk-margin-top">
                    <div class="uk-grid">
                         <input type="hidden" value="" id="dept_id" name="dept_id"/>
                     
                    </div>
                        <div class="uk-grid">
                        
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="dept_name">Department Name<span class="req">*</span></label>
                                <input type="text" name="dept_name" id="dept_name" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
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
            "pageLength": 100,
    
            "ajax": {
                "url": "<?php echo site_url('Department/ajax_list')?>",
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

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status...
    $(document).on('click','.status_checks',function()
    {
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Inactive' : 'Active';

        if(confirm("Are you sure to "+ msg))
        {
            var current_element=$(this);
            var dept_id = $(current_element).attr('data');
            var myurl="<?php echo base_url()."Department/update_status"?>";

            $.ajax({
                type:"POST",
                url:myurl,
                data:{"dept_id":dept_id,"status":status},
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
    
    function edit_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $("#btnSave").show();

        $('.parsley-row').removeClass('parsley-required'); // clear error class
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string
            
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('Department/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="dept_id"]').val(data.dept_id);                
                $('[name="dept_name"]').val(data.dept_name);
                
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
            url = "<?php echo site_url('Department/ajax_add')?>";
        } else {
            url = "<?php echo site_url('Department/ajax_update')?>";
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

    function view_data(dept_id)
    {
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('parsley-required'); // clear error class
        $('.parsley-required').empty(); // clear error string
        $('.md-input').removeClass('md-input-danger'); // clear error class

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('Department/ajax_edit')?>/" + dept_id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {                
                $('[name="dept_id"]').val(data.dept_id);
                $('[name="dept_name"]').val(data.dept_name);
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
                url : "<?php echo site_url('Department/ajax_delete')?>/"+id,
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

    function bulk_delete() {
    var list_id = [];
    $(".data-check:checked").each(function() {
        list_id.push(this.value);
    });
    if(list_id.length > 0) {
        UIkit.modal.confirm('Are you sure delete this ' + list_id.length + ' data?', function() {
            $.ajax({
                type: "POST",
                data: { id: list_id }, // Correct the key to 'id'
                url: "<?php echo site_url('Department/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data) {
                    if(data.status) {
                        reload_table();
                        UIkit.notify({
                            message: 'Records deleted!',
                            status: 'danger',
                            timeout: 5000,
                            pos: 'bottom-center'
                        });
                    } else {
                        alert('Failed.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        });
    } else {
        UIkit.modal.alert('No record selected!');
    }
}

      
</script>
<script>
        function goBack() {
            window.history.back();
        }
</script>
