<?php

namespace app\modules\kholuutru\controllers;

use Yii;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\search\FileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\kholuutru\models\LoaiFile;
use yii\web\UploadedFile;
use app\modules\vanban\models\VanBanDen;
use app\widgets\FileDisplayTypeWidget;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
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
	 * @inheritdoc
	 */
	public function beforeAction($action)
	{
	    if ($action->id == 'upload-multi-process') {
	        $this->enableCsrfValidation = false;
	    }	    
	    return parent::beforeAction($action);
	}

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FileSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new FileSearch(); // "reset"
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
     * @param int $loaiFile : id của loại đối tượng nếu null thì hiển thị list chọn loại đối tượng trong form
     * @param string $doiTuong: mã đối tượng <hocvien/vbden..>
     * @param int $idDoiTuong: id của đối tượng thuộc bảng của mã đối tượng
     * upload single file
     */
    public function actionUploadSingle($loaiFile=NULL, $doiTuong, $idDoiTuong){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new File();
        if($request->isGet){
            return [
                'title'=> "Tải file",
                'content'=>$this->renderAjax('upload-single', [
                    'model' => $model,
                    'loaiFile' => $loaiFile,
                    'doiTuong' => $doiTuong,
                    'idDoiTuong' => $idDoiTuong
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }else if($model->load($request->post())){
            $file = UploadedFile::getInstance($model, 'file');
            if($loaiFile){
                $model->loai_file = $loaiFile;
            }
            $model->doi_tuong = $doiTuong;
            $model->id_doi_tuong = $idDoiTuong;
            if (!empty($file)){
                $model->file_name = $file->name;
                $model->file_type = $file->extension;
                $model->file_size = File::getFileSizeInString($file->size);
            }
            if($model->save()){
                $model->refresh();
                if (!empty($file))
                    $file->saveAs( Yii::getAlias('@webroot') . File::FOLDER_DOCUMENTS .  $model->fileSaveName);
                return [
                    'reloadType'=>'hinhAnh',
                    'reloadBlock'=>'#blockVanBan'.$model->id_doi_tuong,
                    'reloadContent'=>FileDisplayTypeWidget::widget([
                        'doiTuong'=>$model->doi_tuong,
                        'idDoiTuong'=>$model->id_doi_tuong
                    ]),
                    'tcontent'=>'Tải file thành công!',
                    'title'=> "Thêm mới File",
                    'content'=>'<span class="text-success">Tải file thành công</span>',
                    'tcontent'=>'Tải file '.$model->file_name.' thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal2"]).
                    Html::a('Tiếp tục thêm',[
                        'upload-single', 
                        'doiTuong'=>VanBanDen::MODEL_ID,
                        'idDoiTuong'=>$model->id
                    ],['class'=>'btn btn-primary','role'=>'modal-remote-2'])
                    
                ];
            }else{
                return [
                    'test' => $model->errors,
                    'title'=> "Tải file",
                    'content'=>$this->renderAjax('upload-single', [
                        'model' => $model,
                        'loaiFile' => $loaiFile,
                        'doiTuong' => $doiTuong,
                        'idDoiTuong' => $idDoiTuong
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    
                ];
            }
        }else{
            return [
                'title'=> "Tải file",
                'content'=>$this->renderAjax('upload-single', [
                    'model' => $model,
                    'loaiFile' => $loaiFile,
                    'doiTuong' => $doiTuong,
                    'idDoiTuong' => $idDoiTuong
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }
    }
    
    /**
     * upload multi file
     */
    public function actionUploadMulti($loaiFile=NULL, $doiTuong, $idDoiTuong){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new File();
        if($request->isGet){
            return [
                'title'=> "Tải file",
                'content'=>$this->renderAjax('upload-multi', [
                    'model' => $model,
                    'loaiFile' => $loaiFile,
                    'doiTuong' => $doiTuong,
                    'idDoiTuong' => $idDoiTuong
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::a('Lưu lại',['reload', 'loaiFile'=>$loaiFile, 'doiTuong'=>$doiTuong, 'idDoiTuong'=>$idDoiTuong],['class'=>'btn btn-primary','role'=>'modal-remote-2'])
                
            ];
        }
    }
    /**
     * reload block file
     */
    public function actionReload($loaiFile=NULL, $doiTuong, $idDoiTuong){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'forceClose'=>true,
            'reloadType'=>'hinhAnh',
            'reloadBlock'=>'#blockVanBan'.$idDoiTuong,
            'reloadContent'=>FileDisplayTypeWidget::widget([
                'doiTuong'=>$doiTuong,
                'idDoiTuong'=>$idDoiTuong
            ]),
            'tcontent'=>'Đã upload thành công!',
        ];
    }
    
    /**
     * upload multi file process
     */
    public function actionUploadMultiProcess($loaiFile=NULL, $doiTuong, $idDoiTuong){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!empty($_FILES)){
            $file = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileSize = $_FILES['file']['size'];
           // $fileLocation = $folderName . $_FILES['file']['name'];
           // move_uploaded_file($file,$fileLocation);
            $model = new File();
            if($loaiFile){
                $model->loai_file = $loaiFile;
            }else{
                $loaiFileModel = LoaiFile::find()->where([
                    'doi_tuong' => $doiTuong,
                ])->orderBy(['id'=>SORT_DESC])->one();
                $model->loai_file = $loaiFileModel->id;
            }
            $model->doi_tuong = $doiTuong;
            $model->id_doi_tuong = $idDoiTuong;
            $model->file_display_name = $fileName;//chưa có
            if (!empty($file)){
                $model->file_name = $fileName;
                $model->file_type = $fileType;
                $model->file_size = File::getFileSizeInString($fileSize);
            }
            if($model->save()){
                $model->refresh();
                move_uploaded_file($file, Yii::getAlias('@webroot') . File::FOLDER_DOCUMENTS .  $model->fileSaveName);
                //if (!empty($file))
                //$file->saveAs( Yii::getAlias('@webroot') . File::FOLDER_DOCUMENTS .  $model->fileSaveName);
                
                return [
                    'message' => 'success',
                    /* 'data' => $this->renderAjax('_block_van_ban', [
                        'model' => File::getModelByDoiTuong($doiTuong, $idDoiTuong)
                    ]), */
                ];
            } else {
                return [
                    'data' => $model->errors
                ];
            }
        } 
        
    }
    
    /**
     * Download file
     * @param integer $id
     * @return mixed
     */
    public function actionDownload($id)
    {
        //find path of file
        $file = File::findOne($id);
        if($file != NULL){
            $path = File::getFolderRootDocument() . $file->fileSaveName;
            //echo $path;
            if(file_exists($path)){
                return Yii::$app->response->sendFile($path, $file->file_name);
            } else {
                echo 'File không tồn tại!';
            }
        }
        
        //return Yii::app()->getRequest()->sendFile($name, @file_get_contents($fileName));
    }


    /**
     * Displays a single File model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "File",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote-2'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Updates an existing File model.
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
                    'title'=> "Cập nhật File",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceClose'=>true,   
                    'reloadType'=>'hinhAnh',
                    'reloadBlock'=>'#blockVanBan'.$model->id_doi_tuong,
                    'reloadContent'=>FileDisplayTypeWidget::widget([
                        'doiTuong'=>$model->doi_tuong,
                        'idDoiTuong'=>$model->id_doi_tuong
                    ]),
                    'tcontent'=>'Cập nhật file thành công!',
                ];
                /* return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "File",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'tcontent'=>'Cập nhật thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    */ 
            }else{
                 return [
                    'title'=> "Cập nhật File",
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
     * Delete an existing File model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose'=>true,
                'reloadType'=>'hinhAnh',
                'reloadBlock'=>'#blockVanBan'.$model->id_doi_tuong,
                'reloadContent'=>FileDisplayTypeWidget::widget([
                    'doiTuong'=>$model->doi_tuong,
                    'idDoiTuong'=>$model->id_doi_tuong
                ]),
                'tcontent'=>'Đã xóa file!',                
            ];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing File model.
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
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}