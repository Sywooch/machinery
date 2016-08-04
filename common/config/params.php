<?php
return [
    'adminEmail' => 'revardy@gmail.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'catalog' => [
        'defaultPageSize' => 20,
        'vocabularyId' => 7,
        'vocabularyFields' => [
            'all' => 'terms',
            7 => 'catalog'
        ],
        'buyButtonText' => 'Купить',
        'models' => [
            11 => \backend\models\ProductDefault::class,
            12 => \backend\models\ProductDefault::class
        ]
    ],
];
