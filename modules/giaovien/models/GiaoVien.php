<?php

namespace app\modules\giaovien\models;

use app\modules\giaovien\models\base\GiaoVienBase;


class GiaoVien extends GiaoVienBase
{
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            // Xác định giá trị của doi_tuong dựa trên giá trị của chuc_vu
            if ($this->chuc_vu === 'Giáo viên') {
                $this->doi_tuong = 'GV';
            } elseif ($this->chuc_vu === 'Nhân viên / Giáo viên') {
                $this->doi_tuong = 'NV_GV';
            }
    
            // Các giá trị mặc định khác
            $this->id_phong_ban = '2';
            $this->id_to = '8';
            $this->vi_tri_cong_viec = 'GIANG DAY';
        }
        return parent::beforeSave($insert);
    }
    
}