<?php

namespace app\modules\daotao\controllers;

use Yii;
use app\modules\daotao\models\TietHoc;
use app\modules\daotao\models\search\TietHocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\daotao\models\KeHoach;
use app\modules\daotao\models\DmThoiGian;
use app\modules\daotao\models\HangMonHoc;
use app\modules\hocvien\models\HocVien;
use yii\helpers\ArrayHelper;
use app\modules\thuexe\models\Xe;
use app\modules\user\models\User;

/**
 * TietHocController implements the CRUD actions for TietHoc model.
 */
class TietHocController extends Controller
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
	 * get list mon hoc cua hoc vien
	 * @param unknown $country_id
	 * @return unknown[]
	 */
	public function actionGetListMonHocByHocVien($hocvien_id) {
	    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	    $hocVien = HocVien::findOne($hocvien_id);
	    $query = HangMonHoc::find()->alias('t')
	    ->andFilterWhere(['t.id_hang' => $hocVien->id_hang])
	    ->limit(20)
	    ->all();
	    
	    $results = [];
	    foreach ($query as $item) {
	        $results[] = [
	            'id' => $item->id_mon,
	            'text' => $item->mon->ten_mon . ($item->mon->ten_mon_sub?' ('.$item->mon->ten_mon_sub.')':''),
	        ];
	    }
	    return ['results' => $results];
	    
	    /* return ArrayHelper::map($query, 'id_mon', function ($model) {
	        return '+ ' . $model->mon->ten_mon . ($model->mon->ten_mon_sub?' ('.$model->mon->ten_mon_sub.')':'');
	    }); */
	}

    /**
     * Lists all TietHoc models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new TietHocSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new TietHocSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionGetHocVienFromKeHoachAjax($idhv){
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        return [
            'status' => 'success',
            'content' => $this->renderAjax('_viewHocVienFromKeHoach', [
                'model' => $this->findModel($id),
            ]),
        ];
    }


    /**
     * Displays a single TietHoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "TietHoc",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new TietHoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new TietHoc();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới TietHoc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới TietHoc",
                    'content'=>'<span class="text-success">Thêm mới thành công</span>',
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới TietHoc",
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
     * copy an existing TietHoc model FROM KEHOACH.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCopyFromKeHoach($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model &&
                (($model->keHoach->trang_thai_duyet==KeHoach::TT_NHAP || $model->keHoach->trang_thai_duyet==KeHoach::TT_KHONGDUYET)
                    && ($model->nguoi_tao == Yii::$app->user->id))  || User::hasRole('Admin')
                ){
                    //kiem tra gio tiếp theo có chưa
                    $tietHoc = TietHoc::find()->where([
                        'id_thoi_gian_hoc'=>($model->id_thoi_gian_hoc+1),
                        'id_hoc_vien'=>$model->id_hoc_vien,
                        'id_ke_hoach'=>$model->id_ke_hoach
                    ])->exists();
                    if(!$tietHoc){
                        $tietHocNew = new TietHoc();
                        $time = DmThoiGian::findOne($model->id_thoi_gian_hoc+1);
                        if($time){
                            $tietHocNew->id_ke_hoach = $model->id_ke_hoach;
                            $tietHocNew->id_giao_vien = $model->id_giao_vien;
                            $tietHocNew->id_thoi_gian_hoc = $time->id;
                            $tietHocNew->id_xe = $model->id_xe;
                            $tietHocNew->id_hoc_vien = $model->id_hoc_vien;
                            $tietHocNew->id_mon_hoc = $model->id_mon_hoc;
                            $tietHocNew->trang_thai = TietHoc::TT_CHUATHUCHIEN;
                            $tietHocNew->so_gio = $time->so_gio;
                            $tietHocNew->thoi_gian_bd = $model->keHoach->ngay_thuc_hien . ' ' . $time->thoi_gian_bd;
                            $tietHocNew->thoi_gian_kt = $model->keHoach->ngay_thuc_hien . ' ' . $time->thoi_gian_kt;
                            if($tietHocNew->save()){
                                return [
                                    'forceClose'=>true,
                                    'title'=> "Sao chép giờ học",
                                    'content'=>'<span class="text-success">Sao chép thành công!</span>',
                                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]),
                                    'reloadType'=>'gioHoc',
                                    'reloadBlock'=>'#gioHocContent',
                                    'reloadContent'=>$this->renderAjax('_viewFromKeHoach', [
                                        'model' => KeHoach::findOne($model->id_ke_hoach),
                                    ]),
                                    'tcontent'=>'Sao chép giờ học thành công!',
                                ];
                            } else {
                                return [
                                    'forceClose'=>true,
                                    'title'=> "Sao chép giờ học",
                                    'content'=>'<span class="text-warning">Không thể sao chép giờ học!</span>',
                                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]),
                                    'tcontent'=>'Không thể sao chép giờ học!',
                                ];
                            }
                        } else {
                            return [
                                'forceClose'=>true,
                                'title'=> "Sao chép giờ học",
                                'content'=>'<span class="text-warning">Thời gian không hợp lệ!</span>',
                                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]),
                                'tcontent'=>'Thời gian không hợp lệ!',
                                'forceClose'=>true,
                            ];
                        }
                        
                    }else {
                        return [
                            'forceClose'=>true,
                            'title'=> "Sao chép giờ học",
                            'content'=>'<span class="text-warning">Thời gian tiếp theo đã tồn tại!</span>',
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]),
                            'tcontent'=>'Thời gian tiếp theo đã tồn tại, không thể sao chép tiếp',
                        ];
                    }
            } else {
                return [
                    'forceClose'=>true,
                    'title'=> "Sao chép giờ học",
                    'content'=>'<span class="text-warning">Không thể sao chép!</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]),
                    'tcontent'=>'Không thể sao chép! Vui lòng kiểm tra lại!',
                    
                ];
            }
        }
    }
    
    
    /**
     * Creates a new Tiet hoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateFromKeHoach($idkh,$idtime)
    {
        $request = Yii::$app->request;
        $model = new TietHoc();
        
        if ($idkh != null) {
            $keHoach = KeHoach::findOne($idkh);
            $time = DmThoiGian::findOne($idtime);
            $model->id_ke_hoach = $idkh;
            $model->id_giao_vien = $keHoach->id_giao_vien;
            $model->id_thoi_gian_hoc = $idtime;
            
            $model->so_gio = $time->so_gio;
            $model->thoi_gian_bd = $keHoach->ngay_thuc_hien . ' ' . $time->thoi_gian_bd;
            $model->thoi_gian_kt = $keHoach->ngay_thuc_hien . ' ' . $time->thoi_gian_kt;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới giờ học",
                    'content'=>$this->renderAjax('_formFromKeHoach', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    
                ];
            }else if($model->load($request->post())){
                /**
                 * check học viên
                 */
                if($model->id_hoc_vien){
                    $tietHoc = TietHoc::find()->alias('t')->joinWith(['keHoach as kh'])->where([
                        't.id_thoi_gian_hoc'=>$idtime, 
                        't.id_hoc_vien'=>$model->id_hoc_vien,
                        'kh.ngay_thuc_hien'=>$keHoach->ngay_thuc_hien
                    ])->one();
                    if($tietHoc != null){
                        $model->addError('id_hoc_vien', 'Lỗi: Học viên đã được chọn theo khung giờ này trong kế hoạch khác!');
                        return [
                            'title'=> "Thêm mới giờ học",
                            'content'=>$this->renderAjax('_formFromKeHoach', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                            
                        ];
                    }
                }
                /**
                 * check xe
                 */
                if($model->id_xe){
                    //check xe có khả dụng không
                    $xe = Xe::findOne($model->id_xe);
                    if($xe != null && ($xe->tinh_trang_xe != Xe::XE_BINHTHUONG || $xe->trang_thai != 'Khả dụng') ){
                        $model->addError('id_xe', 'Lỗi chọn xe: Xe đang hư hỏng, bảo trì hoặc không khả dụng!');
                        return [
                            'title'=> "Thêm mới giờ học",
                            'content'=>$this->renderAjax('_formFromKeHoach', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                            
                        ];
                    }
                    //check xe có rảnh không
                    $tietHoc = TietHoc::find()->alias('t')->joinWith(['keHoach as kh'])->where([
                        't.id_thoi_gian_hoc'=>$idtime, 
                        't.id_xe'=>$model->id_xe,
                        'kh.ngay_thuc_hien'=>$keHoach->ngay_thuc_hien
                    ])->one();
                    if($tietHoc != null){
                        $model->addError('id_xe', 'Lỗi chọn xe: Xe đã được lên kế hoạch cho khung giờ này!');
                        return [
                            'title'=> "Thêm mới giờ học",
                            'content'=>$this->renderAjax('_formFromKeHoach', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                            
                        ];
                    }
                }
                
                if($model->save()){
                    $tietHocOk = TietHoc::getSoTietHocByMonOfHocVien($model->id_hoc_vien, $model->id_mon_hoc);
                    $soLuongGioHoc = $model->monHoc->so_gio_tt;
                    $message = 'Thêm giờ học thành công!';
                    if($tietHocOk>=$soLuongGioHoc){
                        $message = '<span style="color:red"><strong>Cảnh báo số giờ học của học viên lớn hơn số giờ được cấu hình ('.$tietHocOk.'/'.$soLuongGioHoc.')!</strong></span>';
                        return [
                            'title'=> "Thêm mới giờ học",
                            'content'=>$message,
                            'reloadType'=>'gioHoc',
                            'reloadBlock'=>'#gioHocContent',
                            'reloadContent'=>$this->renderAjax('_viewFromKeHoach', [
                                'model' => KeHoach::findOne($idkh),
                            ]),
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                            
                        ];
                    }
                    return [
                        'forceClose'=>true,
                        'reloadType'=>'gioHoc',
                        'reloadBlock'=>'#gioHocContent',
                        'reloadContent'=>$this->renderAjax('_viewFromKeHoach', [
                            'model' => KeHoach::findOne($idkh),
                        ]),                    
                        'tcontent'=>$message,
                    ];
                }else{
                    return [
                        'title'=> "Thêm mới giờ học",
                        'content'=>$this->renderAjax('_formFromKeHoach', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                        
                    ];
                }
            }else{
                return [
                    'title'=> "Thêm mới giờ học",
                    'content'=>$this->renderAjax('_formFromKeHoach', [
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
     * Updates an existing TietHoc model.
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
                    'title'=> "Cập nhật TietHoc",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
            	if(Yii::$app->params['showView']){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "TietHoc",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Cập nhật thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];    
                }else{
                	return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax','tcontent'=>'Cập nhật thành công!',];
                }
            }else{
                 return [
                    'title'=> "Cập nhật TietHoc",
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
     * Updates an existing HangMonHoc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateFromKeHoach($id)
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
                    'title'=> "Cập nhật giờ học",
                    'content'=>$this->renderAjax('_formFromKeHoach', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post())){
                //check time
                if($model->trang_thai == TietHoc::TT_DAHOANTHANH || $model->trang_thai == TietHoc::TT_HOCVIENHUY){
                    $mocTime = $model->thoi_gian_kt;
                    if(date('Y-m-d H:i:s') < $mocTime){
                        $model->addError('trang_thai', 'Không thể cập nhật trạng thái do thời gian chưa đến!');
                        return [
                            'title'=> "Cập nhật giờ học",
                            'content'=>$this->renderAjax('_formFromKeHoach', [
                                'model' => $model,
                            ]),
                            'tcontent'=>'Giờ học chưa hoàn thành do thời gian chưa đến!',
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                        ];
                    }
                }
                if($model->save()){
                    return [
                        'forceClose'=>true,
                        'reloadType'=>'gioHoc',
                        'reloadBlock'=>'#gioHocContent',
                        'reloadContent'=>$this->renderAjax('_viewFromKeHoach', [
                            'model' => KeHoach::findOne($model->id_ke_hoach),
                        ]),
                        
                        'tcontent'=>'Cập nhật giờ học thành công!',
                    ];
                }else{
                    return [
                        'title'=> "Cập nhật giờ học",
                        'content'=>$this->renderAjax('_formFromKeHoach', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    ];
                }
            }else{
                return [
                    'title'=> "Cập nhật giờ học",
                    'content'=>$this->renderAjax('_formFromKeHoach', [
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
     * Delete an existing TietHoc model.
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
     * Delete an existing TietHoc model FROM KEHOACH.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteFromKeHoach($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model &&
                (($model->keHoach->trang_thai_duyet==KeHoach::TT_NHAP || $model->keHoach->trang_thai_duyet==KeHoach::TT_KHONGDUYET)
                    && ($model->nguoi_tao == Yii::$app->user->id)) || User::hasRole('Admin') 
             ){
                $model->delete();
                return [
                    'forceClose'=>true,
                    'reloadType'=>'gioHoc',
                    'reloadBlock'=>'#gioHocContent',
                    'reloadContent'=>$this->renderAjax('_viewFromKeHoach', [
                        'model' => KeHoach::findOne($model->id_ke_hoach),
                    ]),
                    'tcontent'=>'Xóa giờ học thành công!',
                ];
                              
            } else {                
                return [
                    'forceClose'=>true,
                    'tcontent'=>'Không thể xóa',
                ];  
            }
        }
    }

     /**
     * Delete multiple existing TietHoc model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        $delOk = true;
        $fList = array();
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            try{
            	$model->delete();
            }catch(\Exception $e) {
            	$delOk = false;
            	$fList[] = $model->id;
            }
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax',
            			'tcontent'=>$delOk==true?'Xóa thành công!':('Không thể xóa:'.implode('</br>', $fList)),
            ];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the TietHoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TietHoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TietHoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
