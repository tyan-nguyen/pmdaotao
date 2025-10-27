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
use app\modules\hocvien\models\search\ThongKeLuuLuongSearch;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class ThongKeController extends Controller
{
   /*  public $freeAccessActions = [
        'tong-hop', 
        'ban-hang',
        'luu-luong'
    ]; */
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
     * thống kê học viên - học phí
     */
    public function actionTongHop(){       
        return $this->render('tong-hop', [            
        ]);
    }    
    /**
     * thống kê lưu lượng
     */
    public function actionLuuLuong(){        
        $searchModel = new ThongKeLuuLuongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //an add
        //$dataProvider->query->andWhere(['trang_thai' => ['DANG_KY']]);
        //$dataProvider->query->andWhere('id_khoa_hoc is NULL');
        $pagination = $dataProvider->getPagination();
        $pagination->pageSize = 20;
        return $this->render('luu-luong', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' =>$pagination,
        ]);
    }    
    /**
     * thống kê bán hàng
     */
    public function actionBanHang(){
        
        return $this->render('ban-hang', [
            
        ]);
    }
    /**
     * thống kê số lượng học viên mới
     */
    public function actionThongKeHoSoMoi(){
        
        return $this->render('ho-so-moi', [
            
        ]);
    }
    /**
     * thống kê thu tiền
     */
    public function actionThongKeThuTien(){
        
        return $this->render('thu-tien', [
            
        ]);
    }
    /**
     * thống kê công nợ
     */
    public function actionThongKeCongNo(){
        
        return $this->render('cong-no', [
            
        ]);
    }
    
}