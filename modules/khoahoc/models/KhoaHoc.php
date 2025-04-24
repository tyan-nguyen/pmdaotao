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
    
    public static function getList($anKhoaHocFull=false)
    {
        // Sắp xếp danh sách theo thứ tự bảng chữ cái dựa trên 'ten_loai'
        //$dsKH = KhoaHoc::find()->orderBy(['ten_khoa_hoc' => SORT_ASC])->all();
        if($anKhoaHocFull){
            $dsKH = KhoaHoc::find()->orderBy(['id' => SORT_ASC])->all();
        } else {
            $dsKH = KhoaHoc::find()->orderBy(['id' => SORT_ASC])->all();
        }
    
        return ArrayHelper::map($dsKH, 'id', function($model) {
            return '+ ' . $model->ten_khoa_hoc . ' (' . $model->showSoLuong . ')'; // Thêm dấu + trước tên loại
        });
    }
    public static function getListByHang($idHang)
    {
        // Sắp xếp danh sách theo thứ tự bảng chữ cái dựa trên 'ten_loai'
        $dsKH = KhoaHoc::find()->where(['id_hang'=>$idHang])->orderBy(['id' => SORT_ASC])->all();
        
        // Thêm dấu + vào trước mỗi tên loại văn bản
        return ArrayHelper::map($dsKH, 'id', function($model) {
            return '+ ' . $model->ten_khoa_hoc; // Thêm dấu + trước tên loại
        });
    }
    public static function getNameById($id)
    {
    $khoaHoc = self::findOne($id);
    return $khoaHoc ? $khoaHoc->ten_khoa_hoc : null;
    }
    /**
     * get so luong hoc vien cua khoa hoc
     */
    public function getSoLuongHocVien(){
        return $this->getHvHocViens()->count();
    }
    /**
     * hien thi so luong cho view
     */
    public function getShowSoLuong(){
        return $this->soLuongHocVien . '/' . $this->so_hoc_vien_khoa_hoc;
    }

}