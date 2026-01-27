<?php

namespace app\modules\demxe\controllers;

use Yii;
use app\modules\demxe\models\DemXe;
use app\modules\demxe\models\search\DemXeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\custom\CustomFunc;
use app\modules\thuexe\models\Xe;

/**
 * DemXeController implements the CRUD actions for DemXe model.
 */
class LuotXeController extends Controller
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
     * Lists all DemXe models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new DemXeSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new DemXeSearch(); // "reset"
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
     * Displays a single DemXe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "DemXe",
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
     * Creates a new DemXe model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DemXe();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới DemXe",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới DemXe",
                    'content'=>'<span class="text-success">Thêm mới thành công</span>',
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới DemXe",
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
     * Updates an existing DemXe model.
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
                    'title'=> "Cập nhật DemXe",
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
                        'title'=> "DemXe",
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
                    'title'=> "Cập nhật DemXe",
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
     * Delete an existing DemXe model.
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
     * Delete multiple existing DemXe model.
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
     * Finds the DemXe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DemXe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DemXe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * báo cáo xe vi phạm qua đêm/đi không có kế hoạch
     */
    public function actionBcViPham(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return [
                'title' => "Báo cáo vi phạm",
                'content' => $this->renderAjax('rp_bao_cao_vi_pham', [
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    /**
     * in báo cáo vi phạm theo các tham số (dành cho xe đào tạo)
     * @param unknown $startdate
     * @param unknown $starttime
     * @param unknown $enddate
     * @param unknown $endtime
     * @param unknown $byuser
     * @param unknown $typereport
     * @param unknown $byaddress
     */
    public function actionGetPhieuInXeDaoTao($startdate, $starttime, $enddate, $endtime, $typereport)//0 for all
    {
        $currentTime = date('Y-m-d H:i:s');
        if($starttime == null)
            $starttime = '00:00:00';
        if($endtime == null)
            $endtime = '23:59:59';
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;
        
        $listVP = [];
        //get all dem xe match date,
        //lay moc ngày di, luot xe co di co ve, moc ve la ngay ve, 
        //luot xe chua co moc ve, ngay ve la ngay $end
        $listXe = Xe::find()->where(['phan_loai'=>Xe::PHANLOAI_TAPLAI])->all();
        foreach ($listXe as $iXe=>$xe){
            $demXe = DemXe::find()->alias('t')->joinWith(['xe as x'])->where([
                't.id_xe' => $xe->id,
            ])->andWhere(['>=','t.thoi_gian_bd', $start])
            ->andWhere([
                'or',
                ['<=', 't.thoi_gian_kt', $end],
                ['thoi_gian_kt' => null],
                //['thoi_gian' => ''],
            ])
            ->all();
            $mss = '';
            foreach ($demXe as $iDx=>$dx){
                //check qua dem
                if($dx->xeQuaDem){
                    $mss = 'Xe đi qua đêm (' . CustomFunc::convertYMDHISToDMYHI($dx->thoi_gian_bd)
                    . ' - ' . ($dx->thoi_gian_kt!=null?CustomFunc::convertYMDHISToDMYHI($dx->thoi_gian_kt):
                    '???' ) . ')'  . ';';
                }
                //check khong ke hoach
                if($dx->diKhongKeHoach){
                    $mss .=  'Xe đi không kế hoạch (' . CustomFunc::convertYMDHISToDMYHI($dx->thoi_gian_bd)
                    . ' - ' . ($dx->thoi_gian_kt!=null?CustomFunc::convertYMDHISToDMYHI($dx->thoi_gian_kt):
                    '???' ) . ')' . ';';
                }
            }
            if($mss!=''){
                $listVP[$xe->bien_so_xe] = $mss;
            }
        }
        /* $demXe = DemXe::find()->alias('t')->joinWith(['xe as x'])->where([
            'x.phan_loai' => Xe::PHANLOAI_TAPLAI,
        ])->andWhere(['>=','t.thoi_gian_bd', $start])
        ->andWhere([
            'or',
            ['<=', 't.thoi_gian_kt', $end],
            ['thoi_gian' => null],
            //['thoi_gian' => ''],
        ])
        ->all(); */
        
        //loop all data, check overnight or not planing
        //send listVP to view
        if($typereport==1){
            $content = $this->renderPartial('rp_bao_cao_vi_pham_print', [
                'list'=>$listVP,
                'start' => $start,
                'end' => $end
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
        
    }
}