<div id="page_content">
    <div id="page_content_inner">

        <div class="md-card">
            <div class="md-card-content">

                <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                    <div class="uk-grid uk-grid-divider">
                        <div class="uk-width-large-2-5 uk-width-small-1-5 uk-pull">
                            <h3 class="heading_c uk-margin-bottom uk-margin-top">User Management</h3>
                        </div>
                        <div class="uk-width-large-3-5 uk-width-small-1-3 uk-push-1-5">
                            <div class="uk-grid">
                                <div class="uk-width-large-1-3 uk-width-small-1-2">
                                    <div class="parsley-row">
                                        <input type="text" name="searchText" value="<?=$searchText;?>" class="md-input" required  />
                                    </div>
                                </div>
                                <div class="uk-width-large-1-3 uk-width-small-1-3 uk-margin-top">
                                    <button class="md-btn md-btn-small ">Search</button>
                                    <a class="md-btn md-btn-small md-btn-primary" href="<?php echo base_url(); ?>addNew" title="Add User" data-uk-tooltip>ADD</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url();?>assets/login_user_js/common.js"></script>


