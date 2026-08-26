<?php

namespace app\modules\daotao\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\modules\user\models\User;
use app\modules\daotao\models\HinhAnh;
use yii\filters\VerbFilter;

/**
 * ChamCongAnhController hỗ trợ chụp ảnh từ camera thiết bị và lưu hình ảnh giảng dạy
 */
class ChamCongAnhController extends Controller
{
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
     * Action hiển thị giao diện chụp ảnh từ camera
     * @param string|null $loai KEHOACH | LICHDUNGXE
     * @param string $luot DI | VE
     * @return string
     */
    public function actionIndex($loai = null, $luot = 'DI')
    {
        $idGiaoVien = null;
        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->id);
            if ($user && method_exists($user, 'getIdGiaoVien')) {
                $idGiaoVien = $user->getIdGiaoVien();
            }
        }

        $loai = $loai ?: HinhAnh::LOAI_KEHOACH;
        $luot = in_array(strtoupper($luot), [HinhAnh::LUOT_DI, HinhAnh::LUOT_VE]) ? strtoupper($luot) : HinhAnh::LUOT_DI;

        return $this->render('index', [
            'loai' => $loai,
            'luot' => $luot,
            'idGiaoVien' => $idGiaoVien,
            'loaiList' => HinhAnh::getLoaiHinhAnhList(),
            'luotList' => HinhAnh::getLuotList(),
        ]);
    }

    /**
     * Action nhận dữ liệu hình ảnh (Base64 hoặc File) và lưu vào server & DB
     * @return array
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        if (!$request->isPost) {
            return [
                'success' => false,
                'message' => 'Phương thức không hợp lệ.',
            ];
        }

        $loai = $request->post('loai', HinhAnh::LOAI_KEHOACH);
        $luot = $request->post('luot', HinhAnh::LUOT_DI);
        $idGiaoVien = $request->post('id_giao_vien');

        if (empty($idGiaoVien) && !Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->id);
            if ($user && method_exists($user, 'getIdGiaoVien')) {
                $idGiaoVien = $user->getIdGiaoVien();
            }
        }

        if (empty($idGiaoVien)) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy thông tin giáo viên. Vui lòng đăng nhập với tài khoản giáo viên.',
            ];
        }

        // Tạo thư mục /uploads/giangday/ nếu chưa có
        $uploadDir = Yii::getAlias('@webroot') . '/uploads/giangday/';
        if (!file_exists($uploadDir)) {
            FileHelper::createDirectory($uploadDir, 0775, true);
        }

        $extension = 'jpg';
        $fileName = date('YmdHis') . '_' . uniqid() . '_' . rand(100, 999) . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        $imageData = $request->post('image_data');

        if (!empty($imageData)) {
            // Xử lý chuỗi Base64
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $ext = strtolower($type[1]);
                if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'webp'])) {
                    $extension = ($ext === 'jpeg') ? 'jpg' : $ext;
                    $fileName = date('YmdHis') . '_' . uniqid() . '_' . rand(100, 999) . '.' . $extension;
                    $filePath = $uploadDir . $fileName;
                }
            }

            $decodedData = base64_decode($imageData);
            if ($decodedData === false) {
                return [
                    'success' => false,
                    'message' => 'Dữ liệu hình ảnh không hợp lệ.',
                ];
            }

            if (file_put_contents($filePath, $decodedData) === false) {
                return [
                    'success' => false,
                    'message' => 'Không thể lưu tệp hình ảnh vào hệ thống.',
                ];
            }
        } else {
            // Xử lý tệp được tải lên dạng multipart
            $uploadedFile = UploadedFile::getInstanceByName('file_upload');
            if ($uploadedFile) {
                $extension = strtolower($uploadedFile->extension) ?: 'jpg';
                $fileName = date('YmdHis') . '_' . uniqid() . '_' . rand(100, 999) . '.' . $extension;
                $filePath = $uploadDir . $fileName;
                if (!$uploadedFile->saveAs($filePath)) {
                    return [
                        'success' => false,
                        'message' => 'Không thể lưu file tải lên.',
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Không nhận được dữ liệu hình ảnh.',
                ];
            }
        }

        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
        $today = date('Y-m-d');

        // Tìm bản ghi HinhAnh đã tồn tại theo 4 tiêu chí: date, id_giao_vien, loai, luot
        $model = HinhAnh::find()->where([
            'date' => $today,
            'id_giao_vien' => (int)$idGiaoVien,
            'loai' => $loai,
            'luot' => $luot,
        ])->orderBy(['id' => SORT_DESC])->one();

        $oldFileName = null;
        if ($model) {
            // Đã tồn tại bản ghi cũ -> lưu lại tên file cũ để xóa sau khi cập nhật
            $oldFileName = $model->file_name;
        } else {
            // Chưa có bản ghi -> khởi tạo bản ghi mới
            $model = new HinhAnh();
            $model->loai = $loai;
            $model->luot = $luot;
            $model->id_giao_vien = (int)$idGiaoVien;
            $model->date = $today;
        }

        // Cập nhật tên file MỚI và thông tin kích thước/thời gian
        $model->file_name = $fileName;
        $model->file_size = $fileSize;
        $model->extension = $extension;
        $model->thoi_gian_tao = date('Y-m-d H:i:s');

        if ($model->save()) {
            // Nếu đây là trường hợp chấm công lại (ghi đè), xóa tệp ảnh cũ trên máy chủ
            if (!empty($oldFileName) && $oldFileName !== $fileName) {
                $oldPath = $uploadDir . $oldFileName;
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            return [
                'success' => true,
                'message' => 'Chụp và tải lên hình ảnh thành công!',
                'data' => [
                    'id' => $model->id,
                    'file_name' => $fileName,
                    'file_url' => Yii::getAlias('@web') . '/uploads/giangday/' . $fileName,
                    'loai' => $model->loai,
                    'luot' => $model->luot,
                    'date' => $model->date,
                ],
            ];
        } else {
            // Xóa file tạm vừa lưu nếu không lưu được bản ghi database
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            return [
                'success' => false,
                'message' => 'Lỗi khi lưu dữ liệu hình ảnh.',
                'errors' => $model->getErrors(),
            ];
        }
    }
}
