<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\HocVienBase;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LuuKho;
use app\modules\khoahoc\models\NhomHoc;
use app\custom\CustomFunc;
use Yii;

class HocVien extends HocVienBase
{
    CONST MODEL_ID = 'HOCVIEN';
    
    public function getPubName(){
        return $this->ho_ten;
    }
    
    /**
     * {@inheritdoc}
     * xoa file anh, tai lieu, lich su sau khi xoa du lieu
     */
    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id);
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id);
        return parent::afterDelete();
    }
    
    public function getHocPhi()
    {
        // Truy vấn học phí từ bảng hoc_phi dựa trên id_hang
        return HocPhi::find()
            ->where(['id_hang' => $this->id_hang])
            ->one();
    }
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
    public function getNhomHoc()
    {
        return $this->hasOne(NhomHoc:: class,['id'=>'id_nhom'] );
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai='NHAPTRUCTIEP';
            $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
            
        }
  
        return parent::beforeSave($insert);
    }
  
}