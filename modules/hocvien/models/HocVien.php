<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\HocVienBase;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LuuKho;
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
}
