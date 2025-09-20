<?php

namespace app\modules\daotao\models;

use Yii;
use app\modules\daotao\models\base\TietHocBase;
use app\modules\hocvien\models\DangKyHv;

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
    
    //hien thi tiet hoc da hoc/tiet hoc phai hoc cua hoc vien
    public static function getSoTietDaHocByMonOfHocVien($idhv){
        //get so mon hoc cua hoc vien
        $hocVien = DangKyHv::findOne($idhv);
        $monHocs = HangMonHoc::find()->where([
            'id_hang' => $hocVien->id_hang
        ])->all();
        
        $html = '';
        
        foreach ($monHocs as $iMon=>$mon){
            $tietHocOk = TietHoc::getSoTietHocByMonOfHocVien($idhv, $mon->id_mon);
            $html .= ($iMon>0?'; ':''). ($mon->mon?$mon->mon->ma_mon:'') . ': <strong>' . $tietHocOk . '/' . ($mon->mon?$mon->mon->so_gio_tt:0) . '</strong>';
        }
        return $html;
    }
    
}
