<?php    
    $csvPath = base_url().'purchasewindow/export_csv/'.$projectID;
?>

<style>
    .projectNoText{
        text-align: center;
    }
</style>

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="md-card">        
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text"> List Purchase Activity
                    <a href="<?php echo base_url('add_new_project/add_project');?>" data-uk-tooltip="{pos:'bottom'}" title="Add New Design Activity"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                    <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                    <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons md-color-white">&#xE5D5;</i></a>
                    <a href="<?php echo $csvPath; ?>" data-uk-tooltip="{pos:'bottom'}" title="Export Data"><i class="md-icon material-icons md-color-white">archive</i></a>
                    <a href="<?=base_url();?>add_new_project/myactivities" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                 </h1>
            </div>
            <!-- <div> -->
                <h5>&nbsp;&nbsp;&nbsp;&nbsp;Project & Client:- &nbsp;&nbsp;<?php echo $project_info->project_no.' / '.$project_info->company_name; ?></h5>
            <!-- </div> -->
            <div class="md-card-content">                
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>#</th>                            
                            <!-- <th>Project / Client</th> -->
                            <th>Equipment / TAG</th>
                            <th>Purchase TAG Number</th>
                            <th>Description</th>
                            <th>Material Specification</th>
                            <th>Stock</th>
                            <th>Vendor</th>
                            <!-- <th>Price</th> -->
                            <th>EXP PO Release Date</th>    
                            <th>Actual PO Date</th>    
                            <th>Quality Remark</th>                    
                            <th>Release for Prod</th>
                            <th>Availability of TC</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="uk-modal" id="modal_default">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <div class="uk-modal-header">
                <h3 class="uk-modal-title">Purchase Details</h3>
            </div>
            
            <form action="#" id="show_call_details" class="uk-margin-top">
                <div class="uk-grid"> 
                    <div class="uk-width-1-1">
                        <div class="parsley-row md-input-wrapper">
                            <label for="projectNo">Project Number / Equipment / TAG Number</label>
                            <input type="text" name="projectNo" class="md-input label-fixed"/>                                
                        </div>                                           
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="tag_no">Purchase TAG No</label>
                            <input type="text" name="tag_no" class="md-input label-fixed"/>                                
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="md-input label-fixed"/>                                
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="tech_req">Material Specification</label>
                            <input type="text" name="tech_req" class="md-input label-fixed"/>                                
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="dim_width">Width / Length / Thickness</label>
                            <input type="text" name="dim_width" class="md-input label-fixed"> 
                        </div>

                       

                        <div class="parsley-row md-input-wrapper">
                            <label for="qty"><b>Qty</b></label>
                            <input type="text" name="qty" class="md-input label-fixed"/>                                                         
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="rev_odl">Change as per Revised ODL</label>
                            <input type="text" name="rev_odl" class="md-input label-fixed"> 
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="stock">Stock</label>
                            <input type="text" name="stock" class="md-input label-fixed"> 
                        </div>
                   
                        <div class="parsley-row md-input-wrapper">
                            <label for="vendor">Final Vendor</label>
                            <input type="text" name="vendor" class="md-input label-fixed"> 
                        </div>
                                                                
                        <div class="parsley-row md-input-wrapper">
                            <label for="po_release_date">Expected PO Release Date</label>
                            <input type="text" name="po_release_date" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="actual_po_date">Actual PO Date</label>
                            <input type="text" name="actual_po_date" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="appr_date">QAP Approved Date</label>
                            <input type="text" name="appr_date" class="md-input label-fixed" />                               
                        </div>
                    
                        <div class="parsley-row md-input-wrapper">
                            <label for="qap_given">QAP Given/Sample Date</label>
                            <input type="text" name="qap_given" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="material_reqd_prod">Material Required by Production On</label>
                            <input type="text" name="material_reqd_prod" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="exp_material_rec_date">Expected M.R Date</label>
                            <input type="text" name="exp_material_rec_date" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="actual_material_rec_date">Actual M.R Date</label>
                            <input type="text" name="actual_material_rec_date" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="tc_rec">TC Available</label>
                            <input type="text" name="tc_rec" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="remark">Remark</label>
                            <input type="text" name="remark" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="quality_remark">Quality Remark</label>
                            <input type="text" name="quality_remark" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="release_for_prod">Release for Production</label>
                            <input type="text" name="release_for_prod" class="md-input label-fixed" />                               
                        </div>

                        <div class="parsley-row md-input-wrapper">
                            <label for="mtc">Availability of TC</label>
                            <input type="text" name="mtc" class="md-input label-fixed" />                               
                        </div>
                    </div>                                                            
                </div>                   
            </form>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>                
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    var table;
    var base_url = '<?php echo base_url();?>';
    var projectID = "<?php echo $projectID; ?>";   

    $(document).ready(function() {
        
        table = $('#dt_mytable').DataTable({ 
            "processing": true, 
            "serverSide": true,
            "pageLength": 50,
            "order": [], 
    
            "ajax": {
                "url": "<?php echo site_url('purchasewindow/list_activity'); ?>",
                "data": {"projectID":projectID},
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ 0,1, -1], 
                    "orderable": false,
                }
            ],           
        });
    });

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status to Active or Passive
    $(document).on('click','.status_checks',function(){
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Passive' : 'Active';

        if(confirm("Are you sure to "+ msg + " this record"))
        {            
            var activityID = $(this).attr('data');
            // console.log(activityID);
            var myurl="<?php echo base_url()."purchasewindow/update_status"?>";

            $.ajax({
                type:"POST",
                url:myurl,
                data:{"activityID":activityID,"status":status},
                success:function(data)
                {    
                    // console.log(data);
                    reload_table()
                }
            });
        }      
    });
    
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

    function view_activity_data(activityID)
    {
        $('#show_call_details')[0].reset(); // reset form on modals
        $('.form-group').removeClass('parsley-required'); // clear error class
        $('.parsley-required').empty(); // clear error string
        $('.md-input').removeClass('md-input-danger'); // clear error class
        
        if(activityID > 0){
            $.ajax({
                url : base_url+'purchasewindow/get_activity_detail',
                type: "GET",
                dataType: "JSON",
                data:{'activityID':activityID},
                success: function(data)
                {   
                    if(data.activityID > 0){
                        // console.log(data.list);
                        var stock = 'Stock';
                        if(data.list.stock == 2){
                            stock = 'Purchase';
                        }

                        var release_for_prod = '';
                        if(data.list.release_for_prod == 'prod_release')
                            release_for_prod = 'Release for Production';

                        if(data.list.release_for_prod == 'design_hold')
                            release_for_prod = 'Hold from Design';

                        if(data.list.release_for_prod == 'on_hold')
                            release_for_prod = 'On Hold';

                        var projectNo = data.list.projectNo+' / '+data.list.equipment+' / '+data.list.tag_number;
                        var dim_width = data.list.dim_width+' / '+data.list.dim_length+' / '+data.list.dim_thickness;
                        var qty = data.list.qty;
                        
                        $('[name="projectNo"]').val(projectNo);

                        $('[name="tag_no"]').val(data.list.tag_no);
                        $('[name="stock"]').val(stock);               

                        $('[name="dim_width"]').val(dim_width);

                        $('[name="mtc"]').val(data.list.mtc);               
                        $('[name="tech_req"]').val(data.list.tech_req);
                        $('[name="vendor"]').val(data.list.vendor);
                        // $('[name="weight"]').val(data.list.weight+' Kg');
                        $('[name="qty"]').val(qty);
                        $('[name="description"]').val(data.list.description);
                        $('[name="exp_material_rec_date"]').val(data.list.exp_material_rec_date);
                        $('[name="actual_material_rec_date"]').val(data.list.actual_material_rec_date);
                        $('[name="tc_rec"]').val(data.list.tc_rec);
                        $('[name="remark"]').val(data.list.remark);
                        $('[name="quality_remark"]').val(data.list.quality_remark);
                        $('[name="release_for_prod"]').val(release_for_prod);
                        $('[name="po_release_date"]').val(data.list.po_release_date);
                        $('[name="actual_po_date"]').val(data.list.actual_po_date);
                        $('[name="appr_date"]').val(data.list.appr_date);
                        $('[name="qap_given"]').val(data.list.qap_given);
                        $('[name="rev_odl"]').val(data.list.rev_odl);
                        $('[name="material_reqd_prod"]').val(data.list.material_reqd_prod);
                                  

                        // $("#btnSave").hide();
                        UIkit.modal($('.uk-modal')).show();
                    }else{
                        alert('Something went wrong.. Please try again');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Something went wrong.. Please try again');
                }
            });
        }
    }

    function delete_data(activityID)
    {
        UIkit.modal.confirm('Are you sure delete?', function(){ 
            $.ajax({
                url : "<?php echo site_url('purchasewindow/delete_new_activity')?>",
                type: "POST",
                dataType: "JSON",
                data: {'activityID':activityID},
                success: function(data)
                {
                    UIkit.modal(('.uk-modal')).hide();
                    reload_table();
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

    function bulk_delete()
    {
        var list_id = [];
        $(".data-check:checked").each(function() {
                list_id.push(this.value);
        });
        if(list_id.length > 0)
        {
            UIkit.modal.confirm('Are you sure delete this '+list_id.length+' data?', function(){             
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('purchasewindow/ajax_bulk_delete')?>",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            reload_table();
                            UIkit.notify({
                        message : 'Records deleted!',
                        status  : 'danger',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                        }
                        else
                        {
                            alert('Failed.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            });
        }
        else
        {
            UIkit.modal.alert('No record selected!')
        }
    }
</script>