<?php

namespace app\modules\hocvien\controllers;

use Yii;
use app\models\HvHocVien;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\hocvien\models\search\DangKyHvSearch;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\DangKyHvOnline;
use app\modules\hocvien\models\NopHocPhi;
use yii\web\UploadedFile;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class DangKyOnlineController extends Controller
{
    public $freeAccess = true;
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'dang-ky' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionDangKy(){
        $request = Yii::$app->request;
        $model = new DangKyHvOnline();  
        if ($model->load($request->post())) {
            if ($model->save()) {
                //gui email
                
                //redirect về website
                $this->redirect('http://localhost:9999/dang-ky-online/all/success');
            }else{
                print_r($model->errors);
                //$this->redirect('http://localhost:9999/xxxxxxxxxxxxxxx');
                //$this->redirect('http://localhost:9999/dang-ky-online/all/failed');
            }
        }
    }
    
    
}