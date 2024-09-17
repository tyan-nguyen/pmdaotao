<?php

namespace app\modules\khoahoc\models;
use app\modules\khoahoc\models\base\KhoaHocBase;
use app\modules\kholuutru\models\File;
class KhoaHoc extends KhoaHocBase
{
   
    CONST MODEL_ID = 'KHOAHOC';
   
    public function getFileKhoaHoc(){
        return File::getAllByLoaiFile(5, $this::MODEL_ID, $this->id);//3 is file gv
    }
    public function getFileKH()
    {
        return File::getOneByLoaiFile(5, $this::MODEL_ID, $this->id);
    }
    
   
}
