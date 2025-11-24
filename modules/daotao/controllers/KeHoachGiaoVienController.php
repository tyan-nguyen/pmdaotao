<?php

namespace app\modules\daotao\controllers;

use Yii;
use app\modules\daotao\models\KeHoach;
use app\modules\daotao\models\search\KeHoachSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\user\models\User;
use app\modules\daotao\models\base\KeHoachBase;
use app\custom\CustomFunc;
use app\modules\daotao\models\TietHoc;
use app\modules\daotao\models\DmThoiGian;

/**
 * KeHoachController implements the CRUD actions for KeHoach model.
 */
class KeHoachGiaoVienController extends Controller
{
    public $freeAccessActions = ['print'];
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
     * Lists all KeHoach models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KeHoachSearch();
        if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->searchGiaoVien(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new KeHoachSearch(); // "reset"
            $dataProvider = $searchModel->searchGiaoVien(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->searchGiaoVien(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * in bản kế hoạch
     * @param unknown $id
     * @return \yii\web\Response
     */
    public function actionPrint($id){
        $model = KeHoach::findOne($id);
        $content = $this->renderPartial('ke_hoach_print', [
            'model'=>$model
        ]);
        
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    
    
    /**
     * Displays a single KeHoach model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Kế hoạch",
                'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                /*  .Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote']) */
            ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    
    /**
     * Trình duyệt kế hoạch
     * @param integer $id
     * @return mixed
     */
    public function actionTrinhDuyet($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model!=null){
                if($model->gdTietHocs!=null && $model->nguoi_tao == Yii::$app->user->id){
                    $model->trang_thai_duyet = KeHoachBase::TT_CHODUYET;
                    $model->save(false);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Kế hoạch",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Trình duyệt kế hoạch thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                        /*  .Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote']) */
                    ];
                } else {
                    return [
                        'title'=> "Kế hoạch",
                        'content'=>$this->renderAjax('_trinh_duyet_failed', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                        /*  .Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote']) */
                    ];
                }
            }
            
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    
    /**
     * Hoàn thành kế hoạch
     * @param integer $id
     * @return mixed
     */
    public function actionHoanThanh($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model!=null){
                if($model->nguoi_tao == Yii::$app->user->id  /* || User::getCurrentUser()->superadmin */ ){
                    
                    //check thời gian đến chưa
                    $tietHocLast = TietHoc::find()->where([
                        'id_ke_hoach'=>$model->id,
                    ])->orderBy(['id_thoi_gian_hoc'=>SORT_DESC])->one();
                    if($tietHocLast){
                        $mocTime = $tietHocLast->thoi_gian_kt;
                        if(date('Y-m-d H:i:s') < $mocTime){
                            return [
                                'title'=> "Thông báo",
                                'content'=>'<span class="text-danger">Chưa thể chọn hoàn thành kế hoạch do thời gian chưa đến!</span>',
                                'tcontent'=>'Chưa thể chọn hoàn thành kế hoạch do thời gian chưa đến!',
                                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                            ];
                        }
                    }
                    
                    $model->trang_thai_duyet = KeHoachBase::TT_HOANTHANH;
                    $model->save(false);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Kế hoạch",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Xác nhận hoàn thành kế hoạch thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                        /*  .Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote']) */
                    ];
                } else {
                    return [
                        'title'=> "Kế hoạch",
                        'content'=>'Có lỗi xảy ra!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                        /*  .Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote']) */
                    ];
                }
            }
            
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    
    /**
     * Creates a new KeHoach model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new KeHoach();
        $user = User::findOne(Yii::$app->user->id);
        if($user->getIdGiaoVien()!=null){
            $model->id_giao_vien = $user->getIdGiaoVien();
        }
        
        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới Kế Hoạch",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    
                ];
            }else if($model->load($request->post())){
                //check kế hoạch ngày của giáo viên có chưa
                if($model->ngay_thuc_hien){
                    $checkNgay = KeHoach::find()->where([
                        'id_giao_vien' => $model->id_giao_vien,
                        'ngay_thuc_hien' => CustomFunc::convertDMYToYMD($model->ngay_thuc_hien)
                    ])->exists();
                    if($checkNgay){
                        $model->addError('ngay_thuc_hien', 'Kế hoạch '. 
                            $model->ngay_thuc_hien .' đã tồn tại, vui lòng kiểm tra lại!');
                        return [
                            'title'=> "Thêm mới Kế Hoạch",
                            'content'=>$this->renderAjax('create', [
                                'model' => $model,
                            ]),
                            'tcontent'=> 'Kế hoạch '.
                                $model->ngay_thuc_hien .' đã tồn tại, vui lòng kiểm tra lại!',
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])                        
                        ];
                    }
                }
                
                if($model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thêm mới Kế Hoạch",
                        'content'=>'<span class="text-success">Thêm mới thành công</span>',
                        'tcontent'=>'Thêm mới thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote']) 
                    ];
                }else{
                    return [
                        'title'=> "Thêm mới Kế Hoạch",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                        
                    ];
                }
            }else{
                return [
                    'title'=> "Thêm mới Kế Hoạch",
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
     * Updates an existing KeHoach model.
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
                    'title'=> "Cập nhật Kế Hoạch",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post())){
                //check kế hoạch ngày của giáo viên có chưa
                if($model->ngay_thuc_hien != CustomFunc::convertYMDHISToDMY($oldModel->ngay_thuc_hien)){
                    $checkNgay = KeHoach::find()->where([
                        'id_giao_vien' => $model->id_giao_vien,
                        'ngay_thuc_hien' => CustomFunc::convertDMYToYMD($model->ngay_thuc_hien)
                    ])->exists();
                    if($checkNgay){
                        $model->addError('ngay_thuc_hien', 'Kế hoạch '.
                            $model->ngay_thuc_hien .' đã tồn tại, vui lòng kiểm tra lại!');
                        return [
                            'title'=> "Thêm mới Kế Hoạch",
                            'content'=>$this->renderAjax('create', [
                                'model' => $model,
                            ]),
                            'tcontent'=> 'Kế hoạch '.
                            $model->ngay_thuc_hien .' đã tồn tại, vui lòng kiểm tra lại!',
                            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                        ];
                    }
                }
                if($model->save()){
                    //cap nhat ngay cua tiet hoc khi co thay doi ngay
                    if($model->ngay_thuc_hien != CustomFunc::convertYMDHISToDMY($oldModel->ngay_thuc_hien)){
                        $tietHocs = TietHoc::find()->where([
                            'id_ke_hoach' => $model->id
                        ])->all();
                        foreach ($tietHocs as $iTiet=>$tiet){
                            $time = DmThoiGian::findOne($tiet->id_thoi_gian_hoc);
                            $tiet->thoi_gian_bd = $model->ngay_thuc_hien . ' ' . $time->thoi_gian_bd;
                            $tiet->thoi_gian_kt = $model->ngay_thuc_hien . ' ' . $time->thoi_gian_kt;
                            $tiet->save();
                        }
                    }
                    if(Yii::$app->params['showView']){
                        return [
                            'forceReload'=>'#crud-datatable-pjax',
                            'title'=> "Kế Hoạch",
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
                        'title'=> "Cập nhật Kế Hoạch",
                        'content'=>$this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    ];
                }
            }else{
                return [
                    'title'=> "Cập nhật Kế Hoạch",
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
           /*  if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            } */
        }
    }
    
    /**
     * Delete an existing KeHoach model.
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
     * Delete multiple existing KeHoach model.
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
     * Finds the KeHoach model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KeHoach the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KeHoach::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
