<?php

namespace app\modules\hocvien\controllers;

use Yii;
use app\models\HvHocVien;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\hocvien\models\search\DangKyHvSearch;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\NopHocPhi;
use yii\web\UploadedFile;
use app\custom\CustomFunc;
use yii\db\Expression;

/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class HvHoSoController extends Controller
{
    // public $freeAccess = true;
    //public $freeAccessActions = ['get-phieu-in-ajax', 'update-print-count', 'report-list', 'get-phieu-in-report-list-ajax'];
    public $freeAccessActions = ['view'];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'ghost-access' => [
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
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý Học viên';
        Yii::$app->params['modelID'] = 'Hồ sơ thuế (HĐĐT)';
        //return true;
        return parent::beforeAction($action);
    }
    /**
     * Lists all HvHocVien models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DangKyHvSearch();
        $dataProvider = $searchModel->searchHoSo(Yii::$app->request->queryParams);
        //an add
        //$dataProvider->query->andWhere(['trang_thai' => ['DANG_KY']]);
        //$dataProvider->query->andWhere('id_khoa_hoc is NULL');
        $pagination = $dataProvider->getPagination();
        if (!empty($_GET['pageSize'])) {
            $pagination->pageSize = $_GET['pageSize'];
        } else {
            $pagination->pageSize = 20;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $pagination,
        ]);
    }
    /**
     * Lists all HvHocVien models.
     * @return mixed
     */
    public function actionIndexSimple()
    {
        $searchModel = new DangKyHvSearch();
        $dataProvider = $searchModel->searchHoSo(Yii::$app->request->queryParams);
        //an add
        //$dataProvider->query->andWhere(['trang_thai' => ['DANG_KY']]);
        //$dataProvider->query->andWhere('id_khoa_hoc is NULL');
        $pagination = $dataProvider->getPagination();
        $pagination->pageSize = 20;
        return $this->render('simple_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays a single HvHocVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('Trang không tồn tại.');
        /* $model = HocVien::find()->where(['id' => $id])->one();
        $trang_thai_duyet = $model->trang_thai_duyet;
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $kiemDuyetButton = '';
            if (empty($trang_thai_duyet)) {
                $kiemDuyetButton = Html::a(
                    '<i class="fa fa-check"> </i> Kiểm duyệt',
                    ['/hocvien/dang-ky-hv/duyet-hv', 'id' => $id, 'modalType' => 'modal-remote-2'],
                    [
                        'class' => 'btn btn-info',
                        'role' => 'modal-remote-2',
                        'title' => 'Kiểm duyệt'
                    ]
                );
            }
            return [
                'title' => "Học viên  #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => $kiemDuyetButton .
                    Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } */
    }

    /**
     * Displays a single HvHocVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView1($id)
    {
        $model = HocVien::find()->where(['id' => $id])->one();
        $trang_thai_duyet = $model->trang_thai_duyet;
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $kiemDuyetButton = '';
            if (empty($trang_thai_duyet)) {
                $kiemDuyetButton = Html::a(
                    '<i class="fa fa-check"> </i> Kiểm duyệt',
                    ['/hocvien/dang-ky-hv/duyet-hv', 'id' => $id, 'modalType' => 'modal-remote-2'],
                    [
                        'class' => 'btn btn-info',
                        'role' => 'modal-remote-2',
                        'title' => 'Kiểm duyệt'
                    ]
                );
            }
            return [
                'title' => "Học viên  #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => $kiemDuyetButton .
                    Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Creates a new HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DangKyHv();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Nhập thông tin học viên đăng ký ",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
            if ($model->load($request->post())) {
                $model->loai_dang_ky = 'Nhập trực tiếp';
                $model->trang_thai_duyet = 'DA_DUYET';
                if ($model->save()) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Thêm học viên",
                        'content' => '<span class="text-success">Đăng ký học viên thành công !</span>',
                        'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::a('Xem thông tin', ['view', 'id' => $model->id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) .
                            Html::a('Tiếp tục thêm mới', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                } else {
                    return [
                        'title' => "Thêm học viên",
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])

                    ];
                }
            } else {
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
    }
    /**
     * Updates an existing HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
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
                    'title' => "Cập nhật thông tin học viên #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Học viên #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Chỉnh sửa', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Cập nhật học viên #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
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


    public function actionDuyetHv($id)
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
                    'title' => "Kiểm duyệt Học viên",
                    'content' => $this->renderAjax('duyet-hv', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
            if ($model->load($request->post())) {
                $model->nguoi_duyet = Yii::$app->user->identity->id;
                $model->save();
                if ($model->save()) {
                    return [
                        'forceClose' => true,
                        'reloadType' => 'hocVien',
                        'reloadBlock' => '#hvContent',
                        'reloadContent' => $this->renderAjax('view', [
                            'model' => $model,
                        ]),

                        'tcontent' => 'Kiểm duyệt thành công!',
                    ];
                }
            } else {
                /*
            *   Process for non-ajax request
            */
                if ($model->load($request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('duyet-hv', [
                        'model' => $model,
                    ]);
                }
            }
        }
    }

    /**
     * Delete an existing HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing HvHocVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the HvHocVien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HvHocVien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HocVien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionCreate2($id)
    {
        $request = Yii::$app->request;
        $model = new NopHocPhi();
        $model->id_hoc_vien = $id;
        // Tìm học viên theo id_hoc_vien
        $hocVien = HocVien::findOne($id);
        $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';

        $hocVien = HocVien::findOne($id);
        $hoTenHocVien = $hocVien ? $hocVien->ho_ten : '';
        if ($hocVien && $hocVien->hang) {
            $tenHang = $hocVien->hang->ten_hang;
        } else {
            $tenHang = 'Chưa có hạng xe';
        }

        $hocPhi = null;
        if ($hocVien) {
            $hocPhi = $hocVien->hocPhi;
            /* $hangDaoTao = $hocVien->hangDaoTao;  
          if ($hangDaoTao) {
              $hocPhi = $hangDaoTao->hocPhi;  
          } */
        }

        if ($request->isAjax) {
            /*
        *   Process for ajax request
        */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thông tin học phí",
                    'content' => $this->renderAjax('create2', [
                        'model' => $model,
                        'hoTenHocVien' => $hoTenHocVien,
                        'tenHang' => $tenHang,
                        'hocPhi' => $hocPhi,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {
                // Xử lý file upload
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file) {
                    $uploadPath = Yii::getAlias('@webroot/uploads/bien_lai/');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    $fileName = time() . '_' . $model->file->baseName . '.' . $model->file->extension;
                    $filePath = $uploadPath . $fileName;
                    if ($model->file->saveAs($filePath)) {
                        $model->bien_lai = 'uploads/bien_lai/' . $fileName;
                        $model->save(false);
                    }
                }
                if ($hocVien) {
                    $hocVien->trang_thai = 'NHAPTRUCTIEP';
                    $hocVien->save();
                }
                /* return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin học phí",
                'content'=>'<span class="text-success">Thêm học phí thành công !</span>',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])         
            ];  */
                return [
                    'title' => "Học viên  #" . $model->hocVien->id,
                    'content' => $this->renderAjax('view', [
                        'model' => $hocVien,
                    ]),
                    'footer' =>
                    Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Thông tin học phí",
                    'content' => $this->renderAjax('create2', [
                        'model' => $model,
                        'hoTenHocVien' => $hoTenHocVien,
                        'tenHang' => $tenHang,
                        'hocPhi' => $hocPhi,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
        *   Process for non-ajax request
        */
            if ($model->load($request->post()) && $model->save()) {
                //  if ($hocVien) {
                // $hocVien->trang_thai = 'NHAP_HOC'; // Cập nhật trạng thái
                // $hocVien->save(); // Lưu thay đổi
                // }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create2', [
                    'model' => $model,
                    'hoTenHocVien' => $hoTenHocVien,
                    'tenHang' => $tenHang,
                    'hocPhi' => $hocPhi,
                ]);
            }
        }
    }

    public function actionGetPhieuInAjax($id, $type, $nhap) //$nhap in nhap hay in that
    {
        $model = NopHocPhi::findOne($id);
        //  $model->so_lan_in_phieu = ($model->so_lan_in_phieu ?? 0) + 1;
        //$model->save(false);

        if ($type === 'phieuthu') {
            $soTienDong = 0;
            $soTienConLai = 0;
            $phanTram = null;
            $hocPhi = $model->hocVien->hocPhi;
            $tongTienDong = NopHocPhi::find()->where(['id_hoc_vien' => $model->id_hoc_vien])->sum('so_tien_nop');
            if ($model->loai_nop == 'NOP100') { //100%
                //$soTienDong = $model->so_tien_nop;
                //$soTienConLai = 0;
                // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
                $phanTram = '100%';
            } else if ($model->loai_nop == 'NOP50') { //50%
                // $soTienDong = $model->so_tien_nop;
                //$soTienConLai = $model->so_tien_nop;
                // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
                $phanTram = '50%';
            } else if ($model->loai_nop == 'COC1TR') {
                //$soTienDong = $model->so_tien_nop;
                //$soTienConLai = $hocPhi->hoc_phi - $model->so_tien_nop;
                // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
                $phanTram = null;
            } else if ($model->loai_nop == 'KHAC') {
                // $soTienDong = $model->so_tien_nop;
                // $soTienConLai = $hocPhi->hoc_phi - $model->so_tien_nop;
                // $soTienConLai = $hocPhi->hoc_phi - $tongTienDong;
                $phanTram = null;
            }

            if ($model->loai_phieu == NopHocPhi::PHIEUTHULABEL) {
                $content = $this->renderPartial('_print_phieu_thong_tin', [
                    'model' => $model,
                    //'soTienDong' => $soTienDong,
                    //'soTienConLai' => $soTienConLai,
                    'phanTram' => $phanTram,
                    'nhap' => $nhap
                ]);
            } else if ($model->loai_phieu == NopHocPhi::PHIEUCHILABEL) {
                $content = $this->renderPartial('_print_phieu_thong_tin_chi', [
                    'model' => $model,
                    //'soTienDong' => $soTienDong,
                    //'soTienConLai' => $soTienConLai,
                    'phanTram' => $phanTram,
                    'nhap' => $nhap
                ]);
            }
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

    public function actionUpdatePrintCount($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = NopHocPhi::findOne($id);
        if ($model !== null) {
            $model->so_lan_in_phieu = ($model->so_lan_in_phieu ?? 0) + 1;
            if ($model->save(false)) {
                return ['success' => true, 'so_lan_in' => $model->so_lan_in_phieu];
            }
        }
        return ['success' => false];
    }

    /**
     * in danh sách theo ca
     */
    public function actionReportList()
    {
        /* if($ca=='sang'){
       // $timeStart = date('Y-m-d 06:00:00');
        $title = 'Ca sáng';
    } else if($ca=='chieu'){
        $title = 'Ca chiều';
    } */
        //$model = HocVien::find()->where(['id' => $id])->one();
        //$trang_thai_duyet = $model->trang_thai_duyet;
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title' => "Báo cáo danh sách theo ca",
                'content' => $this->renderAjax('report-list', []),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }

    public function actionGetPhieuInReportListAjax($startdate, $starttime, $enddate, $endtime, $typereport, $byuser = 0) //0 for all
    {
        if ($byuser == null) {
            $byuser = 0;
        }
        // $startStr = $startdate . ' ' .$starttime;//add second
        // $endStr = $enddate . ' ' .$endtime;//add second
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;

        // $start = '2025-03-31 06:00:00';
        //$end = '2025-04-01 11:00:00';
        $query = NopHocPhi::find()
            ->andFilterWhere(['>=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $start . "','%Y-%m-%d %H:%i:%s')")])
            ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $end . "','%Y-%m-%d %H:%i:%s')")]);
        if ($byuser > 0) {
            $query = $query->andFilterWhere(['nguoi_tao' => $byuser]);
        }
        $model = $query->all();
        $modelCount = $query->count();
        $modelSoTienNop = $query->sum('so_tien_nop');

        $queryCK = NopHocPhi::find()
            ->andFilterWhere(['>=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $start . "','%Y-%m-%d %H:%i:%s')")])
            ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $end . "','%Y-%m-%d %H:%i:%s')")]);
        if ($byuser > 0) {
            $queryCK = $queryCK->andFilterWhere(['nguoi_tao' => $byuser]);
        }
        $queryCK = $queryCK->andFilterWhere(['hinh_thuc_thanh_toan' => 'CK']);
        $modelSoTienNopCK = $queryCK->sum('so_tien_nop');

        $queryTM = NopHocPhi::find()
            ->andFilterWhere(['>=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $start . "','%Y-%m-%d %H:%i:%s')")])
            ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $end . "','%Y-%m-%d %H:%i:%s')")]);
        if ($byuser > 0) {
            $queryTM = $queryTM->andFilterWhere(['nguoi_tao' => $byuser]);
        }
        $queryTM = $queryTM->andFilterWhere(['hinh_thuc_thanh_toan' => 'TM']);

        $modelSoTienNopTM = $queryTM->sum('so_tien_nop');

        $queryChietKhau = NopHocPhi::find()
            ->andFilterWhere(['>=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $start . "','%Y-%m-%d %H:%i:%s')")])
            ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('" . $end . "','%Y-%m-%d %H:%i:%s')")]);
        if ($byuser > 0) {
            $queryChietKhau = $queryChietKhau->andFilterWhere(['nguoi_tao' => $byuser]);
        }
        $modelSoTienChietKhau = $queryChietKhau->sum('chiet_khau');

        if ($typereport == 0) {
            $content = $this->renderPartial('_print_report_list_0', [
                'model' => $model,
                'start' => $start,
                'end' => $end,
                'modelCount' => $modelCount,
                'modelSoTienNop' => $modelSoTienNop,
                'modelSoTienNopTM' => $modelSoTienNopTM,
                'modelSoTienNopCK' => $modelSoTienNopCK,
                'modelSoTienChietKhau' => $modelSoTienChietKhau,
                'byuser' => $byuser
            ]);
        } else if ($typereport == 1) {
            $content = $this->renderPartial('_print_report_list_1', [
                'model' => $model,
                'start' => $start,
                'end' => $end,
                'modelCount' => $modelCount,
                'modelSoTienNop' => $modelSoTienNop,
                'modelSoTienNopTM' => $modelSoTienNopTM,
                'modelSoTienNopCK' => $modelSoTienNopCK,
                'modelSoTienChietKhau' => $modelSoTienChietKhau,
                'byuser' => $byuser
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }

    /**
     * in danh sách báo cáo tổng
     */
    public function actionReportSum()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title' => "Báo cáo danh sách theo ca",
                'content' => $this->renderAjax('report-sum', []),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }

    /**
     * Export danh sách học viên theo mẫu Import Phần mềm đào tạo (17 cột)
     * @param int|null $id_khoa_hoc
     */
    public function actionExportPmDaoTao($id_khoa_hoc = null)
    {
        if (empty($id_khoa_hoc)) {
            $id_khoa_hoc = Yii::$app->request->get('id_khoa_hoc');
        }

        $searchModel = new DangKyHvSearch();
        $queryParams = Yii::$app->request->queryParams;
        if (!isset($queryParams['DangKyHvSearch']['id_khoa_hoc']) && $id_khoa_hoc) {
            $queryParams['DangKyHvSearch']['id_khoa_hoc'] = $id_khoa_hoc;
        }

        $dataProvider = $searchModel->searchHoSo($queryParams);
        $dataProvider->pagination = false;
        $models = $dataProvider->models;

        $khoaHoc = \app\modules\hocvien\models\KhoaHoc::findOne($id_khoa_hoc);
        $tenKhoaHoc = $khoaHoc ? $khoaHoc->ten_khoa_hoc : 'Danh_Sach_Hoc_Vien';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Import PMDT');

        $headers = [
            'A' => 'STT',
            'B' => 'HỌ VÀ TÊN (*)',
            'C' => 'NGÀY SINH (*)',
            'D' => 'GIỚI TÍNH (*)',
            'E' => 'SỐ CCCD/CMND (*)',
            'F' => 'NGÀY CẤP CCCD',
            'G' => 'NƠI CẤP CCCD',
            'H' => 'MÃ ĐVHC (*)',
            'I' => 'CHI TIẾT NƠI THƯỜNG TRÚ (CCCD)',
            'J' => 'SỐ ĐIỆN THOẠI',
            'K' => 'SỐ GPLX 1',
            'L' => 'HẠNG GPLX 1',
            'M' => 'NGÀY TT GPLX 1',
            'N' => 'NGÀY CẤP GPLX 1',
            'O' => 'NGÀY HH GPLX 1',
            'P' => 'ĐƠN VỊ CẤP GPLX 1',
            'Q' => 'SỐ GPLX 2',
            'R' => 'HẠNG GPLX 2',
            'S' => 'NGÀY TT GPLX 2',
            'T' => 'NGÀY CẤP GPLX 2',
            'U' => 'NGÀY HH GPLX 2',
            'V' => 'ĐƠN VỊ CẤP GPLX 2',
            'W' => 'SỐ GPLX 3',
            'X' => 'HẠNG GPLX 3',
            'Y' => 'NGÀY TT GPLX 3',
            'Z' => 'NGÀY CẤP GPLX 3',
            'AA' => 'NGÀY HH GPLX 3',
            'AB' => 'ĐƠN VỊ CẤP GPLX 3',
            'AC' => 'GHI CHÚ',
        ];

        // Format Header
        foreach ($headers as $col => $title) {
            $cell = $col . '1';
            $sheet->setCellValue($cell, $title);

            if ($col === 'H') {
                $fillColor = 'C00000';
            } elseif (in_array($col, ['K', 'L', 'M', 'N', 'O', 'P'])) {
                $fillColor = '006666';
            } elseif (in_array($col, ['Q', 'R', 'S', 'T', 'U', 'V'])) {
                $fillColor = '1E3A8A';
            } elseif (in_array($col, ['W', 'X', 'Y', 'Z', 'AA', 'AB'])) {
                $fillColor = '4C1D95';
            } else {
                $fillColor = '1F4E79';
            }

            $sheet->getStyle($cell)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 10,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $fillColor],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]);
        }

        $row = 2;
        foreach ($models as $index => $model) {
            $stt = $index + 1;
            $hoTen = $model->ho_ten ?? '';
            $ngaySinh = !empty($model->ngay_sinh) ? CustomFunc::convertYMDHISToDMY($model->ngay_sinh) : '';
            $gioiTinh = ($model->gioi_tinh == 1) ? 'Nam' : (($model->gioi_tinh === 0 || $model->gioi_tinh === '0') ? 'Nữ' : '');
            $soCccd = $model->so_cccd ?? '';
            $ngayCapCccd = !empty($model->ngay_cap_cmnd) ? CustomFunc::convertYMDHISToDMY($model->ngay_cap_cmnd) : '';
            $noiCapCccd = $model->noi_cap_cmnd ?? '';
            $maDvhc = $model->xa ? $model->xa->ma_xa : '';
            //$chiTietThuongTru = method_exists($model, 'getDiaChiXaTinhText') ? $model->getDiaChiXaTinhText() : '';
            $chiTietThuongTru = '';
            $soDienThoai = $model->so_dien_thoai ?? '';
            $ghiChu = '';

            // Lấy tối đa 3 giấy phép lái xe từ bảng hv_hoc_vien_gplx
            $gplxs = method_exists($model, 'getHocVienGplxs') ? $model->hocVienGplxs : [];
            $gplx1 = $gplxs[0] ?? null;
            $gplx2 = $gplxs[1] ?? null;
            $gplx3 = $gplxs[2] ?? null;

            // GPLX 1
            $soGplx1 = $gplx1 ? ($gplx1->so_gplx ?? '') : '';
            $hangGplx1 = $gplx1 ? ($gplx1->hang_gplx ?? '') : '';
            $ngayTtGplx1 = ($gplx1 && !empty($gplx1->ngay_tt_gplx)) ? CustomFunc::convertYMDToDMY($gplx1->ngay_tt_gplx) : '';
            $ngayCapGplx1 = ($gplx1 && !empty($gplx1->ngay_cap_gplx)) ? CustomFunc::convertYMDToDMY($gplx1->ngay_cap_gplx) : '';
            $ngayHhGplx1 = ($gplx1 && !empty($gplx1->ngay_hh_gplx)) ? CustomFunc::convertYMDToDMY($gplx1->ngay_hh_gplx) : '';
            $donViCapGplx1 = $gplx1 ? ($gplx1->don_vi_cap_gplx ?? '') : '';

            // GPLX 2
            $soGplx2 = $gplx2 ? ($gplx2->so_gplx ?? '') : '';
            $hangGplx2 = $gplx2 ? ($gplx2->hang_gplx ?? '') : '';
            $ngayTtGplx2 = ($gplx2 && !empty($gplx2->ngay_tt_gplx)) ? CustomFunc::convertYMDToDMY($gplx2->ngay_tt_gplx) : '';
            $ngayCapGplx2 = ($gplx2 && !empty($gplx2->ngay_cap_gplx)) ? CustomFunc::convertYMDToDMY($gplx2->ngay_cap_gplx) : '';
            $ngayHhGplx2 = ($gplx2 && !empty($gplx2->ngay_hh_gplx)) ? CustomFunc::convertYMDToDMY($gplx2->ngay_hh_gplx) : '';
            $donViCapGplx2 = $gplx2 ? ($gplx2->don_vi_cap_gplx ?? '') : '';

            // GPLX 3
            $soGplx3 = $gplx3 ? ($gplx3->so_gplx ?? '') : '';
            $hangGplx3 = $gplx3 ? ($gplx3->hang_gplx ?? '') : '';
            $ngayTtGplx3 = ($gplx3 && !empty($gplx3->ngay_tt_gplx)) ? CustomFunc::convertYMDToDMY($gplx3->ngay_tt_gplx) : '';
            $ngayCapGplx3 = ($gplx3 && !empty($gplx3->ngay_cap_gplx)) ? CustomFunc::convertYMDToDMY($gplx3->ngay_cap_gplx) : '';
            $ngayHhGplx3 = ($gplx3 && !empty($gplx3->ngay_hh_gplx)) ? CustomFunc::convertYMDToDMY($gplx3->ngay_hh_gplx) : '';
            $donViCapGplx3 = $gplx3 ? ($gplx3->don_vi_cap_gplx ?? '') : '';

            $sheet->setCellValue('A' . $row, $stt);
            $sheet->setCellValue('B' . $row, $hoTen);
            $sheet->setCellValueExplicit('C' . $row, (string)$ngaySinh, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $gioiTinh);
            $sheet->setCellValueExplicit('E' . $row, (string)$soCccd, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F' . $row, (string)$ngayCapCccd, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' . $row, (string)$noiCapCccd, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('H' . $row, (string)$maDvhc, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('I' . $row, $chiTietThuongTru);
            $sheet->setCellValueExplicit('J' . $row, (string)$soDienThoai, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            // GPLX 1 (K - P)
            $sheet->setCellValueExplicit('K' . $row, (string)$soGplx1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $row, $hangGplx1);
            $sheet->setCellValueExplicit('M' . $row, (string)$ngayTtGplx1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('N' . $row, (string)$ngayCapGplx1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('O' . $row, (string)$ngayHhGplx1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('P' . $row, (string)$donViCapGplx1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            // GPLX 2 (Q - V)
            $sheet->setCellValueExplicit('Q' . $row, (string)$soGplx2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('R' . $row, $hangGplx2);
            $sheet->setCellValueExplicit('S' . $row, (string)$ngayTtGplx2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('T' . $row, (string)$ngayCapGplx2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('U' . $row, (string)$ngayHhGplx2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('V' . $row, (string)$donViCapGplx2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            // GPLX 3 (W - AB)
            $sheet->setCellValueExplicit('W' . $row, (string)$soGplx3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('X' . $row, $hangGplx3);
            $sheet->setCellValueExplicit('Y' . $row, (string)$ngayTtGplx3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('Z' . $row, (string)$ngayCapGplx3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('AA' . $row, (string)$ngayHhGplx3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('AB' . $row, (string)$donViCapGplx3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            // Ghi chú (AC)
            $sheet->setCellValue('AC' . $row, $ghiChu);

            // Format explicit text format code (@) to keep leading zeros in Excel
            $textCols = ['C', 'E', 'F', 'G', 'H', 'J', 'K', 'M', 'N', 'O', 'P', 'Q', 'S', 'T', 'U', 'V', 'W', 'Y', 'Z', 'AA', 'AB'];
            foreach ($textCols as $tCol) {
                $sheet->getStyle($tCol . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            }

            // Alignment & Style for row cells
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('W' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Set red text color for Column H (MÃ ĐVHC) in data row
            $sheet->getStyle('H' . $row)->getFont()->getColor()->setRGB('C00000');

            $row++;
        }

        // Auto-size columns
        $allCols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC'];
        foreach ($allCols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Sanitize filename
        $cleanFileName = preg_replace('/[^\w\s\d\-_]/u', '', $tenKhoaHoc);
        $cleanFileName = trim(preg_replace('/\s+/', '_', $cleanFileName));
        if (empty($cleanFileName)) {
            $cleanFileName = 'Export_PMDT';
        }
        $fileName = $cleanFileName . '_' . date('dmY') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
