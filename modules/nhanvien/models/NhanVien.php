<?php

namespace app\modules\nhanvien\models;

use app\modules\nhanvien\models\base\NhanVienBase;
use yii\helpers\ArrayHelper;
use app\modules\kholuutru\models\File;
class NhanVien extends NhanVienBase
{
    CONST MODEL_ID = 'NHANVIEN';
    public static function getList()
{
    // Lấy danh sách nhân viên có id_phong_ban là 1 và sắp xếp theo thứ tự bảng chữ cái
    $dsNguoiNhan = NhanVien::find()
        ->where(['id_phong_ban' => 1])
        ->orderBy(['ho_ten' => SORT_ASC])
        ->all();

    // Thêm dấu + vào trước tên nhân viên
    return ArrayHelper::map($dsNguoiNhan, 'id', function($model) {
        return '+ ' . $model->ho_ten; // Thêm dấu + trước tên nhân viên
    });
}

    public static function getListTD()
    {
        $trinhDoList = [
            'Đại học' => 'Đại học',
            'Cao đẳng' => 'Cao đẳng',
            'Trung cấp' => 'Trung cấp',
            'Khác' => 'Khác',
        ];
        return $trinhDoList;
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
              // Xác định giá trị của doi_tuong dựa trên giá trị của chuc_vu
              if ($this->chuc_vu === 'Nhân viên') {
                $this->doi_tuong = 'NHAN_VIEN';
            } elseif ($this->chuc_vu === 'Nhân viên / Giáo viên') {
                $this->doi_tuong = 'NV_GV';
            }
        }
        return parent::beforeSave($insert);
    }
    public function getFileNhanVien(){
        return File::getAllByLoaiFile(4, $this::MODEL_ID, $this->id);//3 is file gv
    }
    public function getFileNV()
    {
        return File::getOneByLoaiFile(4, $this::MODEL_ID, $this->id);
    }

}