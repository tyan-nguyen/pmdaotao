<?php

namespace app\modules\hocvien\models;

use app\modules\hocvien\models\base\HocVienBase;
use app\modules\kholuutru\models\File;
use app\modules\kholuutru\models\LuuKho;
use app\modules\khoahoc\models\NhomHoc;
use app\custom\CustomFunc;
use Yii;
use yii\helpers\ArrayHelper;
use app\modules\giaovien\models\GiaoVien;
use app\modules\daotao\models\GvHv;

class HocVien extends HocVienBase
{
    CONST MODEL_ID = 'HOCVIEN';
    
    public function getPubName(){
        return $this->ho_ten;
    }
    
    /**
     * {@inheritdoc}
     * xoa file anh, tai lieu, lich su sau khi xoa du lieu
     */
    public function afterDelete()
    {
        File::deleteFileThamChieu($this::MODEL_ID, $this->id);
        LuuKho::deleteKhoThamChieu($this::MODEL_ID, $this->id);
        return parent::afterDelete();
    }
    
    /* public function getHocPhi()
    {
        // Truy vấn học phí từ bảng hoc_phi dựa trên id_hang
        return HocPhi::find()
            ->where(['id_hang' => $this->id_hang])
            ->one();
    } */
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
    public function getNhomHoc()
    {
        return $this->hasOne(NhomHoc:: class,['id'=>'id_nhom'] );
    }
    public function beforeSave($insert)
    {
       
        
        if ($this->id_khoa_hoc) { // Kiểm tra nếu có id_khoa_hoc
            // Truy vấn số học viên tối đa cho phép của khóa học
            $khoaHoc = KhoaHoc::findOne($this->id_khoa_hoc);
            if ($khoaHoc) {
                $soHocVienToiDa = $khoaHoc->so_hoc_vien_khoa_hoc;
    
                // Đếm số học viên đã đăng ký trong khóa học đó (loại trừ chính bản thân nếu đang cập nhật)
                $query = HocVien::find()->where(['id_khoa_hoc' => $this->id_khoa_hoc]);
                if (!$this->isNewRecord) {
                    $query->andWhere(['!=', 'id', $this->id]); // Loại trừ học viên hiện tại
                }
                $soHocVienHienTai = $query->count();
    
                // Kiểm tra nếu số học viên đã đạt mức tối đa
                if ($soHocVienHienTai >= $soHocVienToiDa) {
                    $this->addError('ho_ten', 'Khóa học này đã đủ số lượng học viên cho phép, Không thể thêm hoặc cập nhật !.');
                    return false; // Hủy việc lưu học viên
                }
            }
        }
    
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai = 'NHAPTRUCTIEP';
            $this->loai_dang_ky = 'Nhập trực tiếp';
            $this->id_hoc_phi =1; 
            //if($this->id_hang){
              //  $this->id_hoc_phi = 1;
            //}
        }
        //set id_hoc_phi
        /* if($this->id_hoc_phi == null){
             $this->id_hoc_phi = HangDaoTao::findOne($this->id_hang)->hocPhi->id;
        } */
        
        $this->ngay_sinh = CustomFunc::convertDMYToYMD($this->ngay_sinh);
        $this->ngay_het_han_cccd = CustomFunc::convertDMYToYMD($this->ngay_het_han_cccd);
        $this->ngay_nhan_ao = CustomFunc::convertDMYToYMD($this->ngay_nhan_ao);
        if($this->huy_ho_so){
            if($this->thoi_gian_huy_ho_so == ''){
                $this->thoi_gian_huy_ho_so = date('Y-m-d H:i:s');
            } else {
                $this->thoi_gian_huy_ho_so = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_huy_ho_so);
            }
        }
        
        
    
        return parent::beforeSave($insert);
    }
    /**
     * {@inheritdoc}
     */
    /* public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($this->id_hang){
            $this->id_hoc_phi = 25;
            $this->updateAttributes(['id_hoc_phi']);
        }
    } */
    
    /**
     * for gv in hoc_vien table
     * @param unknown $idgv
     * @return array|unknown[]|mixed|unknown
     */
    public static function getListByGiaoVien($idgv)
    {
        $dsHocVien = HocVien::find()
        ->where(['id_giao_vien' => $idgv])
        ->orderBy(['id_khoa_hoc' => SORT_ASC,'ho_ten' => SORT_ASC])
        ->all();
        
        return ArrayHelper::map($dsHocVien, 'id', function ($model) {
            return '+ ' . $model->ho_ten;
        });
       
    }
    /**
     * for gv in gv_hv table
     * @param unknown $idgv
     * @return array|unknown[]|mixed|unknown
     */
    public static function getListByGiaoVienDay($idgv)
    {
        $dsHocVien = GvHv::find()->alias('t')->joinWith(['hocVien as hv', 'hocVien.khoaHoc as kh'])
        ->where(['t.id_giao_vien' => $idgv])
        ->orderBy(['hv.id_khoa_hoc' => SORT_ASC,'hv.ho_ten' => SORT_ASC])
        ->all();
        
        return ArrayHelper::map($dsHocVien, 'id_hoc_vien', function ($model) {
            return '+ ' . $model->hocVien->ho_ten;
        },function ($model) {
            return $model->hocVien->khoaHoc->ten_khoa_hoc;
        });
            
    }
    
  
}