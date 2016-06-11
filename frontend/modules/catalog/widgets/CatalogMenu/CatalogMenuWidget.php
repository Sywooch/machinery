<?php
namespace frontend\modules\catalog\widgets\CatalogMenu;

use Yii;
use common\modules\taxonomy\models\TaxonomyItemsSearch;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class CatalogMenuWidget extends \yii\bootstrap\Widget
{
    const  MAX_ITEMS_IN_COLUMN = 20;
    private $taxonomyItemsSearch;
    public $vocabularyId;
    public function __construct(TaxonomyItemsSearch $taxonomyItemsSearch, $config = array()) {
        parent::__construct($config);
        $this->taxonomyItemsSearch = $taxonomyItemsSearch;
    }
    
    public function run()
    {
        $items = $this->taxonomyItemsSearch->getItemsByVid($this->vocabularyId);
        return $this->render('catalog-menu-widget', [
                'menuItems' => TaxonomyHelper::tree($items),
        ]);
    }
}
