<?php defined('BASEPATH') OR exit('No direct script access allowed');  
    $role_name = $this->session->userdata('roleText');        
    $dept_name = $this->session->userdata('dept_name');  
?>

<!doctype html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <!--<link rel="icon" href="<?php echo base_url(); ?>/assets/themes/nashik_cyclist_main_logo.jpg" type="image/x-icon">-->
        <link rel="icon" type="image/jpg" href="<?php echo base_url();?>assets/themes/img/sd.png" sizes="32x32">
        <link rel="icon" type="image/jpg" href="<?php echo base_url();?>assets/themes/img/sd.png" sizes="32x32">

        <title>Shree Datta Industries PMS</title>

        <!-- htmleditor (codeMirror) -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/bower_components/codemirror/lib/codemirror.css">
        <!-- select2 -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/bower_components/select2/dist/css/select2.min.css">

        <!-- jquery ui -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/skins/jquery-ui/material/jquery-ui.min.css">
        <!-- jTable -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/skins/jtable/jtable.min.css">
        <!-- uikit -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/bower_components/uikit/css/uikit.almost-flat.min.css" media="all">
        <!-- flag icons -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/icons/flags/flags.min.css" media="all">
        <!-- style switcher -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/style_switcher.min.css" media="all">
        <!-- altair admin -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/main.css" media="all">
        <!-- themes -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/themes/themes_combined.min.css" media="all">

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
        <script> var baseURL = "<?=base_url();?>";</script>
        <script src="<?=base_url();?>assets/themes/js/jquery-3.5.1.js"></script>

        <style>
            .disabled-link{
                cursor: default;
                pointer-events: none;        
                text-decoration: none;
                color: grey;
            }
            .new-highlight {
             color: #f30;
             font-weight: bold;
             animation: blink 1s steps(1, end) infinite;
            }
            @keyframes blink {
            0% {
             opacity: 1;
            }
           50% {
             opacity: 0;
            }
           100% {
             opacity: 1;
           }
           }
           .uk-navbar-flip1{
              margin-left: 50%;
           }
            
        </style>
    </head>
   

    <body class="login_page">
        <header id="header_main">
            <div class="header_main_content">            
                <nav class="uk-navbar">                                    
                    <!-- main sidebar switch -->
                    <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                        <span class="sSwitchIcon"></span>
                    </a>
                    
                    <!-- secondary sidebar switch -->
                    <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                        <span class="sSwitchIcon"></span>
                    </a>
                   
                   <!-- <div class="uk-navbar-flip1">
                    <ul class="uk-navbar-nav user_actions ">
                       <li>  
                        <span class="new-highlight">New Delay Released </span>
                        </li> 
                        </ul>
                           
                   </div> -->
                   
                    <div class="uk-navbar-flip">
                       
                        <ul class="uk-navbar-nav user_actions heading_actions">
                            
                            <li class="dept-name">
                                <p><?php echo $role_name; ?> || <?php echo $dept_name; ?> Department</p>
                            </li>
                        </ul>
                        
                        <ul class="uk-navbar-nav user_actions">                            
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}" data-uk-tooltip="{pos:'bottom'}" title="Last login">
                                <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">all_out</i></a>
                                <div class="uk-dropdown uk-dropdown-xlarge">
                                    <div class="md-card-content">
                                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                            <li class="uk-width-1-1 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Last login <?=empty($last_login) ? "First Time Login" : $last_login; ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_icon"><span class="material-icons md-24 md-light">account_circle</span></a>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav js-uk-prevent">
                                        <li><a href="<?=base_url();?>profile">Profile</a></li>
                                        <li><a href="<?=base_url();?>logout">Sign out</a></li>

                                    </ul>
                                </div>
                            </li>


                            <!-- <?php 
                            $this->load->helper('notification');
                            $noti_list = get_all_notifications();
                            ?>
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge"><?php echo count($noti_list);?></span></a>
                                <div class="uk-dropdown uk-dropdown-xlarge">
                                    <div class="md-card-content">
                                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                            <li class="uk-width-1-1 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Notification (<?php echo count($noti_list);?>)</a></li>
                                        </ul>
                                        <ul id="header_alerts" class="uk-switcher uk-margin">

                                            <?php 
                                            
                                            foreach($noti_list as $noti){  ?>
                                                <li>
                                                    <ul class="md-list md-list-addon">
                                                        <?php
                                                        if($noti->notification_type == 1){//new project add
                                                            echo '<div class="md-list-content">
                                                                    <span class="md-list-heading">'.$noti->new_projectNo.'</span>
                                                                    <span class="uk-text-small uk-text-muted uk-text-truncate">New Project Is Added</span>
                                                                  </div>';
                                                        }elseif($noti->notification_type == 2){//design activity add
                                                            $row[] = $noti->projectNo_add; 
                                                            $row[] = $noti->noti_name_add;
                                                            echo '<div class="md-list-content">
                                                                    <span class="md-list-heading">'.$noti->projectNo_add.'</span>
                                                                    <span class="uk-text-small uk-text-muted uk-text-truncate"></span>
                                                                  </div>';
                                                        }elseif($noti->notification_type == 3){//design activity update
                                                            $row[] = $noti->projectNo_update; 
                                                            $row[] = $noti->noti_name_update;
                                                        }elseif($noti->notification_type == 4){//production component add
                                                            $row[] = $noti->projectNo_pac; 
                                                            $row[] = $noti->noti_name_pac;
                                                        }elseif($noti->notification_type == 5){ //production assembl add
                                                            $row[] = $noti->projectNo_aas; 
                                                            $row[] = $noti->noti_name_aas;
                                                        }elseif($noti->notification_type == 6){ //production compnent activity update
                                                            $row[] = $noti->projectNo_puc; 
                                                            $row[] = $noti->noti_name_puc;
                                                        }elseif($noti->notification_type == 7){ //production compnent activity update
                                                            $row[] = $noti->projectNo_uas; 
                                                            $row[] = $noti->noti_name_uas;
                                                        }elseif($noti->notification_type == 9){ //purchase update bom
                                                            $row[] = $noti->projectNo_ub; 
                                                            $row[] = $noti->noti_name_ub;
                                                        }
                                                        ?>

                                                        <li>
                                                            
                                                            
                                                        </li>
                                                    </ul>
                                                </li>
                                      <?php }  ?>
                                        </ul>
                                    </div>
                                </div>
                            </li> -->

                        </ul>
                    </div>
                </nav>
            </div>            
        
        
        
        </header><!-- main header end -->




