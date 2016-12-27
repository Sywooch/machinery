<?php

namespace common\modules\store\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\modules\store\models\order\Orders;
use common\modules\store\models\order\OrdersSearch;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class OrdersController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'delete'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['load'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['print'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => 'yii\web\ErrorAction',
            'load' => 
            [
                'class' => 'common\modules\orders\widgets\delivery\components\LoadAction',
                'order' => isset(Yii::$app->cart) ? Yii::$app->cart->getOrder() : null,
            ],
        ];
    }
    public function actionPrint($id)
    {
        exit('TODO');
    }
    
    public function actionIndex()
    {
        
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
 
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
