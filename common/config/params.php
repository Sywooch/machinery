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
            11 => \common\modules\store\models\ProductDefault::class,
            12 => \common\modules\store\models\ProductPC::class,
            3784 => \common\modules\store\models\ProductAV::class,
            3887 => \common\modules\store\models\ProductBitovaya::class,
            3888 => \common\modules\store\models\ProductBuilding::class,
            3889 => \common\modules\store\models\ProductSport::class,
            5408 => \common\modules\store\models\ProductHardware::class,
            3891 => \common\modules\store\models\ProductAccessories::class,
            3892 => \common\modules\store\models\ProductAuto::class
        ],
        'filterVocabularyIds' => [
            2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,
            51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67
        ]
    ],
];
