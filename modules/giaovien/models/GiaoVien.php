<?php

namespace app\modules\giaovien\models;

use app\modules\giaovien\models\base\GiaoVienBase;


class GiaoVien extends GiaoVienBase
{
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->doi_tuong = $this::GV_VALUE;
            
        }
        return parent::beforeSave($insert);
    }
}