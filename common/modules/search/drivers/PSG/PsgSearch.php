<?php

namespace common\modules\search\drivers\PSG;

use common\modules\search\DriverIndex;
use common\modules\search\drivers\PSG\helpers\PsgHelper;
use common\modules\search\drivers\PSG\models\SearchDataRepository;
use common\modules\search\drivers\PSG\models\SearchWordsRepository;
use common\modules\search\DriverSearch;
use common\modules\search\drivers\PSG\data\SearchDataProvider;
use yii;

class PsgSearch implements DriverSearch
{

    /**
     * @var
     */
    public $module;

    /**
     * @var float
     */
    public $similarity = 0.3;

    /**
     * @var PsgIndex
     */
    protected $index;

    /**
     * @var SearchDataRepository
     */
    protected $_dataRepository;

    /**
     * @var SearchWordsRepository
     */
    protected $_wordsRepository;

    /**
     * PsgSearch constructor.
     * @param SearchDataRepository $dataRepository
     * @param SearchWordsRepository $wordsRepository
     */
    function __construct(SearchDataRepository $dataRepository, SearchWordsRepository $wordsRepository)
    {

        $this->_wordsRepository = $wordsRepository;
        $this->_dataRepository = $dataRepository;
    }

    /**
     * @return DriverIndex
     */
    public function getIndex(): DriverIndex
    {
        if (!$this->index) {
            $this->index = Yii::$container->get(PsgIndex::class,[],['module' => $this->module]);
        }

        return $this->index;
    }

    /**
     * @param string $string
     * @return SearchDataProvider
     */
    public function search(string $string)
    {

        Yii::$app->db->createCommand('select set_limit(' . $this->similarity . ')')->execute();
        $wordIds = $this->_wordsRepository->search(PsgHelper::keywords(PsgHelper::searchStringProcess($string)));

        $dataProvider = new SearchDataProvider([
            'query' => $this->_dataRepository->search(PsgHelper::searchStringProcess($string), $wordIds),
            'config' => $this->module->models
        ]);

        return $dataProvider;
    }

    /**
     * @return SearchWordsRepository
     */
    public function getWordsRepository(): SearchWordsRepository
    {
        return $this->_wordsRepository;
    }

    /**
     * @return SearchDataRepository
     */
    public function getDataRepository(): SearchDataRepository
    {
        return $this->_dataRepository;
    }
}