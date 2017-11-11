<?php

namespace common\models;

use common\modules\taxonomy\models\TaxonomyIndex;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;
use frontend\models\FilterForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

class AdvertRepository
{

    /**
     * @param ActiveQuery $query
     * @return array
     */
    public function getSubCategories(ActiveQuery $query){

        return (new \yii\db\Query())
            ->select([
                'term_id',
                new Expression('COUNT(entity_id)').' as c',
            ])
            ->from(TaxonomyIndex::tableName())
            ->indexBy('term_id')
            ->where('entity_id IN ('.$query->select(Advert::tableName().'.id')->createCommand()->rawSql.')')
            ->groupBy('term_id')
            ->all();
    }

    /**
     * @param FilterForm $filter
     * @return AdvertQuery
     */
    public function searchQueryByFilter(FilterForm $filter){


        return Advert::find()
            ->category($filter)
            ->manufacturer($filter)
            ->model($filter)
            ->id($filter)
            ->country($filter)
            ->price($filter)
            ->search($filter);
    }

    /**
     * @param ActiveQuery $query
     * @param Sort $sort
     * @return ActiveDataProvider
     */
    public function searchByFilter(ActiveQuery $query, Sort $sort){

        $query->orderBy($sort ? $sort->orders : null);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                 'pageSize' => 1,
            ]
        ]);

        return $dataProvider;
    }

    /**
     * @return mixed
     */
    public function getMinPrice(){
        return Advert::find()->where(['status'=>1])->min('price');
    }

    /**
     * @return mixed
     */
    public function getMaxPrice(){
        return Advert::find()->where(['status'=>1])->max('price');
    }

}
