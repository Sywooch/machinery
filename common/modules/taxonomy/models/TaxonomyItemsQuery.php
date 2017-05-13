<?php
namespace common\modules\taxonomy\models;

use yii\db\ActiveQuery;

class TaxonomyItemsQuery extends ActiveQuery
{

    /**
     * @param int $vid
     * @return $this
     */
    public function vocabulary(int $vid)
    {
        return $this
            ->andWhere([
                'vid' => $vid
            ]);
    }

}
