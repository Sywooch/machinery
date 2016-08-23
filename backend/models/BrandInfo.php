<?php

namespace backend\models;

use Yii;
use common\modules\taxonomy\components\TermValidator;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyIndex;
use common\helpers\ModelHelper;
/**
 * This is the model class for table "brand_info".
 *
 * @property integer $id
 * @property string $description
 */
class BrandInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string'],
            [['brand'], TermValidator::class],
            [['photo'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                ],
                [
                    'class' => \common\modules\file\components\FileBehavior::class,
                ]
            ];
    }
    
    public function findByTerm(TaxonomyItems $term = null){
        if(!$term){
            return;
        }

        return self::find()
                ->innerJoin(TaxonomyIndex::tableName().' t','t.entity_id = '.self::tableName().'.id')
                ->where([
                    't.term_id' => $term->id,
                    't.model' => ModelHelper::getModelName(self::class)
                ])
                ->one();
    }
}
