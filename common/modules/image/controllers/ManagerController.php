<?php

namespace common\modules\image\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\modules\file\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use common\modules\file\filestorage\Instance;
use common\modules\image\models\File;

/**
 * Default controller for the `image` module
 */
class ManagerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['upload', 'delete'],
                'rules' => [
                    [
                        'actions' => ['upload', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpload()
    {
//        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//        header("Cache-Control: no-store, no-cache, must-revalidate");
//        header("Cache-Control: post-check=0, pre-check=0", false);
//        header("Pragma: no-cache");
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($post = Yii::$app->request->post()) {

//            $targetDir = Yii::getAlias('@files/' . strtolower($post['entity']) . '/' . $post['field']);
            $targetDir = Yii::getAlias('@' . $post['upload_dir']);
            $cleanupTargetDir = true; // Remove old files
            $maxFileAge = 5 * 3600; // Temp file age in seconds

            if (!file_exists($targetDir)) {
                @mkdir($targetDir);
            }

            // Get a file name
            if (isset($post["name"])) {
                $fileName = $post["name"];
            } elseif (!empty($_FILES)) {
                $fileName = $_FILES["files"]["name"];
            } else {
                $fileName = uniqid("file_");
            }


            $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

            // Chunking might be enabled
            $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
            $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

            // Remove old temp files
            if ($cleanupTargetDir) {
                if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
                }

                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                    // If temp file is current file proceed to the next
                    if ($tmpfilePath == "{$filePath}.part") {
                        continue;
                    }

                    // Remove temp file if it is older than the max age and is not the current file
                    if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            }

            // Open temp file
            if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if (!empty($_FILES)) {
                if ($_FILES["files"]["error"] || !is_uploaded_file($_FILES["files"]["tmp_name"])) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
                }

                // Read binary input stream and append it to temp file
                if (!$in = @fopen($_FILES["files"]["tmp_name"], "rb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            } else {
                if (!$in = @fopen("php://input", "rb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($out);
            @fclose($in);

            // Check if file has been uploaded
            if (!$chunks || $chunk == $chunks - 1) {
                // Strip the temp .part suffix off
                rename("{$filePath}.part", $filePath);
            }
            // Return Success JSON-RPC response
//            dd($_REQUEST);
//            echo mime_content_type($filePath);
//            dd(stat($filePath),1);
            $fileStat = stat($filePath);
            $out = [
                "jsonrpc" => "2.0",
                "result" => ["filename"=>  $fileName , "id" => 0],
                "filename" => $fileName
            ];
            if($post['model_action'] == 'edit'){
                $model_file = new File();
                $model_file->entity_id = $post['model_id'];
                $model_file->field = $post['field'];
                $model_file->model = $post['entity'];
                $model_file->name = $fileName;
                $model_file->path = '/' . $post['upload_dir'];
                $model_file->storage = 'StorageLocal';
                $model_file->size = $fileStat['size'];
                $model_file->mimetype = mime_content_type($filePath);
                $model_file->save();
                $out['result']['id'] = $model_file->id;
            }
            return $out;

        }
    }

    /**
     * @param $id
     * @param $token
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
//        $token = Yii::$app->request->post('token');
        $this->enableCsrfValidation = false;
        if($id){
            $file = Instance::findOne($id);

            if (!$file) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            $file->delete();


        } elseif($imgname = Yii::$app->request->post('imgname')) {
            $file = Instance::find()->where(['name'=>$imgname])->one();
            if (!$file) {
                $filepath = Yii::getAlias("@files")."/temp/".$imgname;
                if(file_exists($filepath)){
                    @unlink($filepath);
                }
            }
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['success' => true];
    }
}
