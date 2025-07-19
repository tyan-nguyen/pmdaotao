<?php

namespace app\modules\banhang\controllers;

use Yii;
use app\modules\banhang\models\HangHoa;
use app\modules\banhang\models\search\HangHoaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\banhang\models\DVT;
use app\modules\banhang\models\HangHoaLichSu;

/**
 * HangHoaController implements the CRUD actions for HangHoa model.
 */
class HangHoaController extends Controller
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
	 * refresh data in dropdownlist dvt
	 */
	public function actionRefreshDvt($selected){
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    //lay list khach hang
	    $options = '<option>--Select--</option>';
	    $vts = DVT::find()->all();
	    if($vts != null){
	        foreach ($vts as $vt){
	            $options .= '<option value="'. $vt->id .'" '. ($vt->id==$selected ? 'selected' : '') .'>'. $vt->ten_dvt .'</option>';
	        }
	        $options .= '</optgroup>';
	    }
	    return ['options' => $options];
	}
	
	/**
	 * refresh data in select2 dvt
	 */
	public function actionRefreshDvtSelect2($selected){
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    //lay list khach hang
	    $options = array();
	    $vts = DVT::find()->all();
	    if($vts != null){
	        foreach ($vts as $indexVt => $vt){
	            $options[$indexVt]['id'] = $vt->id;
	            $options[$indexVt]['text'] = $vt->ten_dvt;
	            $options[$indexVt]['selected'] = $vt->id==$selected ? true : false;
	        }
	    }
	    return $options;
	}
	
	/**
	 * Creates a new DVT model in popup.
	 * For ajax request will return json object
	 * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreateDvt()
	{
	    $request = Yii::$app->request;
	    $model = new DVT();	    
	    if($request->isAjax){
	        Yii::$app->response->format = Response::FORMAT_JSON;
	        if($request->isGet){
	            return [
	                'title'=> "Thêm mới đơn vị tính",
	                'content'=>$this->renderAjax('_form-dvt', [
	                    'model' => $model,
	                ]),
	                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
	                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
	            ];
	        }else if($model->load($request->post()) && $model->save()){
	            return [
	                //'forceReload'=>'#crud-datatable-pjax',
	                'forceClose'=>true,
	                //'title'=> "Thêm mới Khách hàng",
	                'runFunc' => true,
	                'runFuncVal1' => $model->id,
	                //'content'=>'<span class="text-success">Thêm dữ liệu thành công!</span>',
	                //'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
	                //Html::button('Close',['data-bs-dismiss'=>"modal"])
	                ];
	        }else{
	            return [
	                'title'=> "Thêm mới đơn vị tính",
	                'content'=>$this->renderAjax('create', [
	                    'model' => $model,
	                ]),
	                'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
	                Html::button('Close',['data-bs-dismiss'=>"modal"])
	            ];
	        }
	    }	    
	}

    /**
     * Lists all HangHoa models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HangHoaSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new HangHoaSearch(); // "reset"
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
     * Displays a single HangHoa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Hàng hóa",
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
     * Creates a new HangHoa model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new HangHoa();  
        $model->ma_hang_hoa = $model->getRandomCode();
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới hàng hóa",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())){
                if($model->save()){                    
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thêm mới hàng hóa",
                        'content'=>'<span class="text-success">Thêm mới thành công</span>',
                        'tcontent'=>'Thêm mới thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];   
                }else{
                    return [
                        'title'=> "Thêm mới hàng hóa",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                        
                    ];
                }
            }else{
                return [
                    'title'=> "Thêm mới hàng hóa",
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
     * Updates an existing HangHoa model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);    
        $oldModel = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật hàng hóa",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
                if($model->save()){
                    //them lich su ton kho neu thay so luong co thay doi
                    if($model->so_luong != $oldModel->so_luong){
                        $lichSuTonKho = new HangHoaLichSu();
                        $lichSuTonKho->id_hang_hoa = $model->id;
                        $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                        $lichSuTonKho->loai_thay_doi = HangHoaLichSu::LOAI_NHAPXUATKHO;
                        $lichSuTonKho->ghi_chu = 'Sửa số lượng tồn kho';
                        $lichSuTonKho->so_luong = $model->so_luong - $oldModel->so_luong;
                        $lichSuTonKho->so_luong_cu = $oldModel->so_luong;
                        $lichSuTonKho->so_luong_moi = $model->so_luong;
                        $lichSuTonKho->save();
                    }
                    
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Hàng hóa",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Cập nhật thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];
                }else{
                    return [
                        'title'=> "Cập nhật hàng hóa",
                        'content'=>$this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    ];
                }
            	
            }else{
                 return [
                    'title'=> "Cập nhật hàng hóa",
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
     * Delete an existing HangHoa model.
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
     * Delete multiple existing HangHoa model.
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
     * Finds the HangHoa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HangHoa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HangHoa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
