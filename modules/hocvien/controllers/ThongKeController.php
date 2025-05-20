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
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\NopHocPhi;
use yii\web\UploadedFile;
use app\custom\CustomFunc;
use yii\db\Expression;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class ThongKeController extends Controller
{
    public $freeAccessActions = [
            'tong-hop',
        ];
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý Học viên';
        Yii::$app->params['modelID'] = 'Thống kê dữ liệu';
        //return true;
        return parent::beforeAction($action);
    }
    /**
     * in danh sách theo ca
     */
    public function actionTongHop(){
       
        return $this->render('tong-hop', [
            
        ]);
    }
    
}