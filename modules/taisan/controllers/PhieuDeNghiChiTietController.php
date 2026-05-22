<?php

namespace app\modules\taisan\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\banhang\models\HoaDonChiTiet;
use app\modules\banhang\models\HoaDon;
use app\modules\banhang\models\LoaiHangHoa;
use app\modules\banhang\models\HangHoa;
use app\modules\taisan\models\DmHangMuc;
use app\modules\taisan\models\DmLoaiHangMuc;
use app\modules\taisan\models\PhieuChiTiet;
use app\modules\taisan\models\PhieuDeNghi;

/**
 * PhieuDeNghiChiTietController implements the CRUD actions for PhieuDeNghi model.
 */
class PhieuDeNghiChiTietController extends Controller
{
    /**
     * lấy danh sách hàng hóa đổ vào dropdownlist
     * @param int $selected: nếu thêm mới thì là null, còn sửa vật tư thì truyền vào id của vật tư đang chọn
     * @return string[]
     */
    public function actionGetListVatTu($selected, $loai = NULL)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        //lay list vat tu
        $options = '<option>--Select--</option>';
        if ($loai == NULL)
            $lvts = DmLoaiHangMuc::find()->all();
        else
            $lvts = DmLoaiHangMuc::find()->where(['id' => $loai])->all();
        foreach ($lvts as $indexLVT => $lvt) {
            $vts = DmHangMuc::find()->where(['id_loai_hang_muc' => $lvt->id])->all();
            if ($vts != null) {
                $options .= '<optgroup label="' . $lvt->ten . '">';
                foreach ($vts as $vt) {
                    $options .= '<option value="' . $vt->id . '" ' . ($vt->id == $selected ? 'selected' : '') . '>' . $vt->ten . '</option>';
                }
                $options .= '</optgroup>';
            }
        }
        return ['options' => $options];
    }
    /**
     * lấy thông tin vật tư để tự động điền vào vật tư chi tiết khi chọn vật tư bằng dropdownlist
     * @param int $idvt
     * @return string[]|NULL[]|string[]
     */
    public function actionGetVatTuAjax($idvt)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vt = DmHangMuc::findOne($idvt);
        if ($vt != null) {
            return [
                'status' => 'success',
                'donGia' => $vt->don_gia,
                'dvt' => $vt->dvt,
                'loaiVatTu' => $vt->loaiHangMuc->ten
            ];
        } else {
            return ['status' => 'failed'];
        }
    }

    /**
     * !!!!!!!!!!!!! đã chỉnh
     */
    public function actionSave($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $hoaDon = PhieuDeNghi::findOne($id);
        if ($hoaDon != null) {
            if (isset($_POST['id']) && $_POST['id'] != null) {
                //update
                $model = PhieuChiTiet::findOne($_POST['id']);
                /* $contentHistory = '';
                if(isset($_POST['soLuong'])){
                    if($hoaDon->trang_thai != 'BAN_NHAP' && $hoaDon->edit_mode == 1 && $model->so_luong != $_POST['soLuong']){
                        $contentHistory .= 'Thay đổi Số lượng từ ' . $model->so_luong . ' -> ' . $_POST['soLuong'];
                    }
                    $model->so_luong = $_POST['soLuong'];
                } */

                // $model->id_vat_tu = $_POST['idVatTu'];

                if (isset($_POST['soLuong'])) {
                    $model->so_luong = $_POST['soLuong'];
                }

                if (isset($_POST['donGia'])) {
                    /*  if($hoaDon->trang_thai != 'BAN_NHAP' && $hoaDon->edit_mode == 1 && $model->don_gia != $_POST['donGia']){
                        if($contentHistory != '')
                            $contentHistory .= '<br/>';
                            $contentHistory .= 'Thay đổi Đơn giá từ ' . $model->don_gia . ' -> ' . $_POST['donGia'];
                    } */
                    $model->don_gia = $_POST['donGia'];
                }
                if (isset($_POST['chietKhau'])) {
                    $model->chiet_khau = $_POST['chietKhau'];
                }
                if (isset($_POST['ghiChu'])) {
                    /*  if($hoaDon->trang_thai != 'BAN_NHAP' && $hoaDon->edit_mode == 1 && $model->ghi_chu != $_POST['ghiChu']){
                        if($contentHistory != '')
                            $contentHistory .= '<br/>';
                            $contentHistory .= 'Thay đổi Ghi chú từ ' . $model->ghi_chu . ' -> ' . $_POST['ghiChu'];
                    } */
                    $model->ghi_chu = $_POST['ghiChu'];
                }


                if ($model->save()) {
                    $hoaDon->refresh();
                    $model->refresh();
                    /*  if($contentHistory != ''){
                        $contentHistory = $model->vatTu->ten_vat_tu . ': ' . $contentHistory;
                        History::addManualHistory(HoaDon::MODEL_ID, $hoaDon->id, $contentHistory);
                    } */

                    return [
                        'type' => 'update',
                        'status' => 'success',
                        'results' => $hoaDon->dsChiTiet(),
                        'vatTuXuat' => $model->danhSachJson()
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'can not save from update'
                    ];
                }
            } else {
                //check vat tu da co trong hoa don chua
                $vatTu = PhieuChiTiet::find()->where([
                    'id_phieu_de_nghi' => $id,
                    'id_hang_muc' => $_POST['idVatTu'], //!---
                ])->one();
                if ($vatTu != null) {
                    return [
                        'status' => 'error',
                        'message' => 'Chi tiết đã tồn tại trong phiếu đề nghị. Vui lòng cập nhật lại số lượng!'
                    ];
                } else {
                    //create
                    $model = new PhieuChiTiet();
                    $model->id_phieu_de_nghi = $id;
                    $model->id_hang_muc = $_POST['idVatTu'];

                    /* if($_POST['loaiVatTu'] == 'VAT-TU'){
                        $vatTuModel = KhoVatTu::findOne($_POST['idVatTu']);
                        if($vatTuModel != null)
                            $model->loai_vat_tu = $vatTuModel->tenNhomVatTu;
                    } else  if($_POST['loaiVatTu'] == 'NHOM'){
                        $model->loai_vat_tu = 'NHOM';
                    } */

                    $model->don_gia = isset($_POST['donGia']) ? $_POST['donGia'] : 0;
                    $model->so_luong = isset($_POST['soLuong']) ? $_POST['soLuong'] : 0;
                    $model->chiet_khau = isset($_POST['chietKhau']) ? $_POST['chietKhau'] : 0;

                    $model->ghi_chu = isset($_POST['ghiChu']) ? $_POST['ghiChu'] : '';
                    if ($model->save()) {
                        $hoaDon->refresh();
                        return [
                            'type' => 'create',
                            'status' => 'success',
                            'results' => $hoaDon->dsChiTiet(),
                            'vatTuXuat' => $model->danhSachJson()
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'message' => 'can not save from create'
                        ];
                    }
                }
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Phiếu đề nghị không tồn tại!'
            ];
        }
    }

    public function actionDeleteVatTu($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vatTu = PhieuChiTiet::findOne($id);
        if ($vatTu != null) {
            $hoaDonId = $vatTu->id_phieu_de_nghi;
            if ($vatTu->delete()) {
                $hoaDon = PhieuDeNghi::findOne($hoaDonId);
                return [
                    'type' => 'delete',
                    'status' => 'success',
                    'results' => $hoaDon->dsChiTiet(),
                ];
            } else {
                return [
                    'type' => 'delete',
                    'status' => 'error',
                    'message' => 'Có lỗi xảy ra!',
                    'results' => $hoaDon->dsChiTiet(),
                ];
            }
        }
    }
}
