
<link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css" media="screen">

<div id="page_content">  

  <div id="page_content_inner">              
    <div class="uk-grid">
      <div class="uk-width-medium-1-1 uk-row-first">

        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> Department Access </h1>
            </div> 

            <div class="md-card-content">
              <div class="uk-grid" data-uk-grid-margin> 
                                                      
                <div class="uk-width-medium-1-4">
                    <div class="parsley-row">
                        <label for="projectNo">Project No<span class="req" style="color:red"> * </span></label>
                        <?php
                            foreach ($department_access as $access):                                           
                                print_r($access->design);
                            endforeach; 
                        ?>
                        <span class="uk-form-help-block uk-text-danger" id="selectprojectno"><?=form_error("projectNo");?></span>
                    </div>
                </div>

                <!-- <div class="uk-width-medium-1-4"> -->
                  <div class="parsley-row">
                      <label for="projectNo">Department<span class="req" style="color:red"> * </span></label>
                          <button class="md-btn md-btn-success" onclick="getDesignWindow()">Design</button>&nbsp;
                          <button class="md-btn md-btn-success" onclick="getProductionWindow()" >Production</button>&nbsp;
                          <button class="md-btn md-btn-success" >Purchase</button>&nbsp;
                          <button class="md-btn md-btn-success" >Planning</button>&nbsp;                                                
                          <button class="md-btn md-btn-success" >Quality</button>&nbsp;
                  </div>
                <!-- </div> -->
              </div>                        
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
   
  <script type="text/javascript">
    $(document).ready(function(){
                          
    });    
  
  function getDesignWindow(){        
    var base_url = '<?php echo base_url();?>'; 
    var projectNO = $('#projectNo').val();    

    if(projectNO != ''){
        // $("#selectprojectno").html('');
        $.ajax({
            url : base_url+'designwindow/loadActivityForm',
            type: "GET",
        //    data: {'projectNO':projectNO},
            dataType: "json",
            
            success: function(data){                       
                window.location = base_url+'designwindow/addActivity'+'?projectNo='+projectNO; 
                // window.location='/Mypage?Name='+id;        
            },

        });                                          
    }else{      
        $("#selectprojectno").html('Please Select Project').css('border-color', 'red');              
    }       
  }

  
</script>