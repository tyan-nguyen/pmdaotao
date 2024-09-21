<?php

namespace app\modules\nhanvien\controllers;

use Yii;
use app\modules\nhanvien\models\NhanVien;
use app\modules\nhanvien\models\search\NhanVienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\nhanvien\models\To;
//use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\kholuutru\models\HoSo;
//use yii\filters\VerbFilter;
use \yii\web\Response;
/**
 * NhanVienController implements the CRUD actions for NhanVien model.
 */
class NhanVienController extends Controller
{
   

    /**
     * Lists all NhanVien models.
     * @return mixed
     */
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý Nhân viên';
	    Yii::$app->params['modelID'] = 'Quản lý Nhân viên';
	    return true;
	}
    
    public function actionIndex()
    {    
        $searchModel = new NhanVienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['doi_tuong' => ['NV_GV', 'NHAN_VIEN']]);
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
                    'title'=> "NhanVien #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-pencil"></i> Sửa lại',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
        $model = new NhanVien();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm Nhân viên",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                       
                    ]),
                    'footer' => Html::button('<i class="fa fa-close"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('<i class="fa fa-save"></i> Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Thêm Nhân Viên",
                    'content' => '<span class="text-success">Thêm Nhân viên thành công</span>',
                    'footer' => Html::button(' <i class ="fa fa-close"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::a('Tiếp tục tạo', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Thêm Nhân viên",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        
                    ]),
                    'footer' => Html::button('<i class="fa-fa-close"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('<i class="fa fa-save"></i> Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
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
                'title'=> "Cập nhật Nhân viên #".$id,
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('<i class="fa fa-close"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('<i class="fa fa-pencil"></i> Sửa lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];         
        }else if($model->load($request->post())) {
            // Gán giá trị cho doi_tuong dựa trên chuc_vu
            if ($model->chuc_vu === 'Nhân viên') {
                $model->doi_tuong = 'NHAN_VIEN';
            } elseif ($model->chuc_vu === 'Nhân viên / Giáo viên') {
                $model->doi_tuong = 'NV_GV';
            }

            if ($model->save()) {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Nhân viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-pencil"> </i> Sửa lại',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }
        }else{
             return [
                'title'=> "Cập nhật Nhân viên #".$id,
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('<i class="fa fa-close"></i> Đóng lại ',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('<i class="fa fa-save"></i> Lưu lại ',['class'=>'btn btn-primary','type'=>"submit"])
            ];        
        }
    }else{
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post())) {
            // Gán giá trị cho doi_tuong dựa trên chuc_vu
            if ($model->chuc_vu === 'Nhân viên') {
                $model->doi_tuong = 'NHAN_VIEN';
            } elseif ($model->chuc_vu === 'Nhân viên / Giáo viên') {
                $model->doi_tuong = 'NV_GV';
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
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
        if (($model = NhanVien::findOne($id)) !== null) {
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
