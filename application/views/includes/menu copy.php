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

            <!-- <li title="Department">
                   
                        <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) 
                        { ?>
                           
                            
                            <li title="Design Department" class="menu_title" ><a href="#">Design</a>
                                <ul>
                                    <li><a href="<?=base_url();?>designActivity">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>designActivitData">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>design_skills_master">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>designSkills">Skills Data</a></li>
                                    <li><a href="<?=base_url();?>designStatus">Status Master</a></li>
                                </ul>
                            </li>                            
                           
                            <li title="Purchase Department" class="menu_title"><a href="#">Purchase</a>
                                <ul>
                                    <li><a href="<?=base_url();?>purchase_activity">Activity Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseActivityData">Activity Data</a></li>
                                    <li><a href="<?=base_url();?>purchaseSkills">Skills Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseStatus">Status Master</a></li>
                                    <li><a href="<?=base_url();?>purchaseMaterialMaster">Material Master Leadtime</a></li>

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
                                                        
                            <li title="Vendor Department" class="menu_title" ><a href="#">Vendor</a>
                                <ul>                                    
                                    <li><a href="<?=base_url();?>vendor_name">All Vendors</a></li>
                                    <li><a href="<?=base_url();?>vendor_location">Vendor Location</a></li>
                                    <li><a href="<?=base_url();?>vendor_md">Material Description</a></li>
                                    <li><a href="<?=base_url();?>vendor_work_scope">Vendor Work Scope</a></li>
                                    <li><a href="<?=base_url();?>vendor_master">Operations</a></li> 
                                </ul>
                            </li>  
                            
                             
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
                                <li><a href="<?=base_url();?>productionSkills">Component & Skills</a></li>
                                <li><a href="<?=base_url();?>production_skill_master">Skills Master</a></li>                                
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
                
            </li>  
            -->

            <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                <li><a href="<?=base_url();?>department"> Departments </a></li>
            <?php } ?>
            <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                <li><a href="<?=base_url();?>supplier"> Supplier </a></li>
            <?php } ?>
            <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                <li><a href="<?=base_url();?>vendor"> Vendor </a></li>
            <?php } ?>
                
            <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD ) { ?>
                <li><a href="<?=base_url();?>user"> Users </a></li>
            <?php } ?>

            <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) { ?>
                <li><a href="<?=base_url();?>client"> Client </a></li>
            <?php } ?>    

            <!-- <?php if($userRole == ROLE_COMPANYADMIN || $userRole == ROLE_ADMIN || $userRole == ROLE_PROJECT_HEAD) { ?>
                <li><a href="<?=base_url();?>sfg"> Sfg </a></li>
            <?php } ?>    -->

            
            <li title="Product Management" class="menu_title" ><a href="#">Product Management</a>
                                <ul>
                                    <li><a href="<?=base_url();?>finish_good">Finish Good</a></li>
                                    <li><a href="<?=base_url();?>semi_finish_good"> Semi Finish Good</a></li>
                                     <li><a href="<?=base_url();?>raw_material">Raw Material</a></li>
                                    <li><a href="<?=base_url();?>product">Product</a></li>
                                    <!--<li><a href="<?=base_url();?>designSkills">Skills Data</a></li>
                                    <li><a href="<?=base_url();?>designStatus">Status Master</a></li> -->
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>

<script>
    $(function () {
        $('#nav_bar ul li a').filter(function () {
            return this.href === location.href;
        }).addClass('active-page');
    });
</script>