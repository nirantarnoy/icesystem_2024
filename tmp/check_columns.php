<?php
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
$config = require(__DIR__ . '/../common/config/main.php');
if (file_exists(__DIR__ . '/../common/config/main-local.php')) {
    $config_local = require(__DIR__ . '/../common/config/main-local.php');
    $config = \yii\helpers\ArrayHelper::merge($config, $config_local);
}

$config['id'] = 'test-app';
$config['basePath'] = dirname(__DIR__);

new yii\console\Application($config);

$schema = Yii::$app->db->getTableSchema('transaction_car_sale');
if ($schema) {
    echo "Columns in transaction_car_sale:\n";
    foreach ($schema->columns as $column) {
        echo "- " . $column->name . " (" . $column->type . ")\n";
    }
} else {
    echo "Table not found.\n";
}
?>
