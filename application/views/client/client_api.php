
<!DOCTYPE html>
<html>
<head>
    <title>Clients</title>
</head>
<body>
<form action="<?php echo site_url('Client/save_selected_client'); ?>" method="post">
    <select name="client_id" id="client_id">
        <option value="">Select Client</option>
        <?php foreach ($clients as $client): ?>
            <option value="<?php echo $client['id']; ?>">
                <?php echo ($client['company_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Save Client</button>
</form>
</body>
</html>
