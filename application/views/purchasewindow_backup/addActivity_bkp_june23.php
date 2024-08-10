<?php
    $activity_id_array = array();  
    $projectID = $projectID;
    $projectequipment = $projectequipment;
    $projectNo = $projectNo;
    $client_id = $client_id;
    $tag_number = $tag_number;
?>

<style>
    .uk-grid>* {
        padding-left: 10px;
    }

    .uk-grid {
        text-align: left;
        margin: 0;
        padding: 0;
    }     

    .content form .user-details{
        display: flex;
        flex-wrap: wrap;        
        margin: -1px 0 -15px 0;        
    }

    form .user-details .input-box{
        margin-bottom: 10px;
        width: calc(100% / 3);
    }

    form .input-box span.details{
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .user-details .input-box input{
        height: 20px;
        width: 87%;
        outline: none;
        font-size: 14px;
        border-radius: 5px;
        padding-left: 8px;
        border: 1px solid #ccc;
        border-bottom-width: 2px;
        transition: all 0.3s ease;
    }

    .user-details .d input{
        /* height: 20px; */
        width: 47%;
    }

    .user-details .input-box select{
        height: 31px;
        width: 90%;
        outline: none;
        font-size: 14px;
        border-radius: 5px;
        padding-left: 8px;
        border: 1px solid #ccc;
        border-bottom-width: 2px;
        transition: all 0.3s ease;
    }

    .user-details .input-box input:focus,
    .user-details .input-box input:valid{
    /* border-color: #9b59b6; */
    }

    form .gender-details .gender-title{
        font-size: 14px;
        font-weight: 500;
    }

    form .category{
    display: flex;
    width: 10%;
    margin: 14px 0 ;
    justify-content: space-between;
    }

    form .category label{
    display: flex;
    align-items: center;
    cursor: pointer;
    }

    form .category label .dot{
        height: 5px;
        width: 5px;
        border-radius: 50%;
        margin-right: 10px;
        background: #d9d9d9;
        border: 5px solid transparent;
        transition: all 0.3s ease;
    }

    form input[type="radio"]{
    /* display: none; */
    }

    form .button{
        height: 45px;
        margin: 35px 0
    }

    form .button input{
        height: 100%;
        width: 100%;
        border-radius: 5px;
        border: none;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
    }

    form .button input:hover{
        /* transform: scale(0.99); */
        background: linear-gradient(-135deg, #71b7e6, #9b59b6);
    }

    @media(max-width: 584px){
        .container{
        max-width: 100%;
    }

    form .user-details .input-box{
        margin-bottom: 15px;
        width: 100%;
    }

    form .category{
        width: 100%;
    }

    .content form .user-details{
        max-height: 300px;
        overflow-y: scroll;
    }

    .user-details::-webkit-scrollbar{
        width: 5px;
    }

    }

    @media(max-width: 459px){
    .container .content .category{
        flex-direction: column;
    }
    }

    .container .title{
    font-size: 25px;
    font-weight: 500;
    position: relative;
    }

    .container .title::before{
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 30px;
        border-radius: 5px;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
    }    

    .header_design{
        text-align:center !important;
    }    

    .input-simple span {
        margin-left: -139px;
    } 

    .container{
        margin-right: 80px !important;
        margin-left: 5px !important;
    }   
    
    .table-select-level-dd {
        width: 55px !important;
        background-color: #fff !important;
        border: 1px solid #ccc !important;
    }

    .table-select-dd {
        width: 80px !important;
        background-color: #fff !important;
        border: 1px solid #ccc !important;
    }

    .padding-fordropdown {
	    padding-top: 0px !important;
    }

    .activity_data_col{
        padding-left:10px !important;
        padding-right:10px !important;
    } 
    
    .input_long{
        width: 220px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .input_long_long{
        width: 140px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .input_short{
        width: 80px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }
    
    .in_stock_disable{
        pointer-events: none;
    }

    .select_class{
        width: 120px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .select_release_class{
        width: 160px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
    }

    .date-input-design{
        margin-left: 2px !important;
        margin-right: 2px !important;
    }   

    .uk-table td {
        border-bottom-color: #c7c0c0 !important;
    }

</style>

<link type="text/css" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text add-activity"> Add Purchase                             
                            <a href="<?=base_url();?>add_new_project/add_project" data-uk-tooltip="{pos:'bottom'}" title="Back"><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a>
                        </h1>                         
                    </div>  

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">         
                                <form id="add_project_timeline" name="add_project_timeline" action="#" method="post" autocomplete="off">                       
                                    <div class="user-details">                                    
                                        <input type="hidden" id="project_id" name="project_id" value="<?php echo $projectID; ?>">                                         
                                        <div class="input-box">                                           
                                            <span class="details"> Project Start Date (Planned)</span>
                                            <input type="date" class="save_timeline" id="purchaseProjectStartDate" name="purchaseProjectStartDate" value="<?=$purchaseProjectStartDate; ?>" onkeydown="return false">
                                        </div>

                                        <div class="input-box">
                                            <span class="details"> Project End Date (Planned) </span>
                                            <input type="date" class="save_timeline" id="purchaseProjectEndDate" name="purchaseProjectEndDate" value="<?=$purchaseProjectEndDate; ?>" onkeydown="return false">
                                        </div> 
                                    </div>

                                    <div class="user-details">                                         
                                        <div class="input-box">                                           
                                            <span class="details"> Project Start Date (Actual)</span>
                                            <input type="date" class="save_timeline" id="purchaseActualStartDate" name="purchaseActualStartDate" value="<?=$purchaseActualStartDate; ?>" onkeydown="return false">
                                        </div>

                                        <div class="input-box">
                                            <span class="details"> Project End Date (Actual)</span>
                                            <input type="date" class="save_timeline" id="purchaseActualEndDate" name="purchaseActualEndDate" value="<?=$purchaseActualEndDate; ?>" onkeydown="return false">
                                        </div> 
                                    </div> 
                                </form>                               
                            </div>   

                            <div class="content">
                                <form id="add_purchase_activity_form" name="add_purchase_activity_form" action="<?php echo base_url().'purchasewindow/importPurchaseFile'?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">                                    
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">                                    
                                    <input type="hidden" id="projectNo" name="projectNo" value="<?php echo $projectNo; ?>">                                    
                                    <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
                                    <input type="hidden" id="tag_number" name="tag_number" value="<?php echo $tag_number; ?>">

                                    <div class="user-details">
                                        <div class="input-box">
                                            <span class="details">Client / Project No</span>
                                            <input type="text" id="project_no" name="project_no"  value="<?php echo $client_name; ?> / <?php echo $projectNo; ?>" disabled>
                                        </div>

                                        <div class="input-box">
                                            <span class="details">Equipment / TAG No</span>
                                            <input type="text" id="projectequipments" name="projectequipments"  value="<?php echo $projectequipmentName; ?> / <?php echo $tag_number; ?>" disabled>
                                        </div>

                                        <div class="input-box">
                                            <span class="details">Upload File<span class="req">*</span></span>
                                            <input class="" type="file" name="fileName" id="fileName" accept=".csv,.xls,.xlsx" style="border: 0; width:80%; height: 30px;">
                                        </div>

                                        <div class="uk-width-medium-1-1" >
                                            <div class="parsley-row md-input-filled input-simple">
                                                <label for="material_tc"></label>
                                                <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span>
                                            </div>
                                        </div> 
                                    </div>
                                </form>
                            </div>

                            <div class="user-details" >
                                <div class="input-box">                                    
                                    <button type="submit" name="submit" onclick="upload_activity()" class="md-btn md-btn-success add-activity">Upload</button>                                    
                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>                                                                        
                                </div>
                            </div>  
                        </div>                      
                    </div>

                    <!-- <div class="response_loader">
                        <img src="<?php // echo base_url()."assets/images/spinner.png" ?>" alt="spinner" style="display:none">
                    </div> -->
                    <h5 style="color:red;"><b>Note: </b> Please download file (Sr. No. 1) first, make changes(if any) and upload same file again. </h5>
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text"> List Purchase</h1> 
                    </div>

                    <div class="uk-overflow-container">
                        <form id="purchase_list_form" name="purchase_list_form" method="post">
                            <table id="purchase_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">
                                <thead>
                                    <tr>                                        
                                        <th class=""><b>Sr.</b></th>                                        
                                        <th class=""><b> File Name </b></th>                                                                            
                                        <th class=""><b> Uploaded By </b></th>
                                        <th class=""><b> Uploaded On </b></th>                                                                                                                    
                                        <th class=""><b> Download </b></th>
                                        <th class=""><b> Action </b></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($getAllPurchaseActivity)) {                                 
                                    $number = 0;
                                    foreach($getAllPurchaseActivity as $activity) {    
                                        $number++;
                                    ?>
                                        <input type="hidden" id="id" name="id" value="<?php echo $activity->id; ?>" >
                                        <input type="hidden" id="projectID" name="projectID" value="<?php echo $activity->projectID; ?>" >
                                        <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $activity->projectequipment; ?>" >
                                        <tr>                                            
                                            <td class=""> <?=$number; ?> </td>
                                            <td class=""> <?=$activity->fileName;?> </td>
                                            <td class=""> <?=$activity->name;?> </td>
                                            <td class=""> <?=$activity->createdOn;?> </td>
                                            <td>                                                                                                
                                                <a href="<?=base_url();?>uploads/purchase_files/<?=$activity->fileName;?>" title="Download"><i class="material-icons md-24 md-color-cyan-700">&#xE8F4;</i></a>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_purchase(<?php echo $activity->id; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>
                                            </td>
                                        </tr>
                                <?php } } ?>
                                </tbody>
                            </table>                                      
                        </form>
                    </div>
                    <br/><br/>

                <!-- modal for view data -->
                    <div class="uk-modal" id="modal_default">
                        <div class="uk-modal-dialog">
                            <button type="button" class="uk-modal-close uk-close"></button>

                            <div class="uk-modal-header">
                                <h3 class="uk-modal-title">Purchase Details</h3>
                            </div>
                                            
                            <div class="uk-grid">                                                        
                                <label for="tag_no"><h5>TAG No.</h5><input type="text" name="tag_no" disabled class="md-input label-fixed" /> </label>                                                                    
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="description"><h5>Description</h5> <input type="text" name="description" disabled class="md-input label-fixed" /></label>                                        
                            </div>

                            <div class="uk-grid">                                                    
                                <label for="tech_req"><h5>Material Specification</h5><input type="text" name="tech_req" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="dim_width"><h5>Dimensions as Per Original ODL (L, W, T)</h5> <input type="text" name="dim_width" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="qty"><h5>Quantity</h5><input type="text" name="qty" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                       
                                <label for="rev_odl"><h5>Change as per Revised ODL</h5><input type="text" name="rev_odl" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="stock"><h5>Stock / Purchase</h5><input type="text" name="stock" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="vendor"><h5>Vendor</h5><input type="text" name="vendor" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="po_release_date"><h5>Expected PO Release Date</h5><input type="text" name="po_release_date" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="actual_po_date"><h5>Actual PO Date</h5><div class="parsley-row md-input-wrapper"><input type="text" name="actual_po_date" disabled class="md-input label-fixed" /></label>
                            </div>                           

                            <div class="uk-grid">                                                        
                                <label for="appr_date"><h5>QAP APPROVED DATE</h5><input type="text" name="appr_date" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="material_reqd_prod"><h5>Material Required by Production On</h5><input type="text" name="material_reqd_prod" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                       
                                <label for="exp_material_rec_date"><h5>Expected Material Receipt Date </h5><input type="text" name="exp_material_rec_date" disabled class="md-input label-fixed" /></label>                                
                            </div>

                            <div class="uk-grid">                        
                                <label for="actual_material_rec_date"><h5>Actual Material Receipt Date</h5><input type="text" name="actual_material_rec_date" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                                        
                                <label for="tc_rec"><h5>TC Available </h5><input type="text" name="tc_rec" disabled class="md-input label-fixed" /></label>
                            </div>

                            <div class="uk-grid">                                
                                <label for="remark"><h5>Remark</h5><input type="text" name="remark" disabled class="md-input label-fixed" /></label>                                   
                            </div>         

                            <div class="uk-modal-footer uk-text-right">
                                <button type="button" style="align:right" class="md-btn uk-modal-close">Close</button>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url();?>';    

    $(document).ready(function(){                 

    });

    function upload_activity(){
        var file = $('#fileName').val();
        if(file!= ''){
            // console.log(file);
            $('#all_field_validation').html('');

            var projectID = $('#projectID').val();
            var projectequipment = $('#projectequipment').val();

            var aUrl = base_url+'purchasewindow/uploadPurchaseFile';

            if(projectID > 0 && projectequipment > 0){
                var formData = new FormData($('#add_purchase_activity_form')[0]);

                swal({
                    title: "Are you sure to upload this file?",                            
                    buttons: true,            
                }).then((willUpdate) => {
                    if(willUpdate){  
                        $.ajax({
                            url : aUrl,
                            type: "POST",
                            dataType: "text",
                            // data: {'projectID':projectID, 'projectequipment':projectequipment, 'file':file },
                            data:formData,  
                            processData: false,
                            contentType: false,  
                            // beforeSend: function(){
                            //     $('.response_loader').show();
                            // },    
                            success: function(data, textStatus, jqXHR){ 
                                // console.log(data);
                                if(projectID > 0){
                                    swal("Purchase file uploaded successfully.")
                                        .then((value) => {
                                            window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 
                                    });
                                }else{
                                    swal({
                                        title: "Something went wrong.. Please try again!",                        
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    });
                                }                                                             
                            },
                            // complete: function(){
                            //     $('.response_loader').hide();
                            // },
                            error: function (jqXHR, textStatus, errorThrown)
                            {                       
                                swal({
                                    title: "Unable to add purchase.. Please try again!!",
                                    text: "Check if you have uploaded correct data!",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                });              
                            }
                        });
                    }
                });                    
                      
            }else{
                
            }

        }else{
            $('#all_field_validation').html('Please upload purchase file first..');
        }        
    }

    function delete_purchase(id, projectID, projectequipment){
        var aUrl = base_url+'purchasewindow/deleteFile';

        swal({
            title: "Are you sure to delete this file?",            
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                if(id > 0){
                    $.ajax({
                        url : aUrl,
                        type: "POST",
                        dataType: "JSON",
                        data: {'id':id},
                        success: function(data)
                        {                                                        
                            window.location = base_url+'purchasewindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         
                        },                
                    });
                }else{
                    swal({
                        title: "Something went wrong.. Please try again!",                        
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }                
            }
        });
    }   
    
    $('.save_timeline').on('change', function(){        
        var aUrl = base_url+'purchasewindow/saveProjectTimeline';
        var projectID = $('#project_id').val();                
        var purchaseProjectStartDate = $('#purchaseProjectStartDate').val();
        var purchaseProjectEndDate = $('#purchaseProjectEndDate').val();
        var purchaseActualStartDate = $('#purchaseActualStartDate').val();
        var purchaseActualEndDate = $('#purchaseActualEndDate').val();
        // console.log(purchaseProjectStartDate);
        // console.log(purchaseProjectEndDate);

        // if(projectID > 0 && purchaseProjectStartDate <= purchaseProjectEndDate){ 
        if(projectID > 0){               
            var formData = new FormData($('#add_project_timeline')[0]);                                  
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",               
                data:formData,  
                processData: false,
                contentType: false,     
                success: function(data, textStatus, jqXHR){ 
                    $('#purchaseProjectStartDate').val(data.purchaseProjectStartDate);
                    $('#purchaseProjectEndDate').val(data.purchaseProjectEndDate);
                    $('#purchaseActualStartDate').val(data.purchaseActualStartDate);
                    $('#purchaseActualEndDate').val(data.purchaseActualEndDate);
                    // swal({
                    //     title: "Timeline saved..",                        
                    //     icon: "success",                                                
                    // });
                },

                error: function (jqXHR, textStatus, errorThrown){                       
                    swal({
                        title: "Something went wrong.. Please try again!!",
                        text: "Check if you have entered correct data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });              
                }
            });                
        }else{
            // console.log('invalid data');
            // $('#purchaseProjectEndDate').val('');
            swal({                
                text: "Check if you have entered correct data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            });  
        }
    });
</script>