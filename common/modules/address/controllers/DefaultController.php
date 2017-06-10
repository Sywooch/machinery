<?php
namespace common\modules\address\controllers;

use yii;
use common\modules\address\models\Address;
use common\modules\address\services\geo\GeoCoderInterface;
use yii\web\Controller;
use yii\base\Module;
use common\modules\address\models\AddressRepository;
use yii\helpers\ArrayHelper;


/**
 * Site controller
 */
class DefaultController extends Controller
{
    /**
     * @var GeoCoderInterface
     */
    private $_geoCoder;

    /**
     * @var AddressRepository
     */
    private $_repository;

    public function __construct($id, Module $module, AddressRepository $repository, array $config = [])
    {
        $this->_geoCoder = new $module->geoCoder;
        $this->_repository = $repository;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['geo'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['geo'],
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @param string $address
     * @return mixed
     */
    public function actionGeo(string $address)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->_geoCoder->find($address);
    }

    /**
     * @param string $address
     * @return array
     */
    public function actionFind(string $address)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ArrayHelper::toArray($this->_repository->trigramSearch($address), [
            Address::class => [
                'id',
                'value' => 'address',
                'label' => 'address',
            ],
        ]);
    }

}
