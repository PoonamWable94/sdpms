<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text">
                <a href="javascript:void(0);"  onclick="goBack()" title="Back" ><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>   
                    List  Of Production Employee
                    <a href="<?php echo base_url(); ?>production_employee/addNew" data-uk-tooltip="{pos:'bottom'}" title="Add New Employee"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>                                        
                    
                 </h1>
            </div>
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>                            
                            <th>Sr. No</th>                                
                            <th>Name</th>
                            <th>Email</th>                                                        
                            <th>Mobile</th>  
                            <th>Employee Skills</th>                                                        
                            <th>Status</th>                                                                                                                                       
                            <th>Action</th>                            
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
        var aUrl = base_url+'production_employee/userListing';        
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
            "pageLength" : 100,
    
            "ajax": {
                "url": aUrl,                              
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

    // Change the Status to Active or Passive
    $(document).on('click','.status_checks',function(){
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Inactive' : 'Active';

        if(confirm("Are you sure to "+ msg + " this employee"))
        {            
            var userId = $(this).attr('data');
            // console.log(activityID);
            var myurl="<?php echo base_url()."production_employee/update_status"?>";

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
        UIkit.modal.confirm('Are you sure delete this employee?', function(){ 
            $.ajax({
                url : "<?php echo site_url('production_employee/delete_user')?>",
                type: "POST",
                dataType: "JSON",
                data: {'userId':userId},
                success: function(data)
                {
                    UIkit.modal(('.uk-modal')).hide();
                    reload_table();
                    UIkit.notify({
                        message : 'employee deleted!',
                        status  : 'danger',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting employee');
                }
            });
        });
    }    
</script>
<script>
        function goBack() {
            window.history.back();
        }
</script>