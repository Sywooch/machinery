<?php
namespace common\modules\favorites\controllers;

use yii;
use common\modules\favorites\Favorite;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\base\Module;
use common\modules\address\models\AddressRepository;


/**
 * Site controller
 */
class DefaultController extends Controller
{

    /**
     * @var AddressRepository
     */
    private $_favorite;

    public function __construct($id, Module $module, Favorite $favorite, array $config = [])
    {
        $this->_favorite = $favorite;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'touch' => ['POST'],
                    'touch-category' => ['POST']
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actionTouch()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!Yii::$app->user->id) {
            return ['status' => 'error', 'type' => 'auth'];
        }

        $entityId = Yii::$app->request->post('entityId');
        $entity = Yii::$app->request->post('entity');

        $id = $this->_favorite->touch($entityId, $entity);

        if ($id) {
            return [
                'status' => 'success',
                'type' => $id === true ? 'remove' : 'add',
                'id' => $id,
                'entityId' => $entityId,
                'count' => $this->_favorite->getRepository()->count(Yii::$app->user->id) 
            ];
        }

        return ['status' => 'error'];
    }

    /**
     * @return array
     */
    public function actionTouchCategory()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $favoriteId = Yii::$app->request->post('favoriteId');
        $categoryId = Yii::$app->request->post('categoryId');

        $id = $this->_favorite->touchCategory($favoriteId, $categoryId);

        return [
            'status' => 'success',
            'type' => $id === true ? 'remove' : 'add',
            'id' => $favoriteId,
            'category' => $categoryId,
        ];
    }


}
