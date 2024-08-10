<?php
// echo '<pre>';
  // print_r($_SESSION); exit;
 
?>

<div id="page_content">

    <div id="page_content_inner">
        <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>

            <div id="barchart_material" style="width: 50%; height: 280px;"></div>
            <div id="columnchart_material" style="width: 50%; height: 280px;"></div>
            <div id="chart_div" style="width: 80%; height: 280px;"></div>
            
            <br><br>
            <div id="line_chart_div" style="width: 80%; height: 280px;"></div>
            <div id="piechart" style="width: 80%; height: 280px;"></div>
            <div id="timelines" style="width: 80%; height: 280px;"></div>

            <h4>Overall Department Progress</h4>
            <div id="timeline12" style="width: 80%; height: 280px;"></div>

            <div class="md-card-content" style="width:100%;">
                <h4>Ongoing Projects</h4>
                <table class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <tr>
                        <th>Project No</th>
                        <th>Equipment No</th>
                        <th>Expected Del Date</th>
                        <th>Estimated Del Date</th>
                        <th>Lead Factor</th>
                    </tr>

                    <tr>
                        <td>P-123</td>
                        <td>E-234</td>
                        <td>16/1/2022</td>
                        <td>20/1/2022</td>
                        <td style="width:50%; height:40px"><div id="timeline"></div></td>
                    </tr>

                    <tr>
                        <td>P-123</td>
                        <td>E-234</td>
                        <td>16/1/2022</td>
                        <td>20/1/2022</td>
                        <td style="width:50%; height:40px"><div id="timeline-2"></div></td>
                    </tr>
                </table>
            </div>
        </div>
    <br>  
  <?php if($role != ROLE_TEAM_ENGINEER) { ?>
 
  <div class="uk-width-large-1-2 uk-width-small-1-1">                  
    <?php $success = $this->session->flashdata('Success');
    if(isset($success)) { ?>
        <div class="uk-alert uk-alert-success" data-uk-alert>
            <a href="#" class="uk-grid uk-alert-close uk-close"></a>
            <a href="<?php echo base_url(); ?>message"> <?php echo $this->session->flashdata('Success'); ?> </a>                   
        </div>
      
    <?php } ?>
  </div>

  <?php } ?>   
  <hr>  
