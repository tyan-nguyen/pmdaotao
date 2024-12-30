<?php

namespace app\modules\lichhoc\models;
use app\modules\lichhoc\models\base\LichThiBase;
use Yii;
use app\custom\CustomFunc;
use app\modules\khoahoc\models\KhoaHoc;

class LichThi extends LichThiBase
{
    public function beforeSave($insert)
    {
        // Chuyển đổi định dạng thời gian
        $this->thoi_gian_thi = CustomFunc::convertYMDHISToDMYHIS($this->thoi_gian_thi);
    
        // Kiểm tra nếu là bản ghi mới
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
    
        // Kiểm tra trạng thái của khóa học
        $khoaHoc = KhoaHoc::findOne($this->id_khoa_hoc);
        if ($khoaHoc && $khoaHoc->trang_thai === "DA_HOAN_THANH") {
            $this->addError('thoi_gian_thi', 'Khóa học này đã hoàn thành, không thể thêm hoặc sửa lịch thi.');
            return false;
        }
    
        return parent::beforeSave($insert);
    }
    
}