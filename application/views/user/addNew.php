<style>
    .user_skill_dd {
	    width: -moz-available !important;   
        width: -webkit-fill-available !important;  
    }  
    
    .uname_available{
        color:green;
    }
</style>

<div id="page_content">
    <div id="page_content_inner">
        <!-- <h3 class="heading_c">Add New User Form</h3> -->
        <div class="uk-grid">
            <div class="uk-width-medium-1-2 uk-row-first">
                <div class="md-card">
                <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                    <h1 class="md-card-toolbar-heading-text"> Add New User </h1>
                </div>

                    <div class="md-card-content large-padding">                                               
                        <form id="add_new_user" name="add_new_user" action="#" method="post" enctype="multipart/form-data" autocomplete="off">

                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="fullname">Full Name<span class="req">*</span></label>
                                        <input type="text" class="md-input lettersOnly" id="fname" name="fname">
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="email">Email<span class="req">*</span></label>
                                        <input type="text" id="email" class="md-input" name="email" maxlength="128" data-parsley-trigger="change">
                                        <span class="uk-form-help-block uk-text-danger" id="email_validate"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="uname">Username<span class="req">*</span></label>
                                        <input type="text" onkeyup="check_uname()" class="md-input unique_uname valid_uname" id="uname" name="uname">
                                    </div>
                                    <span id="uname_validation" ></span>
                                </div>
                            
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="password">Password<span class="req">*</span></label>
                                        <input type="password" class="md-input" id="password" name="password" maxlength="20">
                                    </div>
                                </div>                                
                            </div>

                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="cpassword">Confirm Password<span class="req">*</span></label>
                                        <input type="text" id="cpassword" class="md-input" name="cpassword" maxlength="20" data-parsley-trigger="change">
                                    </div>
                                    <span class="uk-text-danger" id="cpassword_validation" ></span>
                                </div>

                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="Mobile">Mobile Number<span class="req">*</span></label>
                                        <input type="text" id="mobile" class="md-input numberOnly" value="<?php echo set_value('mobile'); ?>" name="mobile" data-parsley-trigger="change" maxlength="10">
                                        <span class="uk-form-help-block uk-text-danger" id="mobile_validate"></span>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                <label for="Mobile">User Role<span class="req">*</span></label>
                                    <select id="role" name="role" data-md-selectize data-md-selectize-bottom>
                                        <option value="">Select Role..</option>
                                        <?php if(!empty($roles)) {
                                                foreach ($roles as $rl) { ?>
                                                    <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <label for="Mobile">Department<span class="req">*</span></label>
                                        <select id="dept" name="dept" data-md-selectize data-md-selectize-bottom>
                                            <option value="">Select Department..</option>
                                            <?php if(!empty($dept)) {
                                                    foreach ($dept as $depts) { ?>
                                                        <option value="<?php echo $depts->dept_id ?>"><?php echo $depts->dept_name; ?></option>
                                            <?php } } ?>
                                        </select>                                    
                                </div>                            
                            </div>                                
                            
                            <div class="uk-grid" data-uk-grid-margin id="skill_div">
                                <div class="uk-width-medium-1-1"> 
                                    <label for="skills_id">User Skills <span class="req">*</span></label>                                                                      
                                    <select name="skills[]" id="skills_id" data-md-selectize-inline data-md-selectize-bottom multiple>                                                                                
                                    
                                    </select>                                    
                                    <span id="errortag" class="uk-text-danger"></span>                                                                       
                                </div>
                            </div>
                                                       
                            <!-- <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <label for="ParentCompanyImage">User Signature (For Engineer)</label>
                                    <br>
                                    <input class="md-input label-fixed" type="file" name="emp_signature" />
                                    <span id="errortag" class="uk-text-danger"><?php //echo form_error('emp_signature'); ?></span>
                                </div>
                            </div> -->
                            <span id="all_field_validation" class="uk-text-danger"></span> 
                            <br/>                            
                        </form>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                                <button type="submit"  class="md-btn md-btn-success add_new_user_class">Submit</button>
                                <!-- <input type="reset" class="md-btn md-btn-default reset_form" value="Reset" /> -->
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
    var global_roleId = global_deptId = 0;
    // $('#dept').prop('disabled', true);

    $(document).ready(function(){
        $('#skill_div').show();       

        $('.add_new_user_class').click(function(){              
            var formData = new FormData($('#add_new_user')[0]); 
            var aUrl = base_url+'user/add_new_user';
            var pwd_match = 0;
            var uname = $('#uname').val();   
            var get_size = uname.length;
            var fullname = $('#fname').val();   
            var password = $('#password').val();   
            var cpassword = $('#cpassword').val();  
            if(password == cpassword){
                pwd_match = 1;
                $('#cpassword_validation').html('');
            } else{
                pwd_match = 0;
                $('#cpassword_validation').html('password dont match');                
            }
            var mobile = $('#mobile').val(); 
            var mobile_no = mobile.length;  
            var role = $('#role').val();   
            var dept = $('#dept').val(); 

            var skills = '';            
            if(dept == 1 || role <= 3){
                skills = 'admin';
            }else{
                skills = $('#skills_id').val(); 
            }

            if(get_size >= 8 && fullname != '' && pwd_match > 0 && mobile_no == 10 && role > 0 && dept > 0 && skills != null){  
                $('#all_field_validation').html('');
                
                swal({
                    title: "Are you sure to add this user?",                            
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
                                    swal("User added Successfull.").then((value) => {
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

        $('#role').change(function(){  
            var aUrl = base_url+'user/user_skills';
            var roleId = global_roleId = $(this).val();
            // $('#dept').removeAttr('disabled');
            // $('#dept').prop('disabled', false);
           if(roleId >= 4 && global_deptId >= 2){   
                $('#skill_div').show(); 
                $.ajax({
                    url : aUrl,
                    type: "POST",
                    data: {'deptId':global_deptId},
                    dataType: "json",                    
                    success: function(data){ 
                        //    console.log(data);                                                 
                        $('#skills_id').selectize()[0].selectize.clearOptions();
                            var $select = $('#skills_id').selectize();
                            var selectize = $select[0].selectize;
                            $.each( data, function( key, value ) {                           
                                selectize.addOption({value:value.id,text:value.skills});
                            });
                            selectize.refreshOptions(); 
                        
                        $('#skills').html(data);
                    },
                });                                  
           } else{
                $('#skill_div').hide();
           }
       });
        
       $('#dept').change(function(){  
            var aUrl = base_url+'user/user_skills';
            var deptId = global_deptId = $(this).val();
           
            if(deptId >= 2 && global_roleId >= 4){   
                $('#skill_div').show();                
                $.ajax({
                    url : aUrl,
                    type: "POST",
                    data: {'deptId':deptId},
                    dataType: "json",                    
                    success: function(data){ 
                        //    console.log(data);                                                 
                        $('#skills_id').selectize()[0].selectize.clearOptions();
                            var $select = $('#skills_id').selectize();
                            var selectize = $select[0].selectize;
                            $.each( data, function( key, value ) {                           
                                selectize.addOption({value:value.id,text:value.skills});
                            });
                            selectize.refreshOptions(); 
                        
                        $('#skills').html(data);
                    },
                });    
            } else{
                    $('#skill_div').hide();
            }           
           
       });

       $('.reset_form').click(function(){
            location.reload();           
        }); 
    }); 

    function check_uname(){        
        var uname = $('#uname').val();
        // console.log(uname);
        var get_size = uname.length;

        if(get_size >= 8){
            $('#uname_validation').html('');

            var aUrl = base_url+'user/check_uname';

            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",
                data: { 'uname':uname },
                success: function(data){
                    // console.log(data);
                    if(data > 0){
                        $('#uname_validation').addClass('uk-text-danger');
                        $('#uname_validation').html('User name not available..'); 
                    }else{                        
                        $('#uname_validation').removeClass('uk-text-danger');
                        $('#uname_validation').addClass('uname_available');
                        $('#uname_validation').html('User name available..'); 
                    }
                }
            });

        }else{
            $('#uname_validation').addClass('uk-text-danger');
            $('#uname_validation').html('Please enter minimum 8 charactes');
        }
    }
</script>
