<?php    
    $csvPath = base_url().'qualitywindow/export_csv/'.$projectID;
    $is_dossier_doc_exists = 0;
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
                <h1 class="md-card-toolbar-heading-text"> List Component Activity                    
                    <a href="<?=base_url();?>add_new_project/myactivities" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                 </h1>
            </div>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;Project & Client:- &nbsp;&nbsp;<?php echo $project_info->project_no.' / '.$project_info->company_name; ?></h5>
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>                            
                            <th>#</th>                                                        
                            <th>Equipment</th>
                            <th>TAG No</th>
                            <th>Activity</th>
                            <th>Quantity</th>                           
                            <th>Supervisor</th>                                                       
                            <th>Client Approval</th>
                            <th>Release</th>
                            <th>Manufacturing Type</th>                             
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> List Assembly Activity                                       
                    <a href="<?=base_url();?>add_new_project/myactivities" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                 </h1>
            </div>            
            <div class="md-card-content">                
                <table id="dt_mytable1" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>                            
                            <th>#</th>                                                        
                            <th>Equipment</th>
                            <th>TAG No</th>
                            <th>Activity</th>
                            <th>Quantity</th>                           
                            <th>Supervisor</th>                                                       
                            <th>Client Approval</th>
                            <th>Release</th>
                            <th>Manufacturing Type</th>                             
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> Dossier List of Documents </h1>
            </div>            
            <div class="md-card-content">                
                <table id="dt_mytable2" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>                            
                            <th>#</th>                                                        
                            <th>Document</th>                                                  
                            <th>Status</th>                                                       
                            <th>Remark</th>                           
                        </tr>
                    </thead>
                    <form id="update_all_documents" name="update_all_documents" method="post">
                        <tbody>
                            <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">
                            <?php
                                //check if doc already added or not
                                $this->load->model('quality_window_model');
                                $check_doc_cnt = $this->quality_window_model->check_dossier_doc($projectID);
                                if($check_doc_cnt > 0){ // doc already added
                                    $sr_no = 1;
                                    $docs = $this->quality_window_model->get_dossier_doc_details($projectID);
                                    foreach($docs as $key){  ?>                                        
                                        <tr>
                                            <input type="hidden" id="name_doc_id" name="name_doc_id[]" value="<?php echo $key->name_doc_id; ?>">
                                            <td>
                                                <?php echo $sr_no; ?>
                                            </td>
                                            <td>
                                                <?php echo $key->name_doc; ?>
                                            </td>

                                            <td>
                                                <select id="status-<?php echo $sr_no; ?>" name="status[]">                                                                                                                                  
                                                    <option value="yes"<?=$key->status == 'yes' ? ' selected="selected"' : '';?>>Yes</option>                                                                                          
                                                    <option value="no"<?=$key->status == 'no' ? ' selected="selected"' : '';?>>No</option>                                                                                     
                                                </select>                                            
                                            </td>

                                            <td>
                                                <input type="text" id="remark-<?php echo $sr_no; ?>" name="remark[]" value="<?php echo $key->remark; ?>">
                                            </td>
                                        </tr>
                                <?php $sr_no++; } ?>                                
                                <?php }else{ 
                                    $is_dossier_doc_exists = 1; ?>
                                    <button type="submit" name="submit" onclick="add_dossier_doc()" class="md-btn md-btn-success">Add Document</button>
                            <?php } ?>
                        </tbody>
                    </form>
                </table>
                <?php if($is_dossier_doc_exists == 0){ ?>
                    <button type="submit" name="submit" class="md-btn md-btn-success update_all_docs">Update All</button>            
                <?php } ?> 
                 <a href="<?=base_url();?>add_new_project/myactivities" class="md-btn">Back</a>  
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var table, table1, table2;
    var base_url = '<?php echo base_url();?>';
    var projectID = "<?php echo $projectID; ?>";

    $(document).ready(function() {
        var projectID = "<?php echo $projectID; ?>";
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
            "iDisplayLength": 50,
            "bPaginate": false,
            "bLengthChange": false,
            "searching": false,
    
            "ajax": {
                "url": "<?php echo site_url('qualitywindow/list_activity'); ?>",
                "data": {"projectID":projectID},
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, 1,2,3,4,5,6,7,8,9], 
                    "orderable": false,
                }
            ],           
        }); 

        table1 = $('#dt_mytable1').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "order": [], 
            "iDisplayLength": 50,
            "bPaginate": false,
            "bLengthChange": false,
            "searching": false,
    
            "ajax": {
                "url": "<?php echo site_url('qualitywindow/list_assembly_activity'); ?>",
                "data": {"projectID":projectID},
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0, 1,2,3,4,5,6,7,8,9], 
                    "orderable": false,
                }
            ],           
        });           
    }); 
    
    $('.update_all_docs').click(function(){          
        var formData = new FormData($('#update_all_documents')[0]); 
        var aUrl = base_url+'qualitywindow/updateAllDocumentsOnce';        
        
        if(projectID > 0){
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",
                data:formData,  
                processData: false,
                contentType: false, 
                success: function(data, textStatus, jqXHR){ 
                    if(data > 0){                           
                        swal("Documents Status Updated Successfully.")
                            .then((value) => {
                                window.location = base_url+'qualitywindow'+'?projectID='+projectID; 
                        });
                    }                                                          
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal({
                        title: "Please enter all fields and try again!!",                      
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }                
            }); 
        }          
    });

    function add_dossier_doc(){
        var aUrl = base_url+'qualitywindow/add_dossier_doc';
        var projectID = "<?php echo $projectID; ?>";
        if(projectID > 0){
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",
                data: {"projectID":projectID},
                success: function(data){ 
                    if(data > 0){                                         
                        swal("Document created successfully!!.")
                            .then((value) => {
                                window.location = base_url+'qualitywindow'+'?projectID='+projectID; 
                        });
                    }else{
                        swal({
                            title: "Something went wrong.. Please try again!!",                        
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        });
                    }                                                             
                }      
            });
        }
    }
</script>