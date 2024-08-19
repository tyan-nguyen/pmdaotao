<?php

namespace app\modules\vanban\models;

use Yii;
use app\modules\vanban\models\base\VanBanBase;
use app\custom\CustomFunc;

class VanBan extends VanBanBase
{
    public function getNgayKy(){
        return CustomFunc::convertYMDToDMY($this->ngay_ky);
    }
    /**
     * Gets query for [[LoaiVanBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiVanBan()
    {
        return $this->hasOne(DmLoaiVanBan::class, ['id' => 'id_loai_van_ban']);
    }
    
    /**
     * Gets query for [[VbDinhKems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVbDinhKems()
    {
        return $this->hasMany(VbDinhKem::class, ['id_van_ban' => 'id']);
    }
    
    
    /**
     * Gets query for [[VbdenNguoiNhan]].
     *
     * @return \yii\db\ActiveQuery
     */
    
    
    public function getVbdenNguoiNhan()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'vbden_nguoi_nhan']);
    }
   
    
   
}