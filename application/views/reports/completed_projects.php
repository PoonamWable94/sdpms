<style>
    .project_over{   
        color: green;
    }
    .project_progress{   
        color: black;
    }
    .project_delayed{   
        color: red;
    }
    .table_head{
        font-size: 16px;    
        background-color: #5f5e5c;
    }
</style>

<div id="page_content">    
    <div id="page_content_inner">        
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <div class="md-card-toolbar-heading-text"> Completed Projects List
                    <a href="javascript:void(0)" onclick="export_projects()" title="Export Projects"><i class="md-icon material-icons md-color-white">archive</i></a>
                </div>
            </div>

           <div class="uk-width-medium-1-1">
                <div class="parsley-row md-input-filled input-simple">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
                    <select id="project_by_year" class="project_by_year" style="width=25%;">
                        <option value="0">All Projects</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                    <select>
                </div>
            </div>
            <div class="md-card-content task-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap uk-table-condensed tablesorter tablesorter-altair" id="project_table">
                        <thead>
                            <tr class="table_head">                                
                                <th class="uk-text-center" style="color:#fff">#</th>
                                <th style="color:#fff">Year</th>
                                <th style="color:#fff">Project No / Client</th>   
                                <th style="color:#fff">Project Head</th>                              
                                <th style="color:#fff">Equipment</th>
                                <th style="color:#fff">TAG No</th>
                                <th style="color:#fff">QTY</th>
                                <th style="color:#fff">PO Number</th>
                                <th style="color:#fff">PO Date</th>
                                <th style="color:#fff">Delivery Date</th>   
                                <th style="color:#fff">Completion Date</th>    
                                <th style="color:#fff">Actual Dispatch Date</th> 
                                <th style="color:#fff">Design Start(Planned)</th>
                                <th style="color:#fff">Design Start(Actual)</th>
                                <th style="color:#fff">Design End(Planned)</th>
                                <th style="color:#fff">Design End(Actual)</th>
                                <th style="color:#fff">Purchase Start(Planned)</th>
                                <th style="color:#fff">Purchase Start(Actual)</th>
                                <th style="color:#fff">Purchase End(Planned)</th>
                                <th style="color:#fff">Purchase End(Actual)</th>
                                <th style="color:#fff">Production Start(Planned)</th>
                                <th style="color:#fff">Production Start(Actual)</th>
                                <th style="color:#fff">Production End(Planned)</th>
                                <th style="color:#fff">Production End(Actual)</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div> 
                <!-- POPUP Form -->                           
            </div>
        </div>          
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.pt-BR.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

    var save_method; //for save method string
    var table;
    var base_url = "<?php echo base_url(); ?>";
    var project_year = 0;

    $(document).ready(function(){
        table = $('#project_table').DataTable({
            "processing": true, 
            "serverSide": true,
            "pageLength": 100,
            "order": [], 

            "ajax": {
                "url": base_url+'report/completed_projects',
                "type": "POST",
                "data": { "project_year":project_year }
            },

            "columnDefs": [
                {
                   "targets": [ 0,3,4,5,6,7,8,9,10,11, -1, -2, -3, -4, -5, -6, -7, -8, -9, -10, -11, -12], 
                    "orderable": false,
                }
            ],
        });

        $('.project_by_year').on('change', function(){
            $('#project_table').DataTable().destroy();    
            project_year = $(this).val();       

            table = $('#project_table').DataTable({
                "processing": true, 
                "serverSide": true,
                "pageLength": 50,
                "order": [], 

                "ajax": {
                    "url": base_url+'report/completed_projects',
                    "type": "POST",
                    "data": { "project_year":project_year }
                },

                "columnDefs": [
                    {
                        "targets": [ 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, -1, -2, -3, -4, -5, -6, -7, -8, -9, -10, -11, -12],
                        "orderable": false,
                    }
                ],
            });
        });
    });

    function export_projects(){
        window.location = base_url+'report/export_project_data?id='+project_year;
    }
</script>