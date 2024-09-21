<?php

namespace app\modules\kholuutru\controllers;

use Yii;
use app\modules\kholuutru\models\LuuKho;
use app\modules\kholuutru\models\search\LuuKhoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\modules\kholuutru\models\Ke;
use app\modules\kholuutru\models\Ngan;
use app\modules\kholuutru\models\Hop;
use app\modules\kholuutru\models\LoaiFile;
use app\modules\kholuutru\models\File;
/**
 * LuuKhoController implements the CRUD actions for LuuKho model.
 */
class LuuKhoController extends Controller
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
	    Yii::$app->params['moduleID'] = 'Module Danh mục kho';
	    Yii::$app->params['modelID'] = 'Kho lưu trữ';
	    return true;
	}
    /**
     * Lists all LuuKho models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new LuuKhoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single LuuKho model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "LuuKho #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('<i class ="fa fa-pencil"> </i> Chỉnh sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new LuuKho model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new LuuKho();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Tạo mới Lưu kho",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class ="fa fa-save"> </i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Tạo mới Lưu kho",
                    'content'=>'<span class="text-success">Tạo mới Lưu kho thành công !</span>',
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('<i class ="fa fa-plus"> </i> Tiếp tục tạo',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Tạo mới Kho lưu trữ ",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class ="fa fa-save"> </i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
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
     * Updates an existing LuuKho model.
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
                    'title'=> "Cập nhật Kho lưu trữ #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class ="fa fa-save"> </i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "LuuKho #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('<i class ="fa fa-pencil"> </i> Chỉnh sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật Kho lưu trữ #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class ="fa fa-save"> </i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
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
     * Delete an existing LuuKho model.
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
     * Delete multiple existing LuuKho model.
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
     * Finds the LuuKho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LuuKho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LuuKho::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    //Hiển thị danh sách các kệ theo id_kho
    public function actionGetToList($id_kho)
    {
        $ke = Ke::find()->where(['id_kho' => $id_kho])->all();
        
        if (empty($ke)) {
            return json_encode(['no_to' => 'Trống']);
        }
        $listKho = ArrayHelper::map($ke, 'id', 'ten_ke');
        return json_encode($listKho);
    }

   //Hiển thị danh sách các ngăn theo id_ke
    public function actionGetToListKe($id_ke)
    {
        $ngan = Ngan::find()->where(['id_ke' => $id_ke])->all();
        
        if (empty($ngan)) {
            return json_encode(['no_ngan' => 'Trống']);
        }
        $listKe = ArrayHelper::map($ngan, 'id', 'ten_ngan');
        return json_encode($listKe);
    }

    //Hiển thị danh sách các hộp theo id_ngan
    public function actionGetToListNgan($id_ngan)
    {
        $hop = Hop::find()->where(['id_ngan' => $id_ngan])->all();
        
        if (empty($hop)) {
            return json_encode(['no_hop' => 'Trống']);
        }
        $listNgan = ArrayHelper::map($hop, 'id', 'ten_hop');
        return json_encode($listNgan);
    }

    //Lấy danh sách loại file dựa trên đối tương
    public function actionGetLoaiFile()
      {
         if (Yii::$app->request->isAjax) {
            $doiTuong = Yii::$app->request->get('doi_tuong');
            $loaiFiles = LoaiFile::find()->where(['doi_tuong' => $doiTuong])->all();
            $data = [];
              foreach ($loaiFiles as $loaiFile) {
                $data[$loaiFile->id] = $loaiFile->ten_loai;
             }
         return json_encode($data); // Trả về dạng JSON
         }
      }

// Lấy danh sách các file dựa trên loại file  
    public function actionGetFile()
      {
          if (Yii::$app->request->isAjax) {
            $loaiFile = Yii::$app->request->get('loai_file');
            $files =File::find()->where(['loai_file' => $loaiFile])->all();
            $data = [];
             foreach ($files as $file) {
                $data[$file->id] = $file->file_display_name;
            }
          return json_encode($data); // Trả về dạng JSON
        }
      }
}
