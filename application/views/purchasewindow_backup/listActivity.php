<?php
?>

<style>
    .projectNoText{
        text-align: center;
    }
</style>

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> List Purchase Files
                    <a href="<?php echo base_url('add_new_project/add_project');?>" data-uk-tooltip="{pos:'bottom'}" title="Add New Design Activity"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                    <a href="<?=base_url();?>add_new_project/myactivities" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                 </h1>
            </div>
            <!-- <div> -->
                <h5>&nbsp;&nbsp;&nbsp;&nbsp;Project & Client:- &nbsp;&nbsp;<?php echo $project_info->project_no.' / '.$project_info->company_name; ?></h5>
            <!-- </div> -->
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>                            
                            <th>#</th>                            
                            <th>Equipment / TAG</th>
                            <th>File Name</th>
                            <th>Uploaded By</th>
                            <th>Uploaded On</th>
                            <th>Download</th>                                                    
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
    var projectID = "<?php echo $projectID; ?>";   

    $(document).ready(function() {
        
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "pageLength": 50,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('purchasewindow/list_activity'); ?>",
                "data": {"projectID":projectID},
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0,1, -1], 
                    "orderable": false,
                }
            ],           
        });
    });

    function delete_data(activityID)
    {
        UIkit.modal.confirm('Are you sure delete?', function(){ 
            $.ajax({
                url : "<?php echo site_url('purchasewindow/delete_new_activity')?>",
                type: "POST",
                dataType: "JSON",
                data: {'activityID':activityID},
                success: function(data)
                {
                    UIkit.modal(('.uk-modal')).hide();
                    reload_table();
                    UIkit.notify({
                        message : 'File deleted!',
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
</script>