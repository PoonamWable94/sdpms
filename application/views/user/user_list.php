<?php
    $userRole = $this->session->userdata('role');
    $department_id = $this->session->userdata('dept');  
?>
<style>
.table_head{
    font-size: 16px;    
    background-color: #5f5e5c;
}
</style>
<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> 
                <a href="javascript:void(0);"  onclick="goBack()" title="Back" ><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>

                    List Users
                    <a href="<?php echo base_url(); ?>user/addNew" data-uk-tooltip="{pos:'bottom'}" title="Add New User"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>                                        
                 </h1>
            </div>
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr class="table_head">                            
                            <th style="color:#fff">Sr. No</th>
                            <th style="color:#fff">Department</th>                        
                            <th style="color:#fff">Role</th>    
                            <th style="color:#fff">Name</th>
                            <th style="color:#fff">Email</th>
                            <th style="color:#fff">Username</th>                               
                            <th style="color:#fff">Mobile</th>                                                        
                            <th style="color:#fff">Status</th>  
                            <th style="color:#fff">User Skills</th>                                                          
                            <?php if($userRole == 1 || $userRole == 2){ ?><th style="color:#fff">Password</th> <?php } ?>                        
                            <th style="color:#fff">Action</th>                            
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
        var aUrl = base_url+'user/userListing';
        var userRole = "<?php echo $userRole; ?>";
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
    
            "ajax": {
                "url": aUrl,  
                "data":{"userRole":userRole},             
                "type": "POST",
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, -1, -2, -3, -4, -5], 
                    "orderable": false,
                }
            ],           
        });
    });

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status to Active or Passive
    $(document).on('click','.status_checks',function(){
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Inactive' : 'Active';

        if(confirm("Are you sure to "+ msg + " this user"))
        {            
            var userId = $(this).attr('data');
            // console.log(activityID);
            var myurl="<?php echo base_url()."user/update_status"?>";

            $.ajax({
                type:"POST",
                url:myurl,
                data:{"userId":userId,"status":status},
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

    function delete_user_data(userId)
    {
        UIkit.modal.confirm('Are you sure delete this user?', function(){ 
            $.ajax({
                url : "<?php echo site_url('user/delete_user')?>",
                type: "POST",
                dataType: "JSON",
                data: {'userId':userId},
                success: function(data)
                {
                    UIkit.modal(('.uk-modal')).hide();
                    reload_table();
                    UIkit.notify({
                        message : 'User deleted!',
                        status  : 'danger',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting user');
                }
            });
        });
    }    
    function goBack() {
            window.history.back();
        }
</script>