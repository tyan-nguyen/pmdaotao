<?php

namespace app\modules\thuexe\controllers;

use Yii;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\search\XeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\modules\thuexe\models\HinhXe;
use app\custom\CustomFunc;

/**
 * XeController implements the CRUD actions for Xe model.
 */
class XeController extends Controller
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
     * Lists all Xe models.
     * @return mixed
     */
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý thuê xe';
	    Yii::$app->params['modelID'] = 'Danh sách Xe';
	    //disable crsf for action upload images
	    if ($action->id === 'upload-images') {
	        $this->enableCsrfValidation = false;
	    }
	    return parent::beforeAction($action);
	}

    public function actionIndex()
    {    
        $searchModel = new XeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * cập nhật giáo viên phụ trách xe
     * tham số: $id -> id xe
     */
    public function actionPhanCongGiaoVien($id){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Xe::findOne($id);
        //$model->scenario = 'phan-cong-giao-vien';
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Xe không tồn tại!',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isAjax){
            if($request->isGet){
                return [
                    'title'=> "Phân công giáo viên phụ trách xe",
                    'content'=>$this->renderAjax('_formGiaoVien', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Lưu lại',['type'=>'submit','class'=>'btn btn-primary']). '&nbsp;'
                    .Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post())){
                if($model->id_giao_vien && $model->validate('id_giao_vien')){
                    $model->updateAttributes(['id_giao_vien']);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'forceClose'=>true,
                        'tcontent'=>'Phân công giáo viên phụ trách thành công!',
                    ];
                }else{
                    $model->updateAttributes(['id_giao_vien']);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'forceClose'=>true,
                        'tcontent'=>'Xóa thông tin giáo viên phụ trách thành công!',
                    ];
                }
                
            }else{
                return [
                    'title'=> "Phân công giáo viên phụ trách xe",
                    'content'=>$this->renderAjax('_formGiaoVien', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Lưu lại',['type'=>'submit','class'=>'btn btn-primary']). '&nbsp;'
                    .Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }
        }//if isAjax
    }


    /**
     * Displays a single Xe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Xe ".$model->bien_so_xe,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
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
     * Creates a new Xe model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
     public function actionCreate()
     {
         $request = Yii::$app->request;
         $model = new Xe();  
 
         if($request->isAjax){
             /*
             *   Process for ajax request
             */
             Yii::$app->response->format = Response::FORMAT_JSON;
             if($request->isGet){
                 return [
                     'title'=> "Thêm mới Xe",
                     'content'=>$this->renderAjax('create', [
                         'model' => $model,
                     ]),
                     'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                 Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
         
                 ];         
             }else if($model->load($request->post()) && $model->save()){
                 return [
                     'forceReload'=>'#crud-datatable-pjax',
                     'title'=> "Thêm mới Xe",
                     'content'=>'<span class="text-success">Thêm mới Xe thành công !</span>',
                     'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                             Html::a('Tiếp tục tạo',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
         
                 ];         
             }else{           
                 return [
                     'title'=> "Thêm mới Xe",
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
     * Updates an existing Xe model.
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
                    'title'=> "Cập nhật Xe #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=>     Html::a('<i class="fa fa-image"> </i> Hình xe', 
                    ['/thuexe/xe/delete-image', 'id' => $id, 'modalType' => 'modal-remote-2'], 
                       [
                         'class' => 'btn btn-info',
                         'role' => 'modal-remote-2',
                         'title' => 'Cập nhật Hình'
                       ]
                 ) .
                                Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Xe #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật Xe #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=>   
                                Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
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
     * Delete an existing Xe model.
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
     * Delete multiple existing Xe model.
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
     * Finds the Xe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Xe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Xe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAddImages($id) // $id là id của xe hiện tại
    {
        if (Yii::$app->request->isPost) {
            $model = new HinhXe();
            $model->id_xe = $id;
            $uploadedFile = UploadedFile::getInstanceByName('file');
    
            if ($uploadedFile) {
                $filePath = 'images/' . uniqid() . '.' . $uploadedFile->extension;
                if ($uploadedFile->saveAs($filePath)) {
                    $model->hinh_anh = $filePath;
                    $model->save();
                    if ($model->save()) {
                        return $this->asJson(['success' => true, 'message' => 'Hình ảnh đã được tải lên thành công!']);
                    }
                }
            }
    
            return $this->asJson(['success' => false, 'message' => 'Tải lên thất bại!']);
        }
    
        return $this->asJson([
            'title' => 'Thêm hình ảnh',
            'content' => $this->renderAjax('add-image', [
                'id' => $id,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ])
        ]);
    }

    public function actionAddImage($id)
    {
        $request = Yii::$app->request;
        $model = new HinhXe(); 
        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm ảnh Xe",
                    'content' => $this->renderAjax('add-image', [
                        'id' => $id, 
                        'images' => $this->getUploadedImages($id), 
                    ]),
                    'footer' => Html::button('Đóng lại', [
                            'class' => 'btn btn-default pull-left',
                            'data-bs-dismiss' => "modal",
                        ]) .
                        Html::button('Lưu lại', [
                            'class' => 'btn btn-primary',
                            'type' => "button",
                            'onclick' => 'saveSelectedImages()',
                        ]),
                ];
            } elseif ($request->isPost) {
                
                $selectedImages = $request->post('selectedImages'); 
    
                if (!empty($selectedImages)) {
                    foreach ($selectedImages as $fileName) {
                        $hinhXeModel = new HinhXe();
                        $hinhXeModel->id_xe = $id;
                        $hinhXeModel->hinh_anh = $fileName;
                        
                        $src = Yii::getAlias('@webroot') . '/images/temp/' . $fileName;
                        $dest = Yii::getAlias('@webroot') . '/images/hinh-xe/' . $fileName;
                        //nếu move thành công thì lưu
                        if(CustomFunc::moveOrCopy($src, $dest)){
                            if (!$hinhXeModel->save()) {
                                return [
                                    'success' => false,
                                    'message' => 'Lỗi khi lưu ảnh vào cơ sở dữ liệu: ' . implode(', ', $hinhXeModel->getErrorSummary(true)),
                                ];
                            }
                        }
                    }
                    return [
                        'success' => true,
                        'message' => 'Thêm ảnh thành công!',
                        'forceReload' => '#crud-datatable-pjax', // Làm mới bảng dữ liệu
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Vui lòng chọn ít nhất một ảnh.',
                    ];
                }
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('add-image', [
                    'model' => $model,
                    'id' => $id,
                ]);
            }
        }
    }
    
    

