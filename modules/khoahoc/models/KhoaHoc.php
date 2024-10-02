<?php

namespace app\modules\khoahoc\models;
use app\modules\khoahoc\models\base\KhoaHocBase;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LuuKho;
use yii\helpers\ArrayHelper;
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
    
    public static function getList()
    {
        // Sắp xếp danh sách theo thứ tự bảng chữ cái dựa trên 'ten_loai'
        $dsKH = KhoaHoc::find()->orderBy(['ten_khoa_hoc' => SORT_ASC])->all();
    
        // Thêm dấu + vào trước mỗi tên loại văn bản
        return ArrayHelper::map($dsKH, 'id', function($model) {
            return '+ ' . $model->ten_khoa_hoc; // Thêm dấu + trước tên loại
        });
    }
}