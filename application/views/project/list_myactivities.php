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
</style>

<link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>assets/date_time_picker/css/bootstrap-datetimepicker.min.css"  rel="stylesheet" type="text/css" media="screen">

<div id="page_content">    
    <div id="page_content_inner">                                                 
        <div class="uk-width-medium-1-1 uk-row-first">
            <div class="md-card">
                <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                    <h1 class="md-card-toolbar-heading-text"> My Activity List </h1>
                </div> 

                <div class="md-card-content">                    
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row md-input-filled input-simple">
                            <label for="projectNo">Projects</label>
                            <select id="projectNo" name="projectNo">
                                <option value="">Select Project</option>
                                <?php                                        
                                    foreach ($projects as $project):                                    
                                    echo '<option value="'.$project->id.'">'.$project->project_no.'</option>';
                                    endforeach; 
                                ?>                                       
                            </select>
                            <span class="uk-form-help-block uk-text-danger selectprojectno"><?=form_error("projectNo");?></span>
                        </div>
                    </div>      
                    <br/>
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row md-input-filled multi-select">
                            <label for="projectNo">Department</label>

                            <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) { ?>
                                <button class="md-btn md-btn-success" onclick="getDesignWindow()">Design</button>                            
                                <button class="md-btn md-btn-success" onclick="getPurchaseWindow()">Purchase</button>                            
                                <button class="md-btn md-btn-success" onclick="getProductionWindow()">Production Component</button>                            
                                <button class="md-btn md-btn-success" onclick="getProductionAssemblyWindow()">Production Assembly</button>                            
                                <button class="md-btn md-btn-success" onclick="getQualityWindow()">Quality</button>                            
                                <button class="md-btn md-btn-success" onclick="getVendorWindow()">Vendor</button>
                            <?php } else{ 
                                if($department_id == 1 || $department_id == 7 || $department_id == 2){ ?>                              
                                    <button class="md-btn md-btn-success" onclick="getDesignWindow()">Design</button>
                            <?php }
                                if($department_id == 1 || $department_id == 7 || $department_id == 3){ ?>
                                    <button class="md-btn md-btn-success" onclick="getPurchaseWindow()">Purchase</button>
                            <?php }
                                if($department_id == 1 || $department_id == 7 || $department_id == 4){ ?>
                                    <button class="md-btn md-btn-success" onclick="getProductionWindow()">Production Component</button>
                            <?php } 
                                if($department_id == 1 || $department_id == 7 || $department_id == 4){ ?>
                                    <button class="md-btn md-btn-success" onclick="getProductionAssemblyWindow()">Production Assembly</button>
                            <?php }
                                if($department_id == 1 || $department_id == 7 || $department_id == 5){ ?>
                                    <button class="md-btn md-btn-success" onclick="getQualityWindow()">Quality</button>
                            <?php }
                                if($department_id == 1 || $department_id == 7 || $department_id == 6){ ?>
                                    <button class="md-btn md-btn-success" onclick="getVendorWindow()">Vendor</button>
                            <?php }                            
                            }
                            ?>
                            <!-- <button class="md-btn md-btn-success" onclick="getDesignWindow()">Design</button>
                            <button class="md-btn md-btn-success" onclick="getProductionWindow()" >Production</button>
                            <button class="md-btn md-btn-success" >Purchase</button>
                            <button class="md-btn md-btn-success" >Planning</button>
                            <button class="md-btn md-btn-success" >Quality</button> -->
                        </div>                        
                                            
                    </div>
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

    $(document).ready(function(){
            
    });

    $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd',
        language: 'English',
        autoclose: true,        
        
    }).on('po_date_time', function(ev){
        $(this).datetimepicker('remove');
    });
    
    $('#datetimepicker2').datetimepicker({
        format: 'yyyy-MM-dd',
        language: 'English',
        autoclose: true,    
    }).on('del_date', function(ev){
        $(this).datetimepicker('remove');
    });        

    function getDesignWindow(){        
        
        var projectNO = $('#projectNo').val();    

        if(projectNO != ''){           
            window.location = base_url+'designwindow'+'?projectID='+projectNO;             
        }else{      
            $(".selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }       
    }

    function getPurchaseWindow(){        
        
        var projectNO = $('#projectNo').val();    

        if(projectNO != ''){           
            window.location = base_url+'purchasewindow'+'?projectID='+projectNO;             
        }else{      
            $(".selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }       
    }

    function getProductionWindow(){        
        
        var projectNO = $('#projectNo').val();    

        if(projectNO != ''){           
            window.location = base_url+'productionwindow'+'?projectID='+projectNO;             
        }else{      
            $(".selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }       
    }

    function getProductionAssemblyWindow(){
        
        var projectNO = $('#projectNo').val();    

        if(projectNO != ''){           
            window.location = base_url+'productionwindow/assemblyList'+'?projectID='+projectNO;             
        }else{      
            $(".selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }       
    }

    function getQualityWindow(){        
        
        var projectNO = $('#projectNo').val();    

        if(projectNO != ''){           
            window.location = base_url+'qualitywindow'+'?projectID='+projectNO;             
        }else{      
            $(".selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }       
    }
   
</script>