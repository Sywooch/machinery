<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductAV;
use backend\models\ProductSearch;
use yii\web\NotFoundHttpException;
use common\modules\orders\models\PromoCodes;
use backend\controllers\ProductDefaultController;

/**
 * ProductAVController implements the CRUD actions for ProductAV model.
 */
class ProductAvController extends ProductDefaultController
{

    /**
     * Lists all ProductAV models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch(new ProductAV());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('../product-default/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single ProductAV model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $promoCodes = new PromoCodes();
        return $this->render('../product-default/view', [
            'model' => $this->findModel($id),
            'promoCodes' => $promoCodes
        ]);
    }

    /**
     * Creates a new ProductAV model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new ProductAV();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('../product-default/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductAV model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
   

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
         //   print_r($model->getErrors()); exit('s');
            return $this->render('../product-default/update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Finds the ProductAV model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductAV the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductAV::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
