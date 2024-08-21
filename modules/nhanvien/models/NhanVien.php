<?php

namespace app\modules\nhanvien\models;

use app\modules\nhanvien\models\base\NhanVienBase;
use yii\helpers\ArrayHelper;

class NhanVien extends NhanVienBase
{
    public static function getList()
    {
        // Lấy danh sách người nhận (Nhân viên) và sắp xếp theo thứ tự bảng chữ cái
        $dsNguoiNhan = NhanVien::find()->orderBy(['ho_ten' => SORT_ASC])->all();

        // Thêm dấu + vào trước tên nhân viên
         return ArrayHelper::map($dsNguoiNhan, 'id', function($model) {
         return '+ ' . $model->ho_ten; // Thêm dấu + trước tên nhân viên
        });
    }

}