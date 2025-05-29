<?php

namespace app\modules\khoahoc\controllers;

use Yii;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\khoahoc\models\search\KhoaHocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\hocvien\models\HocVien;
use app\modules\khoahoc\models\NhomHoc;
use app\modules\lichhoc\models\LichHoc;
use DateTime;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use app\modules\giaovien\models\GiaoVien;
use app\modules\nhanvien\models\NhanVien;
use app\modules\lichhoc\models\LichThi;
use app\modules\hocvien\models\DangKyHv;

/**
 * KhoaHocController implements the CRUD actions for KhoaHoc model.
 */
class KhoaHocController extends Controller
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
	 * phân công giáo viên phụ trách chọn nhiều học viên theo khóa học
	 * @param unknown $id: id cua khoa hoc
	 * @return string[]
	 */
	public function actionPhanCongGiangDay($id){
	    $request = Yii::$app->request;
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $model = KhoaHoc::findOne($id);
	    $model->scenario = 'phan-cong-giang-day';
	    if($model == null){
	        return [
	            'title'=> 'Thông báo',
	            'content'=>'Khóa học không tồn tại!',
	            'footer'=> Html::button('Đóng',['data-bs-dismiss'=>'modal'])
	        ];
	    }
	    if($request->isAjax){
	        if($request->isGet){
	            return [
	                'title'=> "Phân công học viên cho giáo viên",
	                'content'=>$this->renderAjax('_formPhanCong', [
	                    'model' => $model,
	                ]),
	                'footer'=> Html::button('Lưu lại',['type'=>'submit']). '&nbsp;' .
	                Html::button('Đóng',['data-bs-dismiss'=>'modal'])
	            ];
	        }else if($model->load($request->post())){
	            if($model->validate('idGiaoVien')){
	                //xu ly them vao khsx
	                if($model->idGiaoVien != null){
	                    foreach ($model->listIdHocVien as $indexHocVien=>$idHocVien){
	                        $modelHocVien = HocVien::findOne($idHocVien);
	                        //if($modelHocVien!= null && $modelHocVien->id_giao_vien == null){
	                            $modelHocVien->id_giao_vien = $model->idGiaoVien;
	                            $modelHocVien->updateAttributes(['id_giao_vien']);
	                        //}
	                    }
	                }
	            }
	            
	            return [	                
	                'title'=> "Phân công học viên cho giáo viên",
	                'content'=>$this->renderAjax('_formPhanCong', [
	                    'model' => $model,
	                ]),
	                'tcontent'=>'Phân công học viên cho giáo viên thành công!',
	                'footer'=> Html::button('Lưu lại',['type'=>'submit']). '&nbsp;' .
	                Html::button('Đóng',['data-bs-dismiss'=>'modal'])
	                
	            ];
	        }else{
	            return [
	                'title'=> "Phân công học viên cho giáo viên",
	                'content'=>$this->renderAjax('_formPhanCong', [
	                    'model' => $model,
	                ]),
	                'footer'=> Html::button('Save-Popup',['type'=>'submit']). '&nbsp;' .
	                Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
	            ];
	        }
	    }//if isAjax
	}

    /**
     * Lists all KhoaHoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        /* $today = date('Y-m-d');
        $khoaHocs = KhoaHoc::find()
            ->where(['<', 'ngay_ket_thuc', $today])
            ->andWhere(['trang_thai' => 'CHUA_HOAN_THANH'])
            ->all();
        foreach ($khoaHocs as $khoaHoc) {
            $khoaHoc->trang_thai = 'DA_HOAN_THANH';
            $khoaHoc->save(false); 
        } */
        $searchModel = new KhoaHocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
  
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý Khóa học';
	    Yii::$app->params['modelID'] = 'Quản lý Khóa học';
	    return parent::beforeAction($action);
	}
    /**
     * Displays a single KhoaHoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {  
        $model = $this->findModel($id); 
        $weeks = $this->generateWeeks($model->ngay_bat_dau, $model->ngay_ket_thuc);
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "KhoaHoc #".$id,
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
     * Creates a new KhoaHoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new KhoaHoc();  

        if($request->isAjax){ 
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm Khóa học",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại', ['class'=>'btn btn-default pull-left', 'data-bs-dismiss'=>"modal"]).

                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm Khóa học",
                    'content'=>'<span class="text-success">Thêm Khóa học thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm Khóa học",
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
     * Updates an existing KhoaHoc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $weeks = $this->generateWeeks($model->ngay_bat_dau, $model->ngay_ket_thuc);
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật Khóa học #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]), 
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "KhoaHoc #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'weeks' => $weeks,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật Khóa học #".$id,
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
     * Delete an existing KhoaHoc model.
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
     * Delete multiple existing KhoaHoc model.
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
     * Finds the KhoaHoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KhoaHoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KhoaHoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionInsertHocVien($id)
    {
        $request = Yii::$app->request;
        $model = new HocVien();  
        $model->id_khoa_hoc = $id; 
        
      
        $khoaHoc = KhoaHoc::findOne($id);
        if ($khoaHoc) {
            $model->id_hang = $khoaHoc->id_hang;  
        }
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm Học viên ",
                    'content'=>$this->renderAjax('insert-hoc-vien', [
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
                               Html::a('Tiếp tục thêm',['insert-hoc-vien'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];         
            }else{           
                return [
                    'title'=> "Thêm Học viên",
                    'content'=>$this->renderAjax('insert-hoc-vien', [
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
                return $this->render('insert-hoc-vien', [
                    'model' => $model,
                ]);
            }
        }
    }


    public function actionInsertManyHocVien($id)
    {
        // Bắt buộc định dạng response là JSON
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        $khoaHoc = KhoaHoc::findOne($id);
        if ($khoaHoc === null) {
            throw new NotFoundHttpException('Khóa học không tồn tại.');
        }
    
        // Lấy danh sách học viên chưa được gán vào khóa học dựa theo id_hang của khóa học
        $hocVien = HocVien::find()
            ->where(['id_hang' => $khoaHoc->id_hang])
            ->andWhere(['id_khoa_hoc' => null])
            ->all();
    
        // Nếu là yêu cầu POST (tức khi form được submit qua AJAX)
        if (Yii::$app->request->isPost) {
            $selectedHocVienIds = Yii::$app->request->post('hoc_vien_ids', []);
            if (!empty($selectedHocVienIds)) {
                foreach ($selectedHocVienIds as $hocVienId) {
                    $hv = HocVien::findOne($hocVienId);
                    if ($hv !== null) {
                        $hv->id_khoa_hoc = $khoaHoc->id;
                        $hv->trang_thai = "NHAPTRUCTIEP";
                        // Lưu mà không cần chạy validate
                        $hv->save(false);
                    }
                }
            }
            // Sau khi cập nhật, truy vấn lại danh sách học viên chưa được thêm
            $hocVien = HocVien::find()
                ->where(['id_hang' => $khoaHoc->id_hang])
                ->andWhere(['id_khoa_hoc' => null])
                ->all();  
            return [
                'success' => true,
                'content' => $this->renderAjax('insert-many-hoc-vien', [
                    'hocVien' => $hocVien,
                    'khoaHoc' => $khoaHoc,
                ]),
                'message' => 'Thêm Học viên cho Khóa học thành công!'
            ];
        }
        
        return [
            'title' => 'Thêm học viên',
            'content' => $this->renderAjax('insert-many-hoc-vien', [
                'hocVien' => $hocVien,
                'khoaHoc' => $khoaHoc,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ])
        ];
    }
   
    public function actionAddGroup($id)
    {
        $request = Yii::$app->request;
        $model = new NhomHoc();  
     
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm nhóm học",
                    'content'=>$this->renderAjax('add-group', [
                        'model' => $model, 
                    ]),
                    'footer'=>
                                Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            } else if ($model->load($request->post())) {  
                $model->id_khoa_hoc = $id;
                if ($model->save()) {
                    $nhomHoc = NhomHoc::find()->where(['id_khoa_hoc' => $id])->all();
                    return [
                        'forceClose'=>true,   
                        'reloadType'=>'dsNhom',
                        'reloadBlock'=>'#dsNhomContent',
                        'reloadContent'=>$this->renderAjax('danh-sach-nhom', [
                            'nhomHoc' => $nhomHoc, 
                        ]),
                        'tcontent'=>'Thêm nhóm thành công!',
                    ];             
            }else{           
                return [
                    'title'=> "Thêm nhóm học",
                    'content'=>$this->renderAjax('add-group', [
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
                return $this->render('add-group', [
                    'model' => $model,
                 
                ]);
            }
        }
    }
    
}

public function actionDanhSachNhom($id)
{
    if (!$id || !is_numeric($id)) {
        return $this->asJson([
            'title' => 'Lỗi!',
            'content' => 'Khóa học không hợp lệ.',
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => 'modal'
            ]),
        ]);
    }
    $nhomHoc = NhomHoc::find()->where(['id_khoa_hoc' => $id])->all();
    return $this->asJson([
        'title' => 'Danh sách Nhóm',
        'content' => $this->renderAjax('danh-sach-nhom', [
            'nhomHoc' => $nhomHoc,
            'idKhoaHoc' => $id,
        ]),
        'footer' =>   Html::a('<i class="fa fa-plus"> </i> Thêm nhóm', 
        ['/khoahoc/khoa-hoc/add-group', 'id' => $id, 'modalType' => 'modal-remote-2'], 
          [
            'class' => 'btn btn-info',
            'role' => 'modal-remote-2',
            'title' => 'Danh sách Nhóm'
          ]
      ) .
            Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => 'modal'
        ]),
    ]);
}

public function actionDeleteNhom()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $id = Yii::$app->request->post('id');
    if (!$id || !is_numeric($id)) {
        return [
            'success' => false,
            'message' => 'ID không hợp lệ.',
        ];
    }

    $nhomHoc = NhomHoc::findOne($id);
    if (!$nhomHoc) {
        return [
            'success' => false,
            'message' => 'Nhóm không tồn tại.',
        ];
    }

    try {
        $nhomHoc->delete();
        return [
            'success' => true,
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Không thể xóa nhóm: ' . $e->getMessage(),
        ];
    }
}


public function actionUpdateNhom ($id)
{
    $request = Yii::$app->request;
    $model = HocVien:: find()->where(['id'=> $id])->one();
    $idKH= $model->id_khoa_hoc;
    $modelKH = KhoaHoc::find()->where(['id' => $idKH])->one();
    if ($request->isAjax) {
    Yii::$app->response->format = Response::FORMAT_JSON;
    if ($request->isGet) {
        return [
            'title' => "Đổi nhóm #".$id,
            'content' => $this->renderAjax('update_nhom', [
                'model' => $model,
            ]),
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
        ];
    } else if ($model->load($request->post()) && $model->save()) {
        return [
            'forceClose'=>true,   
            'reloadType'=>'nhomHoc',
            'reloadBlock'=>'#hvContent',
            'reloadContent'=>$this->renderAjax('_hoc_vien_list', [
                'modelKH' => $modelKH, 
                
            ]),
            'tcontent'=>'Đổi nhóm thành công!',
        ];
    } else {
        return [
            'title' => "Cập nhật Học phí #".$id,
            'content' => $this->renderAjax('update_nhom', [
                'model' => $model,
                
            ]),
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
        ];
    }
} else {
    
    
}
}


public function actionAddNhom ($id)//id học viên
{
    $request = Yii::$app->request;
    $model = HocVien:: find()->where(['id'=> $id])->one();
    $idKH= $model->id_khoa_hoc;
    $modelKH = KhoaHoc::find()->where(['id' => $idKH])->one();

    if ($request->isAjax) {
    Yii::$app->response->format = Response::FORMAT_JSON;
    if ($request->isGet) {
        return [
            'title' => "Đổi nhóm #".$id,
            'content' => $this->renderAjax('update_nhom', [
                'model' => $model,
            ]),
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
        ];
    } else if ($model->load($request->post()) && $model->save()) {
        return [
            'forceClose'=>true,   
            'reloadType'=>'nhomHoc',
            'reloadBlock'=>'#hvContent',
            'reloadContent'=>$this->renderAjax('_hoc_vien_list', [
                'modelKH' => $modelKH, 
                
            ]),
            'tcontent'=>'Thêm nhóm thành công!',
        ];
    } else {
        return [
            'title' => "Cập nhật Học phí #".$id,
            'content' => $this->renderAjax('update_nhom', [
                'model' => $model,
                
            ]),
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
        ];
    }
} else {
    

}
}

public function actionLoadSchedule($id_nhom)
{
    $data= LichHoc::find()->where(['id_nhom'=>$id_nhom])->all();
    return $this->renderPartial('_schedule_table', [
        'data' => $data,
    ]);
}

public function actionLoadScheduleWeek($week_string, $idKH, $id_nhom)
{
    if (preg_match('/Tuần \d+ \[(\d{2}\/\d{2}\/\d{4}) - (\d{2}\/\d{2}\/\d{4})\]/', $week_string, $matches)) {
        $dayBD = \DateTime::createFromFormat('d/m/Y', $matches[1])->format('Y-m-d');
        $dayKT = \DateTime::createFromFormat('d/m/Y', $matches[2])->format('Y-m-d');
        $listNhom = NhomHoc :: find()->where(['id_khoa_hoc'=>$idKH])->all();
        if (empty($id_nhom) && empty($listNhom)) {
            $data = LichHoc::find()
                ->where(['between', 'ngay', $dayBD, $dayKT]) 
                ->andWhere(['id_khoa_hoc' => $idKH]) 
                ->all();
        } else {
            $data = LichHoc::find()
            ->where(['between', 'ngay', $dayBD, $dayKT])
            ->andWhere(['id_khoa_hoc' => $idKH])
            ->andWhere(['or',
                ['id_nhom' => $id_nhom],
                ['id_nhom' => null]
            ])
            ->all();
        }
        return $this->renderPartial('_schedule_table', [
            'data' => $data,
            'id_nhom'=>$id_nhom,
            'idKH'=>$idKH,
            'week_string'=>$week_string,
        ]); 
    }
    throw new BadRequestHttpException('Chuỗi tuần không hợp lệ.');
}

public function actionUpdateLichHoc($id,$idKH,$week_string,$id_nhom)
    {
        $request = Yii::$app->request;
        if (preg_match('/Tuần \d+ \[(\d{2}\/\d{2}\/\d{4}) - (\d{2}\/\d{2}\/\d{4})\]/', $week_string, $matches)) {
            $dayBD = \DateTime::createFromFormat('d/m/Y', $matches[1])->format('Y-m-d');
            $dayKT = \DateTime::createFromFormat('d/m/Y', $matches[2])->format('Y-m-d');
        }
        $model = LichHoc::find()->where(['id' => $id])->one(); 
        $idKhoaHoc = $model->id_khoa_hoc;
        $giaoViens = GiaoVien::find()->all();
        $giaoVienList = \yii\helpers\ArrayHelper::map($giaoViens, 'id', 'ho_ten');
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
            $data = LichHoc::find()
            ->where(['between', 'ngay', $dayBD, $dayKT])
            ->andWhere(['id_khoa_hoc' => $idKH])
            ->andWhere(['or',
                ['id_nhom' => $id_nhom],
                ['id_nhom' => null]
            ])->all();
            return [
                'forceClose'=>true,   
                'reloadType'=>'lichHoc',
                'reloadBlock'=>'#lhContent',
                'reloadContent'=>$this->renderAjax('_schedule_table', [ 
                    'data'=>$data,
                    'week_string'=>$week_string,
                    'idKH'=>$idKH,
                    'id_nhom'=>$id_nhom, 
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

    public function actionCreateLichHocFromKhoaHoc ($id_khoa_hoc)
    {
        $request = Yii::$app->request;
        $model = new LichHoc();  
        $idKhoaHoc = $id_khoa_hoc;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
          
            if($request->isGet){
                return [
                    'title'=> "Thêm lịch học",
                    'content'=>$this->renderAjax('createLH', [
                        'model' => $model,
                        'idKhoaHoc'=>$idKhoaHoc,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else  if ($model->load($request->post())) { 
                $model->id_khoa_hoc=$idKhoaHoc;
                if ($model->save()) {
              
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm lịch học",
                    'content'=>'<span class="text-success">Thêm lịch học thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['createLH'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];         
            }else{           
                return [
                    'title'=> "Thêm lịch học",
                    'content'=>$this->renderAjax('createLH', [
                        'model' => $model,
                        'idKhoaHoc'=>$idKhoaHoc,
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
                return $this->render('createLH', [
                    'model' => $model,
                    'idKhoaHoc'=>$idKhoaHoc,
                ]);
            }
        }
    }
}

    public function actionGetNhomList($id_khoa_hoc)
    {
        $nhoms = NhomHoc::find()->where(['id_khoa_hoc' => $id_khoa_hoc])->all();
        if (empty($nhoms)) {
            return json_encode(['no_nhom' => 'Trống']);
        }
        $listNhom = ArrayHelper::map($nhoms, 'id', 'ten_nhom');
        return json_encode($listNhom);
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
    
    public function actionGetPhieuInAjax($id,$type)
    {
        $modelKH = KhoaHoc::find()->where(['id'=>$id])->one();
        $tenKH = $modelKH->ten_khoa_hoc;
        $ngayBD = $modelKH->ngay_bat_dau;
        $ngayKT = $modelKH->ngay_ket_thuc;
        $start = new DateTime($ngayBD);
        $end = new DateTime($ngayKT);
        $startFormatted = $start->format('d/m/Y');
        $endFormatted = $end->format('d/m/Y');
        if ($type === 'lichhoc') {
            $content = $this->renderPartial('_in_lich_hoc', ['tenKH' => $tenKH,'startFormatted'=>$startFormatted ,'endFormatted'=>$endFormatted]);
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


    public function actionCreateLichThi($id)
    {
        $request = Yii::$app->request;
        $model = new LichThi();  
        $idKH = $id;
        $modelKH = KhoaHoc::find()->where(['id'=>$id])->one();
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm Lịch thi",
                    'content'=>$this->renderAjax('create_LT', [
                        'model' => $model,
                        'idKH'=>$idKH,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceClose'=>true,   
                    'reloadType'=>'lichThi',
                    'reloadBlock'=>'#ltContent',
                    'reloadContent'=>$this->renderAjax('_exsche', [
                        'modelKH'=>$modelKH,
                    ]),
                    
                    'tcontent'=>'Thêm lịch thi thành công!',
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create_LT', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    public function actionGroupDetails($id)
    {
        $nhomHoc = NhomHoc::findOne($id);
        if (!$nhomHoc) {
            return $this->asJson([
                'title' => 'Lỗi!',
                'content' => '<p>Nhóm học không tồn tại.</p>',
                'footer' => Html::button('Đóng lại', [
                    'class' => 'btn btn-default pull-left',
                    'data-bs-dismiss' => "modal"
                ])
            ]);
        }
    
        $hocVienTrongNhom = HocVien::find()->where(['id_nhom' => $id])->all();
        $hocVienChuaCoNhom = HocVien::find()
            ->where(['id_nhom' => null, 'id_khoa_hoc' => $nhomHoc->id_khoa_hoc])
            ->all();
    
        return $this->asJson([
            'title' => 'Chi tiết nhóm học: ' . $nhomHoc->ten_nhom,
            'content' => $this->renderAjax('group-details', [
                'nhomHoc' => $nhomHoc,
                'hocVienTrongNhom' => $hocVienTrongNhom,
                'hocVienChuaCoNhom' => $hocVienChuaCoNhom,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ])
        ]);
    }

    public function actionDetailsKetQuaThi ($id)
    {
        $model = HocVien::find()->where(['id'=>$id])->one();
        return $this->asJson([
            'title' => 'Chi tiết',
            'content' => $this->renderAjax('ket-qua-thi-hv', [
                 'model'=>$model,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ])
        ]);
    }

    public function actionAddStudentsToGroup($id_nhom)
    {
        $nhomHoc = NhomHoc::findOne($id_nhom);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $selectedHocVien = Yii::$app->request->post('selected_hoc_vien', []);
        $response = ['status' => 'error', 'message' => 'Vui lòng chọn ít nhất một học viên.'];
    
        if ($nhomHoc) {
            $soLuongChoPhep = $nhomHoc->so_luong_hoc_vien;
            $soLuongTrongNhom = HocVien::find()->where(['id_nhom' => $id_nhom])->count(); 
            $soLuongMuonThem = count($selectedHocVien);
    
            if (($soLuongTrongNhom + $soLuongMuonThem) > $soLuongChoPhep) {
                return [
                    'status' => 'error',
                    'message' => 'Số lượng học viên vượt quá số lượng cho phép của nhóm (' . $soLuongChoPhep . ').',
                ];
            }
    
            if (!empty($selectedHocVien)) {
                foreach ($selectedHocVien as $hocVienId) {
                    $hocVien = HocVien::findOne($hocVienId);
                    if ($hocVien) {
                        $hocVien->id_nhom = $id_nhom;
                        $hocVien->save(false);
                    }
                }
    
                // Cập nhật danh sách học viên sau khi thêm
                $hocVienTrongNhom = HocVien::find()->where(['id_nhom' => $id_nhom])->all();
                $hocVienChuaCoNhom = HocVien::find()
                    ->where(['id_nhom' => null, 'id_khoa_hoc' => $nhomHoc->id_khoa_hoc])
                    ->all();
                $totalTrongNhom = count($hocVienTrongNhom);
    
                $response = [
                    'status' => 'success',
                    'message' => 'Đã bổ sung học viên vào nhóm.',
                    'content' => $this->renderPartial('_group_details', [
                        'hocVienTrongNhom' => $hocVienTrongNhom,
                        'hocVienChuaCoNhom' => $hocVienChuaCoNhom,
                        'totalTrongNhom' => $totalTrongNhom,
                        'nhomHoc' => $id_nhom,
                    ]),
                ];
            }
        }
    
        return $response;
    }
    
    public function actionUpdateNhomHoc ($id)
    {
        $request = Yii::$app->request;
        $model = NhomHoc:: find()->where(['id'=> $id])->one();
        if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => "Cập nhật chi tiết nhóm #".$id,
                'content' => $this->renderAjax('update_chi_tiet_nhom', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else if ($model->load($request->post()) && $model->save()) {
            $nhomHoc = NhomHoc::find()->where(['id_khoa_hoc'=>$model->id_khoa_hoc])->all();
            return [
                'forceClose'=>true,   
                'reloadType'=>'chitietNhom',
                'reloadBlock'=>'#dsNhomContent',
                'reloadContent'=>$this->renderAjax('danh-sach-nhom', [
                    'nhomHoc' => $nhomHoc, 
                    
                ]),
                'tcontent'=>'Cập nhật thành công!',
            ];
        } else {
            return [
                'title' => "Cập nhật Nhóm #".$id,
                'content' => $this->renderAjax('update_chi_tiet_nhom', [
                    'model' => $model,
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {    
    }
    }

}