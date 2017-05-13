<?php

namespace common\modules\taxonomy\models;


class TaxonomyItemsRepository
{

    /**
     * @param int $vocabularyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getVocabularyTerms(int $vocabularyId)
    {
        return TaxonomyItems::find()
            ->where(['vid' => $vocabularyId])
            ->orderBy(['weight' => SORT_ASC])
            ->all();
    }


    /**
     * @param string $name
     * @param int|null $vocabularyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findByName(string $name, int $vocabularyId = null)
    {
        return TaxonomyItems::find()
            ->where(['like', 'name', $name])
            ->andFilterWhere(['vid' => $vocabularyId])
            ->all();
    }
}