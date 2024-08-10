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
                    <h1 class="md-card-toolbar-heading-text"> Add New Employee </h1>
                </div>

                    <div class="md-card-content large-padding">                                               
                        <form id="add_new_user" name="add_new_user" action="#" method="post" autocomplete="off">

                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="fname">Full Name<span class="req">*</span></label>
                                        <input type="text" class="md-input lettersOnly" id="fname" name="fname">
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" class="md-input" name="email" maxlength="128" data-parsley-trigger="change">
                                        <span class="uk-form-help-block uk-text-danger" id="email_validate"></span>
                                    </div>
                                </div>
                            </div>                            

                            <div class="uk-grid" data-uk-grid-margin>                                

                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="mobile">Mobile Number<span class="req">*</span></label>
                                        <input type="text" id="mobile" class="md-input numberOnly" value="<?php echo set_value('mobile'); ?>" name="mobile" data-parsley-trigger="change" maxlength="10">
                                        <span class="uk-form-help-block uk-text-danger" id="mobile_validate"></span>
                                    </div>
                                </div>
                            </div>                                                                                       
                            
                            <div class="uk-grid" data-uk-grid-margin id="skill_div">
                                <div class="uk-width-medium-1-1"> 
                                    <label for="skills_id">User Skills <span class="req">*</span></label>                                                                      
                                    <?php echo $skillsList; ?>                                   
                                    <span id="errortag" class="uk-text-danger"></span>                                                                       
                                </div>
                            </div>
                                                                               
                            <span id="all_field_validation" class="uk-text-danger"></span> 
                            <br/>                            
                        </form>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                                <button type="submit"  class="md-btn md-btn-success add_new_user_class">Submit</button>                               
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

    });

    $('.add_new_user_class').click(function(){              
        var formData = new FormData($('#add_new_user')[0]); 
        var aUrl = base_url+'production_employee/add_new_user';
        
        var fullname = $('#fname').val();  
        var email = $('#email').val();               
        var mobile = $('#mobile').val(); 
        var mobile_no = mobile.length;             

        var skills = $('#skills_id').val();             

        if(fullname != '' && mobile_no == 10 && skills != null){  
            $('#all_field_validation').html('');
            
            swal({
                title: "Are you sure to add this employee?",                            
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
                                swal("Employee Added Successfull.").then((value) => {
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
</script>