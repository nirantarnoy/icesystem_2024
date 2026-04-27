<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=vorapat', 'root', '');
    $pdo->exec('ALTER TABLE asset_rental ADD COLUMN remark VARCHAR(255) NULL AFTER work_name');
    echo "Column added successfully";
} catch (Exception $e) {
    echo $e->getMessage();
}
