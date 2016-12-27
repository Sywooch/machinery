<?php
namespace common\modules\store\widgets\Delivery;

use Yii;
use yii\base\InvalidParamException;
use common\modules\store\models\order\Orders;

class DeliveryFactory 
{
    private $_model;
    
    public function __construct($data) {

        if($data instanceof Orders && isset($data->data->delivery->model)){
            $this->_model = new $data->data->delivery->model();
            foreach($data->data->delivery->data as $key => $value){
              $this->_model->{$key} = $value;  
            }
            return;
        }elseif($data instanceof Orders){
            $model = '\\common\\modules\\store\\widgets\\delivery\\models\\DeliveryDefault';
            $this->_model = new $model();
            return;
        }elseif($data instanceof \stdClass){
            $this->_model = new $data->model();
            foreach($data->data as $key => $value){
              $this->_model->{$key} = $value;  
            }
            return;
        }elseif(is_string($data)){  
           foreach(Yii::$app->params['orders']['delivery'] as $item){
                if(strpos($item, $data) !== false){
                    $model = '\\common\\modules\\store\\widgets\\delivery\\models\\'.$item;
                    $this->_model = new $model();
                    return;
                }
            } 
        }
        
        throw new InvalidParamException('Invalid delivery type.');
         
    }
    
    public function load(array $data){
        return $this->_model->load($data);
    }
    
    public function validate(){
        return $this->_model->validate();
    }
    
    public function getErrors(){
        return $this->_model->getErrors();
    }
    
    public function getModel(){
        return $this->_model;
    }
    public function getData() {
        return [
            'model' => get_class($this->_model),
            'data' => $this->_model->attributes
        ];
    } 

}