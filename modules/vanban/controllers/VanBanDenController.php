<?php

namespace app\modules\vanban\controllers;
use yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

use yii\web\Controller;

use yii\web\NotFoundHttpException; 
use app\modules\vanban\models\VanBanDen;

use app\modules\vanban\models\search\VanBanDenSearch;
use yii\web\Response;
use app\modules\vanban\models\FileVanBan;

/**
 * Default controller for the `vanban` module
 */
class VanBanDenController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý Văn bản';
        Yii::$app->params['modelID'] = 'Quản lý Văn bản đến';
        return parent::beforeAction($action);
    }
    
    /**
     * Lists all VanBan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VanBanDenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        // Thêm điều kiện để chỉ hiển thị các văn bản có id_loai_van_ban = 2
        $dataProvider->query->andWhere(['id_loai_van_ban' => 1]);
        Yii::$app->view->title = 'Quản lý văn bản đến';
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $files = FileVanBan::find()->where(['id_van_ban' => $id])->all();
        $request = Yii::$app->request;
        
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "VanBan #".$id,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                    'files' => $files, // Truyền biến files vào renderAjax
                ]),
                'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                           Html::a('Sửa', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
            ];
        } else {
            return $this->render('view', [
                'model' => $model,
                'files' => $files,
            ]);
        }
    }
    

    /**
     * Creates a new VanBan model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new VanBanDen();
    
   
        $maxSoDen = VanBanDen::find()->max('vbden_so_den');
        $model->vbden_so_den = $maxSoDen ? $maxSoDen + 1 : 1;
    
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm văn bản",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('Lưu', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                // Xử lý lưu thông tin file_van_ban
          
                $files = $request->post('FileVanBan', []);
                foreach ($files as $fileData) {
                    $fileVanBan = new FileVanBan();
                    $fileVanBan->id_van_ban = $model->id; 
                    $fileVanBan->file_name = $fileData['file_name'];
                    $fileVanBan->file_size = $fileData['file_size'];
                    $fileVanBan->file_type = $fileData['file_type'];
                    $fileVanBan->file_display_name = $fileData['file_display_name'];
                    $fileVanBan->save();
                }
    
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Thêm văn bản đến",
                    'content' => '<span class="text-success">Create VanBan success</span>',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::a('Tạo mới', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Thêm văn bản đến",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('Lưu', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                // Xử lý lưu thông tin file_van_ban
                $files = $request->post('FileVanBan', []);
                foreach ($files as $fileData) {
                    $fileVanBan = new FileVanBan();
                    $fileVanBan->id_van_ban = $model->id; 
                    $fileVanBan->file_name = $fileData['file_name'];
                    $fileVanBan->file_size = $fileData['file_size'];
                    $fileVanBan->file_type = $fileData['file_type'];
                    $fileVanBan->file_display_name = $fileData['file_display_name'];
                    $fileVanBan->save();
                }
    
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }
    
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
     * Delete multiple existing VanBan model.
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
    protected function findModel($id)
    {
        if (($model = VanBanDen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
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
                    'title'=> "Cập nhật văn bản" ,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "VanBan #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật văn bản ",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
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
 

    
 

}