protected function getUploadedImages($id)
{
    $tempDir = Yii::getAlias('@webroot/images/temp');
    $uploadedImages = [];

  
    if (is_dir($tempDir)) {
        $files = scandir($tempDir);  
        foreach ($files as $file) {
          
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) {
                $uploadedImages[] = $file;
            }
        }
    }

    return $uploadedImages;
}

public function actionUploadImages($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $uploadDir = Yii::getAlias('@webroot/images/temp'); 
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }
    $file = UploadedFile::getInstanceByName('file');
    if ($file) {
        $fileName = uniqid() . '.' . $file->extension; 
        $filePath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if ($file->saveAs($filePath)) {
            return [
                'success' => true,
                'fileName' => $fileName,
                'fileUrl' => Yii::getAlias('@web') . '/images/temp/' . $fileName,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Không thể lưu ảnh.',
            ];
        }
    }
    return [
        'success' => false,
        'message' => 'Không nhận được file tải lên.',
    ];
}

public function actionDeleteImage($id)
{
    // Lấy danh sách hình xe theo id của xe
    $hinhXeList = HinhXe::find()->where(['id_xe' => $id])->all();

    // Kiểm tra nếu không tìm thấy hình ảnh nào
    if (empty($hinhXeList)) {
        return $this->asJson([
            'title' => 'Thông báo!',
            'content' => '<p>Không tìm thấy hình ảnh nào cho xe này.</p>',
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ]),
        ]);
    }

    // Hiển thị danh sách hình ảnh
    return $this->asJson([
        'title' => 'Xóa Hình Ảnh Xe',
        'content' => $this->renderAjax('delete-image', [
            'hinhXeList' => $hinhXeList,
            'id' => $id,
        ]),
        'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ]) ,
          
    ]);
}

public function actionDeleteSingleImage()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $imageId = Yii::$app->request->post('id');
    $hinh = HinhXe::findOne($imageId);
    if ($hinh->delete()) {
        return [
            'success' => true,
            'message' => 'Hình ảnh đã được xóa thành công.',
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Không thể xóa hình ảnh. Vui lòng thử lại.',
        ];
    }
}

}
