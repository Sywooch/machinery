<?php
namespace common\modules\file\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\modules\file\helpers\FileHelper;
use common\modules\file\models\File;
use yii\web\UploadedFile;
use common\helpers\ModelHelper;
use common\modules\file\models\FileValidator;
use yii\web\NotFoundHttpException;


/**
 * Site controller
 */
class ManageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['image'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
    
    /**
     * 
     * @param int $id
     * @param string $field
     * @param string $token
     * @return string
     */
    public function actionUpload($id = null, $field, $token)
    { 
        
        $modelName = '\\backend\\models\\'.key($_FILES);
        $entityModel = $id ? $modelName::findOne($id) : new $modelName();
        $fields = FileHelper::getFileFields($entityModel);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!key_exists($field, $fields)){
            return ['success' => false, 'error'=>'[230] Ошибка загрузки.'];
        }
        $filesInstances = UploadedFile::getInstances($entityModel, $field);
        $filesValidator = \Yii::createObject([
            'class' => FileValidator::class,
            'files' => (isset($fields[$field]['maxFiles']) && $fields[$field]['maxFiles'] == 1) ? array_shift($filesInstances) : $filesInstances,
            'rule' => $fields[$field]
        ]);
        
        if (!$filesValidator->validate()) {
                $errors = $filesValidator->getErrors();
                return ['success' => false, 'error'=>'[932] Ошибка загрузки.', 'info' => $errors['files']];
        }

        $path = FileHelper::createDirectory($entityModel);
        if(!$entityModel->id){
            $path = FileHelper::createTempDirectory($token, $field);
        }
        
        $filesInstances = is_array($filesValidator->files) ? $filesValidator->files : [$filesValidator->files];
        foreach($filesInstances as $file){
            if($file->saveAs($path . '/' . FileHelper::text2url($file->name))){
                if($entityModel->id){
                    $fileModel = \Yii::createObject([
                        'class' => File::class,
                        'entity_id' => $entityModel->id,
                        'field' => $field,
                        'model' => ModelHelper::getModelName($entityModel),
                        'name' => FileHelper::text2url($file->name),
                        'path' => FileHelper::getUrl($entityModel),
                        'mimetype' => $file->type,
                        'size' => $file->size
                     ]);
                    $fileModel->save();
                    return [
                        'initialPreview' => FileHelper::getFileInputPreviews([$fileModel]),
                        'initialPreviewConfig' => FileHelper::getFileInputPreviewsConfig([$fileModel])
                    ];
                }
            }
        }
        return ['success' => true];
    }
    
    /**
     * 
     * @param int $id
     * @param string $token
     * @return string
     */
    public function actionDelete($id, $token)
    { 
        $file = File::findOne($id);
        if(!$file || $token != FileHelper::getToken($file)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if(is_file(Yii::$app->basePath . '/../' . $file->path . '/' . $file->name)){
            unlink(Yii::$app->basePath . '/../' . $file->path . '/' . $file->name);
        }
        $file->delete();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['success' => true];
    }

}
