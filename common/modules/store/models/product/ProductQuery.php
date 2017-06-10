<?php

namespace common\modules\store\models\product;

use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    /**
     * @param array $index
     * @return $this
     */
    public function index(array $index){
        foreach($index as $values){
            $this->andWhere(['&&', 'index', new Expression('ARRAY['.implode(',', $values).']')]);
        }
        return $this;
    }
}

