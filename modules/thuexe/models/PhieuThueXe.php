<?php

namespace app\modules\thuexe\models;
use app\modules\thuexe\models\base\PhieuThueXeBase;
use app\modules\hocvien\models\HocVien;
use app\modules\nhanvien\models\NhanVien;
use Yii;
use app\custom\CustomFunc;
use app\models\User;

class PhieuThueXe extends PhieuThueXeBase
{
    public function getNguoiGui()
    {
           return $this->hasOne(User::class, ['id' => 'id_nguoi_gui']);
    }
    public function getNguoiKiemDuyet()
    {
           return $this->hasOne(User::class, ['id' => 'id_nguoi_duyet']);
    }

    public function getNgayThueXe(){
        return CustomFunc::convertYMDToDMY($this->ngay_thue_xe);
    }
    public function getHocVien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
    }

    public function getXe()
    {
        return $this->hasOne(Xe::class, ['id' => 'id_xe']);
    }

    public function getLoaiHinhThue()
    {
        return $this->hasOne(LoaiHinhThue::class, ['id' => 'id_loai_hinh_thue']);
    }

    public function getNhanVien()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'id_nhan_vien_cho_thue']);
    }

    public function beforeSave($insert)
    {
        // Chuyển đổi định dạng ngày tháng trước khi lưu, bất kể là tạo mới hay cập nhật 
      
        $this->ngay_thue_xe = CustomFunc::convertDMYToYMD($this->ngay_thue_xe);
        $this->ngay_tra_xe = CustomFunc::convertDMYToYMD($this->ngay_tra_xe);
        $this->thoi_gian_bat_dau_thue = CustomFunc::convertYMDHISToDMYHIS($this->thoi_gian_bat_dau_thue);
        $this->thoi_gian_tra_xe_du_kien = CustomFunc::convertYMDHISToDMYHIS($this->thoi_gian_tra_xe_du_kien);
        if ($this->isNewRecord) {

            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
             $this->trang_thai='Đã nhập';
        }
    
        return parent::beforeSave($insert);
    }
}
   
