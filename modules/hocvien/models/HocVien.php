<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\HocVienBase;
class HocVien extends HocVienBase
{
    CONST MODEL_ID = 'HOCVIEN';
    public function getHocPhi()
    {
        // Truy vấn học phí từ bảng hoc_phi dựa trên id_hang
        return HocPhi::find()
            ->where(['id_hang' => $this->id_hang])
            ->one();
    }
}
