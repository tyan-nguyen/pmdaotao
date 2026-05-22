<?php

namespace app\modules\taisan\controllers;

use Yii;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\taisan\models\search\PhieuDeNghiSearch;
use app\modules\taisan\models\search\PhieuSuaXeSearch;
use app\modules\user\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * PhieuDeNghiController implements the CRUD actions for PhieuDeNghi model.
 */
class PhieuSuaXeController extends Controller
{
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

    public function actionTrinhDuyet($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP) {
                $model->trang_thai = PhieuDeNghi::TRANGTHAI_CHODUYET;
                $model->thoi_gian_gui_duyet = date('Y-m-d H:i:s');
                $model->save(false);
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                    'tcontent' => 'Đã gửi duyệt phiếu thành công!'
                ];
            } else {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                    'tcontent' => 'Có lỗi xảy ra!'
                ];
            }
        }
    }

    /**
     * load hoa don in (phieu de nghi)
     * @return mixed
     */
    public function actionGetPhieuInAjax($idPhieu)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = PhieuDeNghi::findOne($idPhieu);
        if ($model != null) {
            return [
                'status' => 'success',
                'content' => $this->renderAjax('_print_phieu', [
                    'model' => $model
                ])
            ];
        } else {
            return [
                'status' => 'failed',
                'content' => 'Phiếu không tồn tại!'
            ];
        }
    }

    /**
     * load hoa don in (phieu chi phi)
     * @return mixed
     */
    public function actionGetPhieuInChiPhiAjax($idPhieu)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = PhieuDeNghi::findOne($idPhieu);
        if ($model != null) {
            return [
                'status' => 'success',
                'content' => $this->renderAjax('_print_phieu_chi_phi', [
                    'model' => $model
                ])
            ];
        } else {
            return [
                'status' => 'failed',
                'content' => 'Phiếu không tồn tại!'
            ];
        }
    }

    /**
     * update print count
     * @param unknown $id
     * @return boolean[]|NULL[]|boolean[]
     */
    public function actionUpdatePrintCount($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);
        if ($model !== null) {
            $model->so_lan_in = ($model->so_lan_in ?? 0) + 1;
            if ($model->save(false)) {
                return ['success' => true, 'so_lan_in' => $model->so_lan_in];
            }
        }
        return ['success' => false];
    }

    /**
     * xuat hoa don va thanh toan
     */
    public function actionThanhToan($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        Yii::$app->response->format = Response::FORMAT_JSON;

        //check đơn hàng null
        if (!$model->chiTiets) {
            $model->addError('id', 'Nội dung phiếu trống, vui lòng thêm chi tiết vào phiếu!');
            return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => "Cập nhật Phiếu đề nghị",
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                ]),
                'tcontent' => 'Nội dung phiếu trống, vui lòng thêm chi tiết vào phiếu!',
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                    Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }

        $trangThaiHienTai = $model->trang_thai;
        $model->da_thanh_toan = 1;
        $model->ngay_thanh_toan = date('Y-m-d H:i:s');
        $model->nguoi_thanh_toan = Yii::$app->user->id;
        $model->loai_thanh_toan = PhieuDeNghi::LOAITT_LE;

        if ($model->save()) {
            $model->refresh();

            return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => "Cập nhật Phiếu đề nghị",
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                ]),
                'tcontent' => 'Thanh toán thành công!',
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                    Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }

    /**
     * Lists all PhieuDeNghi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhieuSuaXeSearch();
        if (isset($_POST['search']) && $_POST['search'] != null) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new PhieuSuaXeSearch(); // "reset"
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
     * Displays a single PhieuDeNghi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Phiếu đề nghị",
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
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
     * Creates a new PhieuDeNghi model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PhieuDeNghi();
        $model->loai_phieu = PhieuDeNghi::LOAIPHIEU_SUACHUA;
        $model->loai_tai_san = PhieuDeNghi::LOAITAISAN_XE;

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm mới Phiếu đề nghị",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {
                /*  return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Thêm mới Phiếu đề nghị",
                    'content' => '<span class="text-success">Thêm mới thành công</span>',
                    'tcontent' => 'Thêm mới thành công!',
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Tiếp tục thêm', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                ]; */
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Cập nhật Phiếu đề nghị",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'tcontent' => 'Thêm mới thành công! Vui lòng thêm chi tiết cho phiếu đề nghị.',
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) . Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else {
                return [
                    'title' => "Thêm mới Phiếu đề nghị",
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
     * Updates an existing PhieuDeNghi model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        //$canEdit = $model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP || User::hasRole('admin') || User::getCurrentUser()->superadmin;
        $canEdit = $model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP;
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Cập nhật Phiếu đề nghị",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        ($canEdit ? Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"]) : '')
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                if (Yii::$app->params['showView']) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Phiếu đề nghị",
                        'content' => $this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent' => 'Cập nhật thành công!',
                        'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                            Html::a('Sửa', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                } else {
                    return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'tcontent' => 'Cập nhật thành công!',];
                }
            } else {
                return [
                    'title' => "Cập nhật Phiếu đề nghị",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        ($canEdit ? Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"]) : '')
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
     * Delete an existing PhieuDeNghi model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        //check model có do user tạo hay không, nếu không phải do user tạo thì không cho xóa, tránh xóa nhầm
        if ($model->nguoi_tao != Yii::$app->user->id) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose' => true,
                'forceReload' => '#crud-datatable-pjax',
                'tcontent' => 'Bạn chỉ có thể xóa phiếu do mình tạo ra!',
            ];
        } else {
            if ($model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP) {
                $model->delete();
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'forceClose' => true,
                    'forceReload' => '#crud-datatable-pjax',
                    'tcontent' => 'Chỉ có thể xóa phiếu ở trạng thái Nháp!',
                ];
            }
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
     * Delete multiple existing PhieuDeNghi model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        $delOk = true;
        $fList = array();
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);

            if ($model->nguoi_tao != Yii::$app->user->id) {
                $delOk = false;
                $fList[] = 'Phiếu #' . $model->id;
            } else {
                if ($model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP) {
                    $model->delete();
                } else {
                    $delOk = false;
                    $fList[] = 'Phiếu #' . $model->id;
                }
            }
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose' => true,
                'forceReload' => '#crud-datatable-pjax',
                'tcontent' => $delOk == true ? 'Xóa thành công!' : ('Không thể xóa:' . implode('</br>', $fList) . '. Vui lòng kiểm tra lại!'),
            ];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the PhieuDeNghi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhieuDeNghi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhieuDeNghi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
