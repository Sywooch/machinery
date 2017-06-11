<?php

namespace common\modules\store\models\product;

use common\modules\file\Finder;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use yii\behaviors\TimestampBehavior;
use common\modules\import\models\Sources;
use common\modules\store\models\promo\PromoCodes;
use common\modules\store\models\promo\PromoProducts;
use common\modules\taxonomy\models\TaxonomyItems;
use common\models\Alias;
use common\modules\store\helpers\ProductHelper;
use common\modules\store\models\wish\Wishlist;
use common\modules\store\models\compare\Compares;

class Product extends ProductBase implements ProductInterface
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \common\modules\store\behaviors\ProductBehavior::class,
            ],
            [
                'class' => \common\modules\taxonomy\behaviors\TaxonomyBehavior::class,
            ],
            [
                'class' => \common\modules\file\components\FileBehavior::class,
            ],
            [
                'class' => \common\components\UrlBehavior::class,
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ]
            ]
        ];
    }

    /**
     * @return EntityQuery
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * @param Alias $alias
     * @return mixed
     */
    public function urlPattern(Alias $alias)
    {
        return ProductHelper::urlPattern($this, $alias);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Sources::className(), ['id' => 'source_id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromoCode()
    {
        return $this->hasOne(PromoCodes::className(), ['id' => 'code_id'])->viaTable(PromoProducts::tableName(), ['entity_id' => 'id'], function ($query) {
            $query->where(['model' => StringHelper::basename(self::class)]);
        });
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasOne(PromoProducts::className(), ['entity_id' => 'id'])->where(['model' => StringHelper::basename(self::class)]);
    }

    /**
     *
     * @return []
     */
    public function getFeature()
    {
        if (!$this->owner->features) {
            return [];
        }
        return json_decode($this->owner->features);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompare()
    {
        return $this->hasOne(Compares::className(), ['entity_id' => 'id'])->where([
            'model' => StringHelper::basename(get_class($this))
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWish()
    {
        return $this->hasOne(Wishlist::className(), ['entity_id' => 'id'])->where([
            'model' => StringHelper::basename(get_class($this))
        ]);
    }

    /**
     *
     * @return [] File
     */
    public function getFiles()
    {
        return Finder::getInstances($this);
    }

    /**
     *
     * @return string
     */
    public function getSpecification()
    {
        if ($this->short) {
            return $this->short;
        }
        $this->short = $this->helper->shortPattern($this);
        if ($this->short) {
            $this::updateAll(['short' => $this->short], ['id' => $this->id]);
        }
        return $this->short;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasMany(TaxonomyItems::className(), ['id' => 'index']);
    }


}

