<?php

namespace app\modules\daotao\models;

use Yii;
use app\modules\daotao\models\base\TietHocBase;

class TietHoc extends TietHocBase
{
    //lay so tiet hoc da hoc from hoc vien id va id mon hoc
    public static function getSoTietHocByMonOfHocVien($idhv, $idmh){
        $tietHocOk = TietHoc::find()->where([
            'id_hoc_vien'=>$idhv, 
            'id_mon_hoc'=>$idmh, 
            'trang_thai'=>self::TT_DAHOANTHANH
        ])->sum('so_gio');
        return $tietHocOk?$tietHocOk:0;
    }
    
}
