<?php

namespace app\modules\nhanvien\models\base;

use Yii;
use app\modules\kholuutru\models\LoaiHoSo;
/**
 * This is the model class for table "nv_ho_so_nhan_vien".
 *
 * @property int $id
 * @property int $id_nhan_vien
 * @property int $id_loai_ho_so
 * @property string|null $file_name
 * @property string|null $file_type
 * @property string|null $file_size
 * @property string $file_display_name
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvLoaiHoSo $loaiHoSo
 * @property NvNhanVien $nhanVien
 */
class HoSoNhanVienBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_ho_so_nhan_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nhan_vien', 'id_loai_ho_so', 'file_display_name'], 'required'],
            [['id_nhan_vien', 'id_loai_ho_so', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['file_name', 'file_type', 'file_size', 'file_display_name'], 'string', 'max' => 255],
            [['id_loai_ho_so'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiHoSo::class, 'targetAttribute' => ['id_loai_ho_so' => 'id']],
            [['id_nhan_vien'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['id_nhan_vien' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhan_vien' => 'Id Nhan Vien',
            'id_loai_ho_so' => 'Id Loai Ho So',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'file_display_name' => 'File Display Name',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[LoaiHoSo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiHoSo()
    {
        return $this->hasOne(LoaiHoSo::class, ['id' => 'id_loai_ho_so']);
    }

    /**
     * Gets query for [[NhanVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhanVien()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'id_nhan_vien']);
    }
}
