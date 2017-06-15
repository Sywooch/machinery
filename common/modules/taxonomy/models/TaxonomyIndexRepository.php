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
     * @throws \yii\base\InvalidConfigException
     */
    public function link(Model $entity)
    {

        foreach ($this->_terms as $attribute => $terms) {

            TaxonomyIndex::deleteAll([
                'entity_id' => $entity->id,
                'model' => StringHelper::basename(get_class($entity)),
                'field' => $attribute
            ]);

            foreach ($terms as $term) {
                \Yii::createObject([
                    'class' => TaxonomyIndex::class,
                    'term_id' => $term->id,
                    'entity_id' => $entity->id,
                    'field' => $attribute,
                    'model' => StringHelper::basename(get_class($entity))
                ])->save();
            }
            $this->_terms[$attribute] = [];
        }
    }
}