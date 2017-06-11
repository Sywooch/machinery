<?php

namespace common\modules\store\widgets\Filter;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use common\modules\store\models\FilterModel;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use common\modules\taxonomy\models\TaxonomyVocabularyRepository;
use common\modules\store\models\product\ProductRepository;

class FilterWidget extends Widget
{
    const CACHE_TIME = 60 * 60 * 5;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var TaxonomyItemsRepository
     */
    protected $_taxonomyItemsRepository;

    /**
     * @var \common\modules\store\components\StoreUrlRule
     */
    public $url;

    /**
     * @var TaxonomyVocabularyRepository
     */
    private $_vocabularyRepository;

    /**
     * @var FilterModel
     */
    private $_model;

    public function __construct(ProductRepository $productRepository, TaxonomyItemsRepository $taxonomyItemsRepository, TaxonomyVocabularyRepository $vocabularyRepository, $config = array())
    {
        $this->_productRepository = $productRepository;
        $this->_taxonomyItemsRepository = $taxonomyItemsRepository;
        $this->_vocabularyRepository = $vocabularyRepository;
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('filter-widget', [
            'filterItems' => $this->getFilterItemsByTerm($this->url->category),
            'filterItemsCount' => [],
            'vocabularies' => $this->_vocabularyRepository->getVocabularies(),
            'model' => $this->_model,
            'url' => $this->url
        ]);
    }

    /**
     * @param TaxonomyItems $term
     * @return array
     */
    private function getFilterItemsByTerm(TaxonomyItems $term)
    {
        $filterTerms = Yii::$app->cache->get("filter:catalog:{$term->id}");
        if ($filterTerms === false) {

            $filterTermIds = $this->_productRepository->getCategoryTermIds($term);

            if (!$filterTermIds) {
                return [];
            }

            $terms = $this->_taxonomyItemsRepository->getByIds($filterTermIds, true);

            if (!$terms) {
                return [];
            }

            $terms = ArrayHelper::index($terms, 'id', 'vid');

            Yii::$app->cache->set("filter:catalog:{$term->id}", $terms, self::CACHE_TIME);
        }
        return $terms;
    }
}
