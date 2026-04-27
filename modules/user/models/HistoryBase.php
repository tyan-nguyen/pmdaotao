<?php

namespace app\modules\user\models;

use app\custom\CustomFunc;
use app\modules\banhang\models\HangHoa;
use app\modules\banhang\models\HoaDon;
use app\modules\banhang\models\HoaDonChiTiet;
use app\modules\banhang\models\KhachHang;
use app\modules\demxe\models\DemXe;
use app\modules\giaovien\models\GiaoVien;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\thuexe\models\LichThue;
use app\modules\thuexe\models\Xe;
use app\modules\user\models\User;
use Yii;

class HistoryBase extends \app\models\UserHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai', 'id_tham_chieu', 'noi_dung'], 'required'],
            [['id_tham_chieu', 'nguoi_tao'], 'integer'],
            [['noi_dung'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['loai'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai' => 'Loại',
            'id_tham_chieu' => 'Tham chiếu',
            'noi_dung' => 'Nội dung',
            'thoi_gian_tao' => 'Thời gian',
            'nguoi_tao' => 'Người thực hiện',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->nguoi_tao = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * luu lich su thay doi cho model goi trong aftersave
     * use(in aftersave): History::addHistory($this::MODEL_ID, $changedAttributes, $this, $insert);
     * tham so:
     * - $type>string:truyen truc tiep hoac qua hang so Model::MODEL_ID
     * - $attr:tham so $changedAttributes cua aftersave
     * - $mod:activerecord: model thong qua findOne(hoac goi $this trong aftersave)
     * - $isNew:tham so $insert cua aftersave
     */
    public static function addHistory($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        if ($isNew == false) {
            foreach ($atr as $key => $value) {
                if ($atr[$key] != $mod->$key) {
                    $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu thành công.';
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
    /** luu lai lich su cho model lichthue */
    public static function addHistoryLichThue($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        if ($isNew == false) {
            $model = LichThue::findOne($mod->id);
            if ($model != null) {
                foreach ($atr as $key => $value) {
                    if ($atr[$key] != $mod->$key) {
                        if ($key == 'id_giao_vien' && $model->loai_giao_vien == LichThue::GV_GIAOVIEN) {
                            $gvold = GiaoVien::findOne($value);
                            $gvnew = GiaoVien::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' Trung tâm' . ' "' . $gvold->ho_ten . '" thành "' . $gvnew->ho_ten . '"</p>';
                        } else if ($key == 'id_giao_vien' && $model->loai_giao_vien == LichThue::GV_KHACHNGOAI) {
                            $gvold = KhachHang::findOne($value);
                            $gvnew = KhachHang::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' gv ngoài' . ' "' . $gvold->ho_ten . '" thành "' . $gvnew->ho_ten . '"</p>';
                        } else if ($key == 'id_khach_hang' && $model->loai_khach_hang == LichThue::KH_HOCVIEN) {
                            $hvold = HocVien::findOne($value);
                            $hvnew = HocVien::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' Trung tâm' . ' "' . $hvold->ho_ten . '" thành "' . $hvnew->ho_ten . '"</p>';
                        } else if ($key == 'id_khach_hang' && $model->loai_khach_hang == LichThue::KH_KHACHNGOAI) {
                            $hvold = KhachHang::findOne($value);
                            $hvnew = KhachHang::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' ngoài' . ' "' . $hvold->ho_ten . '" thành "' . $hvnew->ho_ten . '"</p>';
                        } else if ($key == 'id_xe') {
                            $xeold = Xe::findOne($value);
                            $xenew = Xe::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $xeold->tenXeShort . '" thành "' . $xenew->tenXeShort . '"</p>';
                        } else {
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';
                        }
                    }
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu thành công.';
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
    /** luu lai lich su cho model lichthue */
    public static function addHistoryHoaDon($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        if ($isNew == false) {
            $model = HoaDon::findOne($mod->id);
            if ($model != null) {
                foreach ($atr as $key => $value) {
                    if ($atr[$key] != $mod->$key) {
                        if ($key == 'id_khach_hang' && $model->loai_khach_hang == HoaDon::LOAI_HOCVIEN) {
                            $hvold = HocVien::findOne($value);
                            $hvnew = HocVien::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' Trung tâm' . ' "' . $hvold->ho_ten . '" thành "' . $hvnew->ho_ten . '"</p>';
                        } else if ($key == 'id_khach_hang' && $model->loai_khach_hang == HoaDon::LOAI_KHACHLE) {
                            $hvold = KhachHang::findOne($value);
                            $hvnew = KhachHang::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' ngoài' . ' "' . $hvold->ho_ten . '" thành "' . $hvnew->ho_ten . '"</p>';
                        } else if ($key == 'edit_mode') {
                            if ($mod->$key == 1) {
                                $noiDung .= '<p>Bật chế độ cho phép chỉnh sửa sau khi xuất</p>';
                            } else {
                                $noiDung .= '<p>Tắt chế độ cho phép chỉnh sửa sau khi xuất</p>';
                            }
                        } else {
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';
                        }
                    }
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu thành công.';
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
    /** luu lai lich su cho model lichthue */
    public static function addHistoryHoaDonChiTiet($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        if ($isNew == false) {
            $model = HoaDonChiTiet::findOne($mod->id);
            if ($model != null) {
                //$hangHoa = HangHoa::findOne($atr['id_hang_hoa']);
                $noiDung = '<p>Thay đổi: ' . $model->hangHoa->ten_hang_hoa . ', số lượng: ' . $atr['so_luong'] . ', đơn giá: ' . number_format($atr['don_gia'], 0, ',', '.') . ', thành tiền: ' . number_format(($atr['so_luong'] * $atr['don_gia'] - $atr['chiet_khau']), 0, ',', '.') . '</p>';
                $noiDung .= '<p> Thành: ' . $model->hangHoa->ten_hang_hoa . ', số lượng: ' . $model->so_luong . ', đơn giá: ' . number_format($model->don_gia, 0, ',', '.') . ', thành tiền: ' . number_format($model->thanhTien, 0, ',', '.') . '</p>';
                /* foreach ($atr as $key => $value) {
                    if ($atr[$key] != $mod->$key) {
                        if ($key == 'id_hang_hoa') {
                            $hangHoa = HangHoa::findOne($value);
                            $hangHoaNew = HangHoa::findOne($mod->$key);
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $hangHoa->ten_hang_hoa . '" thành "' . $hangHoaNew->ten_hang_hoa . '"</p>';
                        } else {
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';

                            $noiDung = 'Thay đổi: ' . $model->hangHoa->ten_hang_hoa . ', số lượng: ' . $model->so_luong . ', đơn giá: ' . number_format($model->don_gia, 0, ',', '.') . ', thành tiền: ' . number_format($model->thanhTien, 0, ',', '.');
                        }
                    }
                } */
            }
        } else {
            $model = HoaDonChiTiet::findOne($mod->id);
            $noiDung = 'Thêm hàng hóa vào hóa đơn: ' . $model->hangHoa->ten_hang_hoa . ', số lượng: ' . $model->so_luong . ', đơn giá: ' . number_format($model->don_gia, 0, ',', '.') . ', thành tiền: ' . number_format($model->thanhTien, 0, ',', '.');
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id_don_hang;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }

    /** luu lai lich su cho model demxe */
    public static function addHistoryDemXe($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        $model = DemXe::findOne($mod->id);
        if ($isNew == false) {
            if ($model != null) {
                foreach ($atr as $key => $value) {
                    if ($atr[$key] != $mod->$key) {
                        $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';
                    }
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu từ file ' . $model->file->filename;
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
    /** luu lai lich su cho model hocvien */
    public static function addHistoryHocVien($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        $model = HocVien::findOne($mod->id);
        if ($isNew == false) {
            if ($model != null) {
                foreach ($atr as $key => $value) {
                    if ($atr[$key] != $mod->$key) {
                        if ($key == 'trang_thai') {
                        } else if ($key == 'nguoi_giao_ao') {
                            $tenOld = User::findOne($value) ? User::findOne($value)->shortName : '';
                            $tenNew = User::findOne($mod->$key) ? User::findOne($mod->$key)->shortName : '';
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $tenOld . '" thành "' . $tenNew . '"</p>';
                        } else if ($key == 'nguoi_giao_tai_lieu') {
                            $tenOld = User::findOne($value) ? User::findOne($value)->shortName : '';
                            $tenNew = User::findOne($mod->$key) ? User::findOne($mod->$key)->shortName : '';
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $tenOld . '" thành "' . $tenNew . '"</p>';
                        } else {
                            $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';
                        }
                    }
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu';
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
    /** luu lai lich su cho model hocvien dong hoc phi*/
    public static function addHistoryDongHocPhi($type, $atr, $mod, $isNew)
    {
        $noiDung = '';
        $model = NopHocPhi::findOne($mod->id);
        if ($isNew == false) {
            if ($model != null) {
                foreach ($atr as $key => $value) {
                    if ($atr[$key] != $mod->$key) {
                        $noiDung .= '<p>Thay đổi ' . $mod->getAttributeLabel($key) . ' "' . $value . '" thành "' . $mod->$key . '"</p>';
                    }
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu học phí: ';
            $noiDung .= '<br/>Số phiếu: ' . $model->ma_so_phieu;
            $noiDung .= '<br/>Ngày nộp: ' . CustomFunc::convertYMDHISToDMYHIS($model->ngay_nop);
            $noiDung .= '<br/>Số tiền: ' . number_format($model->so_tien_nop, 0, ',', '.') . '(' . $model->hinh_thuc_thanh_toan . ')';
            $noiDung .= ($model->nguoi_tao ? ('<br/>Người thu ' . (User::findOne($model->nguoi_tao) ? User::findOne($model->nguoi_tao)->shortName : '')) : '');
            $noiDung .= '<br/>Ghi chú: ' . $model->ghi_chu;
        }

        //$his->noi_dung = var_dump($changedAttributes);
        if ($noiDung != null) {
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
}
