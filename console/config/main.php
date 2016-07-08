<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => ['log'], 
    'params' => $params,
];


