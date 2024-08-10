<?php
  $colors = array('green');
?>

<style>
  .table_head{
    font-size: 16px;    
    background-color: #5f5e5c;
  }

  .bar { width: 99%; border: 1px solid #000; }
  .percentage { background: #000; }
</style>
 
    
<div id="page_content">
  <div id="page_content_inner">
    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
            <span class="uk-text-muted uk-text-small">Total Client</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?=$clientCount?></noscript></span></h2>
          </div>
        </div>
      </div>
      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
            <span class="uk-text-muted uk-text-small">Total Projects</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript></noscript></span></h2>
          </div>
        </div>
      </div>

      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
            <span class="uk-text-muted uk-text-small">Live Projects</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript></noscript></span></h2>
          </div>
        </div>
      </div>

      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
            <span class="uk-text-muted uk-text-small">Completed Projects</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript></noscript></span></h2>
          </div>
        </div>
      </div>

      <br/>
      <br/>

      <!-- <div class="md-card-content" style="width:100%;">        

        <h4> Live Projects</h4>
        <table class="uk-table uk-table-align-vertical uk-table-nowrap uk-table-condensed tablesorter tablesorter-altair">
          <thead>
            <tr class="table_head">
              <th class="uk-text-center"  style="color:#fff;">PID</th>              
              <th class="uk-text-center"  style="color:#fff">Project No</th>              
              <th class="uk-text-center"  style="color:#fff">Department</th>
              <th class="uk-text-center"  style="color:#fff">Start Date</th>
              <th class="uk-text-center"  style="color:#fff">End Date</th>
              <th class="uk-text-center"  style="color:#fff">Status</th>
            </tr>
          </thead>

          <?php 
            $sr = 1;
            $srNo = 1;
            $delay = '';
            foreach($currentProjects as $projects){ 
              // if($sr >= 4){
              //   $sr = 0;
              // }
            $todaysDate = date("Y-m-d");
            $color_class = 'green'; 
            $color_class1 = 'blue'; 
            if($projects->productionProjectEndDate < $todaysDate){
              $color_class = $color_class1 = 'red'; 
              $now = time();
              $endDate = strtotime($projects->productionProjectEndDate);              
              $datediff = $now - $endDate;
              $datediff1 =  round($datediff / (60 * 60 * 24));
              if($datediff1 > 100){
                $delay = '';
              }else{
                $delay = ' ('.$datediff1.')';
              }
              
            }
  
            $isValid = 0;
            $isActualValid = 0;

            if($projects->designProjectStartDate != NULL && date("Y", strtotime($projects->designProjectStartDate)) >= '2000'){
              $designProjectStartDateConv = date("j F Y", strtotime($projects->designProjectStartDate));
              $designProjectStartDate = date("Y, m, d", strtotime($projects->designProjectStartDate));
            }else{
              $isValid = 1;
              $designProjectStartDateConv = '';
              $designProjectStartDate = '';  
            }

            //
            if($projects->designActualStartDate != NULL && date("Y", strtotime($projects->designActualStartDate)) >= '2000'){
              $designActualStartDateConv = date("j F Y", strtotime($projects->designActualStartDate));
              $designActualStartDate = date("Y, m, d", strtotime($projects->designActualStartDate));
            }else{
              $isActualValid = 1;
              $designActualStartDateConv = '';
              $designActualStartDate = '';  
            }
            
            if($projects->designProjectEndDate != NULL && date("Y", strtotime($projects->designProjectEndDate)) >= '2000'){              
              $designProjectEndDateConv = date("j F Y", strtotime($projects->designProjectEndDate));
              $designProjectEndDate = date("Y, m, d", strtotime($projects->designProjectEndDate));
            }else{
              $isValid = 1;
              $designProjectEndDate = '';
              $designProjectEndDateConv = '';
            }

            //
            if($projects->designActualEndDate != NULL && date("Y", strtotime($projects->designActualEndDate)) >= '2000'){              
              $designActualEndDateConv = date("j F Y", strtotime($projects->designActualEndDate));
              $designActualEndDate = date("Y, m, d", strtotime($projects->designActualEndDate));
            }else{
              $isActualValid = 1;
              $designActualEndDate = '';
              $designActualEndDateConv = '';
            }
            
            if($projects->purchaseProjectStartDate != NULL && date("Y", strtotime($projects->purchaseProjectStartDate)) >= '2000'){
              $purchaseProjectStartDateConv = date("j F Y", strtotime($projects->purchaseProjectStartDate));
              $purchaseProjectStartDate = date("Y, m, d", strtotime($projects->purchaseProjectStartDate));
            }else{
              $isValid = 1;
              $purchaseProjectStartDate = '';
              $purchaseProjectStartDateConv = '';
            }

            //
            if($projects->purchaseActualStartDate != NULL && date("Y", strtotime($projects->purchaseActualStartDate)) >= '2000'){
              $purchaseActualStartDateConv = date("j F Y", strtotime($projects->purchaseActualStartDate));
              $purchaseActualStartDate = date("Y, m, d", strtotime($projects->purchaseActualStartDate));
            }else{
              $isActualValid = 1;
              $purchaseActualStartDate = '';
              $purchaseActualStartDateConv = '';
            }
            
            if($projects->purchaseProjectEndDate != NULL && date("Y", strtotime($projects->purchaseProjectEndDate)) >= '2000'){
              $purchaseProjectEndDateConv = date("j F Y", strtotime($projects->purchaseProjectEndDate));
              $purchaseProjectEndDate = date("Y, m, d", strtotime($projects->purchaseProjectEndDate));
            }else{
              $isValid = 1;
              $purchaseProjectEndDate = '';
              $purchaseProjectEndDateConv = '';
            }

            //
            if($projects->purchaseActualEndDate != NULL && date("Y", strtotime($projects->purchaseActualEndDate)) >= '2000'){
              $purchaseActualEndDateConv = date("j F Y", strtotime($projects->purchaseActualEndDate));
              $purchaseActualEndDate = date("Y, m, d", strtotime($projects->purchaseActualEndDate));
            }else{
              $isActualValid = 1;
              $purchaseActualEndDate = '';
              $purchaseActualEndDateConv = '';
            }
            
            if($projects->productionProjectStartDate != NULL && date("Y", strtotime($projects->productionProjectStartDate)) >= '2000'){
              $productionProjectStartDateConv = date("j F Y", strtotime($projects->productionProjectStartDate));
              $productionProjectStartDate = date("Y, m, d", strtotime($projects->productionProjectStartDate));
            }else{
              $isValid = 1;
              $productionProjectStartDate = '';
              $productionProjectStartDateConv = '';
            }

            //
            if($projects->productionActualStartDate != NULL && date("Y", strtotime($projects->productionActualStartDate)) >= '2000'){
              $productionActualStartDateConv = date("j F Y", strtotime($projects->productionActualStartDate));
              $productionActualStartDate = date("Y, m, d", strtotime($projects->productionActualStartDate));
            }else{
              $isActualValid = 1;
              $productionActualStartDate = '';
              $productionActualStartDateConv = '';
            }
            
            if($projects->productionProjectEndDate != NULL && date("Y", strtotime($projects->productionProjectEndDate)) >= '2000'){
              $productionProjectEndDateConv = date("j F Y", strtotime($projects->productionProjectEndDate));
              $productionProjectEndDate = date("Y, m, d", strtotime($projects->productionProjectEndDate));
            }else{
              $isValid = 1;
              $productionProjectEndDate = '';
              $productionProjectEndDateConv = '';
            }  

            //
            if($projects->productionActualEndDate != NULL && date("Y", strtotime($projects->productionActualEndDate)) >= '2000'){
              $productionActualEndDateConv = date("j F Y", strtotime($projects->productionActualEndDate));
              $productionActualEndDate = date("Y, m, d", strtotime($projects->productionActualEndDate));
            }else{
              $isActualValid = 1;
              $productionActualEndDate = '';
              $productionActualEndDateConv = '';
            }  

          ?>
            <tr>
                <td class="uk-text-center" style="color:<?=$color_class;?>" ><?=$srNo.$delay;?></td>
                <td class="uk-text-center" style="color:green" ><?=$projects->project_no;?></td>                
                <td class="uk-text-center" style="color:green" >
                  <h6 style="color:green">Design (P)</h6>
                  <h6 style="color:green">Design (A)</h6>

                  <h6 style="color:blue">Purchase (P)</h6>
                  <h6 style="color:blue">Purchase (A)</h6>

                  <h6 style="color:purple">Production (P)</h6>
                  <h6 style="color:purple">Production (A)</h6>
                </td>

                <td class="uk-text-center" style="color:<?=$color_class;?>" >
                  <h6 style="color:green"><?=$designProjectStartDateConv;?></h6>
                  <h6 style="color:green"><?=$designActualStartDateConv;?></h6>

                  <h6 style="color:blue"><?=$purchaseProjectStartDateConv;?></h6>
                  <h6 style="color:blue"><?=$purchaseActualStartDateConv;?></h6>

                  <h6 style="color:purple"><?=$productionProjectStartDateConv;?></h6>
                  <h6 style="color:purple"><?=$productionActualStartDateConv;?></h6>
                </td>

                <td class="uk-text-center" style="color:<?=$color_class;?>" >
                  <h6 style="color:green"><?=$designProjectEndDateConv;?></h6>
                  <h6 style="color:green"><?=$designActualEndDateConv;?></h6>

                  <h6 style="color:blue"><?=$purchaseProjectEndDateConv;?></h6>
                  <h6 style="color:blue"><?=$purchaseActualEndDateConv;?></h6>

                  <h6 style="color:purple"><?=$productionProjectEndDateConv;?></h6>
                  <h6 style="color:purple"><?=$productionActualEndDateConv;?></h6>
                </td>
                
                <?php if ($isValid == 0) { ?>
                    <td style="width:60%;">
                      <div id="timeline-<?=$srNo;?>" style="height: 240px;"></div>  
                      
                        <script type="text/javascript">
                          var date1 = date2 = date3 = date4 = date5 = date6 = "";
                          google.charts.load("current", {packages:["timeline"]});
                              google.charts.setOnLoadCallback(drawTimelineAllChart);
                              function drawTimelineAllChart() {

                                var container = document.getElementById('timeline-<?=$srNo;?>');
                                var chart = new google.visualization.Timeline(container);
                                var dataTable = new google.visualization.DataTable();

                                dataTable.addColumn({ type: 'string', id: 'Position' });
                                dataTable.addColumn({ type: 'string', id: 'Name' });
                                dataTable.addColumn({ type: 'date', id: 'Start' });
                                dataTable.addColumn({ type: 'date', id: 'End' });                            

                                date1 = "<?=$designProjectStartDate?>";
                                date2 = "<?=$designProjectEndDate?>";
                                date3 = "<?=$purchaseProjectStartDate?>";
                                date4 = "<?=$purchaseProjectEndDate?>";
                                date5 = "<?=$productionProjectStartDate?>";
                                date6 = "<?=$productionProjectEndDate?>"; 
                                
                                date11 = "<?=$designActualStartDate?>";
                                date22 = "<?=$designActualEndDate?>";
                                date33 = "<?=$purchaseActualStartDate?>";
                                date44 = "<?=$purchaseActualEndDate?>";
                                date55 = "<?=$productionActualStartDate?>";
                                date66 = "<?=$productionActualEndDate?>"; 

                                dataTable.addRows([
                                  [ 'Planned', 'Design', new Date(date1), new Date(date2)],
                                  [ 'Planned', 'Purchase', new Date(date3),  new Date(date4)],
                                  [ 'Planned', 'Production',  new Date(date5),  new Date(date6)],
                                  
                                  [ 'Actual', 'Design', new Date(date11), new Date(date22)],
                                  [ 'Actual', 'Purchase', new Date(date33),  new Date(date44)],
                                  [ 'Actual', 'Production',  new Date(date55),  new Date(date66)] 
                                ]);
                                // console.log(dataTable);
                                chart.draw(dataTable);
                              }

                        </script>
                    </td>
                  <?php } else{ ?>
                    <td style="width:60%;">
                      <p> Invalid date </p>
                    </td>
                  <?php } ?>
            </tr>
          <?php $srNo++; $sr++;
          } ?>

        </table>
      </div> -->
    </div>
    <br>  
 
 
    <div class="uk-width-large-1-2 uk-width-small-1-1">                  
      <?php $success = $this->session->flashdata('Success');
      if(isset($success)) { ?>
          <div class="uk-alert uk-alert-success" data-uk-alert>
              <a href="#" class="uk-grid uk-alert-close uk-close"></a>
              <a href="<?php echo base_url(); ?>message"> <?php echo $this->session->flashdata('Success'); ?> </a>                   
          </div>
      <?php } ?>
    </div>  
  <hr>  
</div>
</div>

