<div id="page_content">

    <!-- <div id="page_heading" data-uk-sticky="{ top: 40, media: 960 }">
        <div class="heading_actions">
            <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New Equipment"><i class="md-icon material-icons md-color-green-400">&#xE146;</i></a>
            <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
            <a href="javascript:void(0)" onclick="reload_table()" data-uk-tooltip="{pos:'bottom'}" title="Reload"><i class="md-icon material-icons">&#xE5D5;</i></a>
        </div>
        <?php 
        $depts = $this->session->dept_name;
        ?>
        <h1>Activity List: <?= $depts?> Design</h1>
       
    </div> -->

    <div id="page_content_inner">
        
        <!-- DataTable -->
        <div class="md-card">
            <div class="md-card-toolbar md-bg-cyan-300" data-toolbar-progress="100">
                <h1 class="md-card-toolbar-heading-text">
                <a href="javascript:void(0);"  onclick="goBack()" title="Back" ><i class="md-icon material-icons md-color-white">keyboard_backspace</i></a> 
                    List of All Design Documents  
                    <a href="javascript:void(0)" onclick="add_data()" data-uk-tooltip="{pos:'bottom'}" title="Add New"><i class="md-icon material-icons md-color-white">&#xE146;</i></a>
                    <a href="javascript:void(0)" onclick="bulk_delete()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Delete"><i class="md-icon material-icons md-color-red-500">delete</i></a>
                    <a href="javascript:void(0)" onclick="download_selected()()" data-uk-tooltip="{pos:'bottom'}" title="Multiple Download"><i class="material-icons" style="color:white">file_download</i></a>
                </h1>
            </div>

            <div class="md-card-content">
                <!-- <div class="dt_colVis_buttons"></div> -->
                <table id="dt_mytable" class="uk-table uk-table-striped uk-table-hover uk-table-condensed">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="check-all"></th>
                            <th>Sr.No</th> 
                            <th>Documents</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

        <!-- POPUP Form -->
        <div class="uk-modal" id="modal_default">
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>

                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Add New Document</h3>
                </div>
                
                <form action="#" id="form" class="uk-margin-top" enctype='multipart/form-data'>
                    
                        <div class="uk-grid">
                            <input type="hidden" value="" name="id"/>
                            <input type="hidden" name="old_doc" id="old_doc"> 
                        <div class="uk-width-1-1">
                            <div class="input-box">
                                           <label for="document">Document : <span class="req">*</span></label> <br><br>
                                           <input type="file" name="document" id="document" class="form-control" required accept=".csv,.xls,.pdf,.xlsx">
                                           <p id="document_file_name"></p> <!-- Display the existing file name here -->
                                           <span id="errortag" class="uk-text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                    <button class="md-btn md-btn-flat md-btn-flat-primary" id="btnSave" onclick="save()" type="button">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url();?>';
    
    $(document).ready(function() {
    
        table = $('#dt_mytable').DataTable({ 
    
            "processing": true, 
            "serverSide": true,
            "order": [],
            "pageLength": 100,  
    
            "ajax": {
                "url": "<?php echo site_url('design_doc/ajax_list')?>",
                "type": "POST"
            },
    
            "columnDefs": [
                { 
                    "targets": [ -1, -2, 0, 1 ], 
                    "orderable": false,
                }
            ],
            // "dom": "<'uk-grid'<'uk-width-medium-1-1'tr>>" +
            //         "<'uk-grid'<'uk-width-small-1-4'f><'uk-width-small-1-4 text-center'l><'uk-width-small-1-4 uk-margin-small-top'i><'uk-width-small-1-4'p>>",
        });
    });

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    // Change the Status...
    $(document).on('click','.status_checks',function()
    {
        var status=($(this).hasClass("md-btn-success")) ? '0' : '1';
        var msg=(status=='0')? 'Inactive' : 'Active';

        if(confirm("Are you sure to "+ msg))
        {
            var current_element=$(this);
            var id = $(current_element).attr('data');
            var myurl="<?php echo base_url()."design_doc/update_status"?>";

            $.ajax({
                type:"POST",
                url:myurl,
                data:{"id":id,"status":status},
                success:function(data)
                {   
                    reload_table()
                }
            });
        }      
    });
    
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

    function add_data()
    {
        save_method = 'add';

        $('#form')[0].reset(); // reset form on modals
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string

        $("#btnSave").show();
        
        
        UIkit.modal($('.uk-modal'), {bgclose: false}).show();
    }
    
    function edit_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $("#btnSave").show();

        $('.parsley-row').removeClass('parsley-required'); // clear error class
        $('.md-input').removeClass('md-input-danger'); // clear error class
        $('.parsley-required').empty(); // clear error string

        
    
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('design_doc/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="old_doc"]').val(data.document);

                $('#document_file_name').text(data.document ? data.document : 'No file chosen');
              // $('[name="document"]').val(data.document);
               UIkit.modal($('.uk-modal'), {bgclose: false}).show();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    function save()
    {

        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('design_doc/ajax_add')?>";
        } else {
            url = "<?php echo site_url('design_doc/ajax_update')?>";
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data)
            {
    
                if(data.status) //if success close modal and reload ajax table
                {
                    UIkit.modal($('.uk-modal')).hide();
                    reload_table();

                    UIkit.notify({
                        message : 'Record saved!',
                        status  : 'success',
                        timeout : 5000,
                        pos     : 'bottom-center'
                    })
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        if(data.status == false)
                        {
                            $('[name="'+data.inputerror[i]+'"]').next().addClass('parsley-required'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').addClass('md-input-danger');
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });

    }

    function view_data(id)
    {
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('parsley-required'); // clear error class
        $('.parsley-required').empty(); // clear error string
        $('.md-input').removeClass('md-input-danger'); // clear error class

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('design_doc/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data.dept_name);
                $('[name="id"]').val(data.id);
                $('[name="document"]').val(data.document);
                // Disable text box...
                $('[name="document"]').attr("disabled", "disabled");
                $("#btnSave").hide();
                UIkit.modal($('.uk-modal')).show();

            },

            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function delete_data(id)
    {
        UIkit.modal.confirm('Are you sure delete?', function(){ 
            $.ajax({
                url : "<?php echo site_url('design_doc/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
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
            // if(confirm('Are you sure delete this '+list_id.length+' data?'))
            // {
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('design_doc/ajax_bulk_delete')?>",
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

//     function download_selected() {
//     var selected = [];
//     $('.data-check:checked').each(function() {
//         selected.push($(this).val());
//     });

//     if (selected.length === 0) {
//         alert('No documents selected.');
//         return;
//     }

//     // Open a new tab for each selected document to trigger the download
//     selected.forEach(function(id) {
//         var downloadUrl = "<?php echo site_url('design_doc/download_document'); ?>/" + id;
//         window.open(downloadUrl, '_blank');
//     });
// }

function download_selected() {
    // Get selected IDs from checkboxes
    var selected = [];
    $('.data-check:checked').each(function() {
        selected.push($(this).val());
    });

    if (selected.length === 0) {
        alert('No documents selected.');
        return;
    }

    // Send request to download the selected documents
    $.ajax({
        url: "<?php echo site_url('design_doc/download_multiple'); ?>",
        type: "POST",
        data: { ids: selected },
        xhrFields: {
            responseType: 'blob' // Ensure the response is handled as a binary blob
        },
        success: function(response) {
            // Create a URL for the downloaded file and trigger the download
            var url = window.URL.createObjectURL(response);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Design_documents.zip'; // Name of the ZIP file
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error downloading documents.');
        }
    });
}


</script>
<script>
        function goBack() {
            window.history.back();
        }
</script>