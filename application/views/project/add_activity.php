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
    <!-- <a href="<?php echo base_url('add_new_project/');?>" data-uk-tooltip="{pos:'bottom'}" title="List Projects"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>             -->
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-card">
                    <!-- <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> Add New Project 
                            <a href="<?php echo base_url('add_new_project/');?>" class="spacing-tab" data-uk-tooltip="{pos:'bottom'}" title=""><i class="md-icon material-icons md-color-white">&#xe3c7;</i></a>
                        </h1>
                    </div> -->

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        
                        <form role="form" id="form_validation" action="<?=base_url();?>add_new_project/add_project" method="POST" autocomplete="off">
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="project_no"> Project No</label>
                                    <input type="text" id="project_no" name="project_no" value="<?php echo $this->input->post('project_no'); ?>" placeholder="Please enter project number" >
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("project_no");?></span>
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
                                            foreach ($equipment as $equipments):
                                    
                                            echo '<option value="'.$equipments->id.'">'.$equipments->equipment.'</option>';
                                            endforeach; 
                                        ?>                                       
                                    </select>
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("equipment");?></span>
                                </div>
                            </div>
                                                              
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" id="quantity" name="quantity" value="<?php echo $this->input->post('quantity'); ?>" placeholder="Please enter quantity" >
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("quantity");?></span>
                                </div>
                            </div>    
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="tag_number">Tag Number</label>
                                    <input type="text" id="tag_number" name="tag_number" value="<?php echo $this->input->post('tag_number'); ?>" placeholder="Please enter TAG number" >
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("tag_number");?></span>
                                </div>
                            </div>    

                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" name="description" value="<?php echo $this->input->post('description'); ?>" placeholder="Please enter description" >                                    
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("description");?></span>
                                </div>
                            </div> 
                            
                            <!-- <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="description">Description</label>                                    
                                    <textarea id="description" name="description" value="<?php echo $this->input->post('description'); ?>">  </textarea>
                                    <span class="uk-form-help-block uk-text-danger"><?=form_error("description");?></span>
                                </div>
                            </div>  -->
                            
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled input-simple">
                                    <label for="reason"></label>
                                    <button type="submit" name="submit" class="md-btn md-btn-success">Submit</button>
                                    <a href="<?=base_url();?>add_new_project" class="md-btn">Back</a>
                                </div>
                            </div>                              
                        </form>
                    </div>                                        
                </div>
            </div>
        </div>
    
        <div id="page_content_inner">              
            <!-- <div class="uk-grid"> -->
                <div class="uk-width-medium-1-1 uk-row-first">
                    <div class="md-card">
                        <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                            <h1 class="md-card-toolbar-heading-text"> Add Activity </h1>
                        </div> 

                        <div class="md-card-content">
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled multi-select">
                                <label for="projectNo">Projects</label>
                                    <div class="muliple-select">    <?=$projects?> 
                                        <span class="uk-form-help-block uk-text-danger" id="selectprojectno" ><?=form_error("projectNo");?></span>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row md-input-filled multi-select">
                                    <label for="projectNo">Department</label>
                                    <button class="md-btn md-btn-success" onclick="getDesignWindow()">Design</button>
                                    <button class="md-btn md-btn-success" onclick="getProductionWindow()" >Production</button>
                                    <button class="md-btn md-btn-success" >Purchase</button>
                                    <button class="md-btn md-btn-success" >Planning</button>
                                    <button class="md-btn md-btn-success" >Quality</button>
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
        var base_url = '<?php echo base_url();?>'; 
        var projectNO = $('#projectNo').val();    

        if(projectNO != ''){
            // $("#selectprojectno").html('');
            // $.ajax({
            //     url : base_url+'designwindow/loadActivityForm',
            //     type: "GET",
            //    data: {'projectNO':projectNO},
                // dataType: "json",
                
                // success: function(data){                       
                    window.location = base_url+'designwindow/addActivity'+'?projectNo='+projectNO; 
                    // window.location='/Mypage?Name='+id;        
                // },

            // });                                          
        }else{      
            $("#selectprojectno").html('Please Select Project').css('border-color', 'red');              
        }       
    }

   
</script>