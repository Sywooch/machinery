<?php

namespace common\modules\taxonomy;

use common\modules\taxonomy\models\TaxonomyItemsRepository;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class Taxonomy
{
    private $_itemsRepository;

    /**
     * Taxonomy constructor.
     * @param TaxonomyItemsRepository $itemsRepository
     */
    public function __construct(TaxonomyItemsRepository $itemsRepository)
    {
        $this->_itemsRepository = $itemsRepository;
    }

    /**
     * @return TaxonomyItemsRepository
     */
    public function getItemsRepository()
    {
        return $this->_itemsRepository;
    }


    /**
     * @param int $vocabularyId
     * @param array $data
     * @param int|null $parentId
     */
    public function orderVocabulary(int $vocabularyId, array $data, int $parentId = null)
    {
        $order = TaxonomyHelper::nes2Flat($data, $parentId);
        $models = $this->_itemsRepository->getVocabularyTerms($vocabularyId);

        foreach ($models as $model) {
            if (isset($order[$model->id]['pid']) && ($order[$model->id]['pid'] != $model->pid || $order[$model->id]['weight'] != $model->weight)) {
                $model->pid = $order[$model->id]['pid'];
                $model->weight = $order[$model->id]['weight'];
                $model->save();
            }
        }
    }


}