</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Analysis', 'Expected', 'Actual'],
          ['Date', 500, 550],
          ['Date', 600, 600],
        //   ['2015', 1170, 460, 250],
        //   ['2016', 660, 1120, 300],
        //   ['2017', 1030, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Ongoing Project Progress',
            // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

      // google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'Profit'],
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart2);
    function drawChart2() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        ['2014Spring', 'Spring 2014', 'spring',
         new Date(2014, 2, 22), new Date(2014, 5, 20), null, 100, null],
        ['2014Summer', 'Summer 2014', 'summer',
         new Date(2014, 5, 21), new Date(2014, 8, 20), null, 100, null],
        ['2014Autumn', 'Autumn 2014', 'autumn',
         new Date(2014, 8, 21), new Date(2014, 11, 20), null, 100, null],
        ['2014Winter', 'Winter 2014', 'winter',
         new Date(2014, 11, 21), new Date(2015, 2, 21), null, 100, null],
        ['2015Spring', 'Spring 2015', 'spring',
         new Date(2015, 2, 22), new Date(2015, 5, 20), null, 50, null],
        ['2015Summer', 'Summer 2015', 'summer',
         new Date(2015, 5, 21), new Date(2015, 8, 20), null, 0, null],
        ['2015Autumn', 'Autumn 2015', 'autumn',
         new Date(2015, 8, 21), new Date(2015, 11, 20), null, 0, null],
        ['2015Winter', 'Winter 2015', 'winter',
         new Date(2015, 11, 21), new Date(2016, 2, 21), null, 0, null],
        ['Football', 'Football Season', 'sports',
         new Date(2014, 8, 4), new Date(2015, 1, 1), null, 100, null],
        ['Baseball', 'Baseball Season', 'sports',
         new Date(2015, 2, 31), new Date(2015, 9, 20), null, 14, null],
        ['Basketball', 'Basketball Season', 'sports',
         new Date(2014, 9, 28), new Date(2015, 5, 20), null, 86, null],
        ['Hockey', 'Hockey Season', 'sports',
         new Date(2014, 9, 8), new Date(2015, 5, 21), null, 89, null]
      ]);

      var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

    google.charts.load('current', {'packages':['line', 'corechart']});
    google.charts.setOnLoadCallback(drawLineChart);
    function drawLineChart() {

      // var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('line_chart_div');

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Month');
      data.addColumn('number', "Average Temperature");
      data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
        [new Date(2014, 0),  -.5,  5.7],
        [new Date(2014, 1),   .4,  8.7],
        [new Date(2014, 2),   .5,   12],
        [new Date(2014, 3),  2.9, 15.3],
        [new Date(2014, 4),  6.3, 18.6],
        [new Date(2014, 5),    9, 20.9],
        [new Date(2014, 6), 10.6, 19.8],
        [new Date(2014, 7), 10.3, 16.6],
        [new Date(2014, 8),  7.4, 13.3],
        [new Date(2014, 9),  4.4,  9.9],
        [new Date(2014, 10), 1.1,  6.6],
        [new Date(2014, 11), -.2,  4.5]
      ]);     

      var classicOptions = {
        title: 'Average Temperatures and Daylight in Iceland Throughout the Year',
        width: 800,
        height: 400,
        // Gives each series an axis that matches the vAxes number below.
        series: {
          0: {targetAxisIndex: 0},
          1: {targetAxisIndex: 1}
        },
        vAxes: {
          // Adds titles to each axis.
          0: {title: 'Temps (Celsius)'},
          1: {title: 'Daylight'}
        },
        hAxis: {
          ticks: [new Date(2014, 0), new Date(2014, 1), new Date(2014, 2), new Date(2014, 3),
                  new Date(2014, 4),  new Date(2014, 5), new Date(2014, 6), new Date(2014, 7),
                  new Date(2014, 8), new Date(2014, 9), new Date(2014, 10), new Date(2014, 11)
                 ]
        },
        vAxis: {
          viewWindow: {
            max: 30
          }
        }
      };
    
      // function drawClassicChart() {
        var classicChart = new google.visualization.LineChart(chartDiv);
        classicChart.draw(data, classicOptions);
        // button.innerText = 'Change to Material';
        // button.onclick = drawMaterialChart;
      // }

      // drawClassicChart();

    }

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);

      function drawPieChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

      google.charts.load("current", {packages:["timeline"]});
      google.charts.setOnLoadCallback(drawTimelineChart);
      function drawTimelineChart() {
        var container = document.getElementById('timelines');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'string', id: 'Term' });
        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
          [ '1', 'Design Activities', new Date(2022, 0, 1), new Date(2022, 0, 15) ],
          [ '2', 'Purchase',        new Date(2022, 0, 15),  new Date(2022, 0, 20) ],
          [ '3', 'Production',  new Date(2022, 0, 21),  new Date(2022, 1, 28) ],
          [ '4', 'Quality',  new Date(2022, 2, 1),  new Date(2022, 2, 20) ]
        ]);
        var options = {
          timeline: { showRowLabels: false }
          // timeline: { groupByRowLabel: false }
        };

        chart.draw(dataTable, options);
      }

    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawTimelineAllChart);
    function drawTimelineAllChart() {

      var container = document.getElementById('timeline12');
      var chart = new google.visualization.Timeline(container);
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn({ type: 'string', id: 'Position' });
      dataTable.addColumn({ type: 'string', id: 'Name' });
      dataTable.addColumn({ type: 'date', id: 'Start' });
      dataTable.addColumn({ type: 'date', id: 'End' });

      var date1 = '2022, 1, 1';
      var date2 = '2022, 1, 15';
      var date3 = '2022, 1, 15';
      var date4 = '2022, 1, 28';
      var date5 = '2022, 1, 28';
      var date6 = '2022, 2, 28';
      var date7 = '2022, 3, 1';
      var date8 = '2022, 3, 20';

      dataTable.addRows([
        [ 'Actual', 'Design', new Date(date1), new Date(date2) ],
        [ 'Actual', 'Purchase', new Date(date3),  new Date(date4) ],
        [ 'Actual', 'Production',  new Date(date5),  new Date(date6) ],
        [ 'Actual', 'Quality',  new Date(date7),  new Date(date8) ],

        [ 'Estimated', 'Design', new Date(2022, 0, 1), new Date(2022, 0, 18) ],
        [ 'Estimated', 'Purchase',        new Date(2022, 0, 19),  new Date(2022, 0, 24) ],
        [ 'Estimated', 'Production',  new Date(2022, 0, 25),  new Date(2022, 2, 4) ],
        [ 'Estimated', 'Quality',  new Date(2022, 2, 5),  new Date(2022, 3, 1) ],        
      ]);
      // console.log(dataTable);
      chart.draw(dataTable);
    }

   
    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawProjectTimelineChart);
      function drawProjectTimelineChart() {   
        
        // for(var i = 0; i < 2; i++){
          
        // var timeline = 'timeline-'+i;
        var container = document.getElementById('timeline');
        // var timeline= '#timeline-'+i;
        // var container = $(timeline);
        // console.log(container);

        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'string', id: 'Position' });
        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });

        var date1 = '2022, 1, 1';
        var date2 = '2022, 1, 15';
        var date3 = '2022, 1, 15';
        var date4 = '2022, 1, 28';    

        dataTable.addRows([
          [ 'Estimated', 'Planned', new Date(date1), new Date(date2) ],      
          [ 'Actual', 'Actual', new Date(2022, 0, 1), new Date(2022, 0, 18) ],

          // [ 'Estimated', 'Lead factor1', new Date(date1), new Date(date2) ],      
          // [ 'Actual', 'Estimated Lead factor1', new Date(2022, 0, 1), new Date(2022, 0, 18) ]
        ]);
        // console.log(dataTable);
        chart.draw(dataTable);
    //   } 
    } 
    
    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawProjectTimelineChart1);
      function drawProjectTimelineChart1() {   
        
        // for(var i = 0; i < 2; i++){
          
        // var timeline = 'timeline-'+i;
        var container = document.getElementById('timeline-2');
        // var timeline= '#timeline-'+i;
        // var container = $(timeline);
        // console.log(container);

        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'string', id: 'Position' });
        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });

        var date1 = '2022, 1, 1';
        var date2 = '2022, 1, 15';
        var date3 = '2022, 1, 15';
        var date4 = '2022, 1, 28';    

        dataTable.addRows([
          [ 'Estimated', 'Planned', new Date(date1), new Date(date2) ],      
          [ 'Actual', 'Actual', new Date(2022, 0, 1), new Date(2022, 0, 18) ],

          // [ 'Estimated', 'Lead factor1', new Date(date1), new Date(date2) ],      
          // [ 'Actual', 'Estimated Lead factor1', new Date(2022, 0, 1), new Date(2022, 0, 18) ]
        ]);
        // console.log(dataTable);
        chart.draw(dataTable);
        //   } 
      }   
</script>