<style>
.md-btn-success {
  background: #f88c3b !important;
}

</style>
<!doctype html>
<html>
    <head>
        <title>Login Shree Datta Industries PMS</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no"/>

        <link rel="icon" type="image/jpg" href="<?php echo base_url();?>assets/themes/img/sd.png" sizes="32x32">
        <link rel="icon" type="image/jpg" href="<?php echo base_url();?>assets/themes/img/sd.png" sizes="32x32">
        <!-- uikit -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/bower_components/uikit/css/uikit.almost-flat.min.css"/>
        <!-- altair admin login page -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/login_page.min.css" />
    </head>
  
<body class="login_page login_page_v2">

    <?php echo validation_errors('<div class="uk-alert uk-alert-danger">', ' <a href="#" class="uk-alert-close uk-close"></a></div>'); ?>
    <div class="uk-container uk-container-center">
        <div class="md-card">
            <div class="md-card-content padding-reset">
                <div class="uk-grid uk-grid-collapse">
                    <div class="uk-width-large-2-3 uk-hidden-medium uk-hidden-small">
                        <div class="login_page_info uk-height-1-1" style="background-image: url('<?=base_url();?>assets/themes/img/others/img.jpg')">
                            <div class="info_content">
                                <h1 class="heading_b">Shree Datta Industries</h1>
                                <p>Project Management System</p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3 uk-width-medium-2-3 uk-container-center">
                        <div class="login_page_forms">
                            <div id="login_card">
                                <div id="login_form">
                                    
                                    <div class="login_heading">
                                        <div class="user_avatar"></div>
                                    </div>

                                    <h3 class="full_width_in_card heading_c uk-text-center">Log In</h3>

                                    <br>
                                    
                                    <?php
                                        $error = $this->session->flashdata('error');
                                        if($error)
                                        {
                                        ?>
                                            <div class="uk-alert uk-alert-danger" data-uk-alert>
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $error; ?>                    
                                            </div>
                                    <?php }
                                        $success = $this->session->flashdata('success');
                                        if($success)
                                        { ?>
                                            <div class="uk-alert uk-alert-success">
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $success; ?>                    
                                            </div>
                                    <?php } ?>

                                    
                                    <form action="<?php echo base_url();?>loginMe" method="POST">
                                        
                                        <!-- <div class="uk-form-row">
                                            <label for="login_username">Email</label>
                                            <input class="md-input" type="email" name="email" required/>
                                            <div class="uk-text-danger"> <?php //echo form_error('login_username');?> </div>  
                                        </div> -->

                                        <div class="uk-form-row">
                                            <label for="uname">Username</label>
                                            <input class="md-input" type="text" id="uname" name="uname" required/>
                                            <div class="uk-text-danger"> <?php echo form_error('login_username');?> </div>  
                                        </div>

                                        <div class="uk-form-row">
                                            <label for="login_password">Password</label>
                                            <input class="md-input" type="password" name="password" required/>
                                            <div class="uk-text-danger"> <?php echo form_error('login_password');?> </div> 
                                        </div>

                                        <div class="uk-margin-medium-top">
                                            <input type="submit" class="md-btn md-btn-success md-btn-block md-btn-large" value="Submit">
                                        </div>

                                        <div class="uk-margin-top">
                                            <a href="#" id="login_help_show" class="uk-float-right">Forgot Password</a>
                                            <span class="icheck-inline">
                                                <!--<input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck />-->
                                                <!--<label for="login_page_stay_signed" class="inline-label">Stay signed in</label>-->
                                            </span>
                                        </div>

                                    </form>

                                </div>
                                <div class="uk-position-relative" id="login_help" style="display: none">
                                    <button type="button" class="uk-position-top-right uk-close uk-margin-right back_to_login"></button>
                                    <h2 class="heading_b uk-text-success">Can't log in?</h2>
                                    <p>Here’s the info to get you back in to your account as quickly as possible.</p>
                                    <p>First, try the easiest thing: if you remember your password but it isn’t working, make sure that Caps Lock is turned off, and that your username is spelled correctly, and then try again.</p>
                                    <p>If your password still isn’t working, it’s time to <a href="<?=base_url();?>forgotPassword" >reset your password</a>.</p>
                                </div>
                                <div id="login_password_reset" style="display: none">
                                    <button type="button" class="uk-position-top-right uk-close uk-margin-right back_to_login"></button>
                                    <h2 class="heading_a uk-margin-large-bottom">Reset password</h2>


                                        <?php echo validation_errors('<div class="uk-alert">', ' <a href="#" class="uk-alert-close uk-close"></a></div>');
                            
                                        $this->load->helper('form');
                                        $error = $this->session->flashdata('error');
                                        $send = $this->session->flashdata('send');
                                        $notsend = $this->session->flashdata('notsend');
                                        $unable = $this->session->flashdata('unable');
                                        $invalid = $this->session->flashdata('invalid');

                                        if($error)
                                        { ?>
                                            <div class="uk-alert uk-alert-danger" data-uk-alert>
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $this->session->flashdata('error'); ?>                    
                                            </div>
                                        <?php }

                                        if($send)
                                        {?>
                                            <div class="uk-alert uk-alert-danger" data-uk-alert>
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $this->session->flashdata('send'); ?>                    
                                            </div>
                                        <?php }

                                        if($notsend)
                                        {
                                            ?>
                                            <div class="uk-alert uk-alert-danger" data-uk-alert>
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $this->session->flashdata('notsend'); ?>                    
                                            </div>
                                        <?php }
                                        
                                        if($unable)
                                        {
                                            ?>
                                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $this->session->flashdata('unable'); ?>                    
                                            </div>
                                        <?php }

                                        if($invalid)
                                        {
                                            ?>
                                            <div class="uk-alert uk-alert-danger" data-uk-alert>
                                                <a href="#" class="uk-alert-close uk-close"></a>
                                                <?php echo $this->session->flashdata('invalid'); ?>                    
                                            </div>
                                        <?php } ?>



                                        <form action="<?php echo base_url(); ?>resetPasswordUser" method="post">
                                            <div class="uk-form-row">
                                                <label for="login_email_reset">Your email address</label>
                                                <input class="md-input" type="email" name="login_email" />
                                            </div>
                                            <div class="uk-margin-medium-top">
                                                <input type="submit" class="md-btn md-btn-success md-btn-block" value="Reset password" />
                                            </div>
                                        </form>
                                </div>
                                <div id="register_form" style="display: none">
                                    <button type="button" class="uk-position-top-right uk-close uk-margin-right back_to_login"></button>
                                    <h2 class="heading_a uk-margin-medium-bottom">Create an account</h2>
                                    <form>
                                        <div class="uk-form-row">
                                            <label for="register_username">Username</label>
                                            <input class="md-input" type="text" id="register_username" name="register_username" />
                                        </div>
                                        <div class="uk-form-row">
                                            <label for="register_password">Password</label>
                                            <input class="md-input" type="password" id="register_password" name="register_password" />
                                        </div>
                                        <div class="uk-form-row">
                                            <label for="register_password_repeat">Repeat Password</label>
                                            <input class="md-input" type="password" id="register_password_repeat" name="register_password_repeat" />
                                        </div>
                                        <div class="uk-form-row">
                                            <label for="register_email">E-mail</label>
                                            <input class="md-input" type="text" id="register_email" name="register_email" />
                                        </div>
                                        <div class="uk-margin-medium-top">
                                            <a href="index.html" class="md-btn md-btn-success md-btn-block md-btn-large">Sign Up</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

    <!-- common functions -->
    <script src="<?php echo base_url();?>assets/themes/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="<?php echo base_url();?>assets/themes/js/uikit_custom.min.js"></script>
    <!-- altair core functions -->
    <script src="<?php echo base_url();?>assets/themes/js/altair_admin_common.min.js"></script>
    <!-- altair login page functions -->
    <script src="<?php echo base_url();?>assets/themes/js/pages/login.min.js"></script>
</html>