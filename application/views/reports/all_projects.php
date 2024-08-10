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
    .export_projects{
        display: none;
    }
</style>

<link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>assets/date_time_picker/css/bootstrap-datetimepicker.min.css"  rel="stylesheet" type="text/css" media="screen">

<div id="page_content">    
    <div id="page_content_inner">                                                 
        <div class="uk-width-medium-1-1 uk-row-first">
            <div class="md-card">
                <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                    <h1 class="md-card-toolbar-heading-text"> Completed Project 
                        <a href="javascript:void(0)" onclick="export_projects()" title="Export Projects" class="export_projects"><i class="md-icon material-icons md-color-white">archive</i></a>
                    </h1>
                </div> 

                <div class="md-card-content">                    
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row md-input-filled input-simple">
                            <label for="projectNo">Projects : </label>
                            <select id="projectNo" name="projectNo" class="dept_progress">
                                <option value="">Select Project</option>
                                <?php                                        
                                    foreach ($projects as $project):                                    
                                    echo '<option value="'.$project->id.'">'.$project->project_no.'</option>';
                                    endforeach; 
                                ?>                                       
                            </select>                            
                        </div>                         
                    </div>                          
                </div>

                <div id="designprojectinfo"></div>
                <div id="purchaseprojectinfo"></div>
                <div id="productionprojectinfo"></div>

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
    var projectNo = 0;
    
    $(document).ready(function(){       
    });

    $('.dept_progress').on('change',function(){
        projectNo = $('#projectNo').val();       
        var aUrl = base_url+'report/getAllProjectsData';

        // console.log(projectNo);
        // console.log(department);
        if(projectNo > 0){  
            $('.export_projects').show();

            $.ajax({
                url : aUrl,
                type: "GET",
                dataType: "JSON",
                data: {'projectNo':projectNo},
                success: function(data){ 
                    $('#designprojectinfo').html(data.design).css("color","black");
                    $('#purchaseprojectinfo').html(data.purchase).css("color","black");
                    $('#productionprojectinfo').html(data.production).css("color","black");
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    $('#designprojectinfo').html('No data found').css("color","red");
                    $('#purchaseprojectinfo').html('No data found').css("color","red");
                    $('#productionprojectinfo').html('No data found').css("color","red");  
                }                
            });            
        }else{
            $('.export_projects').hide();
            $('#designprojectinfo').html('No data found').css("color","red"); 
            $('#purchaseprojectinfo').html('No data found').css("color","red");
            $('#productionprojectinfo').html('No data found').css("color","red");
        }
    });   
    
    function export_projects(){       
        window.location = base_url+'report/export_completed_project_data?id='+projectNo;
    }
</script>