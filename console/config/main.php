<?php

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'import' => [
            'class' => 'console\modules\import\Module',
        ],
    ], 
];


