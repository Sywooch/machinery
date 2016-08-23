<?php

namespace backend\models;

use Yii;
use common\helpers\URLify;
use common\models\Alias;
use common\helpers\ModelHelper;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => \common\components\UrlBehavior::class,
                ]
            ];
    }
    
    public function urlPattern($model, Alias $alias){
        $alias->url = 'pages/view';
        $alias->alias =  URLify::url($model->title);
        return $alias;
    }
}
