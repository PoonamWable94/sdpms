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
                    <h1 class="md-card-toolbar-heading-text"> Update User </h1>
                </div>

                    <div class="md-card-content large-padding">                                               
                        <form id="update_user" name="update_user" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $userInfo->userId; ?>">
                            
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="fullname">Full Name<span class="req">*</span></label>
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
                                        <label for="uname">Username </label>
                                        <input type="text" class="md-input disable_field" id="uname" name="uname" value="<?php echo $userInfo->uname; ?>" >
                                    </div>
                                    <span id="uname_validation" ></span>
                                </div>
                            
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="password">Password </label>
                                        <input type="text" class="md-input disable_field" id="password" name="password" value="<?php echo $userInfo->pwd; ?>" >
                                    </div>
                                </div>                                
                            </div>

                            <div class="uk-grid" data-uk-grid-margin>                                

                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="Mobile">Mobile Number<span class="req">*</span></label>
                                        <input type="text" id="mobile" name="mobile" class="md-input numberOnly" data-parsley-trigger="change" maxlength="10" value="<?php echo ($this->input->post('mobile')?$this->input->post('mobile'):$userInfo->mobile); ?>" >
                                        <span class="uk-form-help-block uk-text-danger" id="mobile_validate"></span>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2 disable_field">
                                <label for="Mobile">User Role </label>
                                    <select id="role" name="role" data-md-selectize data-md-selectize-bottom>
                                        <option value="">Select Role..</option>
                                        <?php if(!empty($roles)) {
                                                foreach ($roles as $rl) { ?>
                                                    <option value="<?php echo $rl->roleId ?>" <?=$rl->roleId == $userInfo->roleId ? ' selected="selected"' : '';?>><?php echo $rl->role; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="uk-width-medium-1-2 disable_field">
                                    <label for="Mobile">Department </label>
                                        <select id="dept" name="dept" data-md-selectize data-md-selectize-bottom>
                                            <option value="">Select Department..</option>
                                            <?php if(!empty($dept)) {
                                                    foreach ($dept as $depts) { ?>
                                                        <option value="<?php echo $depts->dept_id ?>" <?=$depts->dept_id == $userInfo->dept_id ? ' selected="selected"' : '';?>><?php echo $depts->dept_name; ?></option>
                                            <?php } } ?>
                                        </select>                                    
                                </div>                            
                            </div>                                
                            
                            <?php if ($userInfo->dept_id != 1) { ?>
                                <div class="uk-grid" data-uk-grid-margin id="skill_div">
                                    <div class="uk-width-medium-1-1"> 
                                        <label for="skills_id">User Skills <span class="req">*</span></label>                                                                      
                                        <?php echo $skillist; ?>
                                        <span id="errortag" class="uk-text-danger"></span>                                                                       
                                    </div>
                                </div>
                            <?php } ?>
                                                                                   
                            <span id="all_field_validation" class="uk-text-danger"></span> 
                            <br/>                            
                        </form>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                                <button type="submit"  class="md-btn md-btn-success update_user_class">Update</button>                                
                                <a href="<?=base_url();?>user" class="md-btn">Back</a>
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
            var aUrl = base_url+'user/update_user';
            
            var userId = $('#userId').val(); 
            var fullname = $('#fname').val();   
            var email = $('#email').val();   
            var mobile = $('#mobile').val();  
            var mobile_no = mobile.length;  
            
            var skills = '';
            var dept = $('#dept').val(); 
            if(dept == 1){
                skills = 'admin';
            }else{
                skills = $('#skills_id').val(); 
            }
                          

            if(fullname != '' && email != '' && mobile_no == 10 && skills != null){  
                $('#all_field_validation').html('');
                
                swal({
                    title: "Are you sure to update this user?",                            
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
                                    swal("User updated Successfull.").then((value) => {
                                        window.location = base_url+'user'; 
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
                                    // text: "Check if you have entered correct data!",
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
