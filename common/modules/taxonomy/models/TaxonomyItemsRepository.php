<?php

namespace common\modules\taxonomy\models;


class TaxonomyItemsRepository
{

    /**
     * @param int $id
     * @return TaxonomyItems
     */
    public function getById(int $id){
        return TaxonomyItems::findOne($id);
    }

    /**
     * @param array $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByIds(array $ids){
        return TaxonomyItems::find()->where([
            'id' => $ids
        ])->all();
    }

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

    /**
     * @param string $name
     * @param int|null $vocabularyId
     * @return null|\yii\db\ActiveRecord
     */
    public function getByTransliteration(string $name, int $vocabularyId = null)
    {
        return TaxonomyItems::find()
            ->where(['transliteration' => $name])
            ->andFilterWhere(['vid' => $vocabularyId])
            ->one();
    }
}