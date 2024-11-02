<?php

namespace app\modules\thuexe\controllers;

use Yii;
use app\modules\thuexe\models\PhieuThueXe;
use app\modules\thuexe\models\search\PhieuThueXeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\thuexe\models\LoaiHinhThue;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\NopPhiThueXe;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\KhoaHoc;
use yii\web\UploadedFile;

/**
 * PhieuThueXeController implements the CRUD actions for PhieuThueXe model.
 */
class PhieuThueXeController extends Controller
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
						'roles' => ['admin'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
                    'tinh-chi-phi' => ['POST'],
				],
			],
		];
	}
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý thuê xe';
	    Yii::$app->params['modelID'] = 'Phiếu thuê xe';
	    return true;
	}
    /**
     * Lists all PhieuThueXe models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PhieuThueXeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PhieuThueXe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "PhieuThueXe #".$id,
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
     * Creates a new PhieuThueXe model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PhieuThueXe();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm phiếu thuê",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm phiếu thuê",
                    'content'=>'<span class="text-success">Nhập phiếu thành công !</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục tạo',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm phiếu thu",
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
     * Updates an existing PhieuThueXe model.
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
                    'title'=> "Cập nhật phiếu thu #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Phiếu thuê xe #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật phiếu thuê #".$id,
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
     * Delete an existing PhieuThueXe model.
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
     * Delete multiple existing PhieuThueXe model.
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
     * Finds the PhieuThueXe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhieuThueXe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhieuThueXe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetLoaiHinhThue($id_xe)
{
    // Tìm xe dựa vào id_xe
    $xe = Xe::findOne($id_xe);
    if ($xe !== null) {
        // Lấy danh sách loại hình thuê dựa trên id_loai_xe và điều kiện dang_ap_dung = 1
        $loaiHinhThue = LoaiHinhThue::find()
            ->where(['id_loai_xe' => $xe->id_loai_xe, 'dang_ap_dung' => 1])
            ->all();
        if (!empty($loaiHinhThue)) {
            foreach ($loaiHinhThue as $loai) {
                echo "<option value='" . $loai->id . "'>" . $loai->loai_hinh_thue . " </option>";
            }
        } else {
            echo "<option></option>"; 
        }
    }
}

public function actionSent($id)
{
    $request = Yii::$app->request; 
    $model = $this->findModel($id); 

    if ($request->isAjax) { 
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON; 

        if ($request->isGet) { 
            return [
                'title' => "Yêu cầu duyệt phiếu",
                'content' => $this->renderAjax('sent', [ 
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"]) // Nút gửi
            ];
        } else if ($model->load($request->post())) { 
            
           
            $model->id_nguoi_gui = Yii::$app->user->identity->id; 
            $model->thoi_gian_gui = date('Y-m-d H:i:s'); 
            $model->trang_thai = 'Đã gửi'; 
            $model->save();
           
            if ($model->save()) {
                
                return [
                    'forceReload' => '#crud-datatable-pjax', 
                    'title' => "Gửi Thành công !", 
                    'content' => "Phiếu thuê xe đã được gửi thành công !.", 
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) // Nút đóng hộp thoại
                ];
            } else {
              
                return [
                    'title' => "Cập nhật phiếu thuê #" . $id,
                    'content' => $this->renderAjax('sent', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            return [
                'title' => "Cập nhật phiếu thuê #" . $id,
                'content' => $this->renderAjax('sent', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
           
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
          
            return $this->render('sent', [
                'model' => $model,
            ]);
        }
    }
}

public function actionApprove($id)
{
    $request = Yii::$app->request; 
    $model = $this->findModel($id); 

    if ($request->isAjax) { 
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON; 

        if ($request->isGet) { 
            return [
                'title' => "Yêu cầu duyệt phiếu",
                'content' => $this->renderAjax('approve', [ 
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"]) // Nút gửi
            ];
        } else if ($model->load($request->post())) { 
            
           
            $model->id_nguoi_duyet = Yii::$app->user->identity->id; 
            $model->thoi_gian_duyet = date('Y-m-d H:i:s'); 
        

           
            if ($model->save()) {
                
                return [
                    'forceReload' => '#crud-datatable-pjax', 
                    'title' => "Duyệt thành công !", 
                    'content' => "Duyệt phiếu thành công !.", 
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) // Nút đóng hộp thoại
                ];
            } else {
              
                return [
                    'title' =>"Cập nhật phiếu thuê #" . $id,
                    'content' => $this->renderAjax('approve', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            return [
                'title' => "Cập nhật phiếu thuê #" . $id,
                'content' => $this->renderAjax('approve', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
           
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
          
            return $this->render('approve', [
                'model' => $model,
            ]);
        }
    }
}

public function actionTraXe($id)
{
    $request = Yii::$app->request; 
    $model = $this->findModel($id); 

    if ($request->isAjax) { 
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON; 

        if ($request->isGet) { 
            return [
                'title' => "Thông tin trả xe",
                'content' => $this->renderAjax('tra_xe', [ 
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"]) // Nút gửi
            ];
        } else if ($model->load($request->post())) { 
                $model->trang_thai ='Đã trả'; 
            
            if ($model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax', 
                    'title' => "Gửi thành công !", 
                    'content' => " Gửi thành công !.", 
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) // Nút đóng hộp thoại
                ];
            } else {
              
                return [
                    'title' =>"Cập nhật thông tin trả xe #" . $id,
                    'content' => $this->renderAjax('tra_xe', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            return [
                'title' => "Cập nhật thông tin trả xe #" . $id,
                'content' => $this->renderAjax('approve', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-mail-forward"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    } else {
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
           
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
          
            return $this->render('tra_xe', [
                'model' => $model,
            ]);
        }
    }
}

   
    public function actionMess($id)
    {   
        return $this->asJson([
            'title'=>'Thông báo !',
            'content'=>$this->renderAjax('mess', [
              
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ])
        ]);
        
    }

    public function actionMessDuyetSc($id)
    {   
        $model = $this->findModel($id); 
        return $this->asJson([
            'title'=>'Thông báo !',
            'content'=>$this->renderAjax('mess-duyet-sc', [ 
                'model' => $model,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal",
            ])
        ]);
        
    }

    
public function actionGetPhieuInAjax($id, $type)
{
    $model = $this->findModel($id);

    if ($type === 'phieuthongtin') {
        $content = $this->renderPartial('_print_phieu_thong_tin', ['model' => $model]);
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }

    return $this->asJson([
        'status' => 'error',
        'message' => 'Không tìm thấy loại phiếu.',
    ]);
}



public function actionTinhChiPhi()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $loaiHinhThue = Yii::$app->request->post('loai_hinh_thue');
    $thoiGianBatDau = Yii::$app->request->post('thoi_gian_bat_dau');
    $thoiGianTraDuKien = Yii::$app->request->post('thoi_gian_tra_du_kien');

    if ($loaiHinhThue && $thoiGianBatDau && $thoiGianTraDuKien) {
        $loaiHinh = LoaiHinhThue::findOne($loaiHinhThue);
        if ($loaiHinh) {
            $dateStart = new \DateTime($thoiGianBatDau);
            $dateEnd = new \DateTime($thoiGianTraDuKien);
            $interval = $dateStart->diff($dateEnd);
            $hours = $interval->h + ($interval->days * 24);
            $totalMinutes = $interval->i; 
            // Nếu có phút lẻ, thì cộng thêm 1 giờ để làm tròn
            if ($totalMinutes > 0) {
              $hours++;
            }
        
            // Kiểm tra $hours và đặt chi phí bằng 1 nếu $hours bằng 0
            if ($hours === 0) {
                $chiPhiDuKien = 1;
            } else {
                // Tính chi phí dựa trên loại hình thuê
                $chiPhiDuKien = 0;
                switch ($loaiHinh->loai_hinh_thue) {
                    case 'Giờ ':
                        $chiPhiDuKien = $hours * $loaiHinh->gia_thue;
                        break;
                    case 'Buổi ':
                        $sessions = ceil($hours / 4);
                        $chiPhiDuKien = $sessions * $loaiHinh->gia_thue;
                        break;
                    case 'Ngày ':
                        $days = ceil($hours / 24);
                        $chiPhiDuKien = $days * $loaiHinh->gia_thue;
                        break;
                    default:
                        $chiPhiDuKien = 0;
                        break;
                }
            }
            return $chiPhiDuKien;
        }
    }
    return 'Không thể tính chi phí';
}

public function actionTinhChiPhiPhatSinh()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $loaiHinhThue = Yii::$app->request->post('loai_hinh_thue');
    $thoiGianBatDau = Yii::$app->request->post('thoi_gian_bat_dau');
    $thoiGianTraDuKien = Yii::$app->request->post('thoi_gian_tra_du_kien');
    $thoiGianTraXe = Yii::$app->request->post('thoi_gian_tra_xe');

    if ($loaiHinhThue && $thoiGianBatDau && $thoiGianTraDuKien && $thoiGianTraXe) {
        $loaiHinh = LoaiHinhThue::findOne($loaiHinhThue);
        if ($loaiHinh) {
            $dateStart = new \DateTime($thoiGianBatDau);
            $dateEnd = new \DateTime( $thoiGianTraDuKien );
            $dateTraXe = new \DateTime( $thoiGianTraXe);
            $interval = $dateStart->diff($dateEnd);
            $hours = $interval->h + ($interval->days * 24);
            $intervalTX= $dateEnd -> diff($dateTraXe);
            $hoursTX =  $intervalTX->h +($intervalTX->days *24);
            $totalMinutes = $interval->i; 
            $totalMinutesTX = $intervalTX->i; 
            // Nếu có phút lẻ, thì cộng thêm 1 giờ để làm tròn
            if ($totalMinutes > 0) {
              $hours++;
            }
            if ($totalMinutesTX > 0) {
                $hoursTX++;
              }
           //   echo "Tổng số giờ: " . $hoursTX;

            //echo $dateStart->format('Y-m-d H:i:s');
            // Kiểm tra $hours và đặt chi phí bằng 1 nếu $hours bằng 0
            if (($hours === 0) || ( $dateEnd->getTimestamp() >= $dateTraXe->getTimestamp())){
                $chiPhiDuKien = 0;
            } else {
                // Tính chi phí dựa trên loại hình thuê
                $chiPhiDuKien = 0;
                switch ($loaiHinh->loai_hinh_thue) {
                    case 'Giờ ':
                        $chiPhiDuKien = $hoursTX * $loaiHinh->gia_thue;
                        break;
                    case 'Buổi ':
                        $sessions = ceil($hoursTX / 4);
                        $chiPhiDuKien = $sessions * $loaiHinh->gia_thue;
                        break;
                    case 'Ngày ':
                        $days = ceil($hoursTX / 24);
                        $chiPhiDuKien = $days * $loaiHinh->gia_thue;
                        break;
                    default:
                        $chiPhiDuKien = 0;
                        break;
                }
            }
            return $chiPhiDuKien;
        }
    }
    return 'Không thể tính chi phí';
}

public function actionMessSc($id)
{   
    return $this->asJson([
        'title'=>'Thông báo !',
        'content'=>$this->renderAjax('mess-sc', [
          
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
    
}

public function actionMessKdp($id)
{   
    $model = $this->findModel($id); 
    return $this->asJson([
        'title'=>'Thông báo !',
        'content'=>$this->renderAjax('mess-kdp', [
           'model'=>$model,
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
}


public function actionNopPhiThueXe($id)
{
    $request = Yii::$app->request;
    $model = new NopPhiThueXe();  
    $model->id_phieu_thue_xe = $id;
     // Tìm phiếu thuê xe tương ứng
     $phieuThueXe = PhieuThueXe::findOne($id);
     $idHocVien = $phieuThueXe->id_hoc_vien;
     // Kiểm tra phiếu thuê xe là học viên thuê hay người ở ngoài thuê và lấy thông tin tương ứng 
     if ($phieuThueXe) {
         // Kiểm tra xem id_hoc_vien có null không
         if ($phieuThueXe->id_hoc_vien !== null) {
            $hocVien = HocVien::findOne($idHocVien);
            $khoaHoc = KhoaHoc::findOne($hocVien->id_khoa_hoc);
            $hotenHV = $hocVien->ho_ten;
            $cccdHV = $hocVien->so_cccd;
            $diachiHV = $hocVien->dia_chi;
            $sdtHV = $hocVien->so_dien_thoai;
            $idHang = $hocVien->id_hang;
            $idKhoaHoc = $hocVien->id_khoa_hoc;
            $tenKhoaHoc = $khoaHoc ? $khoaHoc->ten_khoa_hoc : 'N/A';
              // Lấy id_hoc_vien nếu có giá trị
         } else {
             // Nếu id_hoc_vien là null, lấy thông tin người thuê xe
             $hotenNT = $phieuThueXe->ho_ten_nguoi_thue;
             $cccdNT = $phieuThueXe->so_cccd_nguoi_thue;
             $diachiNT = $phieuThueXe->dia_chi_nguoi_thue;
             $sdtNT = $phieuThueXe->so_dien_thoai_nguoi_thue;
         }
     } else {
         throw new NotFoundHttpException("Phiếu thuê xe không tồn tại.");
     }
     // Lấy thông tin chi phí thuê dự kiến và chi phí thuê phát sinh từ phiếu 
     if($phieuThueXe)
     {
        $chiphithueDK = $phieuThueXe->chi_phi_thue_du_kien;
        $chiphithuePS = $phieuThueXe -> chi_phi_thue_phat_sinh;
        if($chiphithuePS != null)
        {
            $chiphithueDK = $chiphithuePS;
        }
     }
    if($request->isAjax){
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thông tin phí thuê xe",
                'content'=>$this->renderAjax('formNopPhiThue', [
                    'model' => $model,  
                    'idHocVien' => $idHocVien ?? null,
                    'hotenNT' => $hotenNT ?? null,
                    'cccdNT' => $cccdNT ?? null,
                    'diachiNT' => $diachiNT ?? null,
                    'sdtNT' => $sdtNT ?? null,
                    'hotenHV' => $hotenHV ?? null,
                    'cccdHV' => $cccdHV ?? null,
                    'diachiHV' => $diachiHV ?? null,
                    'sdtHV' => $sdtHV ?? null,
                    'idHang' =>$idHang ?? null,
                    'idKhoaHoc'=>$idKhoaHoc ?? null,
                    'tenKhoaHoc' =>$tenKhoaHoc ?? null,
                    'chiphithueDK' => $chiphithueDK,
                    'chiphithuePS' => $chiphithuePS,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
    
            ];         
        }else if($model->load($request->post()) && $model->save()){
             // Xử lý file upload
             $model->file = UploadedFile::getInstance($model, 'file');
             if($model->file) {
                 $uploadPath = Yii::getAlias('@webroot/uploads/bien_lai/');
                 if (!file_exists($uploadPath)) {
                     mkdir($uploadPath, 0777, true);
                 }
                 $fileName = time() . '_' . $model->file->baseName . '.' . $model->file->extension;
                 $filePath = $uploadPath . $fileName;
                 if($model->file->saveAs($filePath)) {
                     $model->bien_lai = 'uploads/bien_lai/' . $fileName;
                     $model->save(false); 
                 }
                }
           
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin học phí",
                'content'=>'<span class="text-success">Thành công !</span>',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])         
    
            ];         
        }else{           
            return [
                'title'=> "Thông tin học phí",
                'content'=>$this->renderAjax('formNopPhiThue', [
                    'model' => $model,
                    'idHocVien' => $idHocVien ?? null,
                    'hotenNT' => $hotenNT ?? null,
                    'cccdNT' => $cccdNT ?? null,
                    'diachiNT' => $diachiNT ?? null,
                    'sdtNT' => $sdtNT ?? null,
                    'hotenHV' => $hotenHV ?? null,
                    'cccdHV' => $cccdHV ?? null,
                    'diachiHV' => $diachiHV ?? null,
                    'sdtHV' => $sdtHV ?? null,
                    'idHang' =>$idHang ?? null,
                    'idKhoaHoc'=>$idKhoaHoc ?? null,
                    'tenKhoaHoc' =>$tenKhoaHoc ?? null,
                    'chiphithueDK' => $chiphithueDK,
                    'chiphithuePS' => $chiphithuePS ,
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
            return $this->render('formNopPhiThue', [
                'model' => $model,
                'idHocVien' => $idHocVien ?? null,
                'hotenNT' => $hotenNT ?? null,
                'cccdNT' => $cccdNT ?? null,
                'diachiNT' => $diachiNT ?? null,
                'sdtNT' => $sdtNT ?? null,
                'hotenHV' => $hotenHV ?? null,
                'cccdHV' => $cccdHV ?? null,
                'diachiHV' => $diachiHV ?? null,
                'sdtHV' => $sdtHV ?? null,
                'idHang' =>$idHang ?? null,
                'tenKhoaHoc' =>$tenKhoaHoc ?? null,
                'idKhoaHoc'=>$idKhoaHoc ?? null,
                'chiphithueDK' => $chiphithueDK,
                'chiphithuePS' => $chiphithuePS,
            ]);
        }
    }
   
}


public function actionThongBaoChuaDuyet($id)
{   
    return $this->asJson([
        'title'=>'Thông báo !',
        'content'=>$this->renderAjax('thong-bao-chua-duyet', [
          
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
    
}


public function actionXemThongTinDuyetPhieu($id)
{
    $request = Yii::$app->request; 
    $model = $this->findModel($id); 

    if ($request->isAjax) { 
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON; 

        if ($request->isGet) { 
            return [
                'title' => "Thông tin duyệt phiếu",
                'content' => $this->renderAjax('xem-thong-tin-duyet-phieu', [ 
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) 
                            
            ];
        
        } else {
            return [
                'title' => "Thông tin duyệt phiếu #" . $id,
                'content' => $this->renderAjax('xem-thong-tin-duyet-phieu', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
                           
            ];
        }
    } else {
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
           
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
          
            return $this->render('xem-thong-tin-duyet-phieu', [
                'model' => $model,
            ]);
        }
    }
}

public  function actionXemThongTinPhiThue()
{
       
}

}
