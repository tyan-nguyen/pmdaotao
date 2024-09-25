<?php

namespace app\modules\kholuutru\controllers;

use Yii;
use app\modules\kholuutru\models\Kho;
use app\modules\kholuutru\models\search\Kho as KhoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
/**
 * KhoController implements the CRUD actions for Kho model.
 */
class KhoController extends Controller
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

    /**
     * Lists all Kho models.
     * @return mixed
     */
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Danh mục kho';
	    Yii::$app->params['modelID'] = 'Danh sách Kho';
	    return true;
	}
    public function actionIndex()
    {    
        $searchModel = new KhoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Kho model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Kho #".$id,
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
     * Creates a new Kho model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
{
    $request = Yii::$app->request;
    $model = new Kho();  

    if($request->isAjax){
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thêm Kho",
                'content'=>$this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];         
        } elseif ($model->load($request->post()) && $model->save()) {
            // Xử lý file upload
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file) {
                $uploadPath = Yii::getAlias('@webroot/images/');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $fileName = time() . '_' . $model->file->baseName . '.' . $model->file->extension;
                $filePath = $uploadPath . $fileName;
                if($model->file->saveAs($filePath)) {
                    $model->so_do_kho = 'images/' . $fileName;
                    $model->save(false); 
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thêm Kho",
                        'content'=>'<span class="text-success">Thêm Kho thành công!</span>',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                   Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];   
                } else {
                    return [
                        'title'=> "Thêm Kho",
                        'content'=>'<span class="text-danger">Lỗi khi lưu file. Vui lòng thử lại.</span>',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                   Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    ]; 
                }
            } else {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm Kho",
                    'content'=>'<span class="text-success">Thêm Kho thành công!</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                               Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ]; 
            }
        } else {
            return [
                'title'=> "Thêm Kho",
                'content'=>$this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                           Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];  
        }
    } else {
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
     * Updates an existing Kho model.
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
                    'title'=> "Cập nhật Kho #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            } elseif ($model->load($request->post()) && $model->save()) {
    
                // Xử lý cập nhật hình ảnh
                $model->file = UploadedFile::getInstance($model, 'file');
                if($model->file) {
                    $uploadPath = Yii::getAlias('@webroot/images/');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    $fileName = time() . '_' . $model->file->baseName . '.' . $model->file->extension;
                    $filePath = $uploadPath . $fileName;
                    
                    // Xóa file cũ nếu có
                    if (!empty($model->so_do_kho) && file_exists(Yii::getAlias('@webroot/') . $model->so_do_kho)) {
                        unlink(Yii::getAlias('@webroot/') . $model->so_do_kho);
                    }
    
                    // Lưu file mới
                    if($model->file->saveAs($filePath)) {
                        $model->so_do_kho = 'images/' . $fileName;
                        $model->save(false); // Lưu thay đổi đường dẫn ảnh mới
                    }
                }
    
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Kho #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                               Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            } else {
                return [
                    'title'=> "Cập nhật Kho #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
    
                // Xử lý cập nhật hình ảnh
                $model->file = UploadedFile::getInstance($model, 'file');
                if($model->file) {
                    $uploadPath = Yii::getAlias('@webroot/images/');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    $fileName = time() . '_' . $model->file->baseName . '.' . $model->file->extension;
                    $filePath = $uploadPath . $fileName;
    
                    // Xóa file cũ nếu có
                    if (!empty($model->so_do_kho) && file_exists(Yii::getAlias('@webroot/') . $model->so_do_kho)) {
                        unlink(Yii::getAlias('@webroot/') . $model->so_do_kho);
                    }
    
                    // Lưu file mới
                    if($model->file->saveAs($filePath)) {
                        $model->so_do_kho = 'images/' . $fileName;
                        $model->save(false); // Lưu thay đổi đường dẫn ảnh mới
                    }
                }
    
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    

    /**
     * Delete an existing Kho model.
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
     * Delete multiple existing Kho model.
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
     * Finds the Kho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kho::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
