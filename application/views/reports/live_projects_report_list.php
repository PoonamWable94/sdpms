<?php
// echo '<pre>';
  // print_r($_SESSION); exit;
  $totalProjectsCnt = 2;
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="page_content">  
  <div id="page_content_inner">
    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>        
        <br/>
        <br/>
        
        <div class="md-card-content" style="width:100%;">         

          <h4>Ongoing Projects</h4>
          <table class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
            <tr>
                <th style="width:40%">Project No / Client</th>
                <th style="width:60%">Equipment / TAG No</th>               
            </tr>
         
            <?php  
              $totalProjectCnt =  0;              
              foreach($getLiveProjects as $projects)          
              {
                $totalProjectCnt++;    
                $est_project_start_date = str_replace('-',',  ',$projects->po_date_time);
                $est_project_delivery_date = str_replace('-',',  ',$projects->del_date);
                // print_r($est_project_start_date);

                $this->load->model('live_projects_report_model');

          //Design department activity start and end date                
                $designStartDate = $this->live_projects_report_model->getDesignProjectEqpStartDate($projects->id,$projects->projectequipmentId);
                $designTargetDate = $this->live_projects_report_model->getDesignProjectEqpTargetDate($projects->id,$projects->projectequipmentId);               
                
                $designStartDate = substr($designStartDate->startDate,0,10);
                $designStartDate = str_replace('-',',  ',$designStartDate);
                
                $designTargetDate = substr($designTargetDate->targetDate,0,10);
                $designTargetDate = str_replace('-',',  ',$designTargetDate);
              
              //actual
                $actualdesignStartDate = $this->live_projects_report_model->getActualDesignProjectEqpStartDate($projects->id,$projects->projectequipmentId);
                $actualdesignTargetDate = $this->live_projects_report_model->getActualDesignProjectEqpTargetDate($projects->id,$projects->projectequipmentId);               
                
                $actualdesignStartDate = substr($actualdesignStartDate->actual_start_date,0,10);
                $actualdesignStartDate = str_replace('-',',  ',$actualdesignStartDate);
                
                $actualdesignTargetDate = substr($actualdesignTargetDate->taskCompDate,0,10);
                $actualdesignTargetDate = str_replace('-',',  ',$actualdesignTargetDate);

          //Purchase department activity start and end date                
                $purchaseStartDate = $this->live_projects_report_model->getPurchaseProjectEqpStartDate($projects->id,$projects->projectequipmentId);
                $purchaseTargetDate = $this->live_projects_report_model->getPurchaseProjectEqpTargetDate($projects->id,$projects->projectequipmentId);

                $purchaseStartDate = str_replace('-',',  ',$purchaseStartDate->po_release_date);                
                $purchaseTargetDate = str_replace('-',',  ',$purchaseTargetDate->exp_material_rec_date);
            
            //actual
                $actualpurchaseStartDate = $this->live_projects_report_model->getActualPurchaseProjectEqpStartDate($projects->id,$projects->projectequipmentId);
                $actualpurchaseTargetDate = $this->live_projects_report_model->getActualPurchaseProjectEqpTargetDate($projects->id,$projects->projectequipmentId);

                $actualpurchaseStartDate = str_replace('-',',  ',$actualpurchaseStartDate->actual_po_date);                
                $actualpurchaseTargetDate = str_replace('-',',  ',$actualpurchaseTargetDate->actual_material_rec_date);                               

          //Production department activity start and end date                
                $productionStartDate = $this->live_projects_report_model->getproductionProjectEqpStartDate($projects->id,$projects->projectequipmentId);
                $productionTargetDate = $this->live_projects_report_model->getProductionProjectEqpTargetDate($projects->id,$projects->projectequipmentId);               
                
                $productionStartDate = substr($productionStartDate->startDate,0,10);
                $productionStartDate = str_replace('-',',  ',$productionStartDate);
                
                $productionTargetDate = substr($productionTargetDate->targetDate,0,10);
                $productionTargetDate = str_replace('-',',  ',$productionTargetDate);

              //actual
                $actualproductionStartDate = $this->live_projects_report_model->getActualproductionProjectEqpStartDate($projects->id,$projects->projectequipmentId);
                $actualproductionTargetDate = $this->live_projects_report_model->getActualProductionProjectEqpTargetDate($projects->id,$projects->projectequipmentId);               
                
                $actualproductionStartDate = substr($actualproductionStartDate->startDate,0,10);
                $actualproductionStartDate = str_replace('-',',  ',$actualproductionStartDate);
                
                $actualproductionTargetDate = substr($actualproductionTargetDate->targetDate,0,10);
                $actualproductionTargetDate = str_replace('-',',  ',$actualproductionTargetDate);
            ?>

                <tr>
                    <td style="width:40%"><?php echo $projects->project_no.' / '.$projects->company_name; ?></td>
                    <td style="width:60%"><?php echo $projects->equipment.' / '.$projects->tag_number; ?></td>                    
                </tr>           

                <tr>
                  <td colspan="1" style="width:40%">                    
                    <div id="project_timeline-<?php echo $totalProjectCnt; ?>" style="position: relative; width: 440px; height: 140px;" dir="ltr" ></div>                    
                  </td> 

                  <td colspan="1" style="width:60%">                    
                    <div id="department_timeline-<?php echo $totalProjectCnt; ?>" style="position: relative; width: 860px; height: 140px;" dir="ltr" ></div>                    
                  </td> 
                </tr>
              
                <script type="text/javascript">               
                  
                    google.charts.load("current", {packages:["timeline"]});
                    google.charts.setOnLoadCallback(drawProjectTimelineChart);
                    function drawProjectTimelineChart() {   
                                                
                      var container = document.getElementById('project_timeline-'+<?php echo $totalProjectCnt; ?>);                    

                      var chart = new google.visualization.Timeline(container);
                      var dataTable = new google.visualization.DataTable();
                      dataTable.addColumn({ type: 'string', id: 'Position' });
                      dataTable.addColumn({ type: 'string', id: 'Name' });
                      dataTable.addColumn({ type: 'date', id: 'Start' });
                      dataTable.addColumn({ type: 'date', id: 'End' });

                      var est_project_start_date = "<?=$est_project_start_date; ?> ";
                      var est_project_delivery_date = "<?=$est_project_delivery_date; ?> ";
                      var est_project_start_date = "<?=$est_project_start_date; ?> ";
                      var est_project_delivery_date = "<?=$est_project_delivery_date; ?> ";  
                      // console.log(date1);
                      dataTable.addRows([
                        [ 'Estimated', 'Planned', new Date(est_project_start_date), new Date(est_project_delivery_date) ],      
                        [ 'Actual', 'Actual', new Date(est_project_start_date), new Date(est_project_delivery_date) ],                    
                      ]);                  
                      chart.draw(dataTable);   
                    }
                    
                    google.charts.setOnLoadCallback(drawTimelineAllChart);
                      function drawTimelineAllChart() {

                        var container = document.getElementById('department_timeline-'+<?php echo $totalProjectCnt; ?>);
                        var chart = new google.visualization.Timeline(container);
                        var dataTable = new google.visualization.DataTable();
                        dataTable.addColumn({ type: 'string', id: 'Position' });
                        dataTable.addColumn({ type: 'string', id: 'Name' });
                        dataTable.addColumn({ type: 'date', id: 'Start' });
                        dataTable.addColumn({ type: 'date', id: 'End' });

                        var designStartDate = "<?php echo $designStartDate; ?>";
                        var actualdesignStartDate = "<?php echo $actualdesignStartDate; ?>";                        
                        var designTargetDate = "<?php echo $designTargetDate; ?>";
                        var actualdesignTargetDate = "<?php echo $actualdesignTargetDate; ?>";

                        var purchaseStartDate = "<?php echo $purchaseStartDate; ?>";
                        var actualpurchaseStartDate = "<?php echo $actualpurchaseStartDate; ?>";
                        var purchaseTargetDate = "<?php echo $purchaseTargetDate; ?>";
                        var actualpurchaseTargetDate = "<?php echo $actualpurchaseTargetDate; ?>";

                        var productionStartDate = "<?php echo $productionStartDate; ?>";
                        var actualproductionStartDate = "<?php echo $actualproductionStartDate; ?>";
                        var productionTargetDate = "<?php echo $productionTargetDate; ?>";
                        var actualproductionTargetDate = "<?php echo $actualproductionTargetDate; ?>";

                        var qualityStartDate = "<?php echo $productionStartDate; ?>";
                        var actualqualityStartDate = "<?php echo $actualproductionStartDate; ?>";
                        var qualityTargetDate = "<?php echo $productionTargetDate; ?>";
                        var actualactualTargetDate = "<?php echo $actualproductionTargetDate; ?>";

                        dataTable.addRows([
                          [ 'Estimated', 'Design', new Date(designStartDate), new Date(designTargetDate) ],
                          [ 'Estimated', 'Purchase',        new Date(purchaseStartDate),  new Date(purchaseTargetDate) ],
                          [ 'Estimated', 'Production',  new Date(productionStartDate),  new Date(productionTargetDate) ],
                          [ 'Estimated', 'Quality',  new Date(qualityStartDate),  new Date(qualityTargetDate) ],

                          [ 'Actual', 'Design', new Date(actualdesignStartDate), new Date(actualdesignTargetDate) ],
                          [ 'Actual', 'Purchase', new Date(actualpurchaseStartDate),  new Date(actualpurchaseTargetDate) ],
                          [ 'Actual', 'Production',  new Date(actualproductionStartDate),  new Date(actualproductionTargetDate) ],
                          [ 'Actual', 'Quality',  new Date(actualqualityStartDate),  new Date(actualactualTargetDate) ],
                                 
                        ]);
                        // console.log(dataTable);
                        chart.draw(dataTable);
                      }

                </script>
            <?php                
                }
            ?>           
          </table>
        </div>
    </div>
  </div>
