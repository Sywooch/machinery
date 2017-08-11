<?php

namespace backend\models;

use common\helpers\ModelHelper;
use common\helpers\URLify;
use common\models\Alias;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;

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
            [['test', 'test2'], TaxonomyAttributeValidator::class, 'type' => 'integer'],
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
                'class' => \common\modules\taxonomy\behaviors\TaxonomyBehavior::class,
            ],
            [
                'class' => \common\components\UrlBehavior::class,
            ]
        ];
    }

    public function urlPattern($model, Alias $alias)
    {
        $alias->url = 'pages/view';
        $alias->alias = URLify::url($model->title);
        return $alias;
    }
}
