<?php

namespace app\modules\giaovien\controllers;

use Yii;
use app\modules\giaovien\models\Day;
use app\modules\giaovien\models\search\DaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\giaovien\models\GiaoVien;
/**
 * DayController implements the CRUD actions for Day model.
 */
class DayController extends Controller
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
     * Lists all Day models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new DaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
    }


    /**
     * Displays a single Day model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Day #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"></i>Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('<i class="fa fa-pencil"></i> Chỉnh sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Day model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_nhan_vien)
    {
        $request = Yii::$app->request;
        $model = new Day();  
     
        // Gán id_nhan_vien từ tham số URL
        if ($id_nhan_vien !== null) {
            $model->id_nhan_vien = $id_nhan_vien;
        }
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Phân công giảng dạy",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button(' <i class ="fa fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                   'forceClose'=>true,   
                   //'excuteFunctionDay'=>'reloadDay()',
                   /* 'functionResponseDay' => $this->renderAjax('phan_cong_day', [
                   'model' => $model,
                    'phanCongDay' => Day::find()->where(['id_nhan_vien' => $model->id_nhan_vien])->all(), 
                    ]), */
                    'reloadType'=>'giaoVien',
                    'reloadBlock'=>'#dayContent',
                    'reloadContent'=>$this->renderAjax('phan_cong_day', [
                        'model' => $model,
                        'phanCongDay' => Day::find()->where(['id_nhan_vien' => $model->id_nhan_vien])->all(),
                    ]),
                    
                    'tcontent'=>'Phân công giảng dạy thành công!',
                ];
              /*  return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Day",
                    'content'=>'<span class="text-success">Đã phân công cho giáo viên !</span>',
                    'footer'=> Html::button('<i class="fa fa-close"></i> Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục tạo',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];  */       
            }else{           
                return [
                    'title'=> "Phân công giảng dạy",
                    
                    'tcontent'=>'Thất bại!',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class ="fa fa-close"> </i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-save"> </i>Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
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
     * Updates an existing Day model.
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
                    'title'=> "Phân công dạy",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceClose'=>true,   
                    'reloadType'=>'giaoVien',
                    'reloadBlock'=>'#dayContent',
                    'reloadContent'=>$this->renderAjax('phan_cong_day', [
                        'model' => $model,
                        'phanCongDay' => Day::find()->where(['id_nhan_vien' => $model->id_nhan_vien])->all(),
                    ]),
                    
                    'tcontent'=>'Cập nhật giảng dạy thành công!',
                ];
              /*  return [
                   'forceClose'=>true,
                    'tcontent'=>'Cập nhật thành công!',
                   
                    'functionResponse'=>$this->renderAjax('/giao-vien/phan_cong_day', ['model'=>$model]),
                ];
                
                */
            }else{
                 return [
                    'title'=> "Update Day #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fa fa-close"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('<i class="fa fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
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
     * Delete an existing Day model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

     /**
     * Delete multiple existing Day model.
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
     * Finds the Day model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Day the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Day::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  
}
