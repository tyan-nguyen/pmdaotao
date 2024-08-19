<?php

namespace app\modules\vanban\models;

use app\modules\vanban\models\base\VanBanDenBase;

class VanBanDen extends VanBanDenBase
{
    public function getLoaiVanBan()
    {
        return $this->hasOne(DmLoaiVanBan::class, ['id' => 'id_loai_van_ban']);
    }
    
    public function getVbDinhKems()
    {
        return $this->hasMany(VbDinhKem::class, ['id_van_ban' => 'id']);
    }
    
    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
    public function getFiles()
    {
        return $this->hasMany(FileVanBan::class, ['id_van_ban' => 'id']);
    }
    public function getVbdenNguoiNhan()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'vbden_nguoi_nhan']);
    }
}