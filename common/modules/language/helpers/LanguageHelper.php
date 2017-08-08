<?php

namespace common\modules\language\helpers;

use common\helpers\URLify;
use common\modules\language\models\Message;
use common\modules\language\models\SourceMessage;
use yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper as BaseFileHelper;
use common\modules\file\filestorage\InstanceInterface;
use Intervention\Image\ImageManager;
use yii\helpers\Html;

class LanguageHelper
{

    public static function createTranslateFields(SourceMessage $model, array $languages)
    {

        $messages = ArrayHelper::index($model->messages, 'language');
        $return = [];
        foreach ($languages as $language) {
            $translate = $messages[$language->local] ?? Yii::createObject([
                'class' => Message::class,
                    'id' => $model->id,
                    'language' => $language->local
                ]);

            $return[] =
                '<form class="translate" action="/language/message/update">'
                .   Html::activeHiddenInput($translate, 'id')
                .   Html::activeHiddenInput($translate, 'language')
                .   '<div class="translate-fields row">'
                .       '<div class="col-lg-3">' . Html::label($language->name) . '</div>'
                .       '<div class="col-lg-9">' . Html::activeTextInput($translate, 'translation') . '</div>'
                .   '</div>'
                . '</form>';
        }

        return implode('', $return);

    }

}
