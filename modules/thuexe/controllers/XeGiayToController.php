<?php

namespace app\modules\thuexe\controllers;

use Yii;
use app\modules\thuexe\models\XeGiayTo;
use app\modules\thuexe\models\search\XeGiayToSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use app\custom\CustomFunc;

/**
 * XeGiayToController implements the CRUD actions for XeGiayTo model.
 */
class XeGiayToController extends Controller
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
                    'bulkdelete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all XeGiayTo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new XeGiayToSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single XeGiayTo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modalType = $request->get('modalType', 'modal-remote');
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Giấy tờ xe #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                    Html::a('Sửa', ['update', 'id' => $id, 'modalType' => $modalType], ['class' => 'btn btn-primary', 'role' => $modalType])
            ];
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new XeGiayTo model.
     * @param integer|null $id_xe
     * @return mixed
     */
    public function actionCreate($id_xe = null)
    {
        $request = Yii::$app->request;
        $model = new XeGiayTo();
        if ($id_xe !== null) {
            $model->id_xe = $id_xe;
        }

        $isModal2 = ($request->get('modalType') === 'modal-remote-2' || $request->post('modalType') === 'modal-remote-2' || $model->id_xe);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm mới Giấy tờ xe",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                if ($isModal2 && $model->xe) {
                    return [
                        'forceClose' => true,
                        'reloadType' => 'giayTo',
                        'reloadBlock' => '#giay-to-content',
                        'reloadContent' => $this->renderAjax('@app/modules/thuexe/views/xe/_giay_to_xe', [
                            'model' => $model->xe,
                        ]),
                        'tcontent' => 'Thêm mới giấy tờ xe thành công!',
                    ];
                } else {
                    return [
                        'forceClose' => true,
                        'forceReload' => '#crud-datatable-pjax',
                        'tcontent' => 'Thêm mới giấy tờ xe thành công!',
                    ];
                }
            } else {
                return [
                    'title' => "Thêm mới Giấy tờ xe",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
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
     * Updates an existing XeGiayTo model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $isModal2 = ($request->get('modalType') === 'modal-remote-2' || $request->post('modalType') === 'modal-remote-2');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                if ($model->ngay_bat_dau) {
                    $model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
                }
                if ($model->ngay_ket_thuc) {
                    $model->ngay_ket_thuc = CustomFunc::convertYMDToDMY($model->ngay_ket_thuc);
                }
                return [
                    'title' => "Cập nhật Giấy tờ xe #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                if ($isModal2 && $model->xe) {
                    return [
                        'forceClose' => true,
                        'reloadType' => 'giayTo',
                        'reloadBlock' => '#giay-to-content',
                        'reloadContent' => $this->renderAjax('@app/modules/thuexe/views/xe/_giay_to_xe', [
                            'model' => $model->xe,
                        ]),
                        'tcontent' => 'Cập nhật giấy tờ xe thành công!',
                    ];
                } else {
                    return [
                        'forceClose' => true,
                        'forceReload' => '#crud-datatable-pjax',
                        'tcontent' => 'Cập nhật giấy tờ xe thành công!',
                    ];
                }
            } else {
                return [
                    'title' => "Cập nhật Giấy tờ xe #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
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
     * Delete an existing XeGiayTo model.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $isModal2 = ($request->get('modalType') === 'modal-remote-2' || $request->post('modalType') === 'modal-remote-2');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($isModal2 && $model->xe) {
                $xe = $model->xe;
                $model->delete();
                return [
                    'forceClose' => true,
                    'reloadType' => 'giayTo',
                    'reloadBlock' => '#giay-to-content',
                    'reloadContent' => $this->renderAjax('@app/modules/thuexe/views/xe/_giay_to_xe', [
                        'model' => $xe,
                    ]),
                    'tcontent' => 'Xóa giấy tờ xe thành công!'
                ];
            } else {
                $model->delete();
                return [
                    'forceClose' => true,
                    'forceReload' => '#crud-datatable-pjax',
                    'tcontent' => 'Xóa giấy tờ xe thành công!'
                ];
            }
        } else {
            $model->delete();
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing XeGiayTo model.
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks'));
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            if ($model) {
                $model->delete();
            }
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose' => true,
                'forceReload' => '#crud-datatable-pjax',
                'tcontent' => 'Xóa thành công!'
            ];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the XeGiayTo model based on its primary key value.
     * @param integer $id
     * @return XeGiayTo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = XeGiayTo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang yêu cầu không tồn tại.');
        }
    }
}
