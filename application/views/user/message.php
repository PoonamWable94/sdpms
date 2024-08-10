<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" /> -->

<div id="page_content">
  <div id="page_content_inner">
    
    <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
        <div class="uk-width-medium-2-3 uk-margin-small-top">
            <h4 class="heading_a">Messages</h4>
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

      <h3 class="heading_c">All Messages</h3>

      <hr>

        <div class="uk-overflow-container">
          <table class="uk-table uk-table-condensed uk-text-nowrap">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Date Time</th>
                          <th>Message from</th>
                          <th>Client Name</th>
                          <th>Message</th>
                          <th>Action</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; foreach ($msgData as  $value) { ?>
                          <tr>
                            <td><?=$no++;?></td>
                            <td><?= $value->createdDtm; ?></td>
                            <td><?= $value->send_by; ?></td>
                            <td><?= $value->company_name; ?></td>
                            <td><?=$value->message?></td>
                            <td> <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_data(<?php echo $value->msg_id; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
            
        </div>
            <hr>
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <a href="<?=base_url();?>dashboard" class="md-btn">Back</a>
                </div>
            </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  var table;
    function reload_table()
    {
        table.JQuery.reload(null,false); //reload datatable ajax 
       
}
   
  function delete_data(id)
    {
        UIkit.modal.confirm('Are you sure to delete?', function(){ 
            $.ajax({
                url : "<?php echo site_url('message/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    UIkit.modal(('.uk-modal')).hide();
                    //reload_table();
                    location.reload();
                    UIkit.notify({
                        message : 'Record deleted!',
                        status  : 'danger',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        });
    }
    </script>