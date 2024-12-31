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
        $this->thoi_gian_thi = CustomFunc::convertYMDHISToDMYHIS($this->thoi_gian_thi);
    
        if ($this->isNewRecord) {
            $this->trang_thai = 'KHOI_TAO';
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');

            $lichThi = LichThi::find()->where(['id_khoa_hoc'=>$this->id_khoa_hoc, 'id_nhom'=>$this->id_nhom])->all();
            if(!empty($lichThi))
            {
                $this->addError('thoi_gian_thi', 'Khóa học đã được sắp lịch thi !.');
                return false;
            }
        }

        $khoaHoc = KhoaHoc::findOne($this->id_khoa_hoc);
        if ($khoaHoc && $khoaHoc->trang_thai === "DA_HOAN_THANH") {
            $this->addError('thoi_gian_thi', 'Khóa học này đã hoàn thành, không thể thêm hoặc sửa lịch thi.');
            return false;
        }
       
        return parent::beforeSave($insert);
    }
    
}