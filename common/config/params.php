<?php
return [
    'adminEmail' => 'revardy@gmail.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'catalog' => [
        'defaultPageSize' => 20,
        'vocabularyId' => 1,
        'vocabularyFields' => [
            'all' => 'terms',
            1 => 'catalog'
        ],
        'buyButtonText' => 'В корзину',
        'models' => [
            11 => \backend\models\ProductDefault::class,
            12 => \backend\models\ProductDefault::class
        ],
        'filterVocabularyIds' => [2,31,32,33,34]
    ],
];
