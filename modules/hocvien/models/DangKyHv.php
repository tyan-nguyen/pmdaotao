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
          $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
          $this->ngay_het_han_cccd = CustomFunc::convertDMYToYMD($this->ngay_het_han_cccd);
          $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
          
          
        if ($this->isNewRecord) { 
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai = 'DANG_KY';
            $this->nguoi_lap_phieu = Yii::$app->user->identity->fullname;
            if($this->id_hang){
                $this->id_hoc_phi = HangDaoTao::findOne($this->id_hang)->hocPhi->id;
            }
            if($this->co_ho_so_thue==null){
                $this->co_ho_so_thue = 0;
            }
            if($this->da_nhan_ao==null){
                $this->da_nhan_ao = 0;
            }
            if($this->huy_ho_so==null){
                $this->huy_ho_so = 0;
            }
            
        }
        
        if($this->huy_ho_so){
            if($this->thoi_gian_huy_ho_so == ''){
                $this->thoi_gian_huy_ho_so = date('Y-m-d H:i:s');
            } else {
                $this->thoi_gian_huy_ho_so = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_huy_ho_so);
            }
            if($this->loai_ly_do == NULL)
                $this->loai_ly_do = self::HUY_BATKHAKHANG;
            if($this->le_phi==NULL)
                $this->le_phi = self::getLePhiHuyHoSo($this->loai_ly_do);
        }
        
        if(!$this->id_hoc_phi){
            $this->id_hoc_phi = HangDaoTao::findOne($this->id_hang)->hocPhi->id;
        }
        return parent::beforeSave($insert);
    }
    
    public function getKhoaHoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }

}