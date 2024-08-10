<div id="page_content">
    <div id="page_content_inner">
        <?php $isEdit = ($isEdit == 1 ? 1 : ""); ?>
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-10-10">
                <div class="md-card">
                    <div class="user_heading" data-uk-sticky="{ top: 40, media: 960 }">
                        <div class="user_heading_content">
                            <h2 class="heading_b"><span class="uk-text-truncate" id="user_edit_uname"><?=$name?></span></h2>
                        </div>
                        <div class="md-fab-wrapper">
                            <div class="md-fab md-fab-toolbar md-fab-small md-fab-accent">
                                <i class="material-icons">&#xE8BE;</i>
                                <div class="md-fab-toolbar-actions">
                                    <button type="submit" id="user_edit_save" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Save"><i class="material-icons md-color-white">&#xE161;</i></button>
                                    <button type="submit" id="user_edit_print" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Print"><i class="material-icons md-color-white">&#xE555;</i></button>
                                    <button type="submit" id="user_edit_delete" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Delete"><i class="material-icons md-color-white">&#xE872;</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="user_content">
                        <ul id="user_edit_tabs" class="uk-tab" data-uk-tab="{connect:'#user_edit_tabs_content'}">
                            <li class="<?=($isEdit == false ? "uk-active" : "");?>"><a href="#">View</a></li>
                            <li class="<?=($isEdit == true ? "uk-active" : "");?>"><a href="#">Edit</a></li>
                        </ul>
                        <ul id="user_edit_tabs_content" class="uk-switcher uk-margin">
                            <!-- View Tab -->
                            <li>
                                <div class="md-card-content">
                                    <div class="uk-grid uk-grid-divider uk-grid-medium">
                                        <div class="uk-width-large-1-2">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-1-3">
                                                    <span class="uk-text-muted uk-text-small">Company Name</span>
                                                </div>
                                                <div class="uk-width-large-2-3">
                                                    <span class="uk-text-large uk-text-middle"><?=$name?></span>
                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-1-3">
                                                    <span class="uk-text-muted uk-text-small">Company email</span>
                                                </div>
                                                <div class="uk-width-large-2-3">
                                                    <span class="uk-text-large uk-text-middle"><?=$email?></span>
                                                    <span class="uk-text-large uk-text-middle"><?=$email2?></span>
                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-1-3">
                                                    <span class="uk-text-muted uk-text-small">Company area</span>
                                                </div>
                                                <div class="uk-width-large-2-3">
                                                    <span class="uk-text-large uk-text-middle"><?=$area?></span><br>
                                                    <span class="uk-text-large uk-text-middle"><?=$address?></span>
                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-1-3">
                                                    <span class="uk-text-muted uk-text-small">Company phone_no</span>
                                                </div>
                                                <div class="uk-width-large-2-3">
                                                    <span class="uk-text-large uk-text-middle"><?=$phone_no?></span><br>
                                                    <span class="uk-text-large uk-text-middle"><?=$phone_no_2?></span>

                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider">
                                            <span class="uk-text-muted uk-text-small uk-display-block uk-margin-small-bottom"><?=$name?> Logo</span>
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-2-3">
                                                    <img src="<?=base_url();?>uploads/my_company/<?=$company_logo?>" alt="Parent Company Logo" width="100%" height="100%">
                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider uk-hidden-large">
                                        </div>
                                        <div class="uk-width-large-1-2">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-1-3">
                                                    <span class="uk-text-muted uk-text-small">Parent Company Name</span>
                                                </div>
                                                <div class="uk-width-large-2-3">
                                                    <span class="uk-text-large uk-text-middle"><?=$parent_company_name?></span>
                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider">
                                            <span class="uk-text-muted uk-text-small uk-display-block uk-margin-small-bottom"><?=$parent_company_name?> Logo</span>
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-2-3">
                                                    <img src="<?=base_url();?>uploads/my_company/<?=$parent_company_logo?>" alt="Parent Company Logo" width="100%" height="100%">
                                                </div>
                                            </div>
                                            <hr class="uk-grid-divider">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-large-1-3">
                                                    <span class="uk-text-muted uk-text-small">Email for Report Receiving</span>
                                                </div>
                                                <div class="uk-width-large-2-3">
                                                    <span class="uk-text-large uk-text-middle"><?=$report_email?></span><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Edit Tab -->
                            <li>
                                <div class="uk-margin-top">
                                    <h3 class="full_width_in_card heading_c">
                                        Konark Engineers General info
                                    </h3>
                                    <form action="<?=base_url();?>my_company/save" enctype="multipart/form-data" class="uk-form-stacked" id="user_edit_form" method="POST">

                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyName">Company Name</label>
                                                <input class="md-input label-fixed" type="text" name="name" value="<?=$name?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('name'); ?></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyEmail">Company Email</label>
                                                <input class="md-input label-fixed" type="text" name="email" value="<?=$email?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('email'); ?></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyEmail2">Company second Email </label>
                                                <input class="md-input label-fixed" type="text" name="email2" value="<?=$email2?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('email2'); ?></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyImage"><?=$name?> Company logo</label>
                                                <br>
                                                <input class="md-input label-fixed" type="file" name="company_logo" value="<?=$company_logo?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('company_logo'); ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyArea">Area</label>
                                                <input class="md-input label-fixed" type="text" name="area" value="<?=$area?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('area'); ?></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyAddress">Address</label>
                                                <input class="md-input label-fixed" type="text" name="address" value="<?=$address?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('address'); ?></span>

                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyPhone">Company Phone Number</label>
                                                <input class="md-input label-fixed" type="text" name="phone_no" value="<?=$phone_no?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('phone_no'); ?></span>

                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyPhone2">Company second Phone Number</label>
                                                <input class="md-input label-fixed" type="text" name="phone_no_2" value="<?=$phone_no_2 ?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('phone_no_2'); ?></span>
                                            </div>
                                        </div>

                                        <h3 class="full_width_in_card heading_c">
                                            Parent Company Information
                                        </h3>
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-4">
                                                <label for="ParentCompanyName">Parent Company Name</label>
                                                <input class="md-input label-fixed" type="text" name="parent_company_name" value="<?=$parent_company_name?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('parent_company_name'); ?></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <label for="ParentCompanyImage">Parent Company Image</label>
                                                <br>
                                                <input class="md-input label-fixed" type="file" name="parent_company_logo" value="<?=$parent_company_logo?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('parent_company_logo'); ?></span>
                                            </div>
                                        </div>
                                        <h3 class="full_width_in_card heading_c">
                                            Email Field for Report Receiveing
                                        </h3>
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-4">
                                                <label for="CompanyPhone2">Email for Report</label>
                                                <input class="md-input label-fixed" type="text" name="report_email" value="<?=$report_email ?>"/>
                                                <span id="errortag" class="uk-text-danger"><?php echo form_error('report_email'); ?></span>
                                            </div>
                                        </div>
                                            
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-4">
                                                <input type="submit" class="md-btn md-btn-primary" value="Submit" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>