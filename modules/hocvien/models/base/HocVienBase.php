<?php

namespace app\modules\hocvien\models\base;

use Yii;
use app\modules\kholuutru\models\HoSo;
use app\modules\hocvien\models\KhoaHoc;
/**
 * This is the model class for table "hv_hoc_vien".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property string $ho_ten
 * @property string $so_dien_thoai
 * @property string $so_cccd
 * @property string $ngay_cap_cccd
 * @property string $noi_cap_cccd
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHoSoHocVien[] $hvHoSoHocViens
 * @property HvNopHocPhi[] $hvNopHocPhis
 * @property HvKhoaHoc $khoaHoc
 */
class HocVienBase extends \app\models\HvHocVien
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_khoa_hoc', 'ho_ten', 'so_dien_thoai', 'so_cccd', 'ngay_cap_cccd', 'noi_cap_cccd', 'trang_thai'], 'required'],
            [['id_khoa_hoc', 'nguoi_tao'], 'integer'],
            [['ngay_cap_cccd', 'thoi_gian_tao'], 'safe'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'noi_cap_cccd', 'trang_thai'], 'string', 'max' => 255],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khoa_hoc' => 'Id Khoa Hoc',
            'ho_ten' => 'Ho Ten',
            'so_dien_thoai' => 'So Dien Thoai',
            'so_cccd' => 'So Cccd',
            'ngay_cap_cccd' => 'Ngay Cap Cccd',
            'noi_cap_cccd' => 'Noi Cap Cccd',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[HvHoSoHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHoSoHocViens()
    {
        return $this->hasMany(HoSo::class, ['id_hoc_vien' => 'id']);
    }

    /**
     * Gets query for [[HvNopHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvNopHocPhis()
    {
        return $this->hasMany(NopHocPhi::class, ['id_hoc_vien' => 'id']);
    }

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }
}
