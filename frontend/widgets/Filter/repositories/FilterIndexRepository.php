<?php

namespace frontend\widgets\Filter\repositories;

use common\modules\taxonomy\models\TaxonomyIndex;
use common\modules\taxonomy\models\TaxonomyIndexRepository as TaxonomyIndexRepositoryBase;
use yii\db\Query;

class FilterIndexRepository extends TaxonomyIndexRepositoryBase
{

    /**
     * @param Query $query2
     * @return array
     */
    public function findAll(Query $query2)
    {

        $query2->select(['advert.id']);

        $query = (new Query())
            ->select(['COUNT(i.term_id)', 'i.term_id', 'i.field'])
            ->from(TaxonomyIndex::tableName() . ' i');
        $query->andWhere([
            'i.entity_id' => $query2,
        ]);

        $query->indexBy('term_id')->groupBy(['i.term_id','i.field']);

        return $query->all();

    }




}