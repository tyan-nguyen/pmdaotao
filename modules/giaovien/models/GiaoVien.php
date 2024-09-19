<?php

namespace app\modules\giaovien\models;
use Yii;
use app\modules\giaovien\models\base\GiaoVienBase;
use app\modules\kholuutru\models\File;
use app\custom\CustomFunc;
class GiaoVien extends GiaoVienBase
{
    CONST MODEL_ID = 'GIAOVIEN';

     public function beforeSave($insert) {
        if ($this->isNewRecord) {
            // Xác định giá trị của doi_tuong dựa trên giá trị của chuc_vu
            if ($this->chuc_vu === 'Giáo viên') {
                $this->doi_tuong = 'GIAO_VIEN';
            } elseif ($this->chuc_vu === 'Nhân viên / Giáo viên') {
                $this->doi_tuong = 'NV_GV';
            }
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            // Các giá trị mặc định khác
            $this->id_phong_ban = '2';
            $this->id_to = '1';
            $this->vi_tri_cong_viec = 'GIANG DAY';
            $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
        }
        return parent::beforeSave($insert);
    }
 
  
    
}