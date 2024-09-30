<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\HocVienBase;
use app\modules\kholuutru\models\LuuKho;
use app\modules\kholuutru\models\File;
use Yii; 
use app\custom\CustomFunc;

class HocVien extends HocVienBase
{
    CONST MODEL_ID = 'HOCVIEN';
 
    public function getPubName(){
        return $this->ho_ten;
    }

    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id); 
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id); 
        return parent::afterDelete();
    }
    // Trong model HocVien
    public function getHang()
    {
    return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }


    public function getHocPhi()
    {
        // Truy vấn học phí từ bảng hoc_phi dựa trên id_hang
        return HocPhi::find()
            ->where(['id_hang' => $this->id_hang])
            ->one();
    }
   
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai='NHAPLIEU';
            $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
        }
  
        return parent::beforeSave($insert);
    }
}
