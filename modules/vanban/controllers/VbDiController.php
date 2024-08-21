<?php

namespace app\modules\vanban\controllers;
use yii;
use yii\helpers\Html;

use yii\web\Controller;

use yii\web\NotFoundHttpException; 
use app\modules\vanban\models\VanBanDi;

use app\modules\vanban\models\search\VbDiSearch;
use yii\web\Response;
use app\modules\vanban\models\FileVanBan;
/**
 * Default controller for the `vanban` module
 */
class VbDiController extends Controller
{
  

    /**
     * Lists all VanBan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VbDiSearch();
    
        // Giá trị 'so_loai_van_ban' cần lọc
        $soLoaiVanBanFilter = 'VB_DI'; 
    
        if (isset($_POST['search']) && $_POST['search'] != null) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
         
            $searchModel = new VbDiSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
          
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
    
  
        $query = $dataProvider->query;
        $query->andFilterWhere(['so_loai_van_ban' => $soLoaiVanBanFilter]);
    
      
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Văn bản ';
	    Yii::$app->params['modelID'] = 'Quản lý Văn bản đi';
	    return true;
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
        $model = new VanBanDi();  
        $currentYear = date('Y');
        // Thiết lập giá trị mặc định cho 'so_vb'
        $model->so_vb = "/$currentYear";
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm văn bản",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
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
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm văn bản",
                    'content'=>'<span class="text-success">Create VanBan success</span>',
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tạo',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm văn bản",
                    'content'=>$this->renderAjax('create', [
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
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }
    protected function findModel($id)
    {
        if (($model = VanBanDi::findOne($id)) !== null) {
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
                    'title'=> "Cập nhật văn bản",
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
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật văn bản #",
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
}