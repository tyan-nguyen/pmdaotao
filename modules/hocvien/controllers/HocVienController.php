<?php

namespace app\modules\hocvien\controllers;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\HvHocVien;
use app\modules\hocvien\models\NopHocPhi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\hocvien\models\search\HocVienSearch;
use app\modules\hocvien\models\HocPhi;
use app\modules\hocvien\models\HocVien;
use yii\web\UploadedFile;
use app\modules\hocvien\models\KhoaHoc;
use Datetime;
use app\modules\lichhoc\models\LichHoc;
use yii\web\BadRequestHttpException;
use app\modules\giaovien\models\GiaoVien;
use app\modules\nhanvien\models\NhanVien;

/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class HocVienController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'view', 'update','create','delete','bulkdelete'],
						'allow' => true,
						'roles' => ['@'],
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
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý Học viên';
	    Yii::$app->params['modelID'] = 'Danh sách học viên';
	    return true;
	}
    /**
     * Lists all HvHocVien models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HocVienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['trang_thai' => ['NHAPTRUCTIEP']]);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'pagination'=>$pagination,
        ]);
    }
    


    /**
     * Displays a single HvHocVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id); 
        $idKH = $model->id_khoa_hoc;
        $modelKH = KhoaHoc::find()->where(['id' => $idKH])->one();
        if (!empty($modelKH)) {
            $weeks = $this->generateWeeks($modelKH->ngay_bat_dau, $modelKH->ngay_ket_thuc);
        } else {
            $weeks = []; 
        }  
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Học viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                        'weeks' => $weeks,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'weeks' => $weeks,
            ]);
        }
    }
    protected function generateWeeks($startDate, $endDate)
    {
       $start = new DateTime($startDate);
       $end = new DateTime($endDate);
       $start->modify('last monday');
       $end->modify('next sunday');

       $weeks = [];
       $weekNumber = 1;

       while ($start < $end) {
        $weekStart = clone $start;
        $weekEnd = (clone $start)->modify('+6 days');

        $weeks[$weekNumber] = sprintf(
            'Tuần %d [%s - %s]',
            $weekNumber,
            $weekStart->format('d/m/Y'),
            $weekEnd->format('d/m/Y')
        );

        $weekNumber++;
        $start->modify('+7 days');
       }
        return $weeks;
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
        $model = new HocVien();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm Học viên ",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])

                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm Học viên",
                    'content'=>'<span class="text-success">Thêm Học viên thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm Học viên",
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
                    'title'=> "Cập nhật thông tin Học viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Học viên  #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Lưu lại',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update HvHocVien #".$id,
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
     $hocVien = HocVien::findOne($id);
     $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';
     if ($hocVien && $hocVien->hang) {
        $tenHang = $hocVien->hang->ten_hang; 
    } else {
        $tenHang = 'Chưa có hạng xe'; 
    }

     $hocPhi = null;
     if ($hocVien) {
        $khoaHoc = $hocVien->khoaHoc; 
        if ($khoaHoc && $khoaHoc->id_hoc_phi) {
            $hocPhi = HocPhi::findOne($khoaHoc->id_hoc_phi);
        }
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
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin học phí",
                'content'=>'<span class="text-success">Thêm học phí thành công !</span>',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])         
    
            ];         
        }else{           
            return [
                'title'=> "Thông tin học phí",
                'content'=>$this->renderAjax('create2', [
                    'model' => $model,
                    'hoTenHocVien' => $hoTenHocVien,
                    'tenHang' => $tenHang,
                    'hocPhi' => $hocPhi ,
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
            if ($hocVien) {
                $hocVien->trang_thai = 'NHAP_HOC'; // Cập nhật trạng thái
                $hocVien->save(); // Lưu thay đổi
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create2', [
                'model' => $model,
                'hoTenHocVien' => $hoTenHocVien,
                'tenHang' => $tenHang,
                'hocPhi' => $hocPhi ,
            ]);
        }
    }
   
}


public function actionMess($id)
{   
    return $this->asJson([
        'title'=>'Thông báo !',
        'content'=>$this->renderAjax('mess', [
          
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
    
}
public function actionMess2($id)
{   
    return $this->asJson([
        'title'=>'Thông báo !',
        'content'=>$this->renderAjax('mess2', [
          
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
    
}

public function actionGetToList($id_hang)
{
   
    $kh = KhoaHoc::find()->where(['id_hang' => $id_hang])->all();
    
    if (empty($kh)) {
        return json_encode(['no_khoa_hoc' => 'Trống']);
    }
    $listKh = ArrayHelper::map($kh, 'id', 'ten_khoa_hoc');
    return json_encode($listKh);
}


public function actionCreateHp()
    {
        $request = Yii::$app->request;
        $model = new HocPhi();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new HvHocVien",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new HvHocVien",
                    'content'=>'<span class="text-success">Create HvHocVien success</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new HvHocVien",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
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

    public function actionDeleteFromKhoaHoc($id)
{
    $request = Yii::$app->request;
    $model = HocVien:: find()->where(['id'=> $id])->one();
    $idKH= $model->id_khoa_hoc;
    $modelKH = KhoaHoc::find()->where(['id' => $idKH])->one();

    if ($request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model->id_khoa_hoc = null;
        if ($model->save()) {
            return [
                'forceClose' => true,
                'forceReload' => '#hvContent', 
                'reloadContent' => $this->renderAjax('xem_hv', [
                    'modelKH' => $modelKH,
                ]),
                'tcontent' => 'Học viên đã được xóa khỏi khóa học!',
            ];
        } else {
            return [
                'forceClose' => false,
                'tcontent' => 'Lỗi khi xóa học viên.',
            ];
        }
    } else {
        // Nếu không phải yêu cầu Ajax, sẽ redirect về trang index
        return $this->redirect(['view']);
    }
}

public function actionBienLai($idHP)
{   
    $model = NopHocPhi::findOne($idHP);
    return $this->asJson([
        'title'=>'Biên lai',
        'content'=>$this->renderAjax('xem_bien_lai', [
             'model'=>$model,
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
    
}

public function actionLoadScheduleWeek($week_string, $idKH, $idNhom, $idHV)
{
    if (preg_match('/Tuần \d+ \[(\d{2}\/\d{2}\/\d{4}) - (\d{2}\/\d{2}\/\d{4})\]/', $week_string, $matches)) {
        $dayBD = \DateTime::createFromFormat('d/m/Y', $matches[1])->format('Y-m-d');
        $dayKT = \DateTime::createFromFormat('d/m/Y', $matches[2])->format('Y-m-d');
                $data = LichHoc::find()
                ->where(['between', 'ngay', $dayBD, $dayKT])
                ->andWhere(['id_khoa_hoc' => $idKH])
                ->andWhere(['or',
                    ['id_nhom' => $idNhom],
                    ['id_nhom' => null]
                ])
                ->all();
        return $this->renderPartial('_schedule_table', [
            'data' => $data,
            'idHV'=>$idHV,
            'week_string'=>$week_string,
        ]);
    }
    throw new BadRequestHttpException('Chuỗi tuần không hợp lệ.');
}

public function actionUpdateLichHoc($id, $idHV, $week_string)
    {
        $request = Yii::$app->request;
        if (preg_match('/Tuần \d+ \[(\d{2}\/\d{2}\/\d{4}) - (\d{2}\/\d{2}\/\d{4})\]/', $week_string, $matches)) {
            $dayBD = \DateTime::createFromFormat('d/m/Y', $matches[1])->format('Y-m-d');
            $dayKT = \DateTime::createFromFormat('d/m/Y', $matches[2])->format('Y-m-d');
        }
        $model = LichHoc::find()->where(['id' => $id])->one(); 
        $idKhoaHoc = $model->id_khoa_hoc;
        $modelHV = HocVien::find()->where(['id'=>$idHV])->one();
        $giaoViens = GiaoVien::find()->all();
        $giaoVienList = \yii\helpers\ArrayHelper::map($giaoViens, 'id', 'ho_ten');
        $idHV = $modelHV->id;
        $idKH = $modelHV->id_khoa_hoc;
        $idNhom = $modelHV->id_nhom;
        $data = LichHoc::find()
        ->where(['between', 'ngay', $dayBD, $dayKT])
        ->andWhere(['id_khoa_hoc' => $idKH])
        ->andWhere(['or',
            ['id_nhom' => $idNhom],
            ['id_nhom' => null]
        ]);
    if ($request->isAjax) {
    
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => "Cập nhật lịch học #".$id,
                'content' => $this->renderAjax('update_lich_hoc', [
                    'model' => $model,
                    'idKhoaHoc'=>$idKhoaHoc,
                    'giaoVienList'=>$giaoVienList,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else if ($model->load($request->post()) && $model->save()) {
            return [
                'forceClose'=>true,   
                'reloadType'=>'lichHoc',
                'reloadBlock'=>'#lhContent',
                'reloadContent'=>$this->renderAjax('_schedule_table', [ 
                   'data'=>$data,  
                ]), 
                'tcontent'=>'Cập nhật lịch học thành công!',
            ];
        } else {
            return [
                'title' => "Cập nhật Học phí #".$id,
                'content' => $this->renderAjax('update_lich_hoc', [
                    'model' => $model,
                    'idKhoaHoc'=>$idKhoaHoc,
                    'giaoVienList'=>$giaoVienList,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['mess', 'id' => $model->id]); 
        } else {
            return $this->render('update_lich_hoc', [
                'model' => $model,
                'idKhoaHoc'=>$idKhoaHoc,
                'giaoVienList'=>$giaoVienList,
            ]);
        }
    }
    }

    public function actionGetGiaoVienList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        $request = Yii::$app->request;
    
        if (!$request->isAjax || !$request->isPost) {
            throw new BadRequestHttpException('Invalid request.');
        }
    
        $idKhoaHoc = $request->post('id_khoa_hoc');
        $hocPhan = $request->post('hoc_phan');
    
        if (!$idKhoaHoc || !$hocPhan) {
            return json_encode(['no_giao_vien' => 'Trống']);
        }
    
        $khoaHoc = KhoaHoc::findOne($idKhoaHoc);
        if (!$khoaHoc) {
            return json_encode(['no_giao_vien' => 'Khóa học không hợp lệ']);
        }
    
        $hangDaoTaoId = $khoaHoc->id_hang;
    
        $giaoViens = NhanVien::find()
            ->alias('nv')
            ->select(['nv.id', 'nv.ho_ten'])
            ->innerJoin('nv_day d', 'd.id_nhan_vien = nv.id')
            ->where(['nv.doi_tuong' => 1, 'd.id_hang_xe' => $hangDaoTaoId])
            ->andWhere([
                $hocPhan === 'Lý thuyết' ? 'd.ly_thuyet' : 'd.thuc_hanh' => 1
            ])
            ->groupBy('nv.id, nv.ho_ten')
            ->all();
    
        if (empty($giaoViens)) {
            return json_encode(['no_giao_vien' => 'Trống']);
        }
    
        $listGiaoVien = ArrayHelper::map($giaoViens, 'id', 'ho_ten');
       return json_encode($listGiaoVien);
    }

    public function actionGetPhieuInAjax($id, $idHV, $type)
    {
        $modelKH = KhoaHoc::find()->where(['id'=>$id])->one();
        $tenKH = $modelKH->ten_khoa_hoc;
        $ngayBD = $modelKH->ngay_bat_dau;
        $ngayKT = $modelKH->ngay_ket_thuc;
        $start = new DateTime($ngayBD);
        $end = new DateTime($ngayKT);
        $startFormatted = $start->format('d/m/Y');
        $endFormatted = $end->format('d/m/Y');
        $modelHV = HocVien::find()->where(['id'=>$idHV])->one();
        $tenHV = $modelHV->ho_ten;
        $idNhom = $modelHV ->id_nhom;
        $data = LichHoc::find()->where(['id_khoa_hoc'=>$modelKH->id ,'id_nhom'=>$idNhom])->all();
        if ($type === 'lichhoc') {
            $content = $this->renderPartial('_in_lich_hoc', ['tenKH' => $tenKH,'startFormatted'=>$startFormatted ,'endFormatted'=>$endFormatted,'tenHV'=>$tenHV,'data'=>$data]);
            return $this->asJson([
                'status' => 'success',
                'content' => $content,
            ]);
        }
        return $this->asJson([
            'status' => 'error',
            'message' => 'Không tìm thấy lịch học.',
        ]);
    }
    
}
