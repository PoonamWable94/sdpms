<?php
    $userId = $userInfo->userId;
    $name = $userInfo->name;
    $email = $userInfo->email;
    $mobile = $userInfo->mobile;
    $roleId = $userInfo->roleId;
    $role = $userInfo->role;
?>

<div id="page_content">
    <div id="page_content_inner">


        <div class="uk-grid uk-grid-width-medium-1-1 " data-uk-grid-margin data-uk-grid-match id="user_profile">
            <div>
                <div class="md-card">
                    <div class="user_heading">
                        <div class="uk-grid uk-grid-divider" data-uk-grid-margin>

                            <div class="uk-width-medium-2-3 uk-margin-small-top">
                                <br>
                                <div class="user_heading_avatar">
                                    <div class="thumbnail uk-text-center">
                                        <img src="<?php echo base_url(); ?>assets/themes/img/avatars/user.png" alt="user avatar"/>
                                    </div>
                                </div>

                                <div class="user_heading_content">
                                    <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?=$name;?></span><span class="sub-heading">Role - <?=$role?></span></h2>
                                </div>
                            </div>

                            <div class="uk-width-medium-1-3 uk-margin-small-top">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-large-1-1">
                                        <!-- <h2 class="heading_c uk-margin-small-bottom md-color-white">Contact Info</h2> -->
                                        <ul class="md-list md-list-addon">
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="material-icons md-24">mail</span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><?=$email?></span>
                                                    <span class="uk-text uk-text-white">Email</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="material-icons md-24">local_phone</span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><?=$mobile?></span>
                                                    <span class="uk-text uk-text-white">Phone</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="user_content">

                        <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                            <li class="<?= ($active == "details")? "uk-active" : "" ?>"><a href="#">Details</a></li>
                            <li class="<?= ($active == "changepass")? "uk-active" : "" ?>"><a href="#">Change Password</a></li>
                        </ul>

                        <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">

                            <li>
                                <br>

                                <form action="<?php echo base_url() ?>profileUpdate" method="post" id="editProfile" role="form">
                                    
                                    <?php $this->load->helper('form'); ?>
                                    
                                    <div class="uk-grid form_section" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-3">
                                            <div class="parsley-row md-input-wrapper">
                                                <label for="fname"></label>
                                                <input type="text" class="md-input lettersOnly" id="fname" name="fname" value="<?php echo set_value('fname', $name); ?>"  maxlength="128" />
                                                <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />    
                                            </div>
                                        </div>

                                        <div class="uk-width-medium-1-3">
                                            <div class="parsley-row md-input-wrapper">
                                                <label for="mobile"></label>
                                                <input type="text" class="md-input numberOnly" id="mobile" name="mobile" value="<?php echo set_value('mobile', $mobile); ?>" maxlength="10" >
                                                <span class="uk-form-help-block uk-text-danger" id="mobile_validate"></span>
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="parsley-row md-input-wrapper">
                                                <label for="email"></label>
                                                <input type="text" class="md-input" id="email" name="email" value="<?php echo set_value('email', $email); ?>">
                                                <span class="uk-form-help-block uk-text-danger" id="email_validate"></span>
                                            </div>
                                        </div>

                                        <div class="uk-width-medium-1-3">
                                            <input type="submit" class="md-btn md-btn-success" value="Submit" />
                                        </div>
                                    </div>

                                </form>

                            </li>

                            <li>
                                <br>
                                <form action="<?php echo base_url() ?>changePassword" method="post">
                                    <div class="uk-grid form_section" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-3">
                                            <div class="parsley-row md-input-wrapper">
                                                    <label for="inputPassword1">Old Password</label>
                                                    <input type="password" class="md-input" id="inputOldPassword"  name="oldPassword" maxlength="20" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="uk-width-medium-1-3">
                                            <div class="parsley-row md-input-wrapper">
                                                <label for="inputPassword1">New Password</label>
                                                <input type="password" class="md-input" id="inputPassword1" name="newPassword" maxlength="20" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="uk-width-medium-1-3">
                                            <div class="parsley-row md-input-wrapper">
                                                <label for="inputPassword2">Confirm New Password</label>
                                                <input type="password" class="md-input" id="inputPassword2"  name="cNewPassword" maxlength="20" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="parsley-row md-input-wrapper">
                                            <input type="submit" class="md-btn md-btn-success" value="Submit" />
                                            <!-- <input type="reset" class="md-btn md-btn-default" value="Reset" /> -->
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            
            <div class="uk-width-1-1">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                    ?>
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            <?php echo $this->session->flashdata('error'); ?>                    
                        </div>
                        
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                    ?>
                        <div class="uk-alert uk-alert-success" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            <?php echo $this->session->flashdata('success'); ?>                    
                        </div>
                    
                <?php } ?>

                <?php  
                    $noMatch = $this->session->flashdata('nomatch');
                    if($noMatch)
                    {
                    ?>
                    
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            <?php echo $this->session->flashdata('nomatch'); ?>                    
                        </div>
                    
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="uk-alert uk-alert-danger">', '<a href="#" class="uk-alert-close uk-close"></a></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/login_user_js/editUser.js" type="text/javascript"></script>