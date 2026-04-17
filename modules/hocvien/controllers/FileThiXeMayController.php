<?php

namespace app\modules\hocvien\controllers;

use Yii;
use app\modules\hocvien\models\FileThiXeMay;
use app\modules\hocvien\models\search\FileThiXeMaySearch;
use app\modules\hocvien\models\FileThiXeMayContent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\IOFactory;
use app\custom\CustomFunc;
use app\models\FileUploadForm;
use app\modules\hocvien\models\HocVien;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * FileThiXeMayController implements the CRUD actions for FileThiXeMay model.
 */
class FileThiXeMayController extends Controller
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

    /**
     * Lists all FileThiXeMay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileThiXeMaySearch();
        if (isset($_POST['search']) && $_POST['search'] != null) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new FileThiXeMaySearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImport()
    {
        //nếu còn file chưa xử lý thì thông báo
        $file = FileThiXeMay::find()->where(['da_doc_file_ok' => 0])->one();
        if ($file) {
            Yii::$app->session->setFlash('error', 'Còn file chưa xử lý!');
            return $this->redirect(['index']);
        }
        $model = new FileUploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $filename = date('Ymd_His') . '_' . uniqid() . '.' . pathinfo($model->file->name, PATHINFO_EXTENSION);
                $filePath = Yii::getAlias('@webroot') . '/uploads/thi-xe-may/' . $filename;

                if ($model->file->saveAs($filePath)) {
                    $newFile = new FileThiXeMay();
                    $newFile->ten_khoa_thi = pathinfo($model->file->name, PATHINFO_FILENAME);
                    //$newFile->ngay_thi = '';
                    $newFile->url = $filename;
                    $newFile->filename = $model->file->name;
                    //$newFile->ghi_chu = '';

                    if ($newFile->save()) {
                        return $this->redirect('/hocvien/file-thi-xe-may/index?menu=hvd');
                    }
                }
            }
        }

        return $this->render('import', ['model' => $model]);
    }

    /**
     * Readfile & import content file to db (file_thi_xe_may_content).
     * @param integer $id
     * @return mixed
     * tạm tắt tìm theo ngày sinh vì sợ lỗi định dạng datime trong excel
     */
    public function actionReadFile($id)
    {
        $model = FileThiXeMay::findOne($id);
        $filePath = Yii::getAlias('@webroot') . '/uploads/thi-xe-may/' . $model->url;
        // Đọc file Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $request = Yii::$app->request;

        $textFirstRow = $rows[0][0];
        $textSBD = $rows[2][0];
        $textHoTen = $rows[2][1];
        $textNgaySinh = $rows[2][2];
        $textCMT = $rows[2][3];

        $titleCheck = false;
        $rowErrors = null;
        if (
            mb_strtoupper($textSBD, 'UTF-8') === 'SBD' &&
            mb_strtoupper($textHoTen, 'UTF-8') === 'HỌ TÊN' &&
            mb_strtoupper($textNgaySinh, 'UTF-8') === 'NGÀY SINH' &&
            mb_strtoupper($textCMT, 'UTF-8') === 'SỐ CMT'
        ) {
            $titleCheck = true;
        }
        if ($titleCheck === false) {
            return [
                'title' => "Kết quả CHECK FILE",
                'content' => "File không đúng định dạng!",
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
        //duyet qua mang gia tri check tung hoc vien valid
        unset($rows[0]);
        unset($rows[1]);
        unset($rows[2]);
        $curentRow = 3;
        $visitedSBD = [];
        $visitedCMT = [];

        foreach ($rows as $row) {


            /*  var_dump($row[2]);
            die; */



            $curentRow++;
            if ($row[0] == null || $row[1] == null || $row[2] == null || $row[3] == null) {
                $rowErrors[$curentRow] = 'Lỗi dữ liệu trống!';
                continue;
            }

            // Check trùng SBD trong file
            if (isset($visitedSBD[$row[0]])) {
                $rowErrors[$curentRow] = 'Trùng SBD <strong>' . $row[0] . '</strong> với dòng ' . $visitedSBD[$row[0]];
            } else {
                $visitedSBD[$row[0]] = $curentRow;
            }
            // Check trùng CMT trong file
            if (isset($visitedCMT[$row[3]])) {
                $rowErrors[$curentRow] = 'Trùng số CMT <strong>' . $row[3] . '</strong> với dòng ' . $visitedCMT[$row[3]];
            } else {
                $visitedCMT[$row[3]] = $curentRow;
            }

            //check custom id hoc vien (row E)
            if (isset($row[4]) && $row[4] != null) {
                $hocVien = HocVien::findOne($row[4]);
                if ($hocVien === null) {
                    $rowErrors[$curentRow] = 'Thông tin học viên (custom id) SBD <strong>' . $row[0] . '</strong> không tồn tại';
                } else {
                    //check sbd
                    if ($hocVien->ho_ten != $row[1] || $hocVien->so_cccd != $row[3]) {
                        $rowErrors[$curentRow] = 'Thông tin học viên (custom id) SBD <strong>' . $row[0] . '</strong> không đúng';
                    }
                }
            } else {

                $query = HocVien::find()->where([
                    //'ngay_sinh' => CustomFunc::convertDMYToYMD($row[2]), //tạm bỏ
                    'so_cccd' => $row[3],
                ])
                    ->andWhere(new Expression('UPPER(ho_ten) = :name', [':name' => mb_strtoupper($row[1], 'UTF-8')]))
                    ->andWhere('id_hang IN (7,8,9,10)'); //hạng xe máy
                //$hocVien = $query->one();
                $countHocVien = $query->count();

                if ($countHocVien == 0) {
                    $rowErrors[$curentRow] = 'Thông tin học viên SBD <strong>' . $row[0] . '</strong> không tồn tại';
                } else if ($countHocVien > 1) {
                    $rowErrors[$curentRow] = 'Có nhiều hơn 1 học viên cùng thông tin, hãy chỉnh sửa bằng cách thêm ID học viên vào cột E.';
                }
            }
            //return $this->render('view', ['model' => $model]); //render để test
        }

        if ($rowErrors === null) {
            $model->da_doc_file_ok = 1;
            $model->save(false);
        } else {
            $model->da_doc_file_ok = 2;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title' => "Kết quả CHECK FILE",
            //'content' => "Đã đọc nội dung file từ: " . $textFirstRow . ' - ' . implode('<br/>', $rowErrors),
            'content' => $this->renderPartial('check_file_result', [
                'rowErrors' => $rowErrors,
                'textFirstRow' => $textFirstRow,
            ]),
            'forceReload' => '#crud-datatable-pjax',
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
        ];
    }

    /**
     * Readfile & import content file to db (file_thi_xe_may).
     * @param integer $id
     * @return mixed
     */
    public function actionImportFile($id)
    {
        $model = FileThiXeMay::findOne($id);
        $filePath = Yii::getAlias('@webroot') . '/uploads/thi-xe-may/' . $model->url;
        // Đọc file Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        unset($rows[0]);
        unset($rows[1]);
        unset($rows[2]);
        $success = 0;
        $failed = 0;
        foreach ($rows as $row) {
            //tim hoc vien
            //check custom id hoc vien (row E)
            if (isset($row[4]) && $row[4] != null) {
                $hocVien = HocVien::findOne($row[4]);
                if ($hocVien != null) {
                    $data = new FileThiXeMayContent();
                    $data->id_hoc_vien = $hocVien->id;
                    $data->id_file = $model->id;
                    $data->sbd = $row[0];
                    $data->ho_ten = $row[1];
                    $data->ngay_sinh = $row[2];
                    $data->cccd = $row[3];
                    if ($data->save()) {
                        $success++;
                    } else {
                        $failed++;
                    }
                }
            } else {
                $hocVien = HocVien::find()->where([
                    //'ngay_sinh' => CustomFunc::convertDMYToYMD($row[2]),
                    'so_cccd' => $row[3],
                ])
                    ->andWhere(new Expression('UPPER(ho_ten) = :name', [':name' => strtoupper($row[1])]))
                    ->andWhere('id_hang IN (7,8,9,10)') //hạng xe máy
                    ->one();
                if ($hocVien != null) {
                    $data = new FileThiXeMayContent();
                    $data->id_hoc_vien = $hocVien->id;
                    $data->id_file = $model->id;
                    $data->sbd = $row[0];
                    $data->ho_ten = $row[1];
                    $data->ngay_sinh = $row[2];
                    $data->cccd = $row[3];
                    if ($data->save()) {
                        $success++;
                    } else {
                        $failed++;
                    }
                }
            }
        }
        return [
            'title' => "Kết quả IMPORT FILE",
            'content' => "<span style='color:green;font-size:16px;'>Thành công: " . $success . "</span><br/>" . "<span style='color:red;font-size:16px;'>Thất bại: " . $failed . "</span>",
            'forceReload' => '#crud-datatable-pjax',
            'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
        ];
    }

    /**
     * Displays a single FileTrichXuat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "FileTrichXuat",
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
     * Updates an existing FileTrichXuat model.
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
                    'title' => "Cập nhật File Danh sách thi xe máy",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                if (Yii::$app->params['showView']) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "File Danh sách thi xe máy",
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
                    'title' => "Cập nhật File Danh sách thi xe máy",
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

    /**
     * Delete an existing FileTrichXuat model.
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
     * Delete multiple existing FileTrichXuat model.
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
            try {
                $model->delete();
            } catch (\Exception $e) {
                $delOk = false;
                $fList[] = $model->id;
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
                'tcontent' => $delOk == true ? 'Xóa thành công!' : ('Không thể xóa:' . implode('</br>', $fList)),
            ];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the FileThiXeMay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileThiXeMay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileThiXeMay::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
