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

        <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/themes/img/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/themes/img/favicon-32x32.png" sizes="32x32">

        <title><?php echo $pageTitle; ?></title>

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
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" id="">

       
    </head>

    <body class="disable_transitions login_page">
        <!-- sidebar_main_open sidebar_main_swipe add into body sidebar-->
        
            
        <header id="header_main">
            <div class="header_main_content">
                <nav class="uk-navbar">
                                    
                        <!-- main sidebar switch -->
                        <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                            <span class="sSwitchIcon"></span>
                        </a>


                        <div class="uk-float-left">
                            <div class="user_heading_content" style="padding: 10px 0;">
                                <h1 class="heading_b uk-margin-bottom"><span class="uk-text-truncate" style="font-size: medium;">Project Management System</span></h1>
                            </div>
                        </div>
                    
                        <!-- secondary sidebar switch -->
                        <!-- <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                            <span class="sSwitchIcon"></span>
                        </a> -->
                    
                        <!-- <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
                            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                <a href="#" class="top_menu_toggle"><i class="material-icons md-24">&#xE8F0;</i></a>
                                <div class="uk-dropdown uk-dropdown-width-3">
                                    <div class="uk-grid uk-dropdown-grid">
                                        <div class="uk-width-2-3">
                                            <div class="uk-grid uk-grid-width-medium-1-3 uk-margin-bottom uk-text-center">
                                                <a href="page_mailbox.html" class="uk-margin-top">
                                                    <i class="material-icons md-36 md-color-light-green-600">&#xE158;</i>
                                                    <span class="uk-text-muted uk-display-block">Mailbox</span>
                                                </a>
                                                <a href="page_invoices.html" class="uk-margin-top">
                                                    <i class="material-icons md-36 md-color-purple-600">&#xE53E;</i>
                                                    <span class="uk-text-muted uk-display-block">Invoices</span>
                                                </a>
                                                <a href="page_chat.html" class="uk-margin-top">
                                                    <i class="material-icons md-36 md-color-cyan-600">&#xE0B9;</i>
                                                    <span class="uk-text-muted uk-display-block">Chat</span>
                                                </a>
                                                <a href="page_scrum_board.html" class="uk-margin-top">
                                                    <i class="material-icons md-36 md-color-red-600">&#xE85C;</i>
                                                    <span class="uk-text-muted uk-display-block">Scrum Board</span>
                                                </a>
                                                <a href="page_snippets.html" class="uk-margin-top">
                                                    <i class="material-icons md-36 md-color-blue-600">&#xE86F;</i>
                                                    <span class="uk-text-muted uk-display-block">Snippets</span>
                                                </a>
                                                <a href="page_user_profile.html" class="uk-margin-top">
                                                    <i class="material-icons md-36 md-color-orange-600">&#xE87C;</i>
                                                    <span class="uk-text-muted uk-display-block">User profile</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-3">
                                            <ul class="uk-nav uk-nav-dropdown uk-panel">
                                                <li class="uk-nav-header">Components</li>
                                                <li><a href="components_accordion.html">Accordions</a></li>
                                                <li><a href="components_buttons.html">Buttons</a></li>
                                                <li><a href="components_notifications.html">Notifications</a></li>
                                                <li><a href="components_sortable.html">Sortable</a></li>
                                                <li><a href="components_tabs.html">Tabs</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    
                    <div class="uk-navbar-flip">
                        <ul class="uk-navbar-nav user_actions">
                            <li><a href="#" class="user_action_icon uk-visible-large"> <p><?php echo $role_name; ?> || <?php echo $dept_name; ?> Department</p></a></li>
                            <!-- <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge">16</span></a>
                                <div class="uk-dropdown uk-dropdown-xlarge">
                                    <div class="md-card-content">
                                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                            <li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (12)</a></li>
                                            <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small">Alerts (4)</a></li>
                                        </ul>
                                        <ul id="header_alerts" class="uk-switcher uk-margin">
                                            <li>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <span class="md-user-letters md-bg-cyan">ct</span>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="page_mailbox.html">Ratione quisquam.</a></span>
                                                            <span class="uk-text-small uk-text-muted">Fuga vero earum dolor sunt et.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="page_mailbox.html">Ipsum ut.</a></span>
                                                            <span class="uk-text-small uk-text-muted">Eligendi tenetur eveniet ut alias.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <span class="md-user-letters md-bg-light-green">oj</span>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="page_mailbox.html">Quia minima.</a></span>
                                                            <span class="uk-text-small uk-text-muted">Iste vel nihil blanditiis quia odit et esse qui.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="page_mailbox.html">Saepe quis.</a></span>
                                                            <span class="uk-text-small uk-text-muted">Corrupti iusto assumenda et iure est est.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_09_tn.png" alt=""/>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="page_mailbox.html">Doloribus ea.</a></span>
                                                            <span class="uk-text-small uk-text-muted">Et voluptatem sint et aut asperiores omnis et.</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
                                                    <a href="page_mailbox.html" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All</a>
                                                </div>
                                            </li>
                                            <li>
                                                <ul class="md-list md-list-addon">
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading">Non rerum.</span>
                                                            <span class="uk-text-small uk-text-muted uk-text-truncate">Facilis aut tempore ut soluta quo doloribus deleniti voluptatem.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading">Nemo ea fugit.</span>
                                                            <span class="uk-text-small uk-text-muted uk-text-truncate">Sed voluptas voluptates et fuga rerum voluptatum tempora.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading">Porro mollitia.</span>
                                                            <span class="uk-text-small uk-text-muted uk-text-truncate">Labore est vero rerum voluptatibus.</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE8FD;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading">Sint vero.</span>
                                                            <span class="uk-text-small uk-text-muted uk-text-truncate">Non consectetur omnis alias facilis omnis quidem.</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li> -->
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_icon"><span class="material-icons md-24 md-light">account_circle</span></a>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav js-uk-prevent">
                                        <li><a href="<?=base_url();?>profile">Profile</a></li>
                                        <li class="uk-hidden-large"><a href="#" style="overflow:scroll;">Last login <?=empty($last_login) ? "First Time Login" : $last_login; ?></a></li>
                                        <li><a href="<?=base_url();?>logout">Sign out</a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- main header end -->