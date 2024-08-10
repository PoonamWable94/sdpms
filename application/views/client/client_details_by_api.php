
<!DOCTYPE html>
<html>
<head>
    <title>Clients</title>
</head>
<body>
    
<table border="1px">
    <tr>
         <th>ID</th>
         <th>Company Name</th>
         <th>Address</th>

    </tr>

   <?php  foreach($client as $clients){ 
   ?>
    <tr>
    <th><?php echo $clients['id']; ?></th>
    <th><?php echo $clients['company_name']; ?></th>
    <th><?php echo $clients['address']; ?></th>
    </tr>
  <?php }  ?>
    
</table>
</body>
</html>
