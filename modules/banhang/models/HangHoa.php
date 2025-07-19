<?php
namespace app\modules\banhang\models;

use app\modules\banhang\models\base\HangHoaBase;
use app\modules\nhacungcap\models\ChiTietDonHangNcc;
use app\modules\khachhang\models\ChiTietDonHangKhachHang;
use app\modules\user\models\User;

class HangHoa extends HangHoaBase
{
    public function getKhChiTietDonHangKhs()
    {
        return $this->hasMany(ChiTietDonHangKhachHang::class, ['id_hang_hoa' => 'id']);
    }

    public function getNccChiTietDonHangNccs()
    {
        return $this->hasMany(ChiTietDonHangNcc::class, ['id_hang_hoa' => 'id']);
    }

    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }

   
}