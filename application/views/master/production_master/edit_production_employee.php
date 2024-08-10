<style>
    .user_skill_dd {
	    width: -moz-available !important;   
        width: -webkit-fill-available !important;  
    }  
    
    .uname_available{
        color:green;
    }
    .disable_field{
        pointer-events: none;
    }
</style>

<div id="page_content">
    <div id="page_content_inner">
        <!-- <h3 class="heading_c">Add New User Form</h3> -->
        <div class="uk-grid">
            <div class="uk-width-medium-1-2 uk-row-first">
                <div class="md-card">
                <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                    <h1 class="md-card-toolbar-heading-text"> Update Employee </h1>
                </div>

                    <div class="md-card-content large-padding">                                               
                        <form id="update_user" name="update_user" action="#" method="POST" autocomplete="off">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $userInfo->userId; ?>">
                            
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="fname">Full Name<span class="req">*</span></label>
                                        <input type="text" class="md-input lettersOnly" id="fname" name="fname" value="<?php echo ($this->input->post('fname')?$this->input->post('fname'):$userInfo->name); ?>"  >
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="email">Email<span class="req">*</span></label>
                                        <input type="email" id="email" class="md-input" name="email" maxlength="128" data-parsley-trigger="change" value="<?php echo ($this->input->post('email')?$this->input->post('email'):$userInfo->email); ?>">
                                        <span class="uk-form-help-block uk-text-danger" id="email_validate"></span>
                                    </div>
                                </div>
                            </div>                            

                            <div class="uk-grid" data-uk-grid-margin>                                
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="mobile">Mobile Number<span class="req">*</span></label>
                                        <input type="text" id="mobile" name="mobile" class="md-input numberOnly" data-parsley-trigger="change" maxlength="10" value="<?php echo ($this->input->post('mobile')?$this->input->post('mobile'):$userInfo->mobile); ?>" >
                                        <span class="uk-form-help-block uk-text-danger" id="mobile_validate"></span>
                                    </div>
                                </div>
                            </div>                                                                                                                      
                            
                            <div class="uk-grid" data-uk-grid-margin id="skill_div">
                                <div class="uk-width-medium-1-1"> 
                                    <label for="skills_id">Employee Skills <span class="req">*</span></label>                                                                      
                                    <?php echo $skillist; ?>
                                    <span id="errortag" class="uk-text-danger"></span>                                                                       
                                </div>
                            </div>
                           
                                                                                   
                            <span id="all_field_validation" class="uk-text-danger"></span> 
                            <br/>                            
                        </form>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                                <button type="submit"  class="md-btn md-btn-success update_user_class">Update</button>                                
                                <a href="<?=base_url();?>production_employee" class="md-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url();?>assets/login_user_js/addUser.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    var base_url = '<?php echo base_url();?>';     
   
    $(document).ready(function(){             

        $('.update_user_class').click(function(){              
            var formData = new FormData($('#update_user')[0]); 
            var aUrl = base_url+'production_employee/update_user';
            
            var userId = $('#userId').val(); 
            var fullname = $('#fname').val();   
            var email = $('#email').val();   
            var mobile = $('#mobile').val();  
            var mobile_no = mobile.length;                         
            skills = $('#skills_id').val();                                       

            if(fullname != '' && email != '' && mobile_no == 10 && skills != null){  
                $('#all_field_validation').html('');
                
                swal({
                    title: "Are you sure to update this employee?",                            
                    buttons: true,            
                }).then((addNewUser) => {
                    if(addNewUser){ 
                                        
                        $.ajax({
                            url : aUrl,
                            type: "POST",
                            dataType: "JSON",
                            data:formData,  
                            processData: false,
                            contentType: false, 
                            success: function(data, textStatus, jqXHR){ 
                                if(data.userID > 0){                        
                                    swal("Employee updated Successfull.").then((value) => {
                                        window.location = base_url+'production_employee'; 
                                    });
                                }else{
                                    swal({
                                        title: "Something went wrong.. Please try again!!",                        
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    });
                                }                                                             
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal({
                                    title: "Check if you have entered correct data!!",                                    
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                });
                            }                
                        });                     
                    }
                });     
            }else{                
                $('#all_field_validation').html('Please enter all fields..');
            }
        });             
    });     
</script>