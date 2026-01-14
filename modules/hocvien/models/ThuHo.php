<?php
namespace app\modules\hocvien\models;

use app\models\HvThuHo;

class ThuHo extends HvThuHo
{
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
}