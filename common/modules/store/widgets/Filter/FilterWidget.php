<?php
namespace common\modules\store\widgets\Filter;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\store\models\FilterModel;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabularyRepository;

class FilterWidget extends \yii\bootstrap\Widget
{
    const CACHE_TIME = 60 * 60 * 5;

    /**
     * @var \common\modules\store\Finder
     */
    public $finder;

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

    public function __construct(TaxonomyVocabularyRepository $vocabularyRepository, $config = array())
    {
        $this->_vocabularyRepository = $vocabularyRepository;
        parent::__construct($config);
    }

    /**
     *
     */
    public function init()
    {
        if ($this->finder) {
            $this->_model = new FilterModel($this->finder);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->getFilterForm();
    }


    /**
     * @return string
     */
    private function getFilterForm()
    {

        $filterTerms = $this->getFilterTermsByTerm($this->url->category);
        if (empty($filterTerms)) {
            return;
        }

        return $this->render('filter-widget', [
            'filterItems' => ArrayHelper::index($filterTerms, 'id', 'vid'),
            'filterItemsCount' => [],
            'vocabularies' => $this->_vocabularyRepository->getVocabularies(),
            'model' => $this->_model,
            'url' => $this->url
        ]);
    }

    /**
     * @param TaxonomyItems $term
     * @return array|mixed|void
     */
    private function getFilterTermsByTerm(TaxonomyItems $term)
    {
        $filterTerms = Yii::$app->cache->get("filter:catalog:{$term->id}");
        if ($filterTerms === false) {

            $filterTermIds = $this->_model->getFilterTermIds($term);

            if (!$filterTermIds) {
                return;
            }

            $filterTerms = ArrayHelper::index(TaxonomyItems::findAll($filterTermIds), 'id');

            Yii::$app->cache->set("filter:catalog:{$term->id}", $filterTerms, self::CACHE_TIME);
        }
        return $filterTerms;
    }
}
