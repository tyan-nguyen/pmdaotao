<?php

namespace app\modules\giaovien\models;

use app\modules\giaovien\models\base\GiaoVienBase;


class GiaoVien extends GiaoVienBase
{
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->doi_tuong = $this::GV_VALUE;
            $this->chuc_vu = 'Nhân viên';
            $this->id_phong_ban ='2';
            $this->id_to='8';
            $this->vi_tri_cong_viec ='GIANG DAY';

        }
        return parent::beforeSave($insert);
    }
}