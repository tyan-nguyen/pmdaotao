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
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class DangKyHvController extends Controller
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
	    Yii::$app->params['modelID'] = 'Đăng ký học';
	    return true;
	}
    /**
     * Lists all HvHocVien models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new DangKyHvSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['trang_thai' => ['CHUA_NHAP_HOC']]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
                'title'=> "Học viên  #".$id,
                'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                          Html::a('Xuất PDF',['export-pdf','id'=>$id],['class'=>'btn btn-primary', 'target' => '_blank']) // Mở trong tab mới hoặc tải xuống trực tiếp
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
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm học viên",
                    'content'=>'<span class="text-success">Create HvHocVien success</span>',
                    'footer'=> Html::button('<i class="fa fa-close"> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm học viên",
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
                    'footer'=> Html::button('<i class="fa fa-close"> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-save"> Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Học viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật học viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-save"> Save',['class'=>'btn btn-primary','type'=>"submit"])
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
 public function actionExportPdf($id)
{
    $model = $this->findModel($id);
    
    // Lấy nội dung từ view _pdf.php
    $content = $this->renderPartial('view', [
        'model' => $model,
    ]);

    $pdf = new \kartik\mpdf\Pdf([
        'mode' => \kartik\mpdf\Pdf::MODE_UTF8,
        'format' => [210, 210], // Đặt kích thước trang (148mm x 210mm tương đương A5)
        'content' => $content,
        'options' => [
            'title' => 'Thông tin học viên đăng ký',
            'subject' => 'Xuất PDF thông tin học viên',
        ],
        'methods' => [
            'SetHeader' => ['Thông tin học viên đăng ký'],
            'SetFooter' => [''],
            //'SetFooter' => ['{PAGENO}'],
        ],
        'marginTop' => 20, // Cài đặt lề trên
        'marginBottom' => 20, // Cài đặt lề dưới
        'marginLeft' => 10, // Cài đặt lề trái
        'marginRight' => 10, // Cài đặt lề phải
    ]);
    

    // Đặt tên file PDF sẽ tải về
    $pdf->filename = 'ThongTinHocVien_' . $model->id . '.pdf';

    // Gửi file PDF trực tiếp tới người dùng và tải xuống
    return $pdf->render();
}

    
public function actionCreate2($id)
{
    $request = Yii::$app->request;
    $model = new NopHocPhi();  
    $model->id_hoc_vien = $id;
     // Tìm học viên theo id_hoc_vien
     $hocVien = HocVien::findOne($id);
     $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';
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
                ]),
                'footer'=> Html::button(' <i class="fa fa-close"></i> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('<i class="fa fa-save"></i> Save',['class'=>'btn btn-primary','type'=>"submit"])
    
            ];         
        }else if($model->load($request->post()) && $model->save()){
            if ($hocVien) {
                $hocVien->trang_thai = 'NHAP_HOC'; // Cập nhật trạng thái
                $hocVien->save(); // Lưu thay đổi
            }
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin học phí",
                'content'=>'<span class="text-success">Create HocPhi success</span>',
                'footer'=> Html::button('<i class="fa fa-close"></i> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::a('Create More',['create2'],['class'=>'btn btn-primary','role'=>'modal-remote'])
    
            ];         
        }else{           
            return [
                'title'=> "Thông tin học phí",
                'content'=>$this->renderAjax('create2', [
                    'model' => $model,
                    'hoTenHocVien' => $hoTenHocVien,
                ]),
                'footer'=> Html::button('<i class="fa fa-close"></i> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('<i class="fa fa-save"></i> Save',['class'=>'btn btn-primary','type'=>"submit"])
    
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
            ]);
        }
    }
   
}
}
