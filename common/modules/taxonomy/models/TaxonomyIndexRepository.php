<?php

namespace common\modules\taxonomy\models;

use yii\base\Model;
use yii\helpers\StringHelper;

class TaxonomyIndexRepository
{

    /**
     * @var array TaxonomyItems
     */
    private $_terms = [];
    /**
     * @param string $attribute
     * @param TaxonomyItems $term
     */
    public function addTerm(string $attribute, TaxonomyItems $term)
    {
        $this->_terms[$attribute] = $term;
    }

    /**
     * @param Model $entity
     * @param string $attribute
     * @param array $terms
     */
    public function link(Model $entity, string $attribute, array $terms = [])
    {

        $this->clear($entity, $attribute);
        foreach ($terms as $term) {
            \Yii::createObject([
                'class' => TaxonomyIndex::class,
                'term_id' => $term->id,
                'entity_id' => $entity->id,
                'field' => $attribute,
                'model' => StringHelper::basename(get_class($entity))
            ])->save();
        }
    }

    /**
     * @param Model $entity
     * @param string $attribute
     */
    public function clear(Model $entity, string $attribute)
    {
        TaxonomyIndex::deleteAll([
            'entity_id' => $entity->id,
            'model' => StringHelper::basename(get_class($entity)),
            'field' => $attribute
        ]);
    }
}