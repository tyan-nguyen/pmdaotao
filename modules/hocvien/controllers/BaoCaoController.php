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
use app\modules\hocvien\models\ThayDoiHocPhi;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class BaoCaoController extends Controller
{
    public $freeAccessActions = [
        'rp-danh-sach-dang-ky', 
        'rp-danh-sach-dang-ky-print', 
        'rp-bien-ban-ban-giao', 
        'rp-bien-ban-ban-giao-print',
        'rp-bien-ban-ban-giao-full-print',
        'rp-bien-ban-thay-doi-hang-print',
        'rp-bien-ban-huy-ho-so-print',
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
        Yii::$app->params['modelID'] = 'Đăng ký học';
        //return true;
        return parent::beforeAction($action);
    }
    /**
     * in biên bản thay đổi hạng
     * @param unknown $idbb
     * @return \yii\web\Response
     */
    public function actionRpBienBanThayDoiHangPrint($idbb){
        $model = ThayDoiHocPhi::findOne($idbb);
        $content = $this->renderPartial('rp_bien_ban_ban_thay_doi_hang_print', [
           'model'=>$model
        ]);

        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    /**
     * in biên bản hủy hồ sơ
     * @param unknown $idhv
     * @return \yii\web\Response
     */
    public function actionRpBienBanHuyHoSoPrint($idhv){
        $model = DangKyHv::findOne($idhv);
        $content = $this->renderPartial('rp_bien_ban_huy_ho_so_print', [
            'model'=>$model
        ]);
        
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    /**
     * in danh sách theo ca
     */
    public function actionRpDanhSachDangKy(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return [
                'title' => "Báo cáo danh sách học viên",
                'content' => $this->renderAjax('rp_danh_sach_dang_ky', [
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    
    public function actionRpDanhSachDangKyPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $byhocphi='all', $sortby='date', $byhangdaotao=NULL, $typereport=0,$byaddress=null)//0 for all
    {
        if($byuser==null){
            $byuser = 0;
        }
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;
        
        // $start = '2025-03-31 06:00:00';
        //$end = '2025-04-01 11:00:00';
        $query = HocVien::find()->alias('t');
        //if($byhocphi != 'all'){
        $query = $query->select(['t.*', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien) as tongtiennop']);
        //}        
        $query=$query->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        if($byhocphi != 'all'){
            if($byhocphi=='danop'){
                $query=$query->andFilterWhere(['>', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien)', 2000000]);
            }else if($byhocphi=='coc'){
                $query=$query->andFilterWhere(['<=', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien)', 2000000]);
            }
        }
        
        if($byhangdaotao!=NULL){
            $query = $query->andFilterWhere(['t.id_hang' => $byhangdaotao]);
        }
        
        if($byaddress!=NULL){
           // $byaddress = strtoupper($byaddress);
            $query = $query->andFilterWhere(['t.noi_dang_ky' => $byaddress]);
        }
        
        $model=$query->all();
        $modelCount=$query->count();       
       
        
        if($typereport==0){
            $content = $this->renderPartial('rp_danh_sach_dang_ky_print', [
                'model' => $model,
                'start'=>$start,
                'end'=>$end,
                'modelCount'=>$modelCount,
                'byuser' => $byuser,
                'byhangdaotao' => $byhangdaotao,
                'byaddress' => $byaddress
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
        
    }
    
    /**
     * in danh sách theo ca
     */
    public function actionRpBienBanBanGiao(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return [
                'title' => "Biên bản bàn giao hồ sơ học viên",
                'content' => $this->renderAjax('rp_bien_ban_ban_giao', [
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    
    public function actionRpBienBanBanGiaoPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $sortby='ngay', $byhangdaotao=NULL, $typereport=0, $byaddress=NULL, $bykhoa=NULL)//0 for all
    {
        if($byuser==null){
            $byuser = 0;
        }
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;
        
        // $start = '2025-03-31 06:00:00';
        //$end = '2025-04-01 11:00:00';
        $query = HocVien::find()->alias('t');
        //if($byhocphi != 'all'){
        /* $query = $query->select(['t.*', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien) as tongtiennop']); */
        //}
        
        $query=$query->andFilterWhere(['>=', 't.thoi_gian_hoan_thanh_ho_so', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 't.thoi_gian_hoan_thanh_ho_so', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        
        if($byhangdaotao!=NULL){
            $query = $query->andFilterWhere(['t.id_hang' => $byhangdaotao]);
        }
        
        if($byaddress!=NULL){
            //$byaddress = strtoupper($byaddress);
            $query = $query->andFilterWhere(['t.noi_dang_ky' => $byaddress]);
        }
        if($bykhoa!=NULL){
            //$byaddress = strtoupper($byaddress);
            $query = $query->andFilterWhere(['t.id_khoa_hoc' => $bykhoa]);
        }
        
        $model=$query->all();
        $modelCount=$query->count();
        
        if($sortby==null)
            $sortby = 'ngay';
        if($sortby == 'hang'){
            $model=$query->orderBy(['t.id_hang'=>SORT_ASC, 't.thoi_gian_hoan_thanh_ho_so'=>SORT_ASC])->all();
        } else if($sortby == 'ngay'){
            $model=$query->orderBy(['t.thoi_gian_hoan_thanh_ho_so'=>SORT_ASC])->all();
        }        

       
        
        
        if($typereport==0){
            $content = $this->renderPartial('rp_bien_ban_ban_giao_print', [
                'model' => $model,
                'start'=>$start,
                'end'=>$end,
                'modelCount'=>$modelCount,
                'byuser' => $byuser,
                'byhangdaotao' => $byhangdaotao,
                'sortby'=>$sortby,
                'byaddress' => $byaddress,
                'bykhoa' =>$bykhoa
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
        
    }
    
    public function actionRpBienBanBanGiaoFullPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $sortby='ngay', $byhangdaotao=NULL, $typereport=0, $byaddress=NULL, $bykhoa=NULL)//0 for all
    {
        if($byuser==null){
            $byuser = 0;
        }
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;        
     
        if($typereport==0){
            $content = $this->renderPartial('rp_bien_ban_ban_giao_full_print', [
                'start'=>$start,
                'end'=>$end,
                'byuser' => $byuser,
                'byhangdaotao' => $byhangdaotao,
                'sortby'=>$sortby,
                'byaddress' => $byaddress,
                'bykhoa' =>$bykhoa
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
            
    }
    
}
