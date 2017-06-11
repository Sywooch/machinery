<?php

namespace common\modules\store\models\product;

use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\modules\store\components\StoreUrlRule;
use yii\data\Sort;
use common\modules\taxonomy\models\TaxonomyItems;

class ProductRepository
{

    /**
     * @param int $id
     * @return static
     */
    public function getById(int $id){
        return Product::findOne($id);
    }

    /**
     * @param StoreUrlRule $url
     * @param Sort|null $sort
     * @return ActiveDataProvider
     */
    public function search(StoreUrlRule $url, Sort $sort = null)
    {
        $query = Product::find()
            ->with([
                'terms',
                'files',
                'alias',
                'groupAlias',
                'wish',
                'compare'
            ])
            ->index(ArrayHelper::map($url->getTerms([$url->main]), 'id', 'id', 'vid'))
            ->orderBy($sort ? $sort->orders : null);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //  'pageSize' => $limit,
            ]
        ]);

        return $dataProvider;
    }

    /**
     * @param TaxonomyItems $term
     * @return array
     */
    public function getCategoryTermIds(TaxonomyItems $term)
    {
        return (new \yii\db\Query())
            ->select('id')
            ->from('(SELECT unnest(index) as id FROM ' . Product::tableName() . ' WHERE index && ARRAY[' . $term->id . ']) as t0')
            ->distinct()
            ->column();
    }

    /**
     * @param string $name
     * @param int|null $limit
     * @return mixed
     */
    public function findByName(string $name, int $limit = null)
    {
        return Product::find()
            ->where(['like', 'title', $name])
            ->limit($limit)
            ->all();
    }

}

