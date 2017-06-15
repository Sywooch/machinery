<?php

namespace common\modules\taxonomy\models;

class TaxonomyVocabularyRepository
{
    /**
     * @return array
     */
    public function getVocabularies()
    {
        return TaxonomyVocabulary::find()
            ->all();
    }
}