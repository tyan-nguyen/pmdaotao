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
        
        // Tạo ActiveDataProvider với phân trang
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        // Lọc theo trạng thái học viên 'NHAP_HOC' và 'NHAPTRUCTIEP'
        $dataProvider->query->andWhere(['trang_thai' => ['NHAP_HOC','NHAPTRUCTIEP']]);
    
        // Cấu hình phân trang 
       //  $pagination = $dataProvider->getPagination();
        // $pagination->pageSize = 20;
    
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
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Học viên #".$id,
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
   

     // Tìm học viên theo id_hoc_vien
     $hocVien = HocVien::findOne($id);
     $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';
     if ($hocVien && $hocVien->hang) {
        $tenHang = $hocVien->hang->ten_hang; // Lấy ten_hang từ bảng hang_xe
    } else {
        $tenHang = 'Chưa có hạng xe'; // Nếu không có thông tin hạng xe
    }
     // Kiểm tra nếu học viên tồn tại và lấy thông tin học phí dựa trên id_hang
     $hocPhi = null;
     if ($hocVien) {
        $khoaHoc = $hocVien->khoaHoc;  // Lấy đối tượng KhoaHoc liên kết
        if ($khoaHoc && $khoaHoc->id_hoc_phi) {
            // Truy vấn bảng HocPhi dựa trên id_hoc_phi của KhoaHoc
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
                $hocVien->trang_thai = 'NHAP_HOC'; // Cập nhật trạng thái
                $hocVien->save(); // Lưu thay đổi
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
    $model = $this->findModel($id);

    if ($request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Lưu trữ id_khoa_hoc trước khi cập nhật
        $oldKhoaHocId = $model->id_khoa_hoc;
        
        // Cập nhật id_khoa_hoc = null
        $model->id_khoa_hoc = null;

        // Nếu lưu thành công
        if ($model->save()) {
            // Lấy lại danh sách học viên theo id_khoa_hoc trước khi cập nhật
            $datas = HocVien::find()->where(['id_khoa_hoc' => $oldKhoaHocId])->all();
            
            return [
                'forceClose' => true,
                'forceReload' => '#hocVienTable', // Chọn đúng block để reload lại bảng học viên
                'reloadContent' => $this->renderAjax('xem_hv', [
                    'datas' => $datas,  // Truyền đúng dữ liệu
                    'isEmpty' => empty($datas),  // Kiểm tra mảng rỗng
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


}
