<?php
    $userRole = $this->session->userdata('role');
    $department_id = $this->session->userdata('dept'); 
?>
<style>
    .uk-grid>* {
        padding-left: 10px;
    }

    .uk-grid {
        text-align: left;
        margin: 0;
        padding: 0;
    }
    .header_design{
        text-align:center !important;        
    }

    .table_head{
        font-size: 16px;    
        background-color: #5f5e5c;
    }

    h4{
        color:#f88c3b !important;
        font-weight: 700 !important;
    }
</style>

<link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>assets/date_time_picker/css/bootstrap-datetimepicker.min.css"  rel="stylesheet" type="text/css" media="screen">

<div id="page_content">    
    <div id="page_content_inner">                                                 
        <div class="uk-width-medium-1-1 uk-row-first">
            <div class="md-card">
                <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                    <h1 class="md-card-toolbar-heading-text"> Department wise progress (Completed projects only)
                        <a href="javascript:void(0)" onclick="export_projects()" title="Export Projects"><i class="md-icon material-icons md-color-white">archive</i></a>
                    </h1>
                </div> 

                <div class="md-card-content">                    
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row md-input-filled input-simple">
                            <label for="projectNo">Projects</label>
                            <select id="projectNo" name="projectNo" class="dept_progress">
                                <option value="">Select Project</option>
                                <?php                                        
                                    foreach ($projects as $project):                                    
                                    echo '<option value="'.$project->id.'">'.$project->project_no.'</option>';
                                    endforeach; 
                                ?>                                       
                            </select>

                            <label for="department">Department</label>
                            <select id="department" name="department" class="dept_progress">
                                <option value="0">Select Department</option>
                                <option value="1">Design Department</option>
                                <option value="2">Purchase Department</option>
                                <option value="3">Production & Planning</option>
                            </select>
                            <span class="uk-form-help-block uk-text-danger selectprojectno"><?=form_error("projectNo");?></span>
                        </div>                         
                    </div>                          
                </div>

                <div id="projectinfo"></div>

                <!-- <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                    <thead>
                        <tr>
                            <th class="header_design"><b>Sr.</b></th>
                            <th class="header_design"><b>Equipment</b></th>
                            <th class="header_design"><b>Activity</b></th>                                        
                            <th class="header_design"><b>Start date</b></th>                                        
                            <th class="header_design"><b>End date</b></th>
                            <th class="header_design"><b>Actual Start Date</b></th>                                        
                            <th class="header_design"><b>Actual End Date</b></th>                                   
                            <th class="header_design"><b>Delay</b></th>                            
                        </tr>
                    </thead>
                    <tbody id="projectinfo">
                       
                    </tbody>
                </table>                 -->
            </div>            
        </div>
    </div>    
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.pt-BR.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.min.js"></script>
   
<script type="text/javascript">
    var base_url = '<?php echo base_url();?>'; 
    var projectNo = '';
    var department = '';

    $(document).ready(function(){       
    });

    $('.dept_progress').on('change',function(){
        projectNo = $('#projectNo').val();
        department = $('#department').val();
        var aUrl = base_url+'report/getDesignProjects';

        if(department > 0 && projectNo > 0){
            if(department == 2){
                aUrl = base_url+'report/getPurchaseProjects';
            }else if(department == 3){
                aUrl = base_url+'report/getProductionProjects';
            }

            $.ajax({
                url : aUrl,
                type: "GET",
                dataType: "JSON",
                data: {'projectNo':projectNo},
                success: function(data){ 
                    $('#projectinfo').html(data).css("color","black");                                                      
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    $('#projectinfo').html('No data found').css("color","red");  
                }                
            });            
        }else{
            $('#projectinfo').html('No data found').css("color","red"); 
        }
    });  
    
    function export_projects(){
        if(projectNo > 0 && department > 0){        
            window.location = base_url+'report/export_dept_project_data'+'?projectNo='+projectNo +'&department='+department; 
        }
    }
</script>