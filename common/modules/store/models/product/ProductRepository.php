<?php

namespace common\modules\store\models\product;

use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\modules\store\components\StoreUrlRule;
use yii\data\Sort;

class ProductRepository
{

    public $_model;

    /**
     * @param StoreUrlRule $url
     * @param Sort|null $sort
     * @return ActiveDataProvider
     */
    public function search(StoreUrlRule $url, Sort $sort = null)
    {
        $query = $this->_model->find()
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
     * @return mixed
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }
}

