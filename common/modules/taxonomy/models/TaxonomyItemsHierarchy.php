<?php
namespace common\modules\taxonomy\models;

use yii\base\Model;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class TaxonomyItemsHierarchy extends Model
{
    /**
     * @var int
     */
    public $weight;

    /**
     * @var int
     */
    public $vid;

    /**
     * @var int
     */
    public $pid;

    /**
     * @var TaxonomyItemsRepository
     */
    private $_itemsRepository;

    /**
     * TaxonomyItemsHierarchy constructor.
     * @param TaxonomyItemsRepository $itemsRepository
     */
    public function __construct(TaxonomyItemsRepository $itemsRepository)
    {
        $this->_itemsRepository = $itemsRepository;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid'], 'required'],
            [['vid', 'pid', 'weight'], 'integer']
        ];
    }

    /**
     * @return mixed
     */
    public function getTree()
    {
        $models = $this->_itemsRepository->getVocabularyTerms($this->vid);
        return TaxonomyHelper::tree($models, $this->pid);
    }

    /**
     * @return static
     */
    public function getParent()
    {
        return TaxonomyItems::findOne($this->pid);
    }

}
