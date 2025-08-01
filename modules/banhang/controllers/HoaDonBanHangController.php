<?php

namespace app\modules\banhang\controllers;

use Yii;
use app\modules\banhang\models\HoaDon;
use app\modules\banhang\models\search\HoaDonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * HoaDonBanHangController implements the CRUD actions for HoaDon model.
 */
class HoaDonBanHangController extends Controller
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
	 * load hoa don in
	 * @return mixed
	 */
	public function actionGetPhieuXuatKhoInAjax($idHoaDon)
	{
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $model = HoaDon::findOne($idHoaDon);
	    if($model !=null){
	        return [
	            'status'=>'success',
	            'content' => $this->renderAjax('_print_phieu', [
	                'model' => $model
	            ])
	        ];
	    } else {
	        return [
	            'status'=>'failed',
	            'content' => 'Phiếu xuất kho không tồn tại!'
	        ];
	    }
	}
	
	/**
	 * xuat hoa don va thanh toan
	 */
	public function actionXuatVaThanhToan($id){
	    $request = Yii::$app->request;
	    $model = $this->findModel($id);
	    $trangThaiHienTai = $model->trang_thai;
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $model->trang_thai = HoaDon::TRANGTHAI_DA_TT;
	    $model->so_vao_so = $model->getSoHoaDonCuoi($model->nam) + 1;
	    $model->so_don_hang = $model->getSoDonHangCuoi() + 1;
	    $model->ngay_xuat = date('Y-m-d H:i:s');
	    if($model->save()){
	        $model->refresh();
	        if($trangThaiHienTai == HoaDon::TRANGTHAI_NHAP){
	            $model->xuatHang();
	        }
	        
	        return [
	            'forceReload'=>'#crud-datatable-pjax',
	            'title'=> "Cập nhật Hóa đơn",
	            'content'=>$this->renderAjax('update', [
	                'model' => $model,
	            ]),
	            'tcontent'=>'Xuất và thanh toán thành công!',
	            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
	            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
	        ];
	    }
	    
	    
	}

    /**
     * Lists all HoaDon models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HoaDonSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new HoaDonSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single HoaDon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Hóa đơn",
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
     * Creates a new HoaDon model.
     * $loai is loai khach hang
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($loai=NULL)
    {
        $request = Yii::$app->request;
        $model = new HoaDon();  
        $model->loai_khach_hang = $loai;
        $tieuDe = '';
        if($loai == HoaDon::LOAI_HOCVIEN)
            $tieuDe = ' (Học viên của Trung tâm)';
        if($loai == HoaDon::LOAI_KHACHLE)
            $tieuDe = ' (Khách ngoài Trung tâm)';

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới hóa đơn" .$tieuDe,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                /* return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới hóa đơn".$tieuDe,
                    'content'=>'<span class="text-success">Thêm mới thành công</span>',
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];  */
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Cập nhật hóa đơn".$tieuDe,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]) . Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];      
            }else{           
                return [
                    'title'=> "Thêm mới hóa đơn".$tieuDe,
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
     * Updates an existing HoaDon model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);  
        if($model->loai_khach_hang == HoaDon::LOAI_HOCVIEN)
            $tieuDe = ' (Học viên của Trung tâm)';
        if($model->loai_khach_hang == HoaDon::LOAI_KHACHLE)
            $tieuDe = ' (Khách ngoài Trung tâm)';

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật hóa đơn".$tieuDe,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                ($model->trang_thai==HoaDon::TRANGTHAI_NHAP?Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]):'')
                ];         
            }else if($model->load($request->post()) && $model->save()){
            	/* if(Yii::$app->params['showView']){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Hóa đơn",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Cập nhật thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];    
                }else{
                	return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax','tcontent'=>'Cập nhật thành công!',];
                } */
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'tcontent'=>'Cập nhật thành công!',
                    'title'=> "Cập nhật hóa đơn".$tieuDe,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    ($model->trang_thai==HoaDon::TRANGTHAI_NHAP?Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]):'')
                ];   
            }else{
                 return [
                    'title'=> "Cập nhật hóa đơn".$tieuDe,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                     ($model->trang_thai==HoaDon::TRANGTHAI_NHAP?Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]):'')
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
     * Delete an existing HoaDon model.
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
     * Delete multiple existing HoaDon model.
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
     * Finds the HoaDon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HoaDon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HoaDon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
