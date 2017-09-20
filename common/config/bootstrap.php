<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@files', dirname(dirname(__DIR__)) . '/files');
Yii::setAlias('@root', dirname(dirname(__DIR__)) . '');

function dd($var, $die=0){
    echo "<pre>", print_r($var, 1), "</pre>";
    if($die) die();
}