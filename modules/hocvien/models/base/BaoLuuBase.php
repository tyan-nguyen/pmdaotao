<?php

namespace app\modules\hocvien\models\base;

use Yii;
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\KhoaHoc;
use app\modules\hocvien\models\HangDaoTao;
use app\custom\CustomFunc;

/**
 * This is the model class for table "hv_hoc_vien_bao_luu".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int|null $id_hang
 * @property int|null $id_khoa
 * @property string|null $ngay_khai_giang
 * @property string|null $ngay_bat_dau
 * @property string|null $ngay_ket_thuc
 * @property float|null $hoc_phi_da_dong
 * @property string|null $ly_do
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class BaoLuuBase extends \app\models\HvHocVienBaoLuu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'id_khoa', 'ngay_khai_giang', 'ngay_bat_dau', 'ngay_ket_thuc', 'hoc_phi_da_dong', 'ly_do', 'ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            
            [['id_hoc_vien'], 'required'],
            [['id_hoc_vien', 'id_hang', 'id_khoa', 'nguoi_tao'], 'integer'],
            [['ngay_khai_giang', 'ngay_bat_dau', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['hoc_phi_da_dong'], 'number'],
            [['ly_do', 'ghi_chu'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Học viên',
            'id_hang' => 'Hạng',
            'id_khoa' => 'Khóa',
            'ngay_khai_giang' => 'Ngày khai giảng',
            'ngay_bat_dau' => 'Ngày bắt đầu bảo lưu',
            'ngay_ket_thuc' => 'Ngày kết thúc bảo lưu',
            'hoc_phi_da_dong' => 'Học phí đã đóng',
            'ly_do' => 'Lý do bảo lưu',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    
    public function beforeSave($insert) {
        $this->ngay_khai_giang = CustomFunc::convertDMYToYMD($this->ngay_khai_giang);
        $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
        $this->ngay_ket_thuc = CustomFunc::convertDMYToYMD($this->ngay_ket_thuc);
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
    
    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(DangKyHv::class, ['id' => 'id_hoc_vien']);
    }
    
    /**
     * Gets query for [[Khoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoa()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa']);
    }

}
