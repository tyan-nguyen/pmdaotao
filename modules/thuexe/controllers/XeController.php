<?php

namespace app\modules\thuexe\controllers;

use Yii;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\search\XeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\modules\thuexe\models\HinhXe;
use app\custom\CustomFunc;
use app\models\PtxXeVitriGps;
use app\models\PtxXeVungGioiHan;

/**
 * XeController implements the CRUD actions for Xe model.
 */
class XeController extends Controller
{
    public $freeAccessActions = ['luu-vung-gioi-han', 'xoa-vung-gioi-han'];
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

    /**
     * Lists all Xe models.
     * @return mixed
     */
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý thuê xe';
        Yii::$app->params['modelID'] = 'Danh sách Xe';
        //disable csrf for ajax actions
        if (in_array($action->id, ['upload-images', 'luu-vung-gioi-han', 'xoa-vung-gioi-han'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new XeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lấy vị trí GPS của các xe từ MidApiService và lưu vào bảng ptx_xe_vi_tri_gps
     */
    public function actionLayViTriGps()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            // 1. Gọi API MID để lấy danh sách thiết bị GPS realtime
            $gpsResult = Yii::$app->midApi->fetchRealtimeGps();
            $devices = $gpsResult['data'] ?? [];

            if (empty($devices) || !is_array($devices)) {
                return [
                    'status' => 'warning',
                    'title' => 'Thông báo',
                    'message' => 'API MID không trả về dữ liệu thiết bị GPS nào.',
                ];
            }

            // 2. Lấy danh sách tất cả xe có cấu hình imei_gps
            $vehicles = Xe::find()
                ->where(['not', ['imei_gps' => null]])
                ->andWhere(['!=', 'imei_gps', ''])
                ->all();

            if (empty($vehicles)) {
                return [
                    'status' => 'warning',
                    'title' => 'Chưa có cấu hình IMEI',
                    'message' => 'Hiện chưa có xe nào được cấu hình Số IMEI GPS trong danh sách xe.',
                ];
            }

            $updatedCount = 0;
            $updatedList = [];
            $now = date('Y-m-d H:i:s');

            foreach ($vehicles as $xe) {
                $imei = trim($xe->imei_gps);
                if (isset($devices[$imei])) {
                    $item = $devices[$imei];
                    $viTri = new PtxXeVitriGps();
                    $viTri->id_xe = $xe->id;
                    $viTri->imei = $imei;
                    $viTri->latitude = (float)($item['latitude'] ?? 0);
                    $viTri->longitude = (float)($item['longitude'] ?? 0);
                    $viTri->speed = isset($item['speed']) ? (float)$item['speed'] : 0;
                    $viTri->rotation = isset($item['rotation']) ? (float)$item['rotation'] : 0;
                    $viTri->acc = isset($item['acc']) ? (int)$item['acc'] : 0;
                    $viTri->status = isset($item['status']) ? (int)$item['status'] : null;
                    $viTri->status_device = isset($item['status_device']) ? (int)$item['status_device'] : null;
                    $viTri->signal_quality = isset($item['signal_quality']) ? (int)$item['signal_quality'] : null;
                    $viTri->fuel_lit = (!empty($item['fuel_lit']) && is_numeric($item['fuel_lit'])) ? (float)$item['fuel_lit'] : null;
                    $viTri->fuel_percent = (!empty($item['fuel_percent']) && is_numeric($item['fuel_percent'])) ? (float)$item['fuel_percent'] : null;

                    if (!empty($item['time_record']) && is_numeric($item['time_record'])) {
                        $viTri->time_record = date('Y-m-d H:i:s', (int)$item['time_record']);
                    } elseif (!empty($item['time']) && is_numeric($item['time'])) {
                        $viTri->time_record = date('Y-m-d H:i:s', (int)$item['time']);
                    } else {
                        $viTri->time_record = $now;
                    }

                    $viTri->thoi_gian_tao = $now;
                    $viTri->du_lieu_json = json_encode($item, JSON_UNESCAPED_UNICODE);

                    if ($viTri->save(false)) {
                        $updatedCount++;
                        $updatedList[] = $xe->bien_so_xe;
                    }
                }
            }

            return [
                'status' => 'success',
                'title' => 'Thành công',
                'message' => "Đã cập nhật vị trí GPS cho {$updatedCount}/" . count($vehicles) . " xe (" . implode(', ', $updatedList) . ").",
                'forceReload' => '#crud-datatable-pjax',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'title' => 'Lỗi kết nối GPS',
                'message' => 'Lỗi khi gọi API MID: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Xem vị trí GPS của xe trên bản đồ popup
     * @param int $id ID xe
     */
    public function actionXemViTriGps($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        // Nếu yêu cầu refresh trực tiếp từ popup
        if ($request->get('refresh')) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!empty($model->imei_gps)) {
                try {
                    $gpsResult = Yii::$app->midApi->fetchRealtimeGps();
                    $devices = $gpsResult['data'] ?? [];
                    $imei = trim($model->imei_gps);
                    if (isset($devices[$imei])) {
                        $item = $devices[$imei];
                        $now = date('Y-m-d H:i:s');
                        $viTri = new PtxXeVitriGps();
                        $viTri->id_xe = $model->id;
                        $viTri->imei = $imei;
                        $viTri->latitude = (float)($item['latitude'] ?? 0);
                        $viTri->longitude = (float)($item['longitude'] ?? 0);
                        $viTri->speed = isset($item['speed']) ? (float)$item['speed'] : 0;
                        $viTri->rotation = isset($item['rotation']) ? (float)$item['rotation'] : 0;
                        $viTri->acc = isset($item['acc']) ? (int)$item['acc'] : 0;
                        $viTri->status = isset($item['status']) ? (int)$item['status'] : null;
                        $viTri->status_device = isset($item['status_device']) ? (int)$item['status_device'] : null;
                        $viTri->signal_quality = isset($item['signal_quality']) ? (int)$item['signal_quality'] : null;
                        $viTri->fuel_lit = (!empty($item['fuel_lit']) && is_numeric($item['fuel_lit'])) ? (float)$item['fuel_lit'] : null;
                        $viTri->fuel_percent = (!empty($item['fuel_percent']) && is_numeric($item['fuel_percent'])) ? (float)$item['fuel_percent'] : null;

                        if (!empty($item['time_record']) && is_numeric($item['time_record'])) {
                            $viTri->time_record = date('Y-m-d H:i:s', (int)$item['time_record']);
                        } elseif (!empty($item['time']) && is_numeric($item['time'])) {
                            $viTri->time_record = date('Y-m-d H:i:s', (int)$item['time']);
                        } else {
                            $viTri->time_record = $now;
                        }

                        $viTri->thoi_gian_tao = $now;
                        $viTri->du_lieu_json = json_encode($item, JSON_UNESCAPED_UNICODE);
                        $viTri->save(false);

                        return [
                            'success' => true,
                            'message' => 'Đã cập nhật vị trí GPS mới nhất!',
                            'data' => [
                                'lat' => (float)$viTri->latitude,
                                'lng' => (float)$viTri->longitude,
                                'speed' => $viTri->speed,
                                'rotation' => $viTri->rotation,
                                'acc' => $viTri->acc,
                                'time_record' => $viTri->time_record ? date('d/m/Y H:i:s', strtotime($viTri->time_record)) : '',
                                'thoi_gian_tao' => date('d/m/Y H:i:s', strtotime($viTri->thoi_gian_tao)),
                                'is_dang_chay' => $viTri->isDangChay(),
                                'marker_color' => $viTri->getMarkerColor(),
                                'badge' => $viTri->getTrangThaiBadge(),
                                'time_ago' => $viTri->getTimeAgo(),
                            ]
                        ];
                    } else {
                        return ['success' => false, 'message' => "Không tìm thấy dữ liệu GPS từ thiết bị IMEI {$imei} trên MID."];
                    }
                } catch (\Exception $e) {
                    return ['success' => false, 'message' => 'Lỗi kết nối API MID: ' . $e->getMessage()];
                }
            }
            return ['success' => false, 'message' => 'Xe chưa được cấu hình IMEI GPS.'];
        }

        $viTriMoiNhat = $model->viTriGpsMoiNhat;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => '<i class="fa-solid fa-map-location-dot text-primary"></i> Vị trí GPS - Xe ' . $model->bien_so_xe . ($model->hieu_xe ? ' (' . $model->hieu_xe . ')' : ''),
                'content' => $this->renderAjax('xem-vi-tri-gps', [
                    'model' => $model,
                    'viTri' => $viTriMoiNhat,
                ]),
                'footer' => Html::button('<i class="fa fa-sync"></i> Cập nhật vị trí', [
                    'class' => 'btn btn-success btn-refresh-gps',
                    'data-id' => $model->id,
                    'title' => 'Lấy vị trí GPS mới nhất từ thiết bị'
                ]) . '&nbsp;' .
                Html::button('Đóng lại', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }

        return $this->render('xem-vi-tri-gps', [
            'model' => $model,
            'viTri' => $viTriMoiNhat,
        ]);
    }

    /**
     * Xem bản đồ tổng quan toàn bộ xe
     */
    public function actionBanDoTongQuan()
    {
        $request = Yii::$app->request;
        $vehicles = Xe::find()
            ->where(['not', ['imei_gps' => null]])
            ->andWhere(['!=', 'imei_gps', ''])
            ->all();

        $classified = PtxXeVungGioiHan::phanLoaiVaThongKeXe($vehicles);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => '<i class="fa-solid fa-map text-primary"></i> Bản đồ giám sát vị trí tất cả các xe',
                'content' => $this->renderAjax('ban-do-tong-quan', [
                    'vehicleData' => $classified['vehicleData'],
                    'vungList' => $classified['vungList'],
                    'stats' => $classified['stats'],
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }

        return $this->render('ban-do-tong-quan', [
            'vehicleData' => $classified['vehicleData'],
            'vungList' => $classified['vungList'],
            'stats' => $classified['stats'],
        ]);
    }

    /**
     * Lưu hoặc cập nhật vùng giới hạn (đa giác)
     */
    public function actionLuuVungGioiHan()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $id = $request->post('id');
        $tenVung = trim($request->post('ten_vung', ''));
        $loaiVung = $request->post('loai_vung', 'KHUON_VIEN');
        $mauSac = $request->post('mau_sac', '#2563eb');
        $coords = $request->post('coords'); // Mảng [[lat, lng], ...]

        if (empty($tenVung)) {
            return [
                'status' => 'error',
                'message' => 'Tên vùng giới hạn không được để trống.',
            ];
        }

        if (!is_array($coords) || count($coords) < 3) {
            return [
                'status' => 'error',
                'message' => 'Đa giác phải có ít nhất 3 điểm tọa độ để tạo thành vùng khép kín.',
            ];
        }

        // Chuẩn hóa tọa độ các đỉnh
        $cleanCoords = [];
        foreach ($coords as $pt) {
            if (isset($pt[0], $pt[1]) && is_numeric($pt[0]) && is_numeric($pt[1])) {
                $cleanCoords[] = [(float)$pt[0], (float)$pt[1]];
            }
        }

        if (count($cleanCoords) < 3) {
            return [
                'status' => 'error',
                'message' => 'Tọa độ các đỉnh của đa giác không hợp lệ.',
            ];
        }

        if ($id) {
            $model = PtxXeVungGioiHan::findOne($id);
            if (!$model) {
                return [
                    'status' => 'error',
                    'message' => 'Vùng giới hạn cần sửa không tồn tại.',
                ];
            }
            $model->thoi_gian_cap_nhat = date('Y-m-d H:i:s');
        } else {
            $model = new PtxXeVungGioiHan();
            $model->thoi_gian_tao = date('Y-m-d H:i:s');
            $model->trang_thai = 1;
        }

        $model->ten_vung = $tenVung;
        $model->loai_vung = $loaiVung;
        $model->mau_sac = $mauSac;
        $model->setCoordinates($cleanCoords);

        if ($model->save()) {
            // Tính toán lại thống kê cho tất cả các xe
            $vehicles = Xe::find()
                ->where(['not', ['imei_gps' => null]])
                ->andWhere(['!=', 'imei_gps', ''])
                ->all();
            $classified = PtxXeVungGioiHan::phanLoaiVaThongKeXe($vehicles);

            return [
                'status' => 'success',
                'message' => 'Lưu vùng giới hạn "' . $model->ten_vung . '" thành công!',
                'vung' => [
                    'id' => $model->id,
                    'ten_vung' => $model->ten_vung,
                    'loai_vung' => $model->loai_vung,
                    'mau_sac' => $model->mau_sac,
                    'coords' => $model->getCoordinates(),
                ],
                'stats' => $classified['stats'],
                'vehicleData' => $classified['vehicleData'],
                'vungList' => $classified['vungList'],
            ];
        } else {
            $errors = [];
            foreach ($model->errors as $err) {
                $errors[] = implode(', ', $err);
            }
            return [
                'status' => 'error',
                'message' => 'Lỗi khi lưu vùng: ' . implode('; ', $errors),
            ];
        }
    }

    /**
     * Xóa vùng giới hạn
     */
    public function actionXoaVungGioiHan()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = PtxXeVungGioiHan::findOne($id);

        if (!$model) {
            return ['status' => 'error', 'message' => 'Vùng không tồn tại hoặc đã bị xóa trước đó.'];
        }

        $tenVung = $model->ten_vung;
        $model->delete();

        $vehicles = Xe::find()
            ->where(['not', ['imei_gps' => null]])
            ->andWhere(['!=', 'imei_gps', ''])
            ->all();
        $classified = PtxXeVungGioiHan::phanLoaiVaThongKeXe($vehicles);

        return [
            'status' => 'success',
            'message' => 'Đã xóa vùng giới hạn "' . $tenVung . '" thành công!',
            'stats' => $classified['stats'],
            'vehicleData' => $classified['vehicleData'],
            'vungList' => $classified['vungList'],
        ];
    }
    /**
     * cập nhật giáo viên phụ trách xe
     * tham số: $id -> id xe
     */
    public function actionPhanCongGiaoVien($id)
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Xe::findOne($id);
        //$model->scenario = 'phan-cong-giao-vien';
        if ($model == null) {
            return [
                'title' => 'Thông báo',
                'content' => 'Xe không tồn tại!',
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
        if ($request->isAjax) {
            if ($request->isGet) {
                return [
                    'title' => "Phân công giáo viên phụ trách xe",
                    'content' => $this->renderAjax('_formGiaoVien', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Lưu lại', ['type' => 'submit', 'class' => 'btn btn-primary']) . '&nbsp;'
                        . Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else if ($model->load($request->post())) {
                if ($model->id_giao_vien && $model->validate('id_giao_vien')) {
                    $model->updateAttributes(['id_giao_vien']);
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                        'tcontent' => 'Phân công giáo viên phụ trách thành công!',
                    ];
                } else {
                    $model->updateAttributes(['id_giao_vien']);
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                        'tcontent' => 'Xóa thông tin giáo viên phụ trách thành công!',
                    ];
                }
            } else {
                return [
                    'title' => "Phân công giáo viên phụ trách xe",
                    'content' => $this->renderAjax('_formGiaoVien', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Lưu lại', ['type' => 'submit', 'class' => 'btn btn-primary']) . '&nbsp;'
                        . Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
                ];
            }
        } //if isAjax
    }


    /**
     * Displays a single Xe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Xe " . $model->bien_so_xe,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                    Html::a('Sửa', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Xe model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Xe();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm mới Xe",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post())) {
                // Kiểm tra nếu request gửi lên có chọn không màu, hoặc ô input bị disable không gửi dữ liệu
                if (!isset($_POST['Xe']['ma_mau']) || Yii::$app->request->post('no_color')) {
                    $model->ma_mau = null;
                }
                if ($model->save()) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Thêm mới Xe",
                        'content' => '<span class="text-success">Thêm mới Xe thành công !</span>',
                        'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::a('Tiếp tục tạo', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                    ];
                } else {
                    return [
                        'title' => "Thêm mới Xe",
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])

                    ];
                }
            } else {
                return [
                    'title' => "Thêm mới Xe",
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
    /**
     * Updates an existing Xe model.
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
                    'title' => "Cập nhật Xe #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' =>     Html::a(
                        '<i class="fa fa-image"> </i> Hình xe',
                        ['/thuexe/xe/delete-image', 'id' => $id, 'modalType' => 'modal-remote-2'],
                        [
                            'class' => 'btn btn-info',
                            'role' => 'modal-remote-2',
                            'title' => 'Cập nhật Hình'
                        ]
                    ) .
                        Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                // Kiểm tra nếu request gửi lên có chọn không màu, hoặc ô input bị disable không gửi dữ liệu
                if (!isset($_POST['Xe']['ma_mau']) || Yii::$app->request->post('no_color')) {
                    $model->ma_mau = null;
                }
                if ($model->save()) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Xe #" . $id,
                        'content' => $this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::a('Sửa', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                } else {
                    return [
                        'title' => "Cập nhật Xe #" . $id,
                        'content' => $this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer' =>
                        Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                    ];
                }
            } else {
                return [
                    'title' => "Cập nhật Xe #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' =>
                    Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
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

    /**
     * Delete an existing Xe model.
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
     * Delete multiple existing Xe model.
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
     * Finds the Xe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Xe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Xe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAddImages($id) // $id là id của xe hiện tại
    {
        if (Yii::$app->request->isPost) {
            $model = new HinhXe();
            $model->id_xe = $id;
            $uploadedFile = UploadedFile::getInstanceByName('file');

            if ($uploadedFile) {
                $filePath = 'images/' . uniqid() . '.' . $uploadedFile->extension;
                if ($uploadedFile->saveAs($filePath)) {
                    $model->hinh_anh = $filePath;
                    $model->save();
                    if ($model->save()) {
                        return $this->asJson(['success' => true, 'message' => 'Hình ảnh đã được tải lên thành công!']);
                    }
                }
            }

            return $this->asJson(['success' => false, 'message' => 'Tải lên thất bại!']);
        }

        return $this->asJson([
            'title' => 'Thêm hình ảnh',
            'content' => $this->renderAjax('add-image', [
                'id' => $id,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ])
        ]);
    }

    public function actionAddImage($id)
    {
        $request = Yii::$app->request;
        $model = new HinhXe();
        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm ảnh Xe",
                    'content' => $this->renderAjax('add-image', [
                        'id' => $id,
                        'images' => $this->getUploadedImages($id),
                    ]),
                    'footer' => Html::button('Đóng lại', [
                        'class' => 'btn btn-default pull-left',
                        'data-bs-dismiss' => "modal",
                    ]) .
                        Html::button('Lưu lại', [
                            'class' => 'btn btn-primary',
                            'type' => "button",
                            'onclick' => 'saveSelectedImages()',
                        ]),
                ];
            } elseif ($request->isPost) {

                $selectedImages = $request->post('selectedImages');

                if (!empty($selectedImages)) {
                    foreach ($selectedImages as $fileName) {
                        $hinhXeModel = new HinhXe();
                        $hinhXeModel->id_xe = $id;
                        $hinhXeModel->hinh_anh = $fileName;

                        $src = Yii::getAlias('@webroot') . '/images/temp/' . $fileName;
                        $dest = Yii::getAlias('@webroot') . '/images/hinh-xe/' . $fileName;
                        //nếu move thành công thì lưu
                        if (CustomFunc::moveOrCopy($src, $dest)) {
                            if (!$hinhXeModel->save()) {
                                return [
                                    'success' => false,
                                    'message' => 'Lỗi khi lưu ảnh vào cơ sở dữ liệu: ' . implode(', ', $hinhXeModel->getErrorSummary(true)),
                                ];
                            }
                        }
                    }
                    return [
                        'success' => true,
                        'message' => 'Thêm ảnh thành công!',
                        'forceReload' => '#crud-datatable-pjax', // Làm mới bảng dữ liệu
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Vui lòng chọn ít nhất một ảnh.',
                    ];
                }
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('add-image', [
                    'model' => $model,
                    'id' => $id,
                ]);
            }
        }
    }



    protected function getUploadedImages($id)
    {
        $tempDir = Yii::getAlias('@webroot/images/temp');
        $uploadedImages = [];


        if (is_dir($tempDir)) {
            $files = scandir($tempDir);
            foreach ($files as $file) {

                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) {
                    $uploadedImages[] = $file;
                }
            }
        }

        return $uploadedImages;
    }

    public function actionUploadImages($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $uploadDir = Yii::getAlias('@webroot/images/temp');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $fileName = uniqid() . '.' . $file->extension;
            $filePath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

            if ($file->saveAs($filePath)) {
                return [
                    'success' => true,
                    'fileName' => $fileName,
                    'fileUrl' => Yii::getAlias('@web') . '/images/temp/' . $fileName,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Không thể lưu ảnh.',
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Không nhận được file tải lên.',
        ];
    }

    public function actionDeleteImage($id)
    {
        // Lấy danh sách hình xe theo id của xe
        $hinhXeList = HinhXe::find()->where(['id_xe' => $id])->all();

        // Kiểm tra nếu không tìm thấy hình ảnh nào
        if (empty($hinhXeList)) {
            return $this->asJson([
                'title' => 'Thông báo!',
                'content' => '<p>Không tìm thấy hình ảnh nào cho xe này.</p>',
                'footer' => Html::button('Đóng lại', [
                    'class' => 'btn btn-default pull-left',
                    'data-bs-dismiss' => "modal"
                ]),
            ]);
        }

        // Hiển thị danh sách hình ảnh
        return $this->asJson([
            'title' => 'Xóa Hình Ảnh Xe',
            'content' => $this->renderAjax('delete-image', [
                'hinhXeList' => $hinhXeList,
                'id' => $id,
            ]),
            'footer' => Html::button('Đóng lại', [
                'class' => 'btn btn-default pull-left',
                'data-bs-dismiss' => "modal"
            ]),

        ]);
    }

    public function actionDeleteSingleImage()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $imageId = Yii::$app->request->post('id');
        $hinh = HinhXe::findOne($imageId);
        if ($hinh->delete()) {
            return [
                'success' => true,
                'message' => 'Hình ảnh đã được xóa thành công.',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Không thể xóa hình ảnh. Vui lòng thử lại.',
            ];
        }
    }

    public function actionMakeImgPrimary()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $imageId = Yii::$app->request->post('id');
        $hinh = HinhXe::findOne($imageId);

        if ($hinh != null) {
            $setHinhError = 0;
            $hinhs = HinhXe::find()->where(['id_xe' => $hinh->id_xe])->all();
            if ($hinhs != null) {
                foreach ($hinhs as $indexHinh => $itemHinh) {
                    $itemHinh->la_dai_dien = 0;
                    if (!$itemHinh->save()) {
                        $setHinhError++;
                    }
                }
            }
            if ($setHinhError == 0) {
                $hinh->la_dai_dien = 1;
            }
        }

        if ($setHinhError == 0 && $hinh->save()) {
            return [
                'success' => true,
                'message' => 'Hình ảnh đã được đặt làm ảnh đại diện thành công!',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Không thể đặt hình ảnh làm ảnh đại diện. Vui lòng thử lại.',
            ];
        }
    }
}
