<?php

namespace backend\controllers;

use Yii;
use common\models\menu\Menu;
use common\models\menu\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
                        'actions' => ['index', 'update', 'view', 'create', 'delete'],
                        'roles' => ['admin'],
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

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->parent){          
                $root = Menu::findOne(['id' => $model->parent]);
                if($root){
                    $model->prependTo($root);
                }else{
                    exit('Parent not found');
                } 
            }else{
               $model->makeRoot();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            
            $roots = Menu::find()->roots()->all();
            
            $tree = [];
            foreach($roots as $root){
                $tree[$root->id] = str_repeat ( '-' , $root->depth ).' '.$root->name;
                $childs = $root->children()->all();
                foreach($childs as $child){
                    $tree[$child->id] = str_repeat ( '-' , $child->depth ).' '.$child->name;
                }
            }

            return $this->render('create', [
                'model' => $model,
                'tree' => $tree,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->parent){
                $root = Menu::findOne(['id' => $model->parent]);
                if($root){
                    $model->prependTo($root);
                }else{
                    exit('Parent not found');
                }
            }else{
                $model->save();
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            
            $roots = Menu::find()->roots()->all();
            
            $tree = [];
            foreach($roots as $root){
                $tree[$root->id] = str_repeat ( '-' , $root->depth ).' '.$root->name;
                $childs = $root->children()->all();
                foreach($childs as $child){
                    $tree[$child->id] = str_repeat ( '-' , $child->depth ).' '.$child->name;
                }
            }
            
            unset($tree[$model->id]);
            
            return $this->render('update', [
                'model' => $model,
                'tree' => $tree,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
