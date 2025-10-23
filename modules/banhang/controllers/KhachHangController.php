<?php

namespace app\modules\banhang\controllers;

use Yii;
use app\modules\banhang\models\KhachHang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\banhang\models\HoaDon;
use app\modules\hocvien\models\DangKyHv;
use app\modules\banhang\models\search\KhachHangSearch;
use app\modules\thuexe\models\LichThue;
use app\modules\giaovien\models\GiaoVien;

/**
 * KhachHangController implements the CRUD actions for KhachHang model.
 */
class KhachHangController extends Controller
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
     * use in bán hàng
     * @param unknown $q
     * @param unknown $loai
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionSearch($q = null, $loai = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if($loai == HoaDon::LOAI_KHACHLE){
            $query = KhachHang::find()
            ->select(['id', "CONCAT(ho_ten, ' (', so_dien_thoai , ')') AS text"]);
        } else if ($loai == HoaDon::LOAI_HOCVIEN){
            $query = DangKyHv::find()
            ->select(['id', "CONCAT(ho_ten, ' (', so_dien_thoai , ')') AS text"]);
        }
        if (!empty($q)) {
            $query->andFilterWhere( [ 'OR',
                ['like', 'ho_ten', $q],
                ['like', 'so_dien_thoai', $q]
            ]);
        }
        $results = $query->orderBy(['id'=>SORT_DESC])->limit(10)->asArray()->all();
        return $results;
    }
    /**
     * use in lịch thuê xe
     * @param unknown $q
     * @param unknown $loai
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionSearchGiaoVien($q = null, $loai = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if($loai == LichThue::GV_KHACHNGOAI){
            $query = KhachHang::find()
            ->select(['id', "CONCAT(ho_ten, ' (', so_dien_thoai , ')') AS text"]);
            if (!empty($q)) {
                $query->andFilterWhere( [ 'OR',
                    ['like', 'ho_ten', $q],
                    ['like', 'so_dien_thoai', $q]
                ]);
            }
        } else if ($loai == LichThue::GV_GIAOVIEN){
            $query = GiaoVien::find()
            ->select(['id', "CONCAT(ho_ten, ' (', dien_thoai , ')') AS text"]);
            if (!empty($q)) {
                $query->andFilterWhere( [ 'OR',
                    ['like', 'ho_ten', $q],
                    ['like', 'dien_thoai', $q]
                ]);
            }
        }
        
        $results = $query->orderBy(['id'=>SORT_DESC])->limit(10)->asArray()->all();
        return $results;
    }
    
    /**
     * refresh data in select2 dvt
     */
    public function actionRefreshSelect2($selected){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //lay list khach hang
        $options = array();
        $vts = KhachHang::find()->all();
        if($vts != null){
            foreach ($vts as $indexVt => $vt){
                $options[$indexVt]['id'] = $vt->id;
                $options[$indexVt]['text'] = $vt->ho_ten;
                $options[$indexVt]['selected'] = $vt->id==$selected ? true : false;
            }
        }
        return $options;
    }
    
    /**
     * lấy thông tin khách hàng để tự động điền thông tin
     * @param int $idkh
     * @return string[]|NULL[]|string[]
     */
    public function actionGetKhachHangAjax($idkh, $loai){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($loai == HoaDon::LOAI_KHACHLE)
            $kh = KhachHang::findOne($idkh);
        else if($loai == HoaDon::LOAI_HOCVIEN)
            $kh = DangKyHv::findOne($idkh);
        if($kh != null){
            return [
                'status'=>'success',
                'khHoTen' => $kh->ho_ten,
                'khSDT' => $kh->so_dien_thoai,
                'khDiaChi' => $kh->diaChi,
                'khCCCD' => $kh->so_cccd??''
            ];
        } else {
            return ['status'=>'failed'];
        }
    }  
    
    /**
     * lấy thông tin giáo viên/khách hàng để tự động điền thông tin
     * @param int $idkh
     * @return string[]|NULL[]|string[]
     */
    public function actionGetGiaoVienAjax($idkh, $loai){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($loai == LichThue::GV_KHACHNGOAI){
            $kh = KhachHang::findOne($idkh);
            if($kh != null){
                return [
                    'status'=>'success',
                    'gvHoTen' => $kh->ho_ten,
                    'gvSDT' => $kh->so_dien_thoai,
                    'gvDiaChi' => $kh->diaChi
                ];
            } else {
                return ['status'=>'failed'];
            }
        } else if($loai == LichThue::GV_GIAOVIEN){
            $kh = GiaoVien::findOne($idkh);
            if($kh != null){
                return [
                    'status'=>'success',
                    'gvHoTen' => $kh->ho_ten,
                    'gvSDT' => $kh->so_dien_thoai,
                    'gvDiaChi' => $kh->diaChi
                ];
            } else {
                return ['status'=>'failed'];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }  
    /**
     * Creates a new KhachHang model in popup.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePopup()
    {
        $request = Yii::$app->request;
        $model = new KhachHang();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới khách hàng",
                    'content'=>$this->renderAjax('_form', [
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
                    'title'=> "Thêm mới khách hàng",
                    'content'=>$this->renderAjax('_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }
    /**
     * Creates a new KhachHang model in popup.
     * //giống create popup chỉ khác chạy runFunc khác
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePopup2()
    {
        $request = Yii::$app->request;
        $model = new KhachHang();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới khách hàng",
                    'content'=>$this->renderAjax('_form', [
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
                    'runFunc2' => true,
                    'runFuncVal1' => $model->id,
                    //'content'=>'<span class="text-success">Thêm dữ liệu thành công!</span>',
                    //'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                    //Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else{
                return [
                    'title'=> "Thêm mới khách hàng",
                    'content'=>$this->renderAjax('_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }
    
    /**
     * Lists all KhachHang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KhachHangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    /**
     * Displays a single KhachHang model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "KhachHang #".$id,
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
     * Creates a new KhachHang model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new KhachHang();
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm khách hàng",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm khách hàng",
                    'content'=>'<span class="text-success">Thêm khách hàng thành công</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::a('Tiếp tục tạo',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    
                ];
            }else{
                return [
                    'title'=> "Create new KhachHang",
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
     * Updates an existing KhachHang model.
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
                    'title'=> "Cập nhật KhachHang #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "KhachHang #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Cập nhật KhachHang #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lạilại',['class'=>'btn btn-primary','type'=>"submit"])
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
     * Delete an existing KhachHang model.
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
     * Delete multiple existing KhachHang model.
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
     * Finds the KhachHang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KhachHang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KhachHang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}