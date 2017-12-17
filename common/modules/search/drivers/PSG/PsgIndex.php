<?php

namespace common\modules\search\drivers\PSG;

use common\modules\search\DriverIndex;
use common\modules\search\drivers\PSG\helpers\PsgHelper;
use common\modules\search\drivers\PSG\models\SearchDataRepository;
use common\modules\search\drivers\PSG\models\SearchModels;
use common\modules\search\drivers\PSG\models\SearchWordsRepository;
use yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

class PsgIndex implements DriverIndex
{

    const INDEX_ITEMS_PER_RUN = 500;

    const INDEX_FIELDS = ['title'];

    /**
     * @var
     */
    public $module;

    /**
     * @var array
     */
    private $_modelId = [];

    /**
     * @var SearchDataRepository
     */
    protected $_dataRepository;

    /**
     * @var SearchWordsRepository
     */
    protected $_wordsRepository;

    /**
     * PsgIndex constructor.
     * @param SearchDataRepository $dataRepository
     * @param SearchWordsRepository $wordsRepository
     */
    function __construct(SearchDataRepository $dataRepository, SearchWordsRepository $wordsRepository)
    {
        $this->_dataRepository = $dataRepository;
        $this->_wordsRepository = $wordsRepository;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $modelsConfig = $this->module->models;

        foreach ($modelsConfig as $class => $config){
            $models = $this->_dataRepository->getUnIndexItems($class, ArrayHelper::getValue($config,'indexItems', self::INDEX_ITEMS_PER_RUN));
            foreach ($models as $model) {
                $this->add($model, ArrayHelper::getValue($config, 'indexFields', self::INDEX_FIELDS));
            }
        }
    }

    /**
     * @param ActiveRecord $entity
     * @param array $fields
     * @return ActiveRecord
     */
    public function add(ActiveRecord $entity, array $fields)
    {
        $searchData = PsgHelper::data($entity, $fields);
        $keyWords = PsgHelper::keywords($searchData);

        if(empty($keyWords)){
            return;
        }

        $this->_wordsRepository->add($keyWords);
        $this->_dataRepository->add($entity->id, $this->getModelId($entity), $searchData, $this->_wordsRepository->getIds($keyWords));
    }

    /**
     * @param ActiveRecord $entity
     * @return int
     */
    private function getModelId(ActiveRecord $entity)
    {
        $class = get_class($entity);

        if (isset($this->_modelId[$class])) {
            return $this->_modelId[$class];
        }
        $model = SearchModels::findOne(['model' => $class]);

        if (!$model) {
            $model = Yii::createObject([
                'class' => SearchModels::class,
                'model' => $class
            ]);
            $model->save();
        }

        return $this->_modelId[$class] = $model->id;
    }

}