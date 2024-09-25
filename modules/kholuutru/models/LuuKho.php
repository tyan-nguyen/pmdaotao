<?php

namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\LuuKhoBase;
use Yii;
use app\custom\DoiTuong;

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
    
    //hiển thị đối tượng khi thao tác trong form lưu kho
    public static function getListDoiTuong($doiTuong, $idDoiTuong){
        $arr = [];
        $model = DoiTuong::getModel($doiTuong, $idDoiTuong);
        if($model != null){
            $arr[$model->id] = $model->pubName;
        }
        return $arr;
    }
    //luu kho model
    public static function getLuuKho($doiTuong, $idDoiTuong){
        $model = LuuKho::find()->where(['doi_tuong'=>$doiTuong, 'id_doi_tuong'=>$idDoiTuong])->one();
        return $model;
    }
}