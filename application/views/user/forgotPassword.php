<style>
.md-btn-success {
  background: #f88c3b !important;
}

</style>
<!DOCTYPE html>
<html>
  <head>

    <meta charset="UTF-8">
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

  <body class="login_page">

  <div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">

          <div class="login_heading">
              <div class="user_avatar"></div>
          </div>


            <!--<div class="row">-->
            <!--    <div class="col-md-12">-->
            <!--        <?php //echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>-->
            <!--    </div>-->
            <!--</div>-->

        <?php 
        
          echo validation_errors('<div class="uk-alert">', '</div>');
                    
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

            <div class="uk-margin-medium-top">
              <a class="md-btn md-btn-success md-btn-block" href="<?php echo base_url() ?>">Login</a><br>
            </div>

        </form>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

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