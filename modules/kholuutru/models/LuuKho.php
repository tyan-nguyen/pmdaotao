<?php

namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\LuuKhoBase;
use Yii;

class LuuKho extends LuuKhoBase
{
    //Hiển thị tên loại 
    public function getLoaiFileName() {
        return $this->loai_file ? LoaiFile::findOne($this->loai_file)->ten_loai : null; 
    }
    
    //Hiển thị file_display_name 
    public function getFileName() {
        return $this->id_file ? File::findOne($this->id_file)->file_display_name : null; 
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}