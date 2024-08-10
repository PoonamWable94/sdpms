<?php
    $userRole = $this->session->userdata('role');
    $dept_id = $this->session->userdata('dept');    
    // $design = $this->session->userdata('design_dept_access');
    // $purchase = $this->session->userdata('purchase_dept_access');
    // $production = $this->session->userdata('production_dept_access');
    // $quality = $this->session->userdata('quality_dept_access'); 
    // $vendor = $this->session->userdata('vendor_dept_access');        
?>
<style>
    #nav_bar ul li a.active-page{
        /* background-color:blue;
        position: fixed;
        display:block; */
    }
</style>
<div id="top_bar" class="uk-hidden-small">
    <div class="md-top-bar">
        <ul id="menu_top" class="uk-clearfix">
            <!-- <li>
               <img src="<?php echo base_url();?>assets/themes/img/sd.png" height="5px;">
            </li> -->
            <li class="dashboard" title="Dashboard">
                <a href="<?=base_url();?>dashboard">
                    <span class="menu_icon"><i class="material-icons md-color-deep-orange-A700">&#xE871;</i></span>
                    <span class="menu_title">Dashboard</span>
                </a>
            </li>
            <li data-uk-dropdown class="uk-hidden-small">
                <a href="#"><span class="menu_icon"><i class="material-icons md-color-blue-A400">&#xE8C0;</i></span><span class="menu_title">Master</span></a>
                <div class="uk-dropdown">
                    <ul class="uk-nav uk-nav-dropdown uk-nav-multilevel">
                    <li class="has-submenu">
                            <a href="#">Users Master</a>
                            <ul>
                                <li><a href="<?=base_url();?>department">Departments</a></li>
                                <li><a href="<?=base_url();?>user">Users</a></li>
                                <li><a href="<?=base_url();?>client">Clients</a></li>
                                <li><a href="<?=base_url();?>supplier">Suppliers</a></li>
                                <!-- <li><a href="<?=base_url();?>vendor">Vendors</a></li> -->
                                <li><a href="<?=base_url();?>skill">Skills</a></li>
                                <li><a href="<?=base_url();?>Employee">Employees</a></li>
                               
                            </ul>
                     </li>
                       

                        <li class="has-submenu">
                            <a href="#">PMS Master</a>
                            <ul>
                                <li title="Design Department" class="has-submenu" ><a href="#">Design</a>
                                    <ul>
                                        <li><a href="<?=base_url();?>designActivity">Activity Master</a></li>
                                        <li><a href="<?=base_url();?>designActivitData">Activity Data</a></li>
                                        <li><a href="<?=base_url();?>design_skills_master">Skills Master</a></li>
                                        <li><a href="<?=base_url();?>designSkills">Skills Data</a></li>
                                        <li><a href="<?=base_url();?>designStatus">Status Master</a></li>
                                        <li><a href="<?=base_url();?>design_doc">Upload Documents</a></li>
                                    </ul>
                                </li>

                                <li title="Purchase Department" class="has-submenu" ><a href="#">Purchase</a>
                                    <ul>
                                        <li><a href="<?=base_url();?>purchase_activity">Activity Master</a></li>
                                        <li><a href="<?=base_url();?>purchaseActivityData">Activity Data</a></li>
                                        <li><a href="<?=base_url();?>purchaseSkills">Skills Master</a></li>
                                        <li><a href="<?=base_url();?>purchaseStatus">Status Master</a></li>
                                        <li><a href="<?=base_url();?>purchaseMaterialMaster">Material Master Leadtime</a></li>
                                        <li><a href="<?=base_url();?>purchase_doc">Upload Documents</a></li>
                                    </ul>
                                </li>

                                <li title="Production Department" class="has-submenu" ><a href="#">Production</a>
                                    <ul>
                                        <li><a href="<?=base_url();?>productionTask">Component Activity</a></li>
                                        <li><a href="<?=base_url();?>productionTaskData">Component Sub Activity</a></li>
                                        <li><a href="<?=base_url();?>production_skill_master">Skills Master</a></li>                                    
                                        <li><a href="<?=base_url();?>productionSkills">Component & Skills</a></li>
                                        <li><a href="<?=base_url();?>production_employee">Employee Master</a></li>
                                        <li><a href="<?=base_url();?>productionStatus">Status Master</a></li>                                    
                                        <li><a href="<?=base_url();?>production_assembly">Assembly Activity</a></li>
                                        <li><a href="<?=base_url();?>production_sub_assembly">Assembly Sub Activity</a></li>
                                        <li><a href="<?=base_url();?>production_assembly_skills">Assembly & Skills</a></li>
                                    </ul>
                                </li>



                                <!-- <li title="Quality Department" class="has-submenu" ><a href="#">Quality</a>
                                    <ul>
                                        <li><a href="<?=base_url();?>NameOfDocument">Dossier Documents</a>
                                        <li><a href="<?=base_url();?>quality_activity_master">Activity Master</a></li>
                                        <li><a href="<?=base_url();?>quality_activity_data">Activity Data</a></li>
                                        <li><a href="<?=base_url();?>qualityTest">Test</a></li>
                                        <li><a href="<?=base_url();?>testUnderQuality">Test Under Quality</a></li>
                                        <li><a href="<?=base_url();?>qualityTestType">Test Type</a></li>
                                        <li><a href="<?=base_url();?>qualityConditionToPerform">Condition To Perform Test</a>
                                        <li><a href="<?=base_url();?>qualityStatus">Quality Status</a>
                                        
                                        </li>
                                    </ul>
                                </li> -->
                               
                            </ul>
                        </li>

                        <li title="Product Management" class="has-submenu" ><a href="#">Product Management</a>
                                <ul>
                                    <li><a href="<?=base_url();?>finish_good">Finish Good</a></li>
                                    <li><a href="<?=base_url();?>semi_finish_good"> Semi Finish Good</a></li>
                                     <li><a href="<?=base_url();?>raw_material">Raw Material</a></li>
                                    <!-- <li><a href="<?=base_url();?>product">Product</a></li> -->
                                </ul>
                        </li>  

                        <li title="Inventory Master" class="has-submenu" ><a href="#">Inventory Master</a>
                                <ul>
                                    <li><a href="<?=base_url();?>main_group_master">Main Group Master</a></li>
                                    <li><a href="<?=base_url();?>Sub_group_1">Sub group Master</a></li>
                                    <li><a href="<?=base_url();?>Rm_item_master">RM Item Master</a></li>
                                    <li><a href="<?=base_url();?>Fg_item_master">FG Item Master</a></li>
                                    <li><a href="<?=base_url();?>Consumables_item_master">Consumables Item Master</a></li>
                                    <!-- <li><a href="<?=base_url();?>Fastners_item_master">Fastners Item Master</a></li> -->
                                    
                                </ul>
                        </li>
                        
                        <!-- <li title="Project" class="has-submenu" ><a href="#">Project</a>
                            <ul>
                                <li><a href="<?=base_url();?>add_new_project">All Projects</a></li>                     
                               
                            </ul>
                        </li>         -->
                    </ul>
                </div>
            </li>
            <!-- <li data-uk-dropdown class="uk-hidden-small">
                <a href="#"><i class="material-icons">&#xE8D2;</i><span>Forms</span></a>
                <div class="uk-dropdown cust-list">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="forms_regular.html">Regular Elements</a></li>
                        <li><a href="forms_advanced.html">Advanced Elements</a></li>
                        <li><a href="forms_file_upload.html">File Upload</a></li>
                        <li><a href="forms_validation.html">Validation</a></li>
                        <li><a href="forms_wizard.html">Wizard</a></li>
                        <li class="uk-nav-header">WYSIWYG Editors</li>
                        <li><a href="forms_wysiwyg_ckeditor.html">CKeditor</a></li>
                        <li><a href="forms_wysiwyg_tinymce.html">TinyMCE</a></li>
                    </ul>
                </div>
            </li>
            <li data-uk-dropdown class="uk-hidden-small">
                <a href="#"><i class="material-icons">&#xE87B;</i><span>Components</span></a>
                <div class="uk-dropdown uk-dropdown-scrollable">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="components_accordion.html">Accordions</a></li>
                        <li><a href="components_buttons.html"> Buttons</a></li>
                        <li><a href="components_cards.html">Cards</a></li>
                        <li><a href="components_colors.html">Colors</a></li>
                        <li><a href="components_common.html">Common</a></li>
                        <li><a href="components_dropdowns.html">Dropdowns</a></li>
                        <li><a href="components_dynamic_grid.html">Dynamic Grid</a></li>
                        <li><a href="components_grid.html">Grid</a></li>
                        <li><a href="components_icons.html">Icons</a></li>
                        <li><a href="components_modal.html">Lightbox/Modal</a></li>
                        <li><a href="components_lists.html">Lists</a></li>
                        <li><a href="components_nestable.html">Nestable</a></li>
                        <li><a href="components_notifications.html">Notifications</a></li>
                        <li><a href="components_preloaders.html">Preloaders</a></li>
                        <li><a href="components_sortable.html">Sortable</a></li>
                        <li><a href="components_tables.html">Tables</a></li>
                        <li><a href="components_tables_examples.html">Tables Examples</a></li>
                        <li><a href="components_tabs.html">Tabs</a></li>
                        <li><a href="components_tooltips.html">Tooltips</a></li>
                        <li><a href="components_typography.html">Typography</a></li>
                    </ul>
                </div>
            </li> -->
            <!-- <li data-uk-dropdown="justify:'#top_bar'" class="uk-hidden-small">
                <a href="#"><i class="material-icons">&#xE8F1;</i><span>Mega</span></a>
                <div class="uk-dropdown uk-dropdown-width-4">
                    <div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
                        <div class="uk-width-1-4">
                            <ul class="uk-nav uk-nav-dropdown uk-panel">
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Another item</a></li>
                                <li class="uk-nav-header">Header</li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Another item</a></li>
                                <li class="uk-nav-divider"></li>
                                <li><a href="#">Separated item</a></li>
                            </ul>
                        </div>
                        <div class="uk-width-1-4">
                            <div class="uk-accordion" data-uk-accordion="{showfirst:false}">
                                <h3 class="uk-accordion-title">Heading 1</h3>
                                <div class="uk-accordion-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <h3 class="uk-accordion-title">Heading 2</h3>
                                <div class="uk-accordion-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <h3 class="uk-accordion-title">Heading 3</h3>
                                <div class="uk-accordion-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-2-4">
                            <ul class="md-list md-list-addon">
                                <li>
                                    <div class="md-list-addon-element">
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Heading</span>
                                        <span class="uk-text-small uk-text-muted">Sint asperiores sint perspiciatis commodi laboriosam aut ut.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Heading</span>
                                        <span class="uk-text-small uk-text-muted">Quia corrupti voluptatum incidunt porro suscipit sunt.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-addon-element">
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_06_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <span class="md-list-heading">Heading</span>
                                        <span class="uk-text-small uk-text-muted">Eligendi blanditiis eum eum est fugit repellat voluptatem exercitationem eos eaque.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li data-uk-dropdown="justify:'#top_bar'" class="uk-visible-small">
                <a href="#"><i class="material-icons">&#xE5D2;</i><span>Mobile</span></a>
                <div class="uk-dropdown uk-dropdown-width-2">
                    <div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
                        <div class="uk-width-1-2">
                            <ul class="uk-nav uk-nav-dropdown">
                                <li class="uk-nav-header">Forms</li>
                                <li><a href="forms_regular.html">Regular Elements</a></li>
                                <li><a href="forms_advanced.html">Advanced Elements</a></li>
                                <li><a href="forms_file_upload.html">File Upload</a></li>
                                <li><a href="forms_validation.html">Validation</a></li>
                                <li><a href="forms_wizard.html">Wizard</a></li>
                                <li class="uk-nav-header">WYSIWYG Editors</li>
                                <li><a href="forms_wysiwyg_ckeditor.html">CKeditor</a></li>
                                <li><a href="forms_wysiwyg_tinymce.html">TinyMCE</a></li>
                            </ul>
                        </div>
                        <div class="uk-width-1-2">
                            <ul class="uk-nav uk-nav-dropdown">
                                <li class="uk-nav-header">Components</li>
                                <li><a href="components_accordion.html">Accordions</a></li>
                                <li><a href="components_buttons.html"> Buttons</a></li>
                                <li><a href="components_cards.html">Cards</a></li>
                                <li><a href="components_colors.html">Colors</a></li>
                                <li><a href="components_common.html">Common</a></li>
                                <li><a href="components_dropdowns.html">Dropdowns</a></li>
                                <li><a href="components_dynamic_grid.html">Dynamic Grid</a></li>
                                <li><a href="components_grid.html">Grid</a></li>
                                <li><a href="components_icons.html">Icons</a></li>
                                <li><a href="components_modal.html">Lightbox/Modal</a></li>
                                <li><a href="components_lists.html">Lists</a></li>
                                <li><a href="components_nestable.html">Nestable</a></li>
                                <li><a href="components_notifications.html">Notifications</a></li>
                                <li><a href="components_preloaders.html">Preloaders</a></li>
                                <li><a href="components_sortable.html">Sortable</a></li>
                                <li><a href="components_tables.html">Tables</a></li>
                                <li><a href="components_tables_examples.html">Tables Examples</a></li>
                                <li><a href="components_tabs.html">Tabs</a></li>
                                <li><a href="components_tooltips.html">Tooltips</a></li>
                                <li><a href="components_typography.html">Typography</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
