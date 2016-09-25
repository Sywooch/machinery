<?php

namespace backend\models;

use Yii;
use common\helpers\ModelHelper;

/**
 * This is the model class for table "ads_actions".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 */
class AdsActions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'from', 'to'], 'required'],
            [['from', 'to'], 'safe'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 1],
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
                    'class' => \common\modules\file\components\FileBehavior::class,
                ],
                [
                    'class' => \common\components\UrlBehavior::class,
                ]
            ];
    }
    
    /**
     * 
     * @param \common\models\Alias $alias
     * @return \common\models\Alias
     */
    public function urlPattern(\common\models\Alias $alias){
        $alias->alias = 'actions/'.  \common\helpers\URLify::url($this->title);       
        $alias->url = 'actions/default' . '?id=' . $this->id . '&model='. ModelHelper::getModelName($this);
        return $alias;
    }
}
