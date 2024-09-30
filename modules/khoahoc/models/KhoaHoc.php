<?php

namespace app\modules\khoahoc\models;
use app\modules\khoahoc\models\base\KhoaHocBase;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LuuKho;

class KhoaHoc extends KhoaHocBase
{
   
    CONST MODEL_ID = 'KHOAHOC';

    public function getPubName(){
        return $this->ten_khoa_hoc;
    } 

    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id); 
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id); 
        return parent::afterDelete();
    }

    public function getFileKhoaHoc(){
        return File::getAllByLoaiFile(5, $this::MODEL_ID, $this->id);//3 is file gv
    }
    public function getFileKH()
    {
        return File::getOneByLoaiFile(5, $this::MODEL_ID, $this->id);
    }
    
   
}