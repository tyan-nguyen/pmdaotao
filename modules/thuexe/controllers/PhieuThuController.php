<?php

namespace app\modules\thuexe\controllers;

use Yii;
use app\modules\thuexe\models\PhieuThu;
use app\modules\thuexe\models\search\PhieuThuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\thuexe\models\LichThue;

/**
 * PhieuThuController implements the CRUD actions for PhieuThu model.
 */
class PhieuThuController extends Controller
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
	 * action thu tien (co the thu toan bo hoac tien coc)
	 * For ajax request will return json object
	 * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionThanhToan($type, $idlich)
	{
	    $request = Yii::$app->request;
	    $modelLichThue = LichThue::findOne($idlich);
	    $model = new PhieuThu();
	    $model->id_lich_thue = $idlich;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Phiếu thu",
                'content'=>$this->renderAjax('_form_nop_tien', [
                    'modelLichThue'=>$modelLichThue,
                    'model' => $model,
                    'type'=>$type
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }else if($model->load($request->post()) && $model->save()){
            return [
                'title'=> "Lịch thuê xe " . $modelLichThue->xe->bien_so_xe,
                'content'=>$this->renderAjax('../lich-thue/update', [
                    'model' => $modelLichThue,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];   
        }else{
            return [
                'title'=> "Phiếu thu",
                'content'=>$this->renderAjax('_form_nop_tien', [
                    'modelLichThue'=>$modelLichThue,
                    'model' => $model,
                    'type'=>$type
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }
	    
	}
	
	public function actionGetPhieuInAjax($id, $nhap)//$nhap in nhap hay in that
	{
	    $model = PhieuThu::findOne($id);
	        
        if($model->loai_phieu==PhieuThu::PHIEUTHULABEL){
            $content = $this->renderPartial('_print_phieu_thong_tin', [
                'model' => $model,
                'nhap'=>$nhap
            ]);
        } else if($model->loai_phieu==PhieuThu::PHIEUCHILABEL){
            $content = $this->renderPartial('_print_phieu_thong_tin_chi', [
                'model' => $model,
                'nhap'=>$nhap
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
	}
	
	public function actionUpdatePrintCount($id)
	{
	    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	    
	    $model = PhieuThu::findOne($id);
	    if ($model !== null) {
	        $model->so_lan_in_phieu = ($model->so_lan_in_phieu ?? 0) + 1;
	        if ($model->save(false)) {
	            return ['success' => true, 'so_lan_in' => $model->so_lan_in_phieu];
	        }
	    }
	    return ['success' => false];
	}
	
	
	/*********** chưa sử dụng ***************/

    /**
     * Lists all PhieuThu models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PhieuThuSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new PhieuThuSearch(); // "reset"
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
     * Lists all PhieuThu models.
     * @return mixed
     */
    public function actionPhieuThu()
    {
        $searchModel = new PhieuThuSearch();
        if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->searchPhieuThu(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new PhieuThuSearch(); // "reset"
            $dataProvider = $searchModel->searchPhieuThu(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->searchPhieuThu(Yii::$app->request->queryParams);
        }
        return $this->render('phieu-thu', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all PhieuThu models.
     * @return mixed
     */
    public function actionPhieuChi()
    {
        $searchModel = new PhieuThuSearch();
        if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->searchPhieuChi(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new PhieuThuSearch(); // "reset"
            $dataProvider = $searchModel->searchPhieuChi(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->searchPhieuChi(Yii::$app->request->queryParams);
        }
        return $this->render('phieu-chi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PhieuThu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "PhieuThu",
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
     * Creates a new PhieuThu model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PhieuThu();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới PhieuThu",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới PhieuThu",
                    'content'=>'<span class="text-success">Thêm mới thành công</span>',
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới PhieuThu",
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
     * Updates an existing PhieuThu model.
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
                    'title'=> "Cập nhật PhieuThu",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
            	if(Yii::$app->params['showView']){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "PhieuThu",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Cập nhật thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];    
                }else{
                	return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax','tcontent'=>'Cập nhật thành công!',];
                }
            }else{
                 return [
                    'title'=> "Cập nhật PhieuThu",
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
     * Delete an existing PhieuThu model.
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
     * Delete multiple existing PhieuThu model.
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
     * Finds the PhieuThu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhieuThu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhieuThu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
