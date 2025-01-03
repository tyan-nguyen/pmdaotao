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
use app\modules\thuexe\models\ConfigLoaiHinhThue;

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
                    'title'=> "Cập nhật phiếu thuê xe #".$id,
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
                            Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"]) // Nút gửi
            ];
        } else if ($model->load($request->post())) { 
            
           
            $model->id_nguoi_gui = Yii::$app->user->identity->id; 
            $model->thoi_gian_gui = date('Y-m-d H:i:s'); 
            $model->trang_thai = 'Đã gửi';        
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
                                Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            return [
                'title' => "Cập nhật phiếu thuê #" . $id,
                'content' => $this->renderAjax('sent', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
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
    $id_xe = $model->id_xe;
    $xe = Xe::findOne($id_xe);

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
                            Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"]) // Nút gửi
            ];
        } else if ($model->load($request->post())) {     
            $model->id_nguoi_duyet = Yii::$app->user->identity->id; 
            $model->thoi_gian_duyet = date('Y-m-d H:i:s'); 

            if ($model->save()) {
                if($model->trang_thai == 'Đã duyệt')
                  {
                    $xe->trang_thai = 'Không khả dụng';
                    $xe->save();
                  }
                
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
                                Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
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
    $id_xe = $model->id_xe;
    $xe = Xe::findOne($id_xe);

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
                            Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"]) // Nút gửi
            ];
        } else if ($model->load($request->post())) { 
                $model->trang_thai ='Đã trả'; 
                $xe->trang_thai ='Khả dụng';
                $xe->save();
            
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
                                Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            return [
                'title' => "Cập nhật thông tin trả xe #" . $id,
                'content' => $this->renderAjax('approve', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('<i class="fa fa-share"> </i> Gửi', ['class' => 'btn btn-primary', 'type' => "submit"])
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

public function actionXemTraXe($id)
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
                'content' => $this->renderAjax('xem_tra_xe', [ 
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) 
                          
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
                    'content' => $this->renderAjax('xem_tra_xe', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) 
                                
                ];
            }
        } else {
            return [
                'title' => "Cập nhật thông tin trả xe #" . $id,
                'content' => $this->renderAjax('xem_tra_xe', [
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

    if ($type === 'phieuthuexe') {
        $content = $this->renderPartial('_print_phieu_thue_xe', ['model' => $model]);
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
                       // $sessions = ceil($hours / 4);
                        $chiPhiDuKien =  $loaiHinh->gia_thue;
                        break;
                    case 'Ngày ':
                       // $days = ceil($hours / 12);
                        $chiPhiDuKien = $loaiHinh->gia_thue;
                        break;
                    case '1 Ngày 1 Đêm ':
                        //$ngayDem = ceil($hours / 24 );
                        $chiPhiDuKien = $loaiHinh->gia_thue;
                        break;
                    case 'Đêm ':
                        //$Dem = ceil($hours / 12 );
                        $chiPhiDuKien =  $loaiHinh->gia_thue;
                        break;
                    case 'Tuần ':
                            //$Dem = ceil($hours / 12 );
                            $chiPhiDuKien =  $loaiHinh->gia_thue;
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
            $dateEnd = new \DateTime($thoiGianTraDuKien);
            $dateTraXe = new \DateTime($thoiGianTraXe);
            $intervalTX = $dateEnd->diff($dateTraXe);

            // Tổng số giờ và phút lẻ
            $hoursTX = $intervalTX->h + ($intervalTX->days * 24);
            $minutesTX = $intervalTX->i;
            
            // Làm tròn lên thêm 1 giờ nếu có phút lẻ
            if ($minutesTX > 0) {
                $hoursTX++;
            }

            // Kiểm tra thời gian vượt mức dự kiến và tính chi phí phát sinh
            if ($dateEnd->getTimestamp() >= $dateTraXe->getTimestamp()) {
                $chiPhiDuKien = 0;
            } else {
                $chiPhiDuKien = 0;
                // Tìm đơn giá theo giờ của loại hình thuê "Giờ"
                $giaThueGio = LoaiHinhThue::find()->where(['loai_hinh_thue' => 'Giờ '])->one()->gia_thue;

                switch ($loaiHinh->loai_hinh_thue) {
                    case 'Giờ ':
                        // Không thay đổi, tính dựa trên số giờ vượt quá
                        $chiPhiDuKien = $hoursTX * $loaiHinh->gia_thue;
                        break;

                    case 'Buổi ':
                        // Tính số buổi và số giờ lẻ (1 buổi = 4 giờ)
                      //  $sessions = intdiv($hoursTX, 4);  // Số buổi đầy đủ
                        $remainingHours =  $hoursTX;   // Giờ lẻ còn lại
                        $chiPhiDuKien = ($remainingHours * $giaThueGio);
                        break;

                    case 'Ngày ':
                        // Tính số ngày và số giờ lẻ (1 ngày = 24 giờ)
                       // $days = intdiv($hoursTX, 24);    // Số ngày đầy đủ
                        $remainingHours =  $hoursTX; // Giờ lẻ còn lại
                        $chiPhiDuKien = ($remainingHours * $giaThueGio);
                        break;


                        case '1 Ngày 1 Đêm ':
                            // Tính số ngày và số giờ lẻ (1 ngày = 24 giờ)
                           // $days = intdiv($hoursTX, 24);    // Số ngày đầy đủ
                            $remainingHours =  $hoursTX; // Giờ lẻ còn lại
                            $chiPhiDuKien = ($remainingHours * $giaThueGio);
                            break;
                         case 'Tuần ':
                        // Tính số ngày và số giờ lẻ (1 ngày = 24 giờ)
                               // $days = intdiv($hoursTX, 24);    // Số ngày đầy đủ
                                $remainingHours =  $hoursTX; // Giờ lẻ còn lại
                                $chiPhiDuKien = ($remainingHours * $giaThueGio);
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
     $nopPhiRecords = NopPhiThueXe::find()->where(['id_phieu_thue_xe' => $id])->all();
     $idHocVien = $phieuThueXe->id_hoc_vien;
     $phiThue = $phieuThueXe-> chi_phi_thue_du_kien;
     $phiPhatSinh = $phieuThueXe -> chi_phi_thue_phat_sinh;
     //Tính tổng phí thuê đã thu, phí phát sinh đã thu 
     $phithueThu = 0;
     foreach ($nopPhiRecords as $record)
     {
          if ($record->trang_thai === "Phí thuê xe")
        {
            $phithueThu += $record->so_tien_nop ;
        }
     }
     $phithuePSthu = 0;
     foreach ($nopPhiRecords as $record)
     {
         if ($record->trang_thai === "Phí phát sinh")
         {
             $phithuePSthu += $record->so_tien_nop;
         }
     }
         //Tính chi phí còn nợ của phí thuê xe dự kiến, phí thuê xe phát sinh 
    $chiphiThueConNo = $phiThue - $phithueThu ;
    $chiphiThuePSConNo = $phiPhatSinh - $phithuePSthu;
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
                'footer'=>   
                            Html::a('<i class="fa fa-history"> </i> Lịch sử nộp', 
                               ['/thuexe/phieu-thue-xe/xem-thong-tin-phi-thue', 'id' => $phieuThueXe->id, 'modalType' => 'modal-remote-2'], 
                                  [
                                    'class' => 'btn btn-info',
                                    'role' => 'modal-remote-2',
                                    'title' => 'Xem lịch sử nộp'
                                  ]
                            ) .
                            Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
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

public function actionXemThongTinPhiThue($id)
{
    // Tìm các bản ghi trong bảng NopPhiThueXe có id_phieu_thue_xe bằng $id
    $nopPhiRecords = NopPhiThueXe::find()->where(['id_phieu_thue_xe' => $id])->all();
    $thongtinPhieu = PhieuThueXe :: find()->where(['id'=>$id])->one();
    //Lấy các trường chi phí dự kiến và phát sinh trong phiếu thuê xe ra 
    $phiThue = $thongtinPhieu -> chi_phi_thue_du_kien;
    $phiPhatSinh = $thongtinPhieu -> chi_phi_thue_phat_sinh;
    //Tính tổng phí thuê đã thu, phí phát sinh đã thu 
    $phithueThu = 0;
    foreach ($nopPhiRecords as $record)
    {
         if ($record->trang_thai === "Phí thuê xe")
       {
           $phithueThu += $record->so_tien_nop ;
       }
    }
    $phithuePSthu = 0;
    foreach ($nopPhiRecords as $record)
    {
        if ($record->trang_thai === "Phí phát sinh")
        {
            $phithuePSthu += $record->so_tien_nop;
        }
    }
    //Tính chi phí còn nợ của phí thuê xe dự kiến, phí thuê xe phát sinh 
    $chiphiThueConNo = $phiThue - $phithueThu ;
    $chiphiThuePSConNo = $phiPhatSinh - $phithuePSthu;
    $checkPhiThue =null;
    if( $chiphiThueConNo > 0)
       {
            $checkPhiThue = 1; 
       }
    if($chiphiThueConNo == 0)
        {
             if(empty($phiPhatSinh) || ($phiPhatSinh == 0))
             {
                $checkPhiThue = 0; 
             }
             else 
            if(!empty($phiPhatSinh))
            {
                if ($chiphiThuePSConNo > 0)
               {
                  $checkPhiThue = 1;
               }
                else if ($chiphiThuePSConNo === 0)
                {
                   $checkPhiThue = 0;
                }
            }
        }
    // Khởi tạo các biến để lưu thông tin
    $idHocVien = null;
    $hoTenNguoiThue = null;
    $nguoiThu = null;
    $soTienNop = null;
    $ngayNop = null;
    $trangThai = null;
    $danhSachThongTin = [];
    $checkTrangThai = null;
    $bienlai = null;
    $idNopPhi = null;

    // Duyệt qua từng bản ghi và lấy thông tin cần thiết
    foreach ($nopPhiRecords as $record) {
        $idHocVien = isset($record->hocVien) ? $record->hocVien->ho_ten : null;
        $hoTenNguoiThue = $record->ho_ten_nguoi_thue;
        $nguoiThu = $record->nguoiThu->ho_ten;
        $soTienNop = $record->so_tien_nop;
        $ngayNop = $record->ngay_nop;
        $trangThai = $record->trang_thai;
        $idNopPhi = $record->id;
        if($trangThai === 'Phí phát sinh')
        {
           $checkTrangThai = 1;
        }
        // Lưu thông tin vào mảng danh sách để hiển thị trong bảng
        $danhSachThongTin[] = [
            'id_hoc_vien' => $idHocVien,
            'ho_ten_nguoi_thue' => $hoTenNguoiThue,
            'nguoi_thu' => $nguoiThu,
            'so_tien_nop' => $soTienNop,
            'ngay_nop' => $ngayNop,
            'trang_thai'=>$trangThai,
            'bien_lai'=>$bienlai, 
            'idNopPhi'=>$idNopPhi,
            'checkTrangThai'=>$checkTrangThai,
        ];
    }
    return $this->asJson([
        'title'=>'Thông tin nộp phí thuê xe !',
        'content'=>$this->renderAjax('xem_thong_tin_nop_phi', [
            'danhSachThongTin' => $danhSachThongTin,
            'id'=>$id,
            'phiThue'=>$phiThue,
            'phiPhatSinh'=>$phiPhatSinh,
            'phithueThu'=> $phithueThu,
            'phithuePSthu'=> $phithuePSthu,
            'chiphiThueConNo'=>$chiphiThueConNo,
            'chiphiThuePSConNo'=>$chiphiThuePSConNo,
            'trangThai'=>$trangThai,
            'nopPhiRecords'=> $nopPhiRecords,
            'checkPhiThue'=>$checkPhiThue,
            'phiPhatSinh'=> $phiPhatSinh,
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
    ]);
}

public function actionBienLai($idNopHp)
{   
    $model = NopPhiThueXe::findOne($idNopHp);
    return $this->asJson([
        'title'=>'Biên lai',
        'content'=>$this->renderAjax('xem_bien_lai', [
             'model'=>$model,
        ]),
        'footer' => Html::button('Đóng lại', [
            'class' => 'btn btn-default pull-left',
            'data-bs-dismiss' => "modal"
        ])
        ]);
}

}
