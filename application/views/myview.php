<!DOCTYPE html>
<html>
<head>
    <title>Codeigniter Dependent Dropdown Example with demo</title>
    <script src="<?=base_url();?>assets/jquery.js"></script>
    <!-- <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css"> -->
</head>


<body>
<div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Select State and get bellow Related City</div>
      <div class="panel-body">


            <div class="form-group">
                <label for="title">Select Unit:</label>
                <select name="unit" class="form-control" style="width:350px">
                    <option value="">--- Select Unit ---</option>
                    <?php
                        foreach ($units as $key => $value) {
                            echo "<option value='".$value->uid."'>".$value->unit."</option>";
                        }
                    ?>
                </select>
            </div>

<br>
            <div class="form-group">
                <label for="title">Select Type:</label>
                <select name="utype" class="form-control" style="width:350px">
                </select>
            </div>


      </div>
    </div>
</div>


<script type="text/javascript">


    $(document).ready(function() {
        $('select[name="unit"]').on('change', function() {
            var unitId = $(this).val();
            if(unitId) {
                $.ajax({                    
                    url:'<?=base_url()?>indexdd/myformAjax',
                    type: "POST",
                    dataType: "json",
                    data: {unitId: unitId},
                    success:function(data) {
                        $('select[name="utype"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="utype"]').append('<option value="'+ value.tid +'">'+ value.visit +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="utype"]').empty();
            }
        });
    });
</script>


</body>
</html>