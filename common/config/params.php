<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'catalog' => [
        'defaultPageSize' => 20,
        'vocabularyId' => 7,
        'buyButtonText' => 'Купить',
        'models' => [
            11 => \backend\models\ProductPhone::class,
            12 => \backend\models\ProductPhone::class
        ]
    ],
];
