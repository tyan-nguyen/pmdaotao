<?php

namespace app\modules\vanban\models;

use app\modules\vanban\models\base\VanBanBase;

class VanBan extends VanBanBase
{
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
}