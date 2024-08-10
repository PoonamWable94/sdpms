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
        /* justify-content: space-between; */
        margin: -1px 0 -15px 0;
        /* 20px 0 12px 0; */
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
        width: 80%;
        outline: none;
        font-size: 14px;
        border-radius: 5px;
        padding-left: 8px;
        border: 1px solid #ccc;
        border-bottom-width: 2px;
        transition: all 0.3s ease;
    }

    .user-details .input-box select{
        height: 31px;
        width: 85%;
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

    .selectize-input {
        border: 1px solid #d0d0d0;
        padding: 2px 4px;
        display: inline-block;
        width: 80%;
        border-radius:8px;
    }

    .selectize-control.multi .selectize-input input {
        height: 26px;
        font-size: 12px;
        color:black !important;
    }

    .input-simple span {
        margin-left: -139px;
    } 

    .container{
        margin-right: 80px !important;
        margin-left: 5px !important;
    }

    /* .update-activity{
        display:none;
    }
    .add-activity{
        display:block;
    }
    .reset_form{
        display:block;
    } */
</style>

<link type="text/css" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<!-- <link type="text/css" href="<?php echo base_url(); ?>assets/date_time_picker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> -->

<div id="page_content">    
    <div id="page_content_inner">                
        <div class="uk-grid">
            <div class="uk-width-medium-1-1 uk-row-first">

                <div class="md-card">
                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">
                        <h1 class="md-card-toolbar-heading-text add-activity"> Update Purchase Activity </h1>                         
                    </div>  

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">
                                <form id="edit_purchase_activity_form" name="edit_purchase_activity_form" method="POST" autocomplete="off">
                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">                                    
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">                                    
                                    <input type="hidden" id="activityID" name="activityID" value="<?php echo $activityID; ?>">                                    
                                    
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
                                            <span class="details">Material TAG No</span>
                                            <input type="text" id="tag_no" name="tag_no" value="<?php echo ($this->input->post('tag_no')?$this->input->post('tag_no'):$act_data->tag_no); ?>" >
                                        </div>  
                                        
                                        <div class="input-box">      
                                            <span class="details">BOM Issue Date</span>                                                                                                                                                                                   
                                            <input class="bom_date" type="text" name="bom_date" id="bom_date" value="<?php echo ($this->input->post('bom_date')?$this->input->post('bom_date'):$act_data->bom_date); ?>">                                                                                                                                     
                                        </div>                                        

                                        <div class="input-box">
                                            <span class="description"> Description </span>
                                            <input type="text" id="description" name="description" value="<?php echo ($this->input->post('description')?$this->input->post('description'):$act_data->description); ?>" >
                                        </div> 

                                        <div class="input-box">
                                            <span class="details">Material Specification </span>
                                            <input type="text" id="tech_req" name="tech_req" value="<?php echo ($this->input->post('tech_req')?$this->input->post('tech_req'):$act_data->tech_req); ?>" >
                                        </div>                                                                                 

                                        <div class="input-box">
                                            <span class="details"> Width </span>
                                            <input type="text" id="dim_width" name="dim_width" value="<?php echo ($this->input->post('dim_width')?$this->input->post('dim_width'):$act_data->dim_width); ?>"  >
                                        </div> 

                                        <div class="input-box">
                                            <span class="details"> Length </span>
                                            <input type="text" id="dim_length" name="dim_length" value="<?php echo ($this->input->post('dim_length')?$this->input->post('dim_length'):$act_data->dim_length); ?>"  >
                                        </div> 

                                        <div class="input-box">
                                            <span class="dim_thickness"> Thickness </span>
                                            <input type="text" id="dim_thickness" name="dim_thickness" value="<?php echo ($this->input->post('dim_thickness')?$this->input->post('dim_thickness'):$act_data->dim_thickness); ?>"  >
                                        </div> 

                                       

                                        <div class="input-box">
                                        <span class="details"> QTY </span>
                                            <input type="text" id="qty" name="qty" value="<?php echo ($this->input->post('qty')?$this->input->post('qty'):$act_data->qty); ?>"  >
                                        </div> 

                                       
                                        <div class="input-box">
                                            <span class="rev_odl"> Change as per Revised ODL </span>
                                            <input type="text" id="rev_odl" name="rev_odl" value="<?php echo ($this->input->post('rev_odl')?$this->input->post('rev_odl'):$act_data->rev_odl); ?>"  >
                                        </div> 

                                        <div class="input-box">
                                            <span class="stock">Stock/Purchase </span>
                                            <select name="stock" id="stock" >    
                                                <option value="1"<?=$act_data->stock == '1' ? ' selected="selected"' : '';?>>Stock</option>                                      
                                                <option value="2"<?=$act_data->stock == '2' ? ' selected="selected"' : '';?>>Purchase</option>                                                                                                                                                                                                          
                                            </select>
                                        </div>

                                        <div class="input-box">
                                            <span class="vendor"> Final Vendor </span>
                                            <input type="text" id="vendor" name="vendor" value="<?php echo ($this->input->post('vendor')?$this->input->post('vendor'):$act_data->vendor); ?>"  >
                                        </div>  

                                        <div class="input-box">      
                                            <span class="details">Expected PO Release Date</span>                                                                                                                                                                                   
                                            <input class="po_release_date" type="text" name="po_release_date" id="po_release_date" value="<?php echo ($this->input->post('po_release_date')?$this->input->post('po_release_date'):$act_data->po_release_date); ?>">                                                                                                                                     
                                        </div> 
                                        
                                        <div class="input-box">      
                                            <span class="details">Actual PO Date</span>                                                                                                                                                                                   
                                            <input class="actual_po_date" type="text" name="actual_po_date" id="actual_po_date" value="<?php echo ($this->input->post('actual_po_date')?$this->input->post('actual_po_date'):$act_data->actual_po_date); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">      
                                            <span class="details">QAP Approved Date</span>                                                                                                                                                                                   
                                            <input class="appr_date" type="text" name="appr_date" id="appr_date" value="<?php echo ($this->input->post('appr_date')?$this->input->post('appr_date'):$act_data->appr_date); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">      
                                            <span class="details">QAP Given/Sample</span>                                                                                                                                                                                   
                                            <input class="qap_given" type="text" name="qap_given" id="qap_given" value="<?php echo ($this->input->post('qap_given')?$this->input->post('qap_given'):$act_data->qap_given); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">      
                                            <span class="details">Material Required by Production On</span>                                                                                                                                                                                   
                                            <input class="material_reqd_prod" type="text" name="material_reqd_prod" id="material_reqd_prod" value="<?php echo ($this->input->post('material_reqd_prod')?$this->input->post('material_reqd_prod'):$act_data->material_reqd_prod); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">      
                                            <span class="details">Expected M.R Date</span>                                                                                                                                                                                   
                                            <input class="exp_material_rec_date" type="text" name="exp_material_rec_date" id="exp_material_rec_date" value="<?php echo ($this->input->post('exp_material_rec_date')?$this->input->post('exp_material_rec_date'):$act_data->exp_material_rec_date); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">      
                                            <span class="details">Actual M.R Date</span>                                                                                                                                                                                   
                                            <input class="actual_material_rec_date" type="text" name="actual_material_rec_date" id="actual_material_rec_date" value="<?php echo ($this->input->post('actual_material_rec_date')?$this->input->post('actual_material_rec_date'):$act_data->actual_material_rec_date); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">      
                                            <span class="details">TC Available</span>                                                                                                                                                                                   
                                            <input class="tc_rec" type="text" name="tc_rec" id="tc_rec" value="<?php echo ($this->input->post('tc_rec')?$this->input->post('tc_rec'):$act_data->tc_rec); ?>">                                                                                                                                     
                                        </div> 

                                        <div class="input-box">
                                            <span class="details"> Remark </span>
                                            <input type="text" id="remark" name="remark" value="<?php echo ($this->input->post('remark')?$this->input->post('remark'):$act_data->remark); ?>" >
                                        </div> 

                                        <div class="input-box">
                                            <span class="quality_remark">Quality Remark </span>
                                            <select name="quality_remark" id="quality_remark" >    
                                                <option value="approved"<?=$act_data->quality_remark == 'approved' ? ' selected="selected"' : '';?>>Approved</option>                                      
                                                <option value="notapproved"<?=$act_data->quality_remark == 'notapproved' ? ' selected="selected"' : '';?>>Not Approved</option>                                                                                                                                                                                                          
                                                <option value="na"<?=$act_data->quality_remark == 'na' ? ' selected="selected"' : '';?>>NA</option>
                                            </select>
                                        </div>

                                        <div class="input-box">
                                            <span class="release_for_prod">Release for Production </span>
                                            <select name="release_for_prod" id="release_for_prod" >    
                                                <option value="design_hold"<?=$act_data->release_for_prod == 'design_hold' ? ' selected="selected"' : '';?>>Hold From Design</option>                                      
                                                <option value="prod_release"<?=$act_data->release_for_prod == 'prod_release' ? ' selected="selected"' : '';?>>Release for Production</option>                                                                                                                                                                                                          
                                                <option value="on_hold"<?=$act_data->release_for_prod == 'on_hold' ? ' selected="selected"' : '';?>>On Hold</option>                                                                                                                                                                                                          
                                            </select>
                                        </div>

                                        <div class="input-box">
                                            <span class="mtc">Availability of TC </span>
                                            <select name="mtc" id="mtc" >    
                                                <option value="original"<?=$act_data->mtc == 'original' ? ' selected="selected"' : '';?>>Original</option>
                                                <option value="photocopy"<?=$act_data->mtc == 'photocopy' ? ' selected="selected"' : '';?>>Photocopy</option>
                                                <option value="pending"<?=$act_data->mtc == 'pending' ? ' selected="selected"' : '';?>>Pending</option>
                                                <option value="na"<?=$act_data->mtc == 'na' ? ' selected="selected"' : '';?>>NA</option>
                                            </select>
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
                                    <button type="submit" name="submit" onclick="update_activity()" class="md-btn md-btn-success">Update</button>                                    
                                    <a href="<?php echo base_url('purchasewindow?projectID=').$projectID;?>" class="md-btn">Back</a>                                    
                                </div>
                            </div>  
                        </div>                      
                    </div>                   
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<!-- <script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.pt-BR.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/date_time_picker/js/bootstrap-datetimepicker.min.js"></script>
<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url();?>';       

    $(document).ready(function(){                                            
        $('#edit_purchase_activity_form').submit(function(){
            $("#edit_purchase_activity_form :disabled").removeAttr('disabled');
        });                                      
    });       

    function update_activity(){               
        var aUrl = base_url+'purchasewindow/update_purchase_details';
        
        var activityID = $('#activityID').val();        
        var projectID = $('#projectID').val();                      

        if(projectID > 0 && activityID > 0 ){ 
            var formData = new FormData($('#edit_purchase_activity_form')[0]);                          
            $.ajax({
                url : aUrl,
                type: "POST",
                dataType: "JSON",
                // data: {'activityID':update_activityID, 'projectID':projectID, 'projectequipment':projectequipment, 'activity':activity, 'skill1':skill1, 'manpower1':manpower1, 'person1':person1, 'startDate':startDate, 'targetDate':targetDate, 'material_tc':material_tc},
                data:formData,  
                processData: false,
                contentType: false,     
                success: function(data, textStatus, jqXHR){ 
                    if(data.projectID > 0){
                        swal("Purchase Activity Updated Successfully.")
                            .then((value) => {                                
                                window.location = base_url+'purchasewindow/'+'?projectID='+projectID; 
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
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // alert('Something went wrong');                   
                    swal({
                        title: "Activity data not updated.. Please try again!!",
                        text: "Check if you have entered correct data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }
            });    
        } 
    }    

    $(".appr_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {
       
    });

    $(".qap_given").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {
        
    });

    $(".po_release_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {
        
    });

    $(".actual_po_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {
       
    }); 

    $(".bom_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {       
    });   

     $(".material_reqd_prod").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {       
    });           

    $(".exp_material_rec_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {       
    });  

    $(".actual_material_rec_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {       
    });   

    $(".tc_rec").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {       
    });  

    $(".bom_date").datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'English',
        autoclose: true,         
    })
    .on("change", function() {       
    });   
</script>