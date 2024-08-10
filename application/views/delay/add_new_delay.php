<?php
    $userRole = $this->session->userdata('role');
    $department_id = $this->session->userdata('dept');   
    $dept_name_session = $this->session->userdata('dept_name');
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

    <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) 
    { ?>               
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> Add New Project 
                            <a href="<?php echo base_url('add_new_project/');?>" class="spacing-tab" data-uk-tooltip="{pos:'bottom'}" title=""><i class="md-icon material-icons md-color-white">&#xe3c7;</i></a>
                        </h1>
                    </div>

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        
                        <form role="form" id="add_new_project_form" action="<?=base_url();?>add_new_project/add_project" method="POST" autocomplete="off">
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="project_no"> Project No</label>
                                    <input type="text" id="project_no" name="project_no" value="<?php echo $this->input->post('project_no'); ?>" placeholder="Please enter project number" >
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("project_no");?></span>
                                </div>
                            </div>
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="client">Client</label>
                                    <select id="client" name="client">
                                        <option value="">Select Client</option>
                                        <?php                                        
                                            foreach ($clientlist as $client) {?>                                    
                                                <option value="<?php echo $client->id; ?>"<?=$this->input->post('client') == $client->id ? ' selected="selected"' : '';?>><?php echo $client->company_name; ?></option>
                                            <?php }
                                        ?>                                       
                                    </select>
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("client");?></span>
                                </div>
                            </div>
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="po_number"> PO Number</label>
                                    <input type="text" id="po_number" name="po_number" value="<?php echo $this->input->post('po_number'); ?>" placeholder="Please enter PO Number" >
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("po_number");?></span>
                                </div>
                            </div>

                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled md-input-filled input-calendar input-append date" id="datetimepicker">                                                                        
                                    <label for="po_date_time">PO Date</label>                                                                       
                                        <input class="" type="text" name="po_date_time" id="po_date_time"  value="<?php echo $this->input->post('po_date_time'); ?>" placeholder="Please select PO Date">
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                        </span>                                                                          
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("po_date_time");?></span>
                                </div>  
                            </div>                              
                                
                            <div class="uk-width-medium-1-1"> 
                                <div class="parsley-row md-input-filled md-input-filled input-calendar input-append date" id="datetimepicker2">                                                                        
                                    <label for="del_date">Delivery Date</label>                                                                       
                                        <input class="" type="text" name="del_date" id="del_date"  value="<?php echo $this->input->post('del_date'); ?>" placeholder="Please select delivery date" >
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                        </span>                                                                          
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("del_date");?></span>
                                </div>  
                            </div> 

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="equipment">Equipment</label>
                                    <select id="equipment" name="equipment">
                                        <option value="">Select Equipment</option>
                                        <?php                                        
                                            foreach ($equipmentlist as $equipment):
                                    
                                            echo '<option value="'.$equipment->id.'">'.$equipment->equipment.'</option>';
                                            endforeach; 
                                        ?>                                       
                                    </select>
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("equipment");?></span>
                                </div>
                            </div>

                            <div class="uk-width-medium-1-1 equipBoxes">
                                <div class="parsley-row md-input-filled input-simple tagbox input-calendar" id="equipBoxes">  
                                                               
                                </div>                                
                            </div>                             

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="manager_name">Project Head</label>
                                    <select id="manager_name" name="manager_name">
                                        <option value="">Select Project Head</option>
                                        <?php                                        
                                            foreach ($managers as $manager) {?>                                    
                                                <option value="<?php echo $manager->userId; ?>"<?=$this->input->post('manager_name') == $manager->userId ? ' selected="selected"' : '';?>><?php echo $manager->name; ?></option>
                                            <?php }
                                        ?>                                       
                                    </select>
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("manager_name");?></span>
                                </div>
                            </div>

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="jobvendor">Job Allocated To</label>
                                    <input type="text" id="jobvendor" name="jobvendor" value="<?php echo $this->input->post('jobvendor'); ?>" placeholder="Please enter job allocated person" >                                    
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("jobvendor");?></span>
                                </div>
                            </div>  

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" name="description" value="<?php echo $this->input->post('description'); ?>" placeholder="Please enter description" >                                    
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("description");?></span>
                                </div>
                            </div>                                                        
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="reason"></label>
                                    <button type="submit" name="submit" class="md-btn md-btn-success" >Submit</button>
                                    <!-- <a href="javascript:void(0)" class="md-btn reset_form">Reset</a> -->
                                    <a href="<?=base_url();?>add_new_project" class="md-btn">Back</a>                                    
                                </div>
                            </div>                              
                        </form>
                    </div>                                        
                </div>
            </div>
        </div>
    <?php } ?>    
    
        <div id="page_content_inner">              
            <!-- <div class="uk-grid"> -->
            <div class="uk-width-medium-1-1 uk-row-first">
                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> Add Activity </h1>
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
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row md-input-filled input-simple">
                                <label for="projectequipment">Equipment</label>                                   
                                <select id="projectequipment" name="projectequipment">
                                    <option value="">Select Equipment</option>                                                                            
                                </select>
                                <span class="uk-form-help-block uk-text-danger selectprojectequipment"><?=form_error("projectequipment");?></span>
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row md-input-filled input-simple">
                                <label for="department">Department</label>

                                <select id="dept_name" name="dept_name">                                                                                   
                                    <?php                               
                                    if($userRole == 1 || $userRole == 2 || $userRole == 3){ // admin or super admin             
                                        foreach ($department as $dept) { ?>
                                                <option value="<?php echo $dept->dept_id ?>"><?php echo $dept->dept_name; ?></option>
                                        <?php } 
                                    }
                                    else { ?>
                                        <option value="<?php echo $department_id ?>"><?php echo $dept_name_session; ?></option>
                                    <?php } ?>                                    
                                </select>
                                <span class="uk-form-help-block uk-text-danger selectdepartment"><?=form_error("dept_name");?></span>
                            </div>                                                                         
                        </div>

                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row md-input-filled input-simple">
                                <label for="reason"></label>
                                <button type="submit" name="submit" class="md-btn md-btn-success" onclick="getDepartment()">Submit</button>                                                                        
                                <a href="<?=base_url();?>add_new_project" class="md-btn">Back</a>  
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- </div> -->
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
        $('#projectNo').change(function(){  
            var projectID = $(this).val();
            // console.log(projectID);
            if(projectID > 0){                   
                $.ajax({
                    url : base_url+'add_new_project/getProjectEquipment',
                    type: "POST",
                    data: {'projectID':projectID},
                    dataType: "json",                    
                    success: function(data){ 
                        // console.log(data);                                                 
                        $('#projectequipment').html(data);
                    },
                });    
            } 
        });       

        $('#equipment').change(function(){              
            var selectval = $("#equipment").val(); 
            // console.log(selectval);            
            if(selectval && selectval.length > 0){            
                var equipmentId = selectval[selectval.length-1]; 
                // console.log(equipmentId);  
                var idcnt = $('#tag_number-'+equipmentId).length;                        
                // console.log(idcnt);  

                if(equipmentId > 0 && idcnt == 0){                   
                    $.ajax({
                        url : base_url+'add_new_project/getEquipmentname',
                        type: "POST",
                        data: {'equipmentId':equipmentId},
                        // dataType: "json",                    
                        success: function(data){ 
                            // console.log(data); 
                            if(data != ''){  
                                // $('.tagbox').append('<div class="uk-width-medium-1-1"><div class="parsley-row md-input-filled input-calendar">');                                                                                                                               
                                $('.tagbox').append('<label for="tag_number_label" class="tag_number_label"></label>');                                
                                $('.tagbox').append('<input type="text" class="tagnobox" id="tag_number-'+equipmentId+'" name="tag_number['+equipmentId+']" placeholder="Enter '+data+' TAG Number">');            
                                $('.tagbox').append('<input type="text" class="equip_qty_box" id="equip_qty-'+equipmentId+'" name="equip_qty['+equipmentId+']" placeholder="Enter '+data+' Quantity" value="1">');
                                $('.tagbox').append('<a href="javascript:void(0)" style="color:red;" id="tag_number_cross-'+equipmentId+'" onclick="removeTag('+"'"+equipmentId+"'"+')" class="removeTag">&nbsp; X</a>');
                                // $('.tagbox').append('</div></div>');   
                                $('.tagbox').append('<br/>');                                                          
                            }                                                 
                        },
                    });    
                } 
            }else{
                $('.tagnobox').remove();
                $('.equip_qty_box').remove();
                $('.tag_number_label').remove();
                $('#equipBoxes').find('br').remove(); 
                $('.removeTag').remove();                       
            }                        
        });

        $('.reset_form').click(function(){
            location.reload();           
        });
          
    });        

    function removeTag(tag_number){       
        // console.log(tag_number);
        $('#tag_number-'+tag_number).remove();
        $('#equip_qty-'+tag_number).remove();
        $('#tag_number_cross-'+tag_number).remove();        
    }     

    function getDepartment(){
        var projectID = $('#projectNo').val();
        var projectequipment = $('#projectequipment').val(); 
        var deptID = $('#dept_name').val();

        if(projectID > 0){  
            if(projectequipment > 0){
                if(deptID > 0){
                    // console.log(dept);
                    if(deptID == 2){ //design
                        window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;
                    }else if(deptID == 3){ //purchase
                        window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                    }else if(deptID == 4){ //production
                        window.location = base_url+'productionwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                    }else if(deptID == 5){ //quality
                        window.location = base_url+'qualitywindow'+'?projectID='+projectID; 
                    }else if (deptID == 6){ // vendor
                        window.location = base_url+'vendor_window'+'?projectID='+projectID; 
                    }else{
                        $(".selectdepartment").html('Something went wrong.. please try again..').css('border-color', 'red');   
                    }
                }else{  
                    $(".selectprojectno").html('');                  
                    $(".selectdepartment").html('Please Select Department').css('border-color', 'red');     
                }

            }else{
                $(".selectprojectno").html('');
                $(".selectprojectequipment").html('Please Select Equipment').css('border-color', 'red'); 
            }                                                            
        }else{      
            $(".selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }        
    }     

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

</script>