<?php

namespace app\modules\banhang\controllers;

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
use app\modules\hocvien\models\ThayDoiHocPhi;
use app\modules\banhang\models\HoaDon;
use app\modules\banhang\models\HoaDonChiTiet;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class ReportController extends Controller
{
    public $freeAccessActions = [
        'rp-theo-ca',
        'rp-theo-ca-hang-hoa-print',
        'rp-theo-ca-hoa-don-print',
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
    /**
     * in danh sách theo ca
     */
    public function actionRpTheoCa(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;            
            return [
                'title' => "Báo cáo danh sách theo ca",
                'content' => $this->renderAjax('rp_theo_ca', [
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    
    public function actionRpTheoCaHangHoaPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $sortby='ngay')//1 for show hang hoa
    {
        if($byuser==null){
            $byuser = 0;
        }
        if($starttime == null)
            $starttime = '00:00:00';
        if($endtime == null)
            $endtime = '23:59:59';
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;
        
        $query = HoaDonChiTiet::find()->alias('t');
        //$query->joinWith(['donHang as dh']);
        $query->select([
            't.*', 
            'SUM(t.so_luong) AS tongSoLuongSanPham',
            'SUM(t.so_luong * t.don_gia) AS tongTienSanPham',
            'SUM(t.chiet_khau) as tongChietKhauSanPham'
        ]);
        $query->innerJoinWith(['donHang as dh']);
        
        $query=$query->andFilterWhere(['>=', 'dh.ngay_xuat', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 'dh.ngay_xuat', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
       
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        
        $query->groupBy(['t.id_hang_hoa']);
        
        
        
        
        
                
        /* $query = HoaDon::find()->alias('t');
        
        $query=$query->andFilterWhere(['>=', 't.ngay_xuat', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 't.ngay_xuat', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]); */
        
        
        $model=$query->all();
        //$modelCount=$query->count();
        
        /* if($sortby==null)
            $sortby = 'ngay';
        if($sortby == 'sohd'){
            $model=$query->orderBy(['t.so_don_hang'=>SORT_ASC, 't.ngay_xuat'=>SORT_ASC])->all();
        } else if($sortby == 'ngay'){
            $model=$query->orderBy(['t.ngay_xuat'=>SORT_ASC])->all();
        } */
            
        $content = $this->renderPartial('rp_theo_ca_hang_hoa_print', [
            'model' => $model,
            'start'=>$start,
            'end'=>$end,
            //'modelCount'=>$modelCount,
            'byuser' => $byuser,
            'sortby'=>$sortby,
        ]);
            
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    public function actionRpTheoCaHoaDonPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $sortby='ngay')//0 for show hoa don
    {
        if($byuser==null){
            $byuser = 0;
        }
        if($starttime == null)
            $starttime = '00:00:00';
        if($endtime == null)
            $endtime = '23:59:59';
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;

        $query = HoaDon::find()->alias('t');
        
        $query=$query->andFilterWhere(['>=', 't.ngay_xuat', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 't.ngay_xuat', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        
        $model=$query->all();
        $modelCount=$query->count();
        
        if($sortby==null)
            $sortby = 'ngay';
        if($sortby == 'sohd'){
            $model=$query->orderBy(['t.so_don_hang'=>SORT_ASC, 't.ngay_xuat'=>SORT_ASC])->all();
        } else if($sortby == 'ngay'){
            $model=$query->orderBy(['t.ngay_xuat'=>SORT_ASC])->all();
        }

        $content = $this->renderPartial('rp_theo_ca_hoa_don_print', [
            'model' => $model,
            'start'=>$start,
            'end'=>$end,
            'modelCount'=>$modelCount,
            'byuser' => $byuser,
            'sortby'=>$sortby,
        ]);
            
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);            
    }
    
}