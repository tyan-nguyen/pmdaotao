<?php

namespace app\modules\giaovien\controllers;

use Yii;
use app\modules\giaovien\models\GiaoVien;
use app\modules\giaovien\models\search\GiaoVienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\nhanvien\models\To;
//use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

//use yii\filters\VerbFilter;
use \yii\web\Response;
/**
 * NhanVienController implements the CRUD actions for NhanVien model.
 */
class GiaoVienController extends Controller
{
   

    /**
     * Lists all NhanVien models.
     * @return mixed
     */
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý Giáo viên';
	    Yii::$app->params['modelID'] = 'Quản lý Giáo viên';
	    return true;
	}
    
    public function actionIndex()
    {    
        $searchModel = new GiaoVienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['doi_tuong' => ['1']]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single NhanVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Giáo viên #".$id,
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
     * Creates a new NhanVien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new GiaoVien();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm Giáo viên",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                       
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Thêm Giáo Viên",
                    'content' => '<span class="text-success">Thêm Giáo viên thành công !</span>',
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::a('Tiếp tục thêm', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Thêm Giáo viên",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
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
     * Updates an existing NhanVien model.
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
                'title'=> "Cập nhật Giáo viên #".$id,
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Sửa',['class'=>'btn btn-primary','type'=>"submit"])
            ];         
        }else if ($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Giáo viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
             return [
                'title'=> "Cập nhật Giáo viên #".$id,
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại ',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại ',['class'=>'btn btn-primary','type'=>"submit"])
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
     * Delete an existing NhanVien model.
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
     * Delete multiple existing NhanVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); 
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
     * Finds the NhanVien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NhanVien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiaoVien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetToList($id_phong_ban)
    {
       
        $tos = To::find()->where(['id_phong_ban' => $id_phong_ban])->all();
        
        if (empty($tos)) {
            return json_encode(['no_to' => 'Trống']);
        }
        $listTo = ArrayHelper::map($tos, 'id', 'ten_to');
        return json_encode($listTo);
    }


}
