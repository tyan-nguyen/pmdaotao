<?php

namespace app\modules\giaovien\models;
use Yii;
use app\modules\giaovien\models\base\GiaoVienBase;
use app\custom\CustomFunc;
use app\modules\kholuutru\models\LuuKho;
use app\modules\kholuutru\models\File;

class GiaoVien extends GiaoVienBase
{
    CONST MODEL_ID = 'GIAOVIEN';

    public function getPubName(){
        return $this->ho_ten;
    } 

    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id); 
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id); 
        return parent::afterDelete();
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
            $this->doi_tuong = 1;
        }
        return parent::beforeSave($insert);
    }
 
  
    
}