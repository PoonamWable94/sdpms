<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" /> -->

<div id="page_content">
  <div id="page_content_inner">
    
    <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
        <div class="uk-width-medium-2-3 uk-margin-small-top">
            <h4 class="heading_a">USER LOGIN DETAILS</h4>
        </div>
    </div>

    <!-- 
      <div class="md-card">
        <div class="md-card-content large-padding">

          <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-4">
                <div class="parsley-row">
                    <label for="fromdate">From Date<span class="req">*</span></label>
                    <input id="fromDate" type="text" name="fromDate" value="<?=$fromDate; ?>" class="md-input" autocomplete="off" />
                </div>
            </div>

            <div class="uk-width-medium-1-4">
                <div class="parsley-row">
                    <label for="todate">To Date<span class="req">*</span></label>
                    <input id="toDate" type="text" name="toDate" value="<?=$toDate; ?>" class="md-input" autocomplete="off" />
                </div>
            </div>

            <div class="uk-width-medium-1-4">
                <div class="parsley-row">
                    <label for="text">Search Text<span class="req">*</span></label>
                    <input id="searchText" type="text" name="searchText" value="<?php echo $searchText; ?>" class="md-input"/>
                </div>
            </div>

                <div class="uk-width-1-4">
                    <button type="submit" class="md-btn md-btn-primary">Submit</button>
                </div>
          </div>

        </div>
      </div> 
    -->

    <div class="md-card">
      <div class="md-card-content large-padding">

      <h3 class="heading_c"><?= !empty($userInfo) ? $userInfo->name." : ".$userInfo->email : "All users" ?></h3>

      <hr>

        <div class="uk-overflow-container">
          <table id="usertbl" class="uk-table uk-text-nowrap">
              <thead>
                  <tr>
                    <th>Session Data</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Agent Full String</th>
                    <th>Platform</th>
                    <th>Date-Time</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                          ?>
                            <tr>
                              <td><?php echo $record->sessionData ?></td>
                              <td><?php echo $record->machineIp ?></td>
                              <td><?php echo $record->userAgent ?></td>
                              <td><?php echo $record->agentString ?></td>
                              <td><?php echo $record->platform ?></td>
                              <td><?php echo $record->createdDtm ?></td>
                            </tr>
                          <?php
                        }
                    }
                  ?>
              </tbody>
          </table>
            
        </div>
            <hr>
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <a href="<?=base_url();?>user" class="md-btn">Back</a>
                </div>
            </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function()
    {
      jQuery('ul.pagination li a').click(function (e) 
      {
          e.preventDefault();            
          var link = jQuery(this).get(0).href;
          jQuery("#searchList").attr("action", link);
          jQuery("#searchList").submit();
      });

      jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy"
      });
      
      jQuery('.resetFilters').click(function(){
        $(this).closest('form').find("input[type=text]").val("");
      })
    });

</script>
