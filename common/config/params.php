<?php
return [
    'adminEmail' => 'na.al@gmail.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'order_statuses' => [
        'wait'   => 0,
        'active' => 1,
        'end'    => 2
    ],
    'ad_user_statuses' => [
        '0' => Yii::t('app', 'Delete'),
        '1' => Yii::t('app', 'Active'),
        '2' => Yii::t('app', 'Hidden'),
        '3' => Yii::t('app', 'Draft'),
    ],
];
