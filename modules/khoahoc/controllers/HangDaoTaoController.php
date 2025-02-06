<?php

namespace app\modules\khoahoc\controllers;

use Yii;
use app\modules\khoahoc\models\HangDaoTao;
use app\modules\khoahoc\models\search\HangDaoTaoSearch;
use app\modules\hocvien\models\HocPhi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\lichhoc\models\PhanThi;

/**
 * HangDaoTaoController implements the CRUD actions for HangDaoTao model.
 */
class HangDaoTaoController extends Controller
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
						'actions' => ['index', 'view', 'update','create','delete','bulkdelete','tuition','update2'],
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
     * Lists all HangDaoTao models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HangDaoTaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý Khóa học';
	    Yii::$app->params['modelID'] = 'Quản lý Hạng đào tạo';
	    return true;
	}
    /**
     * Displays a single HangDaoTao model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Hạng đào tạo #".$id,
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
     * Creates a new HangDaoTao model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new HangDaoTao();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới hạng đào tạo",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới hạng đào tạo",
                    'content'=>'<span class="text-success">Thêm mới hạng đào tạo thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới hạng đào tạo",
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
     * Updates an existing HangDaoTao model.
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
                    'title'=> "Cập nhật hạng đào tạo #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Hạng đào tạo #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật Hạng đào tạo #".$id,
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
     * Delete an existing HangDaoTao model.
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
     * Delete multiple existing HangDaoTao model.
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
     * Finds the HangDaoTao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HangDaoTao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HangDaoTao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionTuition ($id)
    {
        $request = Yii::$app->request;
        $model = new HocPhi();  
        $model->id_hang= $id;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm Học phí",
                    'content'=>$this->renderAjax('tuition', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm Học phí",
                    'content'=>'<span class="text-success">Thêm Học phí thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm Học phí",
                    'content'=>$this->renderAjax('tuition', [
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
                return $this->render('tuition', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    public function actionUpdate2 ($id)
    {
    $request = Yii::$app->request;
    // Tìm kiếm model học phí dựa trên id_hang
    $model = HocPhi::find()->where(['id_hang' => $id])->one();


    if ($request->isAjax) {
        // Xử lý cho yêu cầu AJAX
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => "Cập nhật Học phí #".$id,
                'content' => $this->renderAjax('update2', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else if ($model->load($request->post()) && $model->save()) {
            return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => "Học phí #".$id,
                'content' => $this->renderAjax('mess', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) 
                           
            ];
        } else {
            return [
                'title' => "Cập nhật Học phí #".$id,
                'content' => $this->renderAjax('update2', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        // Xử lý cho yêu cầu không phải AJAX
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['mess', 'id' => $model->id]); // Chuyển hướng tới trang xem
        } else {
            return $this->render('update2', [
                'model' => $model,
            ]);
        }
    }
    }
  
    public function actionListHocPhi($id)
    {   
     // Lấy thông tin học phí của hạng dựa vào id_hang
     $hocPhis = HocPhi::find()
     ->where(['id_hang' => $id])
     ->orderBy(['ngay_ap_dung' => SORT_ASC])
     ->all();
    return $this->asJson([
        'title'=>'Danh sách học phí ',
        'content'=>$this->renderAjax('list-hoc-phi', [
            'hocPhis' => $hocPhis,
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
    }
    
    public function actionListPhanThi($id)
    {
       // Lấy thông tin phần thi dựa vào id_hang 
       $phanThi = PhanThi::find()->where(['id_hang'=> $id])->all();
       return $this->asJson ([
        'title'=>'Danh sách phần thi',
        'content'=>$this->renderAjax('list-phan-thi',[
            'phanThi'=>$phanThi,
        ]),
        'footer'=>Html::button('Đóng lại',[
             'class' =>'btn btn-default pull-left',
             'data-bs-dismiss'=>"modal"
        ])
       ]);
    }

    public function actionUpdateListHocPhi ($id)
    {
        $request = Yii::$app->request;
        $model = HocPhi::find()->where(['id' => $id])->one();
        $idHang = $model->id_hang; 
    if ($request->isAjax) {
        // Xử lý cho yêu cầu AJAX
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => "Cập nhật Học phí ",
                'content' => $this->renderAjax('update2', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else if ($model->load($request->post()) && $model->save()) {
            return [
                'forceClose'=>true,   
                'reloadType'=>'hocPhi',
                'reloadBlock'=>'#hpContent',
                'reloadContent'=>$this->renderAjax('list-hoc-phi', [
                    'hocPhis' => HocPhi::find()->where(['id_hang' => $idHang])
                    ->orderBy(['ngay_ap_dung' => SORT_ASC])
                    ->all(),
                ]),
                
                'tcontent'=>'Cập nhật học phí thành công!',
            ];
        
        } else {
            return [
                'title' => "Cập nhật Học phí",
                'content' => $this->renderAjax('update2', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        if ($model->load($request->post()) && $model->save()) {

            return $this->redirect(['mess', 'id' => $model->id]); 
        } else {
            return $this->render('update2', [
                'model' => $model,
            ]);
        }
    }
    }

    public function actionUpdateListPhanThi($id)
    {
        $request = Yii::$app->request;
        $model = PhanThi::find()->where(['id' => $id])->one();
        $idHang = $model->id_hang; 
        if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => "Cập nhật Phần thi ",
                'content' => $this->renderAjax('updatePhanThi', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else if ($model->load($request->post()) && $model->save()) {
            return [
                'forceClose'=>true,   
                'reloadType'=>'phanThi',
                'reloadBlock'=>'#ptContent',
                'reloadContent'=>$this->renderAjax('list-phan-thi', [
                    'phanThi' => PhanThi::find()->where(['id_hang' => $idHang])->all(),
                ]),
                
                'tcontent'=>'Cập nhật phần thi thành công!',
            ];
        
        } else {
            return [
                'title' => "Cập nhật Phần thi ",
                'content' => $this->renderAjax('updatePhanThi', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        if ($model->load($request->post()) && $model->save()) {

            return $this->redirect(['mess', 'id' => $model->id]); 
        } else {
            return $this->render('updatePhanThi', [
                'model' => $model,
            ]);
        }
    }
    }
    
}
