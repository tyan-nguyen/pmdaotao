<?php

namespace app\modules\thuexe\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\LoaiXe;

/**
 * LichThueController implements the CRUD actions for LichThue model.
 */
class LichXeController extends Controller
{
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
    
    /**
     * get lịch của xe: lich giao vien (da hoan thanh/da len lich/da qua thoi gian)
     */
    public function actionLichXeGv($idxe){
        $model = Xe::findOne($idxe);
        return $this->render('lich-xe-gv', [
            'model' => $model
        ]);
    }
    
    /**
     * get lịch của xe: lich giao vien (da hoan thanh/da len lich/da qua thoi gian) so sanh voi thuc te
     */
    public function actionLichXeGvSoSang($idxe){
        $model = Xe::findOne($idxe);
        return $this->render('lich-xe-gv-so-sanh', [
            'model' => $model
        ]);
    }
    
    /**
     * get lịch của xe: lich thue xe (da len lich/da qua thoi gian)
     */
   /*  public function actionLichXeThue($idxe){
        
    } */
    /**
     * get lịch của xe: lich thue xe (da len lich/da qua thoi gian)
     */
    /* public function actionLichXeAll($idxe){
        
    } */
    
}