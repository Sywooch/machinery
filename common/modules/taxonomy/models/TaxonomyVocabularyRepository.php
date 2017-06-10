<?php

namespace common\modules\taxonomy\models;


class TaxonomyVocabularyRepository
{
    /**
     * @param array $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByIds(array $ids){
        return TaxonomyVocabulary::find()->where([
            'id' => $ids
        ])->all();
    }
}
