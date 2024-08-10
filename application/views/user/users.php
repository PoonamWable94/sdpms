<?php
    $userRole = $this->session->userdata('role');
    $department_id = $this->session->userdata('dept');   
?>

<div id="page_content">
    <div id="page_content_inner">

        <div class="md-card">
        <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
            <h1 class="md-card-toolbar-heading-text"> User Management 
                <!-- <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons md-color-white">&#xE5D5;</i></a> -->                
                <a href="javascript:void(0);"  onclick="goBack()" title="Back" ><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                <a href="<?php echo base_url(); ?>addNew" data-uk-tooltip="{pos:'bottom'}" title="Add new user"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
            </h1>
        </div>
            <div class="md-card-content">

                <!-- <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                    <div class="uk-grid uk-grid-divider">
                        <div class="uk-width-large-2-5 uk-width-small-1-5 uk-pull">
                            <h3 class="heading_c uk-margin-bottom uk-margin-top">User Management</h3>
                        </div>
                        <div class="uk-width-large-3-5 uk-width-small-1-3 uk-push-1-5">
                            <div class="uk-grid">
                                <div class="uk-width-large-1-3 uk-width-small-1-2">
                                    <div class="parsley-row"> -->
                                        <!-- <input type="text" name="searchText" value="<?=$searchText;?>" class="md-input" required  /> -->
                                    <!-- </div>
                                </div>
                                <div class="uk-width-large-1-3 uk-width-small-1-3 uk-margin-top">
                                     <button class="md-btn md-btn-small ">Search</button>
                                    <a class="md-btn md-btn-small md-btn-success" href="<?php echo base_url(); ?>addNew" title="Add User" data-uk-tooltip>Add</a>
                                    <a class="md-btn" href="<?=base_url();?>dashboard" title="Go Back" data-uk-tooltip>Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <hr> -->

                <div class="uk-overflow-container">
                    <table id="usertbl" class="uk-table uk-table-striped uk-table-hover ">
                        <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th width="12%"><b>Name</b></th>
                                <th width="18%"><b>Email</b></th>
                                <th width="10%"><b>Username</b></th>
                                <?php if($userRole == 1 || $userRole == 2){ ?><th width="10%"><b>Password</b></th> <?php } ?>
                                <th width="8%"><b>Mobile</b></th>
                                <th width="8%"><b>Role</b></th>
                                <th width="8%"><b>Department</b></th>
                                <th width="30%"><b>User Skills</b></th>
                                <th width="12%"><b>Actions</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($userRecords)) { 
                                $number = 0;
                                foreach($userRecords as $record) { ?>
                                    <tr>
                                        <td><?php echo $number = $number + 1; ?></td>
                                        <td><?php echo $record->name; ?></td>
                                        <td><?php echo $record->email; ?></td>
                                        <td><?php echo $record->uname; ?></td>
                                        <?php if($userRole == 1 || $userRole == 2){ ?><td><?php echo $record->pwd; ?></td> <?php } ?>
                                        <td><?php echo $record->mobile; ?></td>
                                        <td><?php echo $record->role; ?></td>
                                        <td><?php echo $record->dept_name; ?></td>
                                        <td><?php                                                                                
                                            $trimcomma = trim($record->skill_name,',');                                            
                                            echo str_replace(","," | ",$trimcomma);                                            
                                        ?></td>
                                        <!-- <td><?php //echo date("d-m-Y h:i:A", strtotime($record->createdDtm)); ?></td> -->
                                        <td class="text-center">
                                            <a href="<?=base_url().'login-history/'.$record->userId; ?>" title="Login History" data-uk-tooltip><i class="material-icons md-color-cyan-700">&#xE88F;</i></a> |
                                            <a href="<?=base_url().'editOld/'.$record->userId; ?>"  title="Edit" data-uk-tooltip><i class="material-icons md-color-orange-400">&#xE254;</i></a>
                                            <a onclick="delete_user(<?=$record->userId; ?>)" href="#" title="Delete" data-uk-tooltip><i class="material-icons md-color-red-500">&#xE872;</i></a>
                                        </td>
                                    </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url();?>assets/login_user_js/common.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = $(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            $("#searchList").attr("action", baseURL + "userListing/" + value);
            $("#searchList").submit();
        });
    });

    function reload_table()
    {
        location.reload(); //reload datatable ajax 
    }

    function delete_user(id)
    {
        UIkit.modal.confirm('Are you sure to delete?', function(){ 
            $.ajax({
                url : baseURL+"user/deleteUser/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        });
    }
    function goBack() {
            window.history.back();
        }
</script>