<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\HocVienBase;
use app\modules\kholuutru\models\File;
class HocVien extends HocVienBase
{
    public function getHocPhi()
    {
        // Truy vấn học phí từ bảng hoc_phi dựa trên id_hang
        return HocPhi::find()
            ->where(['id_hang' => $this->id_hang])
            ->one();
    }
    

    CONST MODEL_ID = 'HOCVIEN';
   
    public function getFileHocVien(){
        return File::getAllByLoaiFile(6, $this::MODEL_ID, $this->id);//3 is file gv
    }
    public function getFileHV()
    {
        return File::getOneByLoaiFile(6, $this::MODEL_ID, $this->id);
    }
}
