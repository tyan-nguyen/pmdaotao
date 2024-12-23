<?php

namespace app\modules\hocvien\models;
use Yii;
use app\modules\hocvien\models\base\HocVienBase;
use app\custom\CustomFunc;
/**
 * HocVienSearch represents the model behind the search form about `app\models\HvHocVien`.
 */
class DangKyHv extends HocVienBase
{
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai='DANG_KY';
            $this->nguoi_lap_phieu = Yii::$app->user->identity->fullname;
            $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
        }
  
        return parent::beforeSave($insert);
    }
    public function getKhoaHoc()
{
    return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
}


}