<div id="page_content">    
    <div id="page_content_inner">        
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> 
                    <a href="javascript:void(0);" onclick="goBack()" title="Back">
                        <i class="md-icon material-icons md-color-white">keyboard_backspace</i>
                    </a>
                    List Of All Employees
                    <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New Employee">
                        <i class="md-icon material-icons md-color-white">&#xE146;</i>
                    </a>
                    <!-- <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload">
                        <i class="md-icon material-icons md-color-white">&#xE5D5;</i>
                    </a>  -->
                    <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete">
                        <i class="md-icon material-icons md-color-red-500">delete</i></a>                   
                </h1>
            </div>
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>Sr.No</th>
                            <th>Department</th>
                            <th>Skill</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Status</th>
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
                    <h3 class="uk-modal-title">Employee Details</h3>
                </div>
                <form action="#" id="form" class="uk-margin-top">
                    <input type="hidden" value="" id="id" name="id"/>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="dept_name">Department<span class="req">*</span></label>
                                <select name="dept_id" id="dept_id" class="dept_name md-input label-fixed" required>
                                    <option value="0">Select</option>
                                        <?php foreach ($dept_name as $main): ?>
                                            <option value="<?php echo $main->dept_id; ?>"><?php echo $main->dept_name; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="skill">Skill<span class="req">*</span></label>
                                <select name="skill_id" id="skill_id" class="skill md-input label-fixed" required>
                                 <option value="0">Select</option>
                                 <?php foreach ($skill as $main): ?>
                                <option value="<?php echo $main->id; ?>"><?php echo $main->skill; ?></option>
                                   <?php endforeach; ?>
                                   </select>
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="employee">Employee Name<span class="req">*</span></label>
                                <input type="text" name="employee" id="employee" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="employee">Employee Email<span class="req">*</span></label>
                                <input type="text" name="email" id="email" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row md-input-wrapper">
                                <label for="employee">Employee Phone<span class="req">*</span></label>
                                <input type="text" name="phone" id="phone" required class="md-input label-fixed" />
                                <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <br>
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
    var save_method;
    var table;
    var base_url = '<?php echo base_url();?>';

    $(document).ready(function() {
        table = $('#dt_mytable').DataTable({ 
            "processing": true,
            "serverSide": true,
            "order": [],
            "pageLength": 100,
            "lengthMenu": [100, 200, 300, 400, 500],
            "ajax": {
                "url": "<?php echo site_url('Employee/ajax_list')?>",
                "type": "POST"
            },
            "columnDefs": [
                { "targets": [ -1, -2, 0, 1 ], "orderable": false }
            ],
        });

        $("#check-all").click(function () {
            $(".data-check").prop('checked', $(this).prop('checked'));
        });
    });

    $(document).on('click','.status_checks',function()
    {
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Inactive' : 'Active';

        if(confirm("Are you sure to "+ msg))
        {
            var current_element=$(this);
            var id = $(current_element).attr('data');
            var myurl="<?php echo base_url()."Employee/update_status"?>";

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

    function reload_table() {
        table.ajax.reload(null, false);
    }

    function add_data() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.md-input').removeClass('md-input-danger');
        $('.parsley-required').empty();
        $("#btnSave").show();
        UIkit.modal($('#modal_default'), {bgclose: false}).show();
    }

    function edit_data(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $("#btnSave").show();
        $('.parsley-row').removeClass('parsley-required');
        $('.md-input').removeClass('md-input-danger');
        $('.parsley-required').empty();

        $.ajax({
            url: "<?php echo site_url('Employee/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="dept_id"]').val(data.dept_id);                
                $('[name="skill_id"]').val(data.skill_id);
                $('[name="employee"]').val(data.employee);
                $('[name="email"]').val(data.email);
                $('[name="phone"]').val(data.phone);
                UIkit.modal($('#modal_default'), {bgclose: false}).show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error getting data');
            }
        });
    }

    function save() {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url = (save_method == 'add') ? "<?php echo site_url('Employee/ajax_add')?>" : "<?php echo site_url('Employee/ajax_update')?>";
        var formData = new FormData($('#form')[0]);

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    UIkit.modal($('#modal_default')).hide();
                    reload_table();
                    UIkit.notify({
                        message: 'Record saved!',
                        status: 'success',
                        timeout: 5000,
                        pos: 'bottom-center'
                    });
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                        $('[name="'+data.inputerror[i]+'"]').addClass('md-input-danger');
                    }
                }
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / updating data');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            }
        });
    }

    function delete_data(id) {
        UIkit.modal.confirm('Are you sure to delete?', function() { 
            $.ajax({
                url: "<?php echo site_url('Employee/ajax_delete')?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    UIkit.modal($('#modal_default')).hide();
                    reload_table();
                    UIkit.notify({
                        message: 'Record deleted!',
                        status: 'danger',
                        timeout: 5000,
                        pos: 'bottom-center'
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
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
        if (list_id.length > 0) {
            UIkit.modal.confirm('Are you sure to delete these '+list_id.length+' records?', function() {
                $.ajax({
                    type: "POST",
                    data: {id: list_id},
                    url: "<?php echo site_url('Employee/ajax_bulk_delete')?>",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            reload_table();
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
            alert('No data selected');
        }
    }
    function goBack() {
            window.history.back();
        }
</script>
</script>
