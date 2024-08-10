<?php
?>

<div id="page_content">
    <!-- <div id="page_heading" data-uk-sticky="{ top: 40, media: 960 }">
        <div class="heading_actions">
            <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add User Access"><i class="md-icon material-icons md-color-green-400">&#xE146;</i></a>
            <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
            <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons">&#xE5D5;</i></a>
        </div>        
    </div> -->

    <div id="page_content_inner">        
        <div class="md-card">
        <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
            <h1 class="md-card-toolbar-heading-text"> List Department Access
                <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add User Access"><i class="md-icon material-icons md-color-green-400">&#xE146;</i></a>
                <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons">&#xE5D5;</i></a>
            </h1>
        </div>

            <div class="md-card-content">
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>#</th>
                            <th>User</th>
                            <th>Design</th>
                            <th>Purchase</th>
                            <th>Production</th>
                            <th>Quality</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- POPUP form for update access -->
        <div class="uk-modal" id="modal_default">
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>

                <div class="uk-modal-header" >
                    <h3 class="uk-modal-title" id="username">Add User</h3>
                </div>
                
                <form action="#" id="form" class="uk-margin-top">
                    <div class="uk-grid">                                                                                     
                        <div class="uk-width-1-1"> 
                            <div class="parsley-row" id="userroleId">
                                <select name="userroleID" id="userroleID" data-md-selectize-inline data-md-selectize-bottom data-uk-tooltip="{pos:'top'}"  title="Select User Role">
                                    <option value="">--select user--</option>                                                                        
                                    <?php                                        
                                        foreach ($users as $roles):                                
                                            echo '<option value="'.$roles->roleId.'">'.$roles->role.'</option>';
                                        endforeach; 
                                    ?>
                                </select>
                                <span class="uk-form-help-block uk-text-danger selectrole"></span>
                            </div>

                            
                            <div class="parsley-row md-input-wrapper">
                                <input type="hidden" id="roleID" name="roleID" value="" />
                                <input type="hidden" id="accessID" name="accessID" value="" />

                                <span class="icheck-inline">
                                    <label><input type="checkbox" name="design" id="design" checked="checked" value="1" /> Design</label>
                                </span>

                                <span class="icheck-inline">
                                    <label><input type="checkbox" name="purchase" id="purchase" checked="checked" value="1" /> Purchase</label>
                                </span>

                                <span class="icheck-inline">
                                    <label><input type="checkbox" name="production" id="production" checked="checked" value="1" /> Production</label>
                                </span>

                                <span class="icheck-inline">
                                    <label><input type="checkbox" name="quality" id="quality" checked="checked" value="1" /> Quality</label>
                                </span>
                            </div>
                        </div>                       
                    </div>
                </form>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                    <button class="md-btn md-btn-flat md-btn-flat-primary" id="btnSave" onclick="save()" type="button">Update</button>
                    <button class="md-btn md-btn-flat md-btn-flat-primary" id="addbtnSave" onclick="addUser()" type="button">Add</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">            
    var table;
    var base_url = '<?php echo base_url();?>';
    $(".uk-modal-close").click(function(){
        location.reload();
    });

    $(document).ready(function() {
        $('#addbtnSave').hide();

        table = $('#dt_mytable').DataTable({ 
    
            "processing": true, 
            "serverSide": true,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('accesscontrol/dept_access_list')?>",
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, 6, 7], 
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
        var status=($(this).hasClass("md-btn-primary")) ? '0' : '1';
        var msg=(status=='0')? 'Passive' : 'Active';

        if(confirm("Are you sure to "+ msg))
        {
            var current_element=$(this);
            var id = $(current_element).attr('data');
            var myurl="<?php echo base_url()."design_skills/update_status"?>";

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
        $('#userroleId').show();
        $('#design').hide();
        $('#purchase').hide();
        $('#production').hide();
        $('#quality').hide();
        // $('#username').hide();
        $('.icheck-inline').hide();

        $('#form')[0].reset(); 
        $('.md-input').removeClass('md-input-danger'); 
        $('.parsley-required').empty();

        $("#addbtnSave").show();
        $("#btnSave").hide();
        
        UIkit.modal($('.uk-modal'), {bgclose: false}).show();
    }
    
    function edit_data(accessID, isView)
    {       
        $('#userroleId').hide();           
        $('#form')[0].reset(); 
        $("#btnSave").show();

        $('.parsley-row').removeClass('parsley-required'); 
        $('.md-input').removeClass('md-input-danger'); 
        $('.parsley-required').empty(); 
    
        $.ajax({
            url : "<?php echo site_url('accesscontrol/view_dept_access_control')?>/" + accessID,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {                
                $('[name="roleID"]').val(data.roleID);
                $('[name="accessID"]').val(data.accessID);
                $('#username').html(data.role);
                // console.log(data.role);
                if(data.design == 1){
                    $('#design').attr('checked', true); 
                }else{
                    $('#design').attr('checked', false);
                }

                if(data.purchase == 1){
                    $('#purchase').attr('checked', true); 
                }else{
                    $('#purchase').attr('checked', false);
                }

                if(data.production == 1){
                    $('#production').attr('checked', true); 
                }else{
                    $('#production').attr('checked', false);
                }

                if(data.quality == 1){
                    $('#quality').attr('checked', true); 
                }else{
                    $('#quality').attr('checked', false);
                }    

                if(isView == 0){
                    $("#btnSave").show();
                }else{
                    $("#btnSave").hide();
                }                                                        
                UIkit.modal($('.uk-modal'), {bgclose: false}).show();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from database');
            }
        });
    }
    
    function save()
    {
        var url = "<?php echo base_url('accesscontrol/update_dept_access_control')?>";
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
                if(data.status)
                {
                    UIkit.modal($('.uk-modal')).hide();
                    location.reload();

                    UIkit.notify({
                        message : 'Record Updated Successfully!!',
                        status  : 'success',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                }                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error in update data access');                
            }
        });
    } 

    function addUser()
    {
        var url = "<?php echo base_url('accesscontrol/add_user')?>";        
        var userroleID = $('#userroleID').val();

        if(userroleID > 0){
            $.ajax({
                url : url,
                type: "POST",
                data: {'userroleID':userroleID},        
                dataType: "JSON",
                success: function(data)
                {
                    // console.log(data.status);
                    if(data.status)
                    {
                        UIkit.modal($('.uk-modal')).hide();
                        location.reload();

                        UIkit.notify({
                            message : 'Record saved!',
                            status  : 'success',
                            timeout : 5000,
                            pos     : 'bottom-center'
                        })
                    }else{
                        UIkit.modal($('.uk-modal')).hide();
                        alert('All users & roles are added before..'); 
                    }                
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Erroe adding user..');                
                }
            });
        }else{
            $('.selectrole').html('Please select user').css('border-color', 'red');
        }
    }    

    function delete_data(accessID)
    {
        UIkit.modal.confirm('Are you sure delete access?', function(){ 
            $.ajax({
                url : "<?php echo site_url('accesscontrol/delete_dept_access')?>/"+accessID,
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
                    data: {accessID:list_id},
                    url: "<?php echo site_url('accesscontrol/bulk_delete_dept_access')?>",
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
