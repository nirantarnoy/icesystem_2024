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

$data = (new \yii\db\Query())
    ->from('sale_daily_close')
    ->limit(5)
    ->orderBy(['id' => SORT_DESC])
    ->all();

echo json_encode($data, JSON_PRETTY_PRINT);
?>
