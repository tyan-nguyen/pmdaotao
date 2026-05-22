<?php

namespace app\modules\taisan\models;

use app\modules\taisan\models\base\PhieuDeNghiBase;
use app\modules\thuexe\models\Xe;
use app\modules\user\models\User;

class PhieuDeNghi extends PhieuDeNghiBase
{
    //ham lay tong so tien
    //kiem tra truong phieu_co_chi_tiet, neu =1 thi lay tong tien sum
    // tu bang phieudenghichitiet, neu =0 thì lấy gia tri tong_tien_thuc_te
    public function getTongTien()
    {
        if ($this->phieu_co_chi_tiet == 1) {
            $sum = 0;
            foreach ($this->chiTiets as $ct) {
                $sum += $ct->thanhTien;
            }
            return $sum;
        } else {
            return $this->tong_tien_thuc_te;
        }
    }
    public function dsChiTiet()
    {
        $result = array();
        foreach ($this->chiTiets as $iVt => $vatTu) {
            $result[] = [
                'id' => $vatTu->id,
                'idPhieuDeNghi' => $vatTu->id_phieu_de_nghi,
                'idHangMuc' => $vatTu->id_hang_muc,
                'tenHangMuc' => $vatTu->hangMuc->ten,
                'tenLoaiHangMuc' => $vatTu->hangMuc->loaiHangMuc->ten,
                'dvt' => $vatTu->hangMuc->dvt,
                'soLuong' => $vatTu->so_luong ? $vatTu->so_luong : 0,
                'donGia' => $vatTu->don_gia ? $vatTu->don_gia : 0,
                'chietKhau' => $vatTu->chiet_khau ? $vatTu->chiet_khau : 0,
                'ghiChu' => $vatTu->ghi_chu ? $vatTu->ghi_chu : '',
                'thanhTien' => $vatTu->thanhTien ? $vatTu->thanhTien : 0
            ];
        }
        return [
            'tongTien' => $this->getTongTien(),
            'dsVatTu' => $result
        ];
    }


    //lay ten thiet bi tham chieu
    public function getTenThamChieu()
    {
        if ($this->id_tham_chieu) {
            if ($this->loai_tai_san == self::LOAITAISAN_XE) {
                $thamChieu = Xe::findOne($this->id_tham_chieu);
                if ($thamChieu) {
                    return $thamChieu->bien_so_xe;
                }
            } else if ($this->loai_tai_san == self::LOAITAISAN_THIETBI) {
                //!!!!!!!!!!!!!!!!!! chua xong !!!!!!!!!!!!!!!!!!!

                /* $thamChieu = Xe::findOne($this->id_tham_chieu);
                if ($thamChieu) {
                    return $thamChieu->tenXeShort2;
                } */
            }
        }
        return null;
    }
    //lay link tham chieu
    public function getLinkThamChieu()
    {
        $link = '#';
        if ($this->id_tham_chieu) {
            if ($this->loai_tai_san == self::LOAITAISAN_XE) {
                return '/thuexe/xe/view?id=' . $this->id_tham_chieu;
            } else if ($this->loai_tai_san == self::LOAITAISAN_THIETBI) {
                //!!!!!!!!!!!!!!!!!!!!!! chưa xong !!!!!!!!!!!!!!!!!!!!
            }
        }
        return $link;
    }

    /**
     * get so luong ke hoach dang cho duyet
     */
    public static function slChoDuyet(){
        return self::find()->where(['trang_thai'=>self::TRANGTHAI_CHODUYET])->count();
    }

    //ham lay nguoi de nghi
    public function getNguoiDeNghi()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_de_nghi']);
    }
    //ham lay nguoi duyet
    public function getNguoiDuyet()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_duyet']);
    }
    //ham lay nguoi tao
    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
}
