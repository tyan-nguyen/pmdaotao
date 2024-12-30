<?php

namespace app\modules\lichhoc\models;
use app\modules\lichhoc\models\base\LichHocBase;
use app\modules\khoahoc\models\KhoaHoc;
use Yii;
use app\custom\CustomFunc;

class LichHoc extends LichHocBase
{
    public function beforeSave($insert)
{
    $this->ngay = CustomFunc::convertDMYToYMD($this->ngay);
    $conflict = LichHoc::find()
        ->where([
            'id_khoa_hoc' => $this->id_khoa_hoc,
            'ngay' => $this->ngay,
        ])
        ->andWhere(['<=', 'tiet_bat_dau', $this->tiet_bat_dau])
        ->andWhere(['>=', 'tiet_ket_thuc', $this->tiet_bat_dau]);

    if (!$this->isNewRecord) {
        $conflict->andWhere(['<>', 'id', $this->id]);
    }

    if ($conflict->exists()) {
        $this->addError('tiet_bat_dau', 'Trùng lịch học rồi !.');
        return false;
    }
    $conflict2 = LichHoc::find()
        ->where([
            'ngay' => $this->ngay,
            'id_giao_vien' => $this->id_giao_vien,
        ])
        ->andWhere(['<=', 'tiet_bat_dau', $this->tiet_bat_dau])
        ->andWhere(['>=', 'tiet_ket_thuc', $this->tiet_bat_dau]);

    if (!$this->isNewRecord) {
        $conflict2->andWhere(['<>', 'id', $this->id]);
    }

    if ($conflict2->exists()) {
        $this->addError('tiet_bat_dau', 'Trùng lịch dạy rồi !.');
        return false;
    }
    $conflict3 = LichHoc::find()
        ->where([
            'ngay' => $this->ngay,
            'id_phong' => $this->id_phong,
        ])
        ->andWhere(['<=', 'tiet_bat_dau', $this->tiet_bat_dau])
        ->andWhere(['>=', 'tiet_ket_thuc', $this->tiet_bat_dau]);

    if (!$this->isNewRecord) {
        $conflict3->andWhere(['<>', 'id', $this->id]);
    }

    if ($conflict3->exists()) {
        $this->addError('id_phong', 'Trùng phòng học rồi !.');
        return false;
    }
    $course = KhoaHoc::findOne($this->id_khoa_hoc);
    if ($course) {
        $startDate = strtotime($course->ngay_bat_dau);
        $endDate = strtotime($course->ngay_ket_thuc);
        $lessonDate = strtotime($this->ngay);
        if ($lessonDate < $startDate || $lessonDate > $endDate) {
            $this->addError('ngay', 'Ngày học phải nằm trong khoảng thời gian của khóa học.');
            return false;
        }
    } else {
        $this->addError('id_khoa_hoc', 'Không tìm thấy khóa học.');
        return false;
    }
    if ($this->isNewRecord) {
        $this->nguoi_tao = Yii::$app->user->identity->id;
        $this->thoi_gian_tao = date('Y-m-d H:i:s');
    } else {
        $this->nguoi_tao = Yii::$app->user->identity->id;
        $this->thoi_gian_tao = date('Y-m-d H:i:s');
    }

    return parent::beforeSave($insert);
}

    
    
}
