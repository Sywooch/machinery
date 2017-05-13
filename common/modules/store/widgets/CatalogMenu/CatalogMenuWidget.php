<?php
namespace common\modules\store\widgets\CatalogMenu;

use Yii;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class CatalogMenuWidget extends \yii\bootstrap\Widget
{
    const  MAX_ITEMS_IN_COLUMN = 20;

    /**
     * @var int
     */
    public $vocabularyId;

    /**
     * @var TaxonomyItemsRepository
     */
    private $_itemsRepository;

    /**
     * CatalogMenuWidget constructor.
     * @param TaxonomyItemsRepository $itemsRepository
     * @param array $config
     */
    public function __construct(TaxonomyItemsRepository $itemsRepository, $config = array())
    {
        $this->_itemsRepository = $itemsRepository;
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function run()
    {
        $items = $this->_itemsRepository->getVocabularyTerms($this->vocabularyId);

        return $this->render('catalog-menu-widget', [
            'menuItems' => TaxonomyHelper::tree($items),
        ]);
    }
}
