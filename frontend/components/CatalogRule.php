<?php

namespace frontend\components;

use common\modules\store\components\StoreUrlRules\CatalogUrlRule;
use common\modules\store\components\StoreUrlRules\FilterUrlRule;
use common\modules\store\components\StoreUrlRules\ProductUrlRule;
use common\modules\store\components\StoreUrlRules\SubcategoriesUrlRule;
use common\modules\store\services\StoreUrlService;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use yii;
use yii\web\UrlRuleInterface;

class CatalogRule implements UrlRuleInterface
{

    /**
     * @var TaxonomyItemsRepository
     */
    protected $taxonomyItemsRepository;

    /**
     * CatalogRule constructor.
     * @param TaxonomyItemsRepository $taxonomyItemsRepository
     */
    function __construct(TaxonomyItemsRepository $taxonomyItemsRepository)
    {
        $this->taxonomyItemsRepository = $taxonomyItemsRepository;
    }

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {

        $chanks = explode('/',$request->getPathInfo());

        if(empty($chanks)){
            return false;
        }

        $terms = $this->taxonomyItemsRepository->getByTransliterations($chanks, 2);

        if(count($chanks) != count($terms)){
            return false;
        }

        $current = array_pop($chanks);

        foreach ($terms as $term){
            if($term->transliteration == $current){
                return ['catalog/index',[
                    'FilterForm' => [
                        'category' => $term->id
                    ]
                ]];
            }
        }
        
      return false;

    }

}