</div>
<aside id="sidebar_main">

    <div class="sidebar_main_header">
        <div class="sidebar_logo">
            <a href="<?=base_url();?>" class="sSidebar_hide sidebar_logo_large">                
            </a>            
        </div>
    </div>
    
    <div class="menu_section" id="nav_bar">
        <ul>
            <li class="dashboard" title="Dashboard">
                <a href="<?=base_url();?>dashboard">
                    <span class="menu_icon"><i class="material-icons md-color-deep-orange-A700">&#xE871;</i></span>
                    <span class="menu_title">Dashboard</span>
                </a>
            </li>


            
            <!-- <li title="Project">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons md-color-green-A700">account_balance</i></span>
                    <span class="menu_title"> Project</span>
                </a>
                <ul>
                    <li><a href="<?=base_url();?>add_new_project">All Projects</a></li>                     
                    <li><a href="<?=base_url();?>add_new_project/myactivities">My Activities</a></li>                      
                </ul>
            </li>                                     -->

<!-- admin or project head have all access          -->
            <li title="Master">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons md-color-blue-A400">&#xE8C0;</i></span>
                    <span class="menu_title">Master</span>
                </a>
                <ul>    
                <li title="Users Master" class="menu_title" ><a href="#">Users Master</a> 
                    <ul>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <li><a href="<?=base_url();?>department"> Departments </a></li>
                        <?php } ?>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <li><a href="<?=base_url();?>supplier"> Suppliers </a></li>
                        <?php } ?>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <!-- <li><a href="<?=base_url();?>customer"> Customer </a></li> -->
                        <?php } ?>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <!-- <li><a href="<?=base_url();?>vendor"> Vendor </a></li> -->
                        <?php } ?>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <li><a href="<?=base_url();?>Employee">Employees</a></li>
                        <?php } ?>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <li><a href="<?=base_url();?>skill">Skills</a></li>
                        <?php } ?>
                                
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                            <li><a href="<?=base_url();?>user"> Users </a></li>
                        <?php } ?>

                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) { ?>
                            <li><a href="<?=base_url();?>client"> Clients </a></li>
                        <?php } ?> 
                    </ul>      
                </li>

                <li title="PMS Master" class="menu_title" ><a href="#">PMS Master</a>
                   <ul>
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) 
                        { ?>
                           
                            
                            <li title="Design Department" class="menu_title" ><a href="#">Design</a>
                                <ul>
                                    <li><a href="<?=base_url();?>designActivity">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>designActivitData">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>design_skills_master">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>designSkills">Skills Data</a></li>
                                    <li><a href="<?=base_url();?>designStatus">Status Master</a></li>
                                    <li><a href="<?=base_url();?>design_doc">Upload Documents</a></li>
                                </ul>
                            </li>                            
                           
                            <li title="Purchase Department" class="menu_title"><a href="#">Purchase</a>
                                <ul>
                                    <li><a href="<?=base_url();?>purchase_activity">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseActivityData">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>purchaseSkills">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseStatus">Status Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseMaterialMaster">Material Master Leadtime</a></li>
                                    <li><a href="<?=base_url();?>purchase_doc">Upload Documents</a></li>

                                </ul>
                            </li>
                            
                            <li title="Production Department" class="menu_title" ><a href="#">Production</a>
                                <ul>                                    
                                    <li><a href="<?=base_url();?>productionTask">Component Activity</a></li>
                                    <li><a href="<?=base_url();?>productionTaskData">Component Sub Activity</a></li>                                    
                                    <li><a href="<?=base_url();?>productionSkills">Component & Skills</a></li>
                                    <li><a href="<?=base_url();?>production_skill_master">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>production_employee">Employee Master</a></li>
                                    <li><a href="<?=base_url();?>productionStatus">Status Master</a></li>                                    
                                    <li><a href="<?=base_url();?>production_assembly">Assembly Activity</a></li>
                                    <li><a href="<?=base_url();?>production_sub_assembly">Assembly Sub Activity</a></li>
                                    <li><a href="<?=base_url();?>production_assembly_skills">Assembly & Skills</a></li>
                                </ul>
                            </li>
                            
                            <!-- <li title="Quality Department" class="menu_title" ><a href="#">Quality</a>

                                <ul>
                                    <li><a href="<?=base_url();?>NameOfDocument">Dossier Documents</a>
                                    <li><a href="<?=base_url();?>quality_activity_master">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>quality_activity_data">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>qualityTest">Test</a></li>
                                    <li><a href="<?=base_url();?>testUnderQuality">Test Under Quality</a></li>
                                    <li><a href="<?=base_url();?>qualityTestType">Test Type</a></li>
                                    <li><a href="<?=base_url();?>qualityConditionToPerform">Condition To Perform Test</a>
                                    <li><a href="<?=base_url();?>qualityStatus">Quality Status</a>
                                    
                                    </li>
                                </ul>
                            </li>
                                                        
                            <li title="Vendor Department" class="menu_title" ><a href="#">Vendor</a>
                                <ul>                                    
                                    <li><a href="<?=base_url();?>vendor_name">All Vendors</a></li>
                                    <li><a href="<?=base_url();?>vendor_location">Vendor Location</a></li>
                                    <li><a href="<?=base_url();?>vendor_md">Material Description</a></li>
                                    <li><a href="<?=base_url();?>vendor_work_scope">Vendor Work Scope</a></li>
                                    <li><a href="<?=base_url();?>vendor_master">Operations</a></li> 
                                </ul>
                            </li>   -->
                            
                             
                    <?php  } 
                    // if role is other than admin & head
                    else
                    {                         
                        if($dept_id == 1 || $dept_id == 7 || $dept_id == 2){ ?>
                            <li title="Design Department" class="menu_title" ><a href="#">Design</a>
                                <ul>
                                    <li><a href="<?=base_url();?>designActivity">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>designActivitData">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>design_skills_master">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>designSkills">Skills Data</a></li>
                                    <li><a href="<?=base_url();?>designStatus">Status Master</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if($dept_id == 1 || $dept_id == 7 || $dept_id == 3){ ?>
                            <li title="Purchase Department" class="menu_title"><a href="#">Purchase</a>
                                <ul>
                                    <li><a href="<?=base_url();?>purchase_activity">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseActivityData">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>purchaseSkills">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseStatus">Status Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseMaterialMaster">Material Master Leadtime</a></li>

                                </ul>
                            </li>
                        <?php } ?>  
                        
                        <?php if($dept_id == 1 || $dept_id == 7 || $dept_id == 4){ ?>
                        <li title="Production Department" class="menu_title" ><a href="#">Production</a>
                            <ul>
                                <li><a href="<?=base_url();?>productionTask">Component Activity</a></li>
                                <li><a href="<?=base_url();?>productionTaskData">Component Sub Activity</a></li>
                                <li><a href="<?=base_url();?>production_skill_master">Skills Master</a></li>
                                <li><a href="<?=base_url();?>productionSkills">Component & Skills</a></li>                                
                                <li><a href="<?=base_url();?>production_employee">Employee Master</a></li>
                                <li><a href="<?=base_url();?>productionStatus">Status Master</a></li>
                                <li><a href="<?=base_url();?>production_assembly">Assembly Activity</a></li>
                                <li><a href="<?=base_url();?>production_sub_assembly">Assembly Sub Activity</a></li>
                                <li><a href="<?=base_url();?>production_assembly_skills">Assembly & Skills</a></li>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if($dept_id == 1 || $dept_id == 7 || $dept_id == 5){ ?>
                            <li title="Quality Department" class="menu_title" ><a href="#">Quality</a>

                                <ul>
                                    <li><a href="<?=base_url();?>NameOfDocument">Dossier Documents</a>
                                    <li><a href="<?=base_url();?>quality_activity_master">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>quality_activity_data">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>qualityTest">Test</a></li>
                                    <li><a href="<?=base_url();?>testUnderQuality">Test Under Quality</a></li>
                                    <li><a href="<?=base_url();?>qualityTestType">Test Type</a></li>
                                    <li><a href="<?=base_url();?>qualityConditionToPerform">Condition To Perform Test</a>
                                    <li><a href="<?=base_url();?>qualityStatus">Quality Status</a>
                                    
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if($dept_id == 1 || $dept_id == 7 || $dept_id == 6){ ?>
                            <li title="Vendor Department" class="menu_title" ><a href="#">Vendor</a>
                                <ul>                                    
                                    <li><a href="<?=base_url();?>vendor_name">Vendors</a></li>
                                    <li><a href="<?=base_url();?>vendor_location">Vendor Location</a></li>
                                    <li><a href="<?=base_url();?>vendor_md">Material Description</a></li>
                                    <li><a href="<?=base_url();?>vendor_work_scope">Vendor Work Scope</a></li>
                                    <li><a href="<?=base_url();?>vendor_master">Operations</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php 
                    } ?>
                
                </ul>
            </li>  
            
            <li title="Product Management" class="menu_title" ><a href="#">Product Management</a>
                                <ul>
                                    <li><a href="<?=base_url();?>finish_good">Finish Good</a></li>
                                    <li><a href="<?=base_url();?>semi_finish_good"> Semi Finish Good</a></li>
                                     <li><a href="<?=base_url();?>raw_material">Raw Material</a></li>
                                    <!-- <li><a href="<?=base_url();?>product">Product</a></li> -->
                                </ul>
            </li>  

            <li title="Inventory Master" class="menu_title" ><a href="#">Inventory Master</a>
                                <ul>
                                    <li><a href="<?=base_url();?>main_group_master">Main Group Master</a></li>
                                    <li><a href="<?=base_url();?>Sub_group_1">Sub group Master</a></li>
                                    <li><a href="<?=base_url();?>Rm_item_master">RM Item Master</a></li>
                                    <li><a href="<?=base_url();?>Fg_item_master">FG Item Master</a></li>
                                    <li><a href="<?=base_url();?>Consumables_item_master">Consumables Item Master</a></li>
                                    <!-- <li><a href="<?=base_url();?>Fastners_item_master">Fastners Item Master</a></li> -->
                                    
                                </ul>
            </li> 

            <!-- <li><a href="<?=base_url();?>purchase_sample.xlsx"> Purchase Sample Download</a></li> -->

            <!-- <li title="Project">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons md-color-blue-A400">&#xE8F1;</i></span>
                    <span class="menu_title">Project</span>
                </a>
                <ul>                                
                    <li title="Project Access" class="menu_title" ><a href="#"> Project Access </a>
                    <li title="Design Standards Referred" class="menu_title" ><a href="<?=base_url();?>project_master/design_standerds_referred">Design standard referred</a>
                    <li title="Equipment" class="menu_title" ><a href="<?=base_url();?>project_master/equipment">List of equipments</a>
                    <li title="General Material" class="menu_title" ><a href="<?=base_url();?>project_master/general_material">General Materials</a>
                </ul>
            </li>  -->

        </ul>
    </li>  

    <!-- <li title="Notification" class="menu_title" >
        <a href="#">
            <span class="menu_icon"><i class="material-icons md-color-deep-orange-A700">&#xe7f4;</i></span>
            <span class="menu_title">Notification</span>
        </a>

        <ul>
            <li><a href="<?=base_url();?>project_notification">project notification log</a></li>
            <li><a href="<?=base_url();?>notification/activity_notification_log">Activity notification log</a></li>
        </ul>
    </li> -->
              
    
      
     <!-- <li class="dashboard" title="Dashboard">
        <a href="<?=base_url();?>delay">
            <span class="menu_icon"><i class="material-icons md-color-deep-orange-A700">&#xe192;</i></span>
            <span class="menu_title">Delay</span>
        </a>
        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) { ?>
        <ul>                                
            
            <li title="All Delay" class="menu_title" ><a href="<?=base_url();?>delay"> All Delay </a>
        </ul>
        <?php } else{ ?>
        <ul>                                
            
            <li title="All Delay" class="menu_title" ><a href="<?=base_url();?>delay"> All Delay </a>
            
            <li title="My Delay" class="menu_title" ><a href="<?=base_url();?>delay/my_delay">My Delay </a>
        </ul>
        <?php } ?>
     </li> -->
     
     
            
        <!-- <li class="dashboard" title="Reports">
            <a href="#">
                <span class="menu_icon"><i class="material-icons md-color-green-A700">&#xE871;</i></span>
                <span class="menu_title">Reports</span>
            </a>
            <ul>   
                <li title="All Projects" class="menu_title" ><a href="<?=base_url();?>report"> All Projects </a>
                <li title="Department Progress" class="menu_title" ><a href="<?=base_url();?>report/Department_progress"> Department wise progress </a>
                <li title="Completed Projects" class="menu_title" ><a href="<?=base_url();?>report/All_projects"> Completed Projects </a>
            </ul>
        </li>  -->


        <!-- <li class="dashboard" title="Reports">
            <a href="#">
                <span class="menu_icon"><i class="material-icons md-color-green-A700">&#xE871;</i></span>
                <span class="menu_title">Status Reports</span>
            </a>
            <ul>                              
                <li title="Design_activity_status" class="menu_title" ><a href="<?=base_url();?>status_report/design_material_status"> Design Activity Status </a>
                                        
                <li title="Purchase_activity_status" class="menu_title" ><a href="<?=base_url();?>status_report/purchase_material_status"> Purchase Activity Status </a>
                                        
                <li title="Purchase_activity_status" class="menu_title" ><a href="<?=base_url();?>status_report/production_material_status"> Production Activity Status </a>
                
                <li title="Complete_activity_status" class="menu_title" ><a href="<?=base_url();?>status_report/complete_activity_status"> Complete Activity Status </a>
            </ul>
        </li>  -->
            
            
        </ul>
    </div>
</aside>



<script>
    $(function () {
        $('#nav_bar ul li a').filter(function () {
            return this.href === location.href;
        }).addClass('active-page');
    });
</script>