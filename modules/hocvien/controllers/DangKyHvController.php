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
class DangKyHvController extends Controller
{
    public $freeAccessActions = ['get-phieu-in-ajax', 'update-print-count', 'report-list', 'get-phieu-in-report-list-ajax'];
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
     * Lists all HvHocVien models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new DangKyHvSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //an add
        //$dataProvider->query->andWhere(['trang_thai' => ['DANG_KY']]);
        //$dataProvider->query->andWhere('id_khoa_hoc is NULL');
        $pagination = $dataProvider->getPagination();
        $pagination->pageSize = 20;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' =>$pagination, 
        ]);
    }


    /**
     * Displays a single HvHocVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = HocVien::find()->where(['id' => $id])->one();
        $trang_thai_duyet = $model->trang_thai_duyet;
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $kiemDuyetButton = '';
            if (empty($trang_thai_duyet)) {
                $kiemDuyetButton = Html::a(
                    '<i class="fa fa-check"> </i> Kiểm duyệt', 
                    ['/hocvien/dang-ky-hv/duyet-hv', 'id' => $id, 'modalType' => 'modal-remote-2'], 
                    [
                        'class' => 'btn btn-info',
                        'role' => 'modal-remote-2',
                        'title' => 'Kiểm duyệt'
                    ]
                );
            }
            return [
                'title' => "Học viên  #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => $kiemDuyetButton .
                    Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];    
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    

    /**
     * Creates a new HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DangKyHv();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Nhập thông tin học viên đăng ký ",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }if ($model->load($request->post())) { 
                $model->loai_dang_ky = 'Nhập trực tiếp'; 
                $model->trang_thai_duyet = 'DA_DUYET';
                if ($model->save()) {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm học viên",
                    'content'=>'<span class="text-success">Đăng ký học viên thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Xem thông tin',['view', 'id'=>$model->id],['class'=>'btn btn-primary','role'=>'modal-remote']).
                               Html::a('Tiếp tục thêm mới',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];         
            }else{           
                return [
                    'title'=> "Thêm học viên",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }
    }
    /**
     * Updates an existing HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật thông tin học viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Học viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Chỉnh sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật học viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    public function actionDuyetHv($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Kiểm duyệt Học viên",
                    'content'=>$this->renderAjax('duyet-hv', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }if ($model->load($request->post())) { 
                $model->nguoi_duyet = Yii::$app->user->identity->id; 
                $model->save();
                if ($model->save()) {
                return [
                    'forceClose'=>true,   
                     'reloadType'=>'hocVien',
                     'reloadBlock'=>'#hvContent',
                     'reloadContent'=>$this->renderAjax('view', [
                         'model' => $model,
                     ]),
                     
                     'tcontent'=>'Kiểm duyệt thành công!',
                 ];
                }   
       
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('duyet-hv', [
                    'model' => $model,
                ]);
            }
        }
    }
}

    /**
     * Delete an existing HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the HvHocVien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HvHocVien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HocVien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
public function actionCreate2($id)
{
    $request = Yii::$app->request;
    $model = new NopHocPhi();  
    $model->id_hoc_vien = $id;
     // Tìm học viên theo id_hoc_vien
     $hocVien = HocVien::findOne($id);
     $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';
     
      $hocVien = HocVien::findOne($id);
      $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';
      if ($hocVien && $hocVien->hang) {
         $tenHang = $hocVien->hang->ten_hang; 
     } else {
         $tenHang = 'Chưa có hạng xe'; 
     }
      
      $hocPhi = null;
      if ($hocVien) {
          $hocPhi = $hocVien->hocPhi;
          /* $hangDaoTao = $hocVien->hangDaoTao;  
          if ($hangDaoTao) {
              $hocPhi = $hangDaoTao->hocPhi;  
          } */
      }
 
    if($request->isAjax){
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thông tin học phí",
                'content'=>$this->renderAjax('create2', [
                    'model' => $model,
                    'hoTenHocVien' => $hoTenHocVien,
                    'tenHang' => $tenHang,
                    'hocPhi' => $hocPhi,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
    
            ];         
        }else if($model->load($request->post()) && $model->save()){
              // Xử lý file upload
              $model->file = UploadedFile::getInstance($model, 'file');
              if($model->file) {
                  $uploadPath = Yii::getAlias('@webroot/uploads/bien_lai/');
                  if (!file_exists($uploadPath)) {
                      mkdir($uploadPath, 0777, true);
                  }
                  $fileName = time() . '_' . $model->file->baseName . '.' . $model->file->extension;
                  $filePath = $uploadPath . $fileName;
                  if($model->file->saveAs($filePath)) {
                      $model->bien_lai = 'uploads/bien_lai/' . $fileName;
                      $model->save(false); 
                  }
                 }
            if ($hocVien) {
                $hocVien->trang_thai = 'NHAPTRUCTIEP'; 
                $hocVien->save();
            }
            /* return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin học phí",
                'content'=>'<span class="text-success">Thêm học phí thành công !</span>',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])         
            ];  */     
            return [
                'title' => "Học viên  #" . $model->hocVien->id,
                'content' => $this->renderAjax('view', [
                    'model' => $hocVien,
                ]),
                'footer' => 
                Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];    
        }else{           
            return [
                'title'=> "Thông tin học phí",
                'content'=>$this->renderAjax('create2', [
                    'model' => $model,
                    'hoTenHocVien' => $hoTenHocVien,
                    'tenHang' => $tenHang,
                    'hocPhi' => $hocPhi,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
    
            ];         
        }
    }else{
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
          //  if ($hocVien) {
               // $hocVien->trang_thai = 'NHAP_HOC'; // Cập nhật trạng thái
               // $hocVien->save(); // Lưu thay đổi
           // }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create2', [
                'model' => $model,
                'hoTenHocVien' => $hoTenHocVien,
                'tenHang' => $tenHang,
                'hocPhi' => $hocPhi,
            ]);
        }
    }   
}