</div>



<script type="text/javascript">

  // google.charts.load("current", {packages:["timeline"]});
  // google.charts.setOnLoadCallback(drawTimelineAllChart);
  //   function drawTimelineAllChart() {

  //     var container = document.getElementById('timeline12');
  //     var chart = new google.visualization.Timeline(container);
  //     var dataTable = new google.visualization.DataTable();
  //     dataTable.addColumn({ type: 'string', id: 'Position' });
  //     dataTable.addColumn({ type: 'string', id: 'Name' });
  //     dataTable.addColumn({ type: 'date', id: 'Start' });
  //     dataTable.addColumn({ type: 'date', id: 'End' });

  //     var date1 = '2022, 1, 1';
  //     var date2 = '2022, 1, 15';
  //     var date3 = '2022, 1, 15';
  //     var date4 = '2022, 1, 28';
  //     var date5 = '2022, 1, 28';
  //     var date6 = '2022, 2, 28';
  //     var date7 = '2022, 3, 1';
  //     var date8 = '2022, 3, 20';

  //     dataTable.addRows([
  //       [ 'Actual', 'Design', new Date(date1), new Date(date2) ],
  //       [ 'Actual', 'Purchase', new Date(date3),  new Date(date4) ],
  //       [ 'Actual', 'Production',  new Date(date5),  new Date(date6) ],
  //       [ 'Actual', 'Quality',  new Date(date7),  new Date(date8) ],

  //       [ 'Estimated', 'Design', new Date(2022, 0, 1), new Date(2022, 0, 18) ],
  //       [ 'Estimated', 'Purchase',        new Date(2022, 0, 19),  new Date(2022, 0, 24) ],
  //       [ 'Estimated', 'Production',  new Date(2022, 0, 25),  new Date(2022, 2, 4) ],
  //       [ 'Estimated', 'Quality',  new Date(2022, 2, 5),  new Date(2022, 3, 1) ],        
  //     ]);
  //     // console.log(dataTable);
  //     chart.draw(dataTable);
  //   }
 
</script>