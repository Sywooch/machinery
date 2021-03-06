<?php

namespace common\modules\taxonomy\models;


class TaxonomyItemsRepository
{

    /**
     * @param int $id
     * @return TaxonomyItems
     */
    public function getById(int $id)
    {
        return TaxonomyItems::findOne($id);
    }

    /**
     * @param array $ids
     * @param bool $asArray
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByIds(array $ids, bool $asArray = false)
    {
        $query = TaxonomyItems::find()->where([
            'id' => $ids
        ]);
        if ($asArray) {
            $query->asArray();
        }
        return $query->all();
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
     * @param int $vocabularyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getVocabularyTopTerms(int $vocabularyId)
    {
        return TaxonomyItems::find()
            ->where(['vid' => $vocabularyId])
            ->andWhere(['pid'=>0])
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


    /**
     * @param array $transliterations
     * @param int|null $vocabularyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByTransliterations(array $transliterations, int $vocabularyId = null)
    {
        return TaxonomyItems::find()
            ->where(['transliteration' => $transliterations])
            ->andFilterWhere(['vid' => $vocabularyId])
            ->all();
    }
}