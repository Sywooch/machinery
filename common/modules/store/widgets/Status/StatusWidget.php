<?php

namespace common\modules\store\widgets\Status;

use Yii;
use yii\base\InvalidParamException;
use common\modules\store\models\status\Status;
use common\modules\store\models\status\StatusRepository;
use yii\helpers\StringHelper;
use common\modules\store\models\order\Orders;

class StatusWidget extends \yii\bootstrap\Widget {

    public $model;
    private $statusRepository;
    private $_statuses = [];

    public function __construct(StatusRepository $statusRepository, $config = array()) {
        $this->statusRepository = $statusRepository;
        parent::__construct($config);
    }

    public function init() {
        parent::init();

       
        
        if ($this->model == []) {
            throw new InvalidParamException('Invalid param property: model');
        }
        
        if (!isset($this->model->statuses) && $this->model->statuses == []) {
            throw new InvalidParamException('Invalid param property: statuses');
        }

        $this->_statuses = $this->model->statuses;
    }

    /**
     * 
     * @return []
     */
    public function getStatuses() {
        return $this->_statuses;
    }

    public function run() {

        $statusModel = Yii::createObject([
            'class' => Status::class,
            'entity_id' => $this->model->id,
            'model' => StringHelper:: basename(get_class($this->model))
        ]);
        
        if ($statusModel->load(Yii::$app->request->post()) && $statusModel->validate()) {
            
            $_status = $this->statusRepository->getLastStatus($statusModel->entity_id, $statusModel->model);
            if ($_status){
                $statusModel->from = $_status->to;
            }  
            $this->model->status = $statusModel->to;
            $statusModel->save();
            Orders::updateAll(['status' => $statusModel->to], ['=', 'id', $this->model->id]);
        }

        $statusModels = Status::find()->where([
                    'entity_id' => $this->model->id,
                    'model' => StringHelper:: basename(get_class($this->model))
                ])
                ->with(['user'])
                ->all();

        return $this->render('statuses', [
                    'statuses' => $this->statuses,
                    'models' => $statusModels,
                    'statusModel' => $statusModel
        ]);
    }

}
