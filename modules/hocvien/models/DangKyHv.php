<?php

namespace app\modules\hocvien\models;

use Yii;
use app\modules\hocvien\models\base\HocVienBase;
use app\custom\CustomFunc;
use app\modules\banhang\models\HoaDon;
use app\modules\user\models\User;

/**
 * HocVienSearch represents the model behind the search form about `app\models\HvHocVien`.
 */
class DangKyHv extends HocVienBase
{
    public function beforeSave($insert)
    {
        $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
        $this->ngay_het_han_cccd = CustomFunc::convertDMYToYMD($this->ngay_het_han_cccd);
        $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
        $this->ngay_nhan_tai_lieu = CustomFunc::convertDMYToYMD($this->ngay_nhan_tai_lieu);

        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai = 'DANG_KY';
            $this->nguoi_lap_phieu = Yii::$app->user->identity->fullname;
            if ($this->id_hang) {
                $this->id_hoc_phi = HangDaoTao::findOne($this->id_hang)->hocPhi->id;
            }
            if ($this->co_ho_so_thue == null) {
                $this->co_ho_so_thue = 0;
            }
            if ($this->da_nhan_ao == null) {
                $this->da_nhan_ao = 0;
            }
            if ($this->da_nhan_tai_lieu == null) {
                $this->da_nhan_tai_lieu = 0;
            }
            if ($this->huy_ho_so == null) {
                $this->huy_ho_so = 0;
            }
            if ($this->da_nop_du == null) {
                $this->da_nop_du = 0;
            }
        }

        if ($this->huy_ho_so) {
            if ($this->thoi_gian_huy_ho_so == '') {
                $this->thoi_gian_huy_ho_so = date('Y-m-d H:i:s');
            } else {
                $this->thoi_gian_huy_ho_so = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_huy_ho_so);
            }
            if ($this->loai_ly_do == NULL)
                $this->loai_ly_do = self::HUY_BATKHAKHANG;
            if ($this->le_phi == NULL)
                $this->le_phi = self::getLePhiHuyHoSo($this->loai_ly_do);
        }

        if (!$this->id_hoc_phi) {
            $this->id_hoc_phi = HangDaoTao::findOne($this->id_hang)->hocPhi->id;
        }
        return parent::beforeSave($insert);
    }

    public function getKhoaHoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }

    public function getFileThiXeMayContents()
    {
        return $this->hasMany(FileThiXeMayContent::class, ['id_hoc_vien' => 'id']);
    }

    public function getSoLanThi()
    {
        return $this->getFileThiXeMayContents()->count();
    }

    //get số lần đóng tiền lệ phí
    public function getDongTienLePhi()
    {
        $listLePhi = null;
        //search in hoa don hoc phi
        $hoaDonHocPhi = NopHocPhi::find()->where(['id_hoc_vien' => $this->id])
            ->andWhere('so_tien_thu_ho >0')->all();
        foreach ($hoaDonHocPhi as $hoaDonHocPhi) {
            $user = User::findOne($hoaDonHocPhi->nguoi_tao);
            $listLePhi[] = [
                'type' => 'ThuLanDau',
                'id' => $hoaDonHocPhi->id,
                'so_tien' => $hoaDonHocPhi->so_tien_thu_ho,
                'hinh_thuc' => $hoaDonHocPhi->hinh_thuc_thu_ho,
                'ghi_chu' => $hoaDonHocPhi->ghi_chu_thu_ho,
                'thoi_gian' => CustomFunc::convertYMDHISToDMYHI($hoaDonHocPhi->thoi_gian_tao),
                'nguoi_thu' => $user->shortName,
            ];
        }
        //search in ban hang
        $banHangs = HoaDon::find()->where(['loai_khach_hang' => HoaDon::LOAI_HOCVIEN])
            ->andWhere('id_khach_hang =:id_hoc_vien', [':id_hoc_vien' => $this->id])
            ->andWhere('trang_thai =:trang_thai', [':trang_thai' => HoaDon::TRANGTHAI_DA_TT])
            ->andWhere('loai_hang_hoa =:id_loai', [':id_loai' => 11])->all(); //11 là thu hộ lệ phí
        foreach ($banHangs as $banHang) {
            $user = User::findOne($banHang->nguoi_tao);
            $listLePhi[] = [
                'type' => 'ThuLePhi',
                'id' => $banHang->id,
                'so_tien' => $banHang->tongTien,
                'hinh_thuc' => $banHang->hinh_thuc_thanh_toan,
                'ghi_chu' => $banHang->ghi_chu,
                'thoi_gian' => CustomFunc::convertYMDHISToDMYHI($banHang->ngay_xuat),
                'nguoi_thu' => $user->shortName,
            ];
        }
        return $listLePhi;
    }
}
