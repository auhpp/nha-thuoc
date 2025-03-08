<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedicineSearch</title>
</head>
<body>
    <?php foreach ($medicines as $medicien): ?>
        <h3><?= htmlspecialchars($medicien->medicineName)?></h3>
    <?php endforeach ?>
</body>
</html>

