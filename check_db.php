<?php
$pdo = new PDO('mysql:host=localhost;dbname=vorapat', 'root', '');
$stmt = $pdo->query('DESCRIBE asset_rental');
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo $row['Field'] . "\n";
}
