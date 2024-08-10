<!doctype html>
<html>

  <head>
      <title>Admin Panel</title>

      <meta charset="UTF-8">
      <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="msapplication-tap-highlight" content="no"/>

      <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/themes/img/favicon-16x16.png" sizes="16x16">
      <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/themes/img/favicon-32x32.png" sizes="32x32">

      <!-- uikit -->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/bower_components/uikit/css/uikit.almost-flat.min.css"/>

      <!-- altair admin login page -->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/login_page.min.css" />
  </head>

    <div class="login_page_wrapper">
      <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">
        
            <div class="login_heading">
                <div class="user_avatar"></div>
                <h3 class="heading_b">Reset Password</h3>
            </div>

            <?php $this->load->helper('form'); ?>

            <?php echo validation_errors('<div class="uk-alert uk-alert-danger">', ' <a href="#" class="uk-alert-close uk-close"></a></div>'); ?>

            <?php

              $error = $this->session->flashdata('error');
              if($error)
              {
                ?>
                <div class="uk-alert uk-alert-danger" data-uk-alert>
                    <a href="#" class="uk-alert-close uk-close"></a>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
            <?php } ?>
          
            <form action="<?php echo base_url(); ?>createPasswordUser" method="post">

              <div class="uk-form-row">
                  <label for="login_username">Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" readonly required />
              </div>

              <div class="uk-form-row">
                  <input type="hidden" name="activation_code"  value="<?php echo $activation_code; ?>" required />
              </div>

              <hr>

              <div class="uk-form-row">
                  <label for="Password">Password</label>
                  <input type="password" class="form-control" name="password" required />
              </div>

              <div class="uk-form-row">
                  <label for="Confirm Password">Confirm Password</label>
                  <input type="password" class="form-control" name="cpassword" required />
              </div>

              
              <div class="uk-margin-medium-top">
                  <input type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large" value="Login">
              </div>

            </form>
      
        </div>
      </div>
    </div>
   
    <!-- common functions -->
    <script src="<?php echo base_url();?>assets/themes/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="<?php echo base_url();?>assets/themes/js/uikit_custom.min.js"></script>
    <!-- altair core functions -->
    <script src="<?php echo base_url();?>assets/themes/js/altair_admin_common.min.js"></script>
    <!-- altair login page functions -->
    <script src="<?php echo base_url();?>assets/themes/js/pages/login.min.js"></script>

  </body>
</html>