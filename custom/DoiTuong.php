<?php

namespace app\custom;

use app\modules\vanban\models\VanBan;
use app\modules\vanban\models\VanBanDen;
use app\modules\vanban\models\VanBanDi;
use app\modules\hocvien\models\HocVien;

class DoiTuong
{ 
    public static function getModel($doiTuong, $idDoiTuong){
        $model = NULL;
        if($doiTuong == VanBanDen::MODEL_ID){
            $model = VanBanDen::findOne($idDoiTuong);
        } else if($doiTuong == VanBanDi::MODEL_ID){
            $model = VanBanDi::findOne($idDoiTuong);
        } else if($doiTuong == HocVien::MODEL_ID){
            $model = HocVien::findOne($idDoiTuong);
        }
        return $model;
    }
    
}