public function actionGetPhieuInAjax($id, $type, $nhap)//$nhap in nhap hay in that
{
    $model = NopHocPhi::findOne($id);
  //  $model->so_lan_in_phieu = ($model->so_lan_in_phieu ?? 0) + 1;
    //$model->save(false);

    if ($type === 'phieuthu') {
        $soTienDong = 0;
        $soTienConLai = 0;
        $phanTram = null;
        $hocPhi = $model->hocVien->hocPhi;
        $tongTienDong = NopHocPhi::find()->where(['id_hoc_vien'=>$model->id_hoc_vien])->sum('so_tien_nop');
        if($model->loai_nop == 'NOP100'){//100%
            //$soTienDong = $model->so_tien_nop;
            //$soTienConLai = 0;
           // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
            $phanTram = '100%';
        } else if($model->loai_nop == 'NOP50'){//50%
           // $soTienDong = $model->so_tien_nop;
            //$soTienConLai = $model->so_tien_nop;
           // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
            $phanTram = '50%';
        } else if($model->loai_nop == 'COC1TR'){
            //$soTienDong = $model->so_tien_nop;
            //$soTienConLai = $hocPhi->hoc_phi - $model->so_tien_nop;
           // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
            $phanTram = null;
        }else if($model->loai_nop == 'KHAC'){
           // $soTienDong = $model->so_tien_nop;
           // $soTienConLai = $hocPhi->hoc_phi - $model->so_tien_nop;
           // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
            $phanTram = null;
        }
        
        if($model->loai_phieu==NopHocPhi::PHIEUTHULABEL){
            $content = $this->renderPartial('_print_phieu_thong_tin', [
                'model' => $model,
                //'soTienDong' => $soTienDong,
                //'soTienConLai' => $soTienConLai,
                'phanTram' => $phanTram,
                'nhap'=>$nhap
            ]);
        } else if($model->loai_phieu==NopHocPhi::PHIEUCHILABEL){
            $content = $this->renderPartial('_print_phieu_thong_tin_chi', [
                'model' => $model,
                //'soTienDong' => $soTienDong,
                //'soTienConLai' => $soTienConLai,
                'phanTram' => $phanTram,
                'nhap'=>$nhap
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }

    return $this->asJson([
        'status' => 'error',
        'message' => 'Không tìm thấy loại phiếu.',
    ]);
}

public function actionUpdatePrintCount($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $model = NopHocPhi::findOne($id);
    if ($model !== null) {
        $model->so_lan_in_phieu = ($model->so_lan_in_phieu ?? 0) + 1;
        if ($model->save(false)) {
            return ['success' => true, 'so_lan_in' => $model->so_lan_in_phieu];
        }
    }
    return ['success' => false];
}

/**
 * in danh sách theo ca
 */
public function actionReportList(){
    /* if($ca=='sang'){
       // $timeStart = date('Y-m-d 06:00:00');
        $title = 'Ca sáng';
    } else if($ca=='chieu'){
        $title = 'Ca chiều';
    } */
    //$model = HocVien::find()->where(['id' => $id])->one();
    //$trang_thai_duyet = $model->trang_thai_duyet;
    $request = Yii::$app->request;
    if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
 
        return [
            'title' => "Báo cáo danh sách theo ca",
            'content' => $this->renderAjax('report-list', [
                
            ]),
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
        ];
    }
}

public function actionGetPhieuInReportListAjax($startdate, $starttime, $enddate, $endtime, $byuser=0,$typereport,$byaddress)//0 for all
{
    if($byuser==null){
        $byuser = 0;
    }
   // $startStr = $startdate . ' ' .$starttime;//add second
   // $endStr = $enddate . ' ' .$endtime;//add second
    $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
    $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;
    
   // $start = '2025-03-31 06:00:00';
    //$end = '2025-04-01 11:00:00';
    $query = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
        ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
        ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
    if($byuser>0){
        $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
    }
    if($byaddress>0){
        $query = $query->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
    }
    $model=$query->all();
    $modelCount=$query->count();
    $modelSoTienNop = $query->sum('t.so_tien_nop');
    
    $queryCK = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
    ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
    ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
    if($byuser>0){
        $queryCK = $queryCK->andFilterWhere(['t.nguoi_tao' => $byuser]);
    }
    if($byaddress>0){
        $queryCK = $queryCK->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
    }
    $queryCK = $queryCK->andFilterWhere(['t.hinh_thuc_thanh_toan' => 'CK']);
    $modelSoTienNopCK = $queryCK->sum('t.so_tien_nop');
    
    $queryTM = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
    ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
    ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
    if($byuser>0){
        $queryTM = $queryTM->andFilterWhere(['t.nguoi_tao' => $byuser]);
    }
    if($byaddress>0){
        $queryTM = $queryTM->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
    }
    $queryTM = $queryTM->andFilterWhere(['t.hinh_thuc_thanh_toan' => 'TM']);
    
    $modelSoTienNopTM = $queryTM->sum('t.so_tien_nop');
    
    $queryChietKhau = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
    ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
    ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
    if($byuser>0){
        $queryChietKhau = $queryChietKhau->andFilterWhere(['t.nguoi_tao' => $byuser]);
    } 
    if($byaddress>0){
        $queryChietKhau = $queryChietKhau->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
    }
    $modelSoTienChietKhau = $queryChietKhau->sum('t.chiet_khau');
    
    if($typereport==0){
        $content = $this->renderPartial('_print_report_list_0', [
            'model' => $model,
            'start'=>$start,
            'end'=>$end,
            'modelCount'=>$modelCount,
            'modelSoTienNop'=> $modelSoTienNop,
            'modelSoTienNopTM'=> $modelSoTienNopTM,
            'modelSoTienNopCK'=> $modelSoTienNopCK,
            'modelSoTienChietKhau' => $modelSoTienChietKhau,
            'byuser' => $byuser
        ]);
    }else if($typereport==1){
        $content = $this->renderPartial('_print_report_list_1', [
            'model' => $model,
            'start'=>$start,
            'end'=>$end,
            'modelCount'=>$modelCount,
            'modelSoTienNop'=> $modelSoTienNop,
            'modelSoTienNopTM'=> $modelSoTienNopTM,
            'modelSoTienNopCK'=> $modelSoTienNopCK,
            'modelSoTienChietKhau' => $modelSoTienChietKhau,
            'byuser' => $byuser
        ]);
    }
    return $this->asJson([
        'status' => 'success',
        'content' => $content,
    ]);
    
}

/**
 * in danh sách báo cáo tổng
 */
public function actionReportSum(){
    $request = Yii::$app->request;
    if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        return [
            'title' => "Báo cáo danh sách theo ca",
            'content' => $this->renderAjax('report-sum', [
                
            ]),
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
        ];
    }
}

}
