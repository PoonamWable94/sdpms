<?php
    // $activity_id_array = array();
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



    .selectize-input {

        border: 1px solid #d0d0d0;

        padding: 2px 4px !important;

        display: inline-block;

        width: 90%;

        border-radius:8px;

    }



    .selectize-control.multi .selectize-input input {

        line-height: 11px !important;

        font-size: 10px !important;

        color:black !important;

    }



    .input-simple span {

        margin-left: -139px;

    } 



    .container{

        margin-right: 80px !important;

        margin-left: 5px !important;

    }



    .sturdy td:nth-child(2) {

        width: 30%;        

        overflow: hidden; 

        text-overflow: ellipsis; 

        white-space: nowrap;

        /* overflow: visible; */

    }



    textarea {

    overflow: hidden;

    padding: 0;

    outline: none;

    min-width: 30%;

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
                        <h1 class="md-card-toolbar-heading-text add-activity"> Add Design Activity</h1> 
                        <h1 class="md-card-toolbar-heading-text update-activity"> Update Design Activity</h1> 
                    </div>  

                    <div class="md-card-content">                        
                        <?php $this->load->helper("form"); ?>
                        <div class="container">
                            <div class="content">
                                <form id="add_design_activity_form" action="#" method="post" autocomplete="off">

                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectID; ?>">                                    
                                    <input type="hidden" id="projectequipment" name="projectequipment" value="<?php echo $projectequipment; ?>">                                    

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
                                            <span class="details">Manpower Required <span class="req">*</span></span>
                                            <select name="manpower1" id="manpower1" >                                                                                  
                                                <option value="1">1</option>                                      

                                                <option value="2">2</option>                                      

                                                <option value="3">3</option>                                      

                                                <option value="4">4</option>                                      

                                                <option value="5">5</option>                                      

                                                <option value="6">6</option>                                      

                                                <option value="7">7</option>                                      

                                                <option value="8">8</option>                                      

                                                <option value="9">9</option>    

                                                <option value="10">10</option>                                                                             

                                            </select>

                                        </div>                                      



                                        <div class="input-box">

                                            <span class="details">Activity <span class="req">*</span></span>

                                            <select id="activity_id" name="activity">

                                            <option value="">Select Activity</option>

                                                <?php                                                                                    

                                                    foreach ($activitylist as $activity) {

                                                        $timeHours = substr($activity->activity_time,0,2);

                                                        $timeMinutes = substr($activity->activity_time,3,2); 

                                                    ?>                                    

                                                        <option value="<?php echo $activity->id; ?>"<?=$this->input->post('activity') == $activity->id ? ' selected="selected"' : '';?>><?php echo $activity->activity_data.' ( '.$activity->activity_days.' day '.$timeHours.' hrs '.$timeMinutes.' min )'; ?></option>

                                                <?php } ?>     

                                            </select>

                                        </div>



                                        <div class="input-box">

                                            <span class="details">Skills </span>                                            

                                            <select name="skill1[]" id="skill1_id" data-md-selectize-inline data-md-selectize-bottom multiple disabled>                                            

                                            </select>

                                        </div>                                         

                                   

                                        <div class="input-box">

                                            <span class="details">Responsible Persons <span class="req">*</span></span>

                                            <select name="person_name_id[]" id="person_name_id" data-md-selectize-inline data-md-selectize-bottom multiple>                                                                                

                                                

                                            </select>

                                        </div>                                                                    



                                        <div class="input-box input-calendar input-append date d" style="font-size:14px;" id="datetimepicker1"> 

                                            <span class="details">Start Date <span class="req">*</span></span>

                                            <div id="startDate_time" class="input-append date">

                                                <input class="startDate" type="text" name="startDate" id="startDate">

                                                <span class="add-on">

                                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>

                                                </span>

                                                <a href="javascript:void(0)" id="get_target_date" class="md-btn md-btn-success" style="margin-left:5px; height:27px !important; padding-top:0px; font-size:10px;">Target Date</a>

                                            </div>

                                            

                                        </div>



                                        <div class="input-box input-calendar input-append date" style="font-size:14px;" id="datetimepicker2">

                                            <span class="details">Target Date <span class="req">*</span></span>                                            

                                                <input class="targetDate" type="text" name="targetDate" id="targetDate">                                                

                                        </div>                                    



                                        <div class="gender-details" style="margin-left: -6px;">

                                            <span class="gender-title">Client Approval <span class="req">*</span></span><br>

                                            <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_yes" value="yes" checked >Yes &nbsp;&nbsp;

                                            <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_no" value="no">No &nbsp;&nbsp;

                                            <input type="radio" id="clientApproval" name="clientApproval" class="data-check-clientApproval clientApproval_pending" value="pending">Pending

                                        </div>



                                        <div class="gender-details" style="margin-left:28px;">

                                            <span class="gender-title">Release for Production <span class="req">*</span></span><br>

                                            <input type="radio" id="prod_release" name="prod_release" class="data-check-prodRelease prod_release_yes" value="yes" checked >Yes &nbsp;&nbsp;

                                            <input type="radio" id="prod_release" name="prod_release" class="data-check-prodRelease prod_release_no" value="no">No &nbsp;&nbsp;

                                            

                                        </div>



                                        <div class="uk-width-medium-1-1" >

                                            <div class="parsley-row md-input-filled input-simple">

                                                <label for="clientApproval"></label>

                                                <span class="uk-form-help-block uk-text-danger" id="all_field_validation"></span> 

                                            </div>

                                        </div> 

                                    </div>                                                                                  

                                </form>

                            </div>                       

                        

                            <div class="user-details" >

                                <div class="input-box">

                                    <button type="submit" name="submit" onclick="save_activity()" class="md-btn md-btn-success add-activity">Add</button>

                                    <button type="submit" name="submit" onclick="update_activity()" class="md-btn md-btn-success update-activity">Update</button>

                                    <button type="submit" class="md-btn reset_form">Reset</button>

                                    <a href="<?=base_url();?>add_new_project/add_project" class="md-btn">Back</a>

                                    <!-- <button type="submit" name="submit" onclick="get_target_date()" class="md-btn md-btn-success">Get Target Date</button> -->

                                    <!-- <a href="javascript:void(0)" class="md-btn reset_form">Reset</a> -->

                                </div>

                            </div>  

                        </div>                      

                    </div>



                    <div class="md-card-toolbar md-bg-cyan-300 " data-toolbar-progress="100">

                        <h1 class="md-card-toolbar-heading-text"> List Activities</h1> 

                    </div>



                    <div class="uk-overflow-container">

                        <table id="design_activity" class="uk-table uk-table-striped uk-table-hover uk-text-nowrap">

                            <thead>

                                <tr>

                                    <th><b>Sr.</b></th>

                                    <th><b>Activity</b></th>

                                    <th><b>Skills</b></th>

                                    <th><b>ManP</b></th>

                                    <th><b>Person Name</b></th>

                                    <th><b>Start Date</b></th>

                                    <th><b>Target Date</b></th>                                   

                                    <th><b>Client</b></th>

                                    <th><b>Release</b></th>

                                    <th><b>Action</b></th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php if(!empty($getAllDesignActivity)) { 

                                $this->load->model('design_window_model');

                                $number = 0;

                                foreach($getAllDesignActivity as $activity) { ?>

                                    <tr>

                                        <td><?php echo $number = $number + 1; ?></td>

                                        <td><?php echo $activity->activity_data; ?></td>

                                        <td><?php 

                                            $list = explode(',',$activity->skill1);

                                            $skill_name = '';

                                            foreach($list as $skillId){

                                                $getSkill = $this->design_window_model->get_skill_name($skillId);

                                                $skill_name = $skill_name.''.$getSkill->skills.'<br/>';

                                            }

                                            echo $skill_name; 

                                        ?></td>

                                        <td><?php echo $activity->manpower1; ?></td>

                                        <td><?php 

                                        if($activity->person1){

                                            $list = explode(',',$activity->person1);

                                            $person_name = '';

                                            foreach($list as $usrID){

                                                $getNames = $this->design_window_model->get_person_name($usrID);

                                                $person_name = $person_name.''.$getNames->name.'<br/>';

                                            }

                                            echo $person_name;

                                        } 

                                        ?></td>                                        

                                        <td><?php echo $activity->startDate; ?></td>

                                        <td><?php echo $activity->targetDate; ?></td>

                                        <td><?php 

                                            $clientApproval = 'Yes';

                                            if($activity->clientApproval == 'no'){

                                                $clientApproval = 'No';

                                            }

                                            if($activity->clientApproval == 'pending'){

                                                $clientApproval = 'Pending';

                                            }

                                            echo $clientApproval;

                                        ?></td>

                                        <td><?php 

                                            $prod_release = 'Yes';

                                            if($activity->prod_release == 'no'){

                                                $prod_release = 'No';

                                            }

                                            

                                            echo $prod_release;

                                        ?></td>

                                        <td>

                                            <a href="javascript:void(0)" data-uk-tooltip title="Edit" onclick="edit_activity(<?php echo $activity->activityID; ?>)" ><i class="material-icons md-24 md-color-orange-400">&#xE254;</i></a> |

                                            <a href="javascript:void(0)" data-uk-tooltip title="Delete" onclick="delete_activity(<?php echo $activity->activityID; ?>,<?php echo $activity->projectID; ?>,<?php echo $activity->projectequipment; ?>)"><i class="material-icons md-24 md-color-red-500">&#xE872;</i></a>

                                        </td>

                                    </tr>

                            <?php } } ?>

                            </tbody>

                        </table>

                    </div>

                    <br/><br/>

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

    var activityID = totalSkills = activity_days = 0;

    var activity_time = '';

    var update_activityID = 0; 

    // var js_activity_id_array = [];   

    // js_activity_id_array =<?php //echo json_encode($activity_id_array );?>;       

    // console.log(js_activity_id_array);



    $(document).ready(function(){                 

        $('.update-activity').hide(); 

        // $('#activity_id').on('change', function() { 

            

        // });               



        $('#activity_id').on('change', function() { 

            activityID = $(this).val();

            totalSkills = 0;

            if(activityID > 0){                   

                $.ajax({

                    url : base_url+'designwindow/getActivitySkill',

                    type: "POST",

                    data: {'activityID':activityID},

                    dataType: "json",                    

                    success: function(data){                         

                        var skill_array = [];

                        $('#skill1_id').selectize()[0].selectize.clearOptions();                        

                        var $select = $('#skill1_id').selectize();

                        var selectize = $select[0].selectize;

                        $.each( data, function( key, value ) {                            

                            totalSkills++;

                            selectize.addOption({value:value.id,text:value.skills});

                            skill_array.push(value.id);                           
                        });

                        // selectize.refreshOptions(); 

                        skill_array.forEach(function(item) {

                            selectize.addItem(item);

                        });

                                              

                        $('#targetDate').val('');

                        $('#startDate').val('');

                    

                        //get skills full persons list

                        if(activityID > 0 && totalSkills > 0){

                            $.ajax({

                                url : base_url+'designwindow/getPersonsActivitySkill',

                                type: "POST",

                                data: {'activityID':activityID, 'totalSkills':totalSkills},

                                dataType: "json",                    

                                success: function(data){                                                                 

                                    // $.each( data, function( key, value ) { 

                                    //     $('.personlist').append('<label for="person_name_label" class="person_name_label"></label>');                                

                                    //     $('.personlist').append('<input type="text" class="personlist" id="person_name-'+key+'" name="person_name['+key+']" value="'+value+'" readonly="readonly">');            

                                    //     $('.personlist').append('<a href="javascript:void(0)" style="color:red;" id="person_name_cross-'+key+'" onclick="removePerson('+"'"+key+"'"+')" class="removePerson">&nbsp; X</a>');                                    

                                    //     $('.personlist').append('<br/>');                                    

                                    // });



                                    $('#person_name_id').selectize()[0].selectize.clearOptions();

                                        var $select1 = $('#person_name_id').selectize();

                                        var selectize1 = $select1[0].selectize;

                                        $.each( data, function( key, value ) {                                           

                                            selectize1.addOption({value:key,text:value});

                                        });

                                        selectize1.refreshOptions(); 

                                },

                            }); 

                        } 



                        // get activity time required

                        if(activityID > 0){

                            $.ajax({

                                url : base_url+'designwindow/getActivityTimeRequired',

                                type: "POST",

                                data: {'activityID':activityID},

                                dataType: "json",                    

                                success: function(data){                                                                 

                                    activity_days = data.activity_days;

                                    activity_time = data.activity_time;                                    

                                },

                            }); 

                        }                         

                    },

                });    

            } else{

                $('#skill1_id').selectize()[0].selectize.clearOptions();

                var $select = $('#skill1_id').selectize();

                var selectize = $select[0].selectize;                        

                selectize.refreshOptions();                  

            }                       

        });              



        $('#add_design_activity_form').submit(function(){

            $("#add_design_activity_form :disabled").removeAttr('disabled');

        });   

        

        $('.reset_form').click(function(){

            location.reload();           

        });                      

    });  



    function update_manpower(id){

        var activity_id = id.data("activity-id");

        console.log(activity_id);

        // var manpower1 = $('#manpower1').val();

        // var edit_activity_id = $('#edit_activity_id').val();

        // console.log(manpower1);

        // console.log(edit_activity_id);

    }     



    function edit_activity(editactivityID){       

        $('.update-activity').show();

        $('.add-activity').hide();               

           

        var aUrl = base_url+'designwindow/editActivityView';



        if(editactivityID > 0){            

            $.ajax({

                url : aUrl,

                type: "POST",

                dataType: "JSON",

                data: {'activityID':editactivityID},

                success: function(data){ 

                    // console.log(data.act_data);

                    update_activityID = editactivityID;

                    activityID = data.act_data.activity;                    

                    $('[name="activity"] option[value='+data.act_data.activity+']').attr('selected', true);

                    // $('[name="activity"]')[0].selectize.setValue(data.act_data.activity);

                    $('#activity_id').prop('disabled', true);

                    $('[name="manpower1"] option[value='+data.act_data.manpower1+']').attr('selected', true);

                    $('[name="startDate"]').val(data.act_data.startDate);

                    $('[name="targetDate"]').val(data.act_data.targetDate);                                        

                    

                    if (data.act_data.clientApproval == 'yes') {                                                  

                        $('.clientApproval_yes').prop('checked', true);                         

                    }

                    else if(data.act_data.clientApproval == 'no'){                                                

                        $('.clientApproval_no').prop('checked', true); 

                    }else{

                        $('.clientApproval_pending').prop('checked', true); 

                    }

                      

                    if (data.act_data.prod_release == 'yes') {                                                  

                        $('.prod_release_yes').prop('checked', true);                         

                    }else{                                                

                        $('.prod_release_no').prop('checked', true); 

                    }

                    

                    // console.log(data.act_data.person1);

                    var person_names = data.act_data.person1;

                    var person_array = person_names.split(',');

                    $('#person_name_id').selectize()[0].selectize.clearOptions();

                        var $select1 = $('#person_name_id').selectize();

                        var selectize1 = $select1[0].selectize;

                        $.each( data.personsdata, function( key, value ) {                                           

                            selectize1.addOption({value:key,text:value});                            

                        });

                        // selectize1.refreshOptions(); 

                        person_array.forEach(function(item) {

                            selectize1.addItem(item);

                        });                        



                        var skill_array = [];

                        $('#skill1_id').selectize()[0].selectize.clearOptions();

                        var $select = $('#skill1_id').selectize();

                        var selectize = $select[0].selectize;

                        $.each( data.skills_list, function( key, value ) {                                    

                            totalSkills++;                                                        

                            selectize.addOption({value:value.id,text:value.skills});  

                            skill_array.push(value.id);                           

                        });

                        // selectize.refreshOptions();

                        skill_array.forEach(function(item) {

                            selectize.addItem(item);

                        });                                                                        



                    // get activity time required

                    if(activityID > 0){

                        // console.log(activityID);

                        $.ajax({

                            url : base_url+'designwindow/getActivityTimeRequired',

                            type: "POST",

                            data: {'activityID':activityID},

                            dataType: "json",                    

                            success: function(data){  

                                // console.log(data);                                                               

                                activity_days = data.activity_days;

                                activity_time = data.activity_time;                                    

                            },

                        }); 

                    }                                              

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



    function update_activity(){

        // console.log(update_activityID);

        var isValid = 0;

        // var update_activity_from = "addActivity";

        var aUrl = base_url+'designwindow/updateActivity';

        

        var projectID = $('#projectID').val();

        var projectequipment = $('#projectequipment').val();

        var activity1 = $('#activity_id').val();

        var skill1 = $('#skill1_id').val();

        var manpower1 = $('#manpower1').val();

        var person1 = $('#person_name_id').val();

        var startDate = $('#startDate').val();

        var targetDate = $('#targetDate').val();

        

        // var clientApproval = $('#clientApproval').val();

        // console.log(skill1);

        if(activity1 > 0 && skill1 != null && manpower1 > 0 && person1 != null && startDate != '' && targetDate != ''){                

            isValid = 1;

            $('#all_field_validation').html('');

        }   

        else{

            $('#all_field_validation').html('Please Select All Mandatory Fields..');

            isValid = 0;            

        }



        if(projectID > 0 && projectequipment > 0 && isValid > 0){ 

            $('#skill1_id').prop("disabled", false);

            var formData = new FormData($('#add_design_activity_form')[0]); 

            // console.log(formData);

            // alert(projectID); 

            formData.append('activityID', JSON.stringify(update_activityID)); 

            formData.append('activity', activity1);                

            $.ajax({

                url : aUrl,

                type: "POST",

                dataType: "JSON",

                // data: {'activityID':update_activityID, 'projectID':projectID, 'projectequipment':projectequipment, 'activity':activity, 'skill1':skill1, 'manpower1':manpower1, 'person1':person1, 'startDate':startDate, 'targetDate':targetDate, 'clientApproval':clientApproval},

                data:formData,  

                processData: false,

                contentType: false,     

                success: function(data, textStatus, jqXHR){ 

                    if(data.projectID > 0){

                        swal("Design Activity Updated Successfully.")

                            .then((value) => {

                                window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 

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

        } else{           

        }

    }



    function save_activity(){

        var isValid = 0;

        var aUrl = base_url+'designwindow/saveNewActivity';

        

        var projectID = $('#projectID').val();

        var projectequipment = $('#projectequipment').val();

        var activity = $('#activity_id').val();

        var skill1 = $('#skill1_id').val();

        var manpower1 = $('#manpower1').val();

        var person1 = $('#person_name_id').val();

        var startDate = $('#startDate').val();

        var targetDate = $('#targetDate').val();

        // var completionDate = $('#completionDate').val();

        // var releaseDate = $('#releaseDate').val();

        var clientApproval = $('#clientApproval').val();

        // console.log(skill1);

        if(activity > 0 && skill1 != null && manpower1 > 0 && person1 != null && startDate != '' && targetDate != '' && clientApproval != ''){                

            isValid = 1;

            $('#all_field_validation').html('');                        

        }   

        else{

            $('#all_field_validation').html('Please Select All Mandatory Fields..');

            isValid = 0;            

        }



        if(projectID > 0 && projectequipment > 0 && isValid > 0){ 

            $('#skill1_id').prop("disabled", false);

            var formData = new FormData($('#add_design_activity_form')[0]); 

            // alert(projectID);                 

            $.ajax({

                url : aUrl,

                type: "POST",

                dataType: "JSON",

                // data: {'projectID':projectID, 'projectequipment':projectequipment, 'activity':activity, 'skill1':skill1, 'manpower1':manpower1, 'person1':person1, 'startDate':startDate, 'targetDate':targetDate, 'completionDate':completionDate, 'releaseDate':releaseDate, 'clientApproval':clientApproval},

                data:formData,  

                processData: false,

                contentType: false,     

                success: function(data, textStatus, jqXHR){ 

                    if(data.projectID > 0){

                        swal("Design Activity Added Successfully.")

                            .then((value) => {

                                window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment; 

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

                    swal({

                        title: "Unable to add activity.. Please try again!!",

                        text: "Check if you have entered correct data!",

                        icon: "warning",

                        buttons: true,

                        dangerMode: true,

                    });              

                }

            });    

        }else{            

        }

    }    



    function delete_activity(activityID,projectID,projectequipment)

    {

        var aUrl = base_url+'designwindow/delete_new_activity';

        swal({

            title: "Are you sure to delete activity?",

            // text: "Once deleted, you will not be able to recover this imaginary file!",

            icon: "warning",

            buttons: true,

            dangerMode: true,

        }).then((willDelete) => {

            if (willDelete) {

                if(activityID > 0){

                    $.ajax({

                        url : aUrl,

                        type: "POST",

                        dataType: "JSON",

                        data: {'activityID':activityID},

                        success: function(data)

                        {                                                        

                            window.location = base_url+'designwindow/addActivity'+'?projectID='+projectID +'&projectequipment='+projectequipment;                         

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



    // var i;

    // var id_rest = '';

    // js_activity_id_array.forEach(function(item) {                        

        // id_rest = "#startDate_time-"+item;

        $('#startDate_time').datetimepicker({

            format: 'yyyy-MM-dd hh:mm',

            language: 'English',

            autoclose: true, 

            changeMonth: true,

            changeYear: true,        

        })

        .on("change", function() {

            // $(this).datetimepicker('remove');

        });

    // });



    $("#targetDate").bind("propertychange change keyup paste input", function(){

        var startDate = $('#startDate').val();  

        var targetDate = $('#targetDate').val();            

        var startDate1 = new Date(startDate);

        var targetDate1 = new Date(targetDate);

        // console.log(targetDate1); 

        if(startDate == ''){

            $('#all_field_validation').html('Please Select Start Date first..');

            $('#targetDate').val(''); 

        }



        if(startDate1 > targetDate1){                

            $('#all_field_validation').html('Please Select Valid Target Date..');            

            $('#targetDate').val(''); 

        }     

    });

        

    function convertToDateTime(str) {

        var date = new Date(str),

        mnth = ("0" + (date.getMonth() + 1)).slice(-2),

        day = ("0" + date.getDate()).slice(-2);

        hours  = ("0" + date.getHours()).slice(-2);

        minutes = ("0" + date.getMinutes()).slice(-2);

        return [ date.getFullYear(), mnth, day, hours, minutes ].join("-");    

    }



    function convertToDate(str) {

        var date = new Date(str),

        mnth = ("0" + (date.getMonth() + 1)).slice(-2),

        day = ("0" + date.getDate()).slice(-2);        

        return [ date.getFullYear(), mnth, day ].join("-");    

    }



    function target_date_format(target_date,time,minutes){

        var get_hours = target_date.setHours(target_date.getHours() + time);            

        var get_minutes = target_date.setMinutes(target_date.getMinutes() + minutes);                

        return new Date(get_minutes);

    }



    function get_date_difference(date1, date2){

        var start_date = convertToDate(date1);

        var target_date = convertToDate(date2);

        var date1 = new Date(start_date);

        var date2 = new Date(target_date);

        var diffTime = Math.abs(date2 - date1);

        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

    }



    // function get_target_date(){

    $('#get_target_date').click(function(){                        

        var startDate = $('#startDate').val();  



        var act_hours = Number(activity_time.substr(0,2));

        var act_minutes = Number(activity_time.substr(3,2));

        var total_act_hours = activity_days*24 + act_hours;        

        // console.log(total_act_hours);

        if(total_act_hours > 0 || act_minutes > 0){

            if(startDate != ''){

                $('#all_field_validation').html('');   



                var start_date_format = new Date(startDate);

                var start_date_format_new = new Date(startDate);

                                           

                //check if start date is holiday                

                var check_holiday_start_date = new Date(start_date_format.setDate(start_date_format.getDate()));                

                if(check_holiday_start_date.getDay() != 0 && check_holiday_start_date.getDay() != 6)                   

                { 

                    var get_formated_date;                   

                    var get_target_date = target_date_format(start_date_format, total_act_hours, act_minutes);

                    

                    // check if output target date is holiday

                    var check_holiday_target_date = new Date(get_target_date.setDate(get_target_date.getDate()));                

                    if(check_holiday_target_date.getDay() != 0 && check_holiday_target_date.getDay() != 6)                   

                    {

                        var if_holiday = 0;                                             

                        var total_days = get_date_difference(startDate, get_target_date);                         

                        var initial_start_date = start_date_format_new;



                        // check if in bteween start date & target date there id holiday

                        while(total_days > 0 ){                                                  

                            var get_target_date4 = target_date_format(initial_start_date, 24, 0);                                               

                            var check_holiday_target_date1 = new Date(get_target_date4.setDate(get_target_date4.getDate())); 

                            

                            if(check_holiday_target_date1.getDay() != 0 && check_holiday_target_date1.getDay() != 6){                                                                                           

                                if_holiday = 1;

                            }else{                                

                                if_holiday = 0; // yes                                  

                                break;

                            }

                            initial_start_date = get_target_date4;

                            total_days=total_days-1;

                        }

                        

                        if(if_holiday == 1){ //no in between holiday                                   

                            get_formated_date = convertToDateTime(get_target_date);   

                        }else{  // in between holiday                             

                            var get_target_date1 = target_date_format(get_target_date, 48, 0);

                            get_formated_date = convertToDateTime(get_target_date1);                                                         

                        }

                                            

                    }else{    

                        // postpond target date by 2 days if target date is holiday                  

                        $get_target_date_formatted = target_date_format(get_target_date, 48, 0);

                        get_formated_date = convertToDateTime($get_target_date_formatted);                                              

                    }

                    // console.log(get_formated_date);

                    var get_date1 =  get_formated_date.substr(0,10);

                    var get_formt_hours1 = get_formated_date.substr(11,2);

                    var get_formt_minutes1 = get_formated_date.substr(14,2);

                    var final_date1 = get_date1+' '+get_formt_hours1+':'+get_formt_minutes1;

                    $('#targetDate').val(final_date1);

                   

                }else{

                    $('#all_field_validation').html('Please select working day..'); 

                    $('#startDate').val(''); 

                    $('#targetDate').val('');      

                }     

               

            }else{

                $('#all_field_validation').html('Please Select Start Date first..');

                $('#targetDate').val(''); 

            }

        }else{

            $('#all_field_validation').html('Please Select Activity First..');

            $('#startDate').val(''); 

            $('#targetDate').val(''); 

        }                

    });
</script>