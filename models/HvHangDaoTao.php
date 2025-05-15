<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hang_dao_tao".
 *
 * @property int $id
 * @property string|null $ma_hang
 * @property string $ten_hang
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string $check_phan_hang
 *
 * @property GdHangMonHoc[] $gdHangMonHocs
 * @property HvHocPhi[] $hvHocPhis
 * @property HvHocVien[] $hvHocViens
 * @property HvKhoaHoc[] $hvKhoaHocs
 * @property LhPhanThi[] $lhPhanThis
 * @property NvDay[] $nvDays
 */
class HvHangDaoTao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hang_dao_tao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_hang', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_hang', 'check_phan_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ma_hang'], 'string', 'max' => 20],
            [['ten_hang'], 'string', 'max' => 255],
            [['check_phan_hang'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_hang' => 'Ma Hang',
            'ten_hang' => 'Ten Hang',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'check_phan_hang' => 'Check Phan Hang',
        ];
    }

    /**
     * Gets query for [[GdHangMonHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdHangMonHocs()
    {
        return $this->hasMany(GdHangMonHoc::class, ['id_hang' => 'id']);
    }

    /**
     * Gets query for [[HvHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocPhis()
    {
        return $this->hasMany(HvHocPhi::class, ['id_hang' => 'id']);
    }

    /**
     * Gets query for [[HvHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocViens()
    {
        return $this->hasMany(HvHocVien::class, ['id_hang' => 'id']);
    }

    /**
     * Gets query for [[HvKhoaHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvKhoaHocs()
    {
        return $this->hasMany(HvKhoaHoc::class, ['id_hang' => 'id']);
    }

    /**
     * Gets query for [[LhPhanThis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLhPhanThis()
    {
        return $this->hasMany(LhPhanThi::class, ['id_hang' => 'id']);
    }

    /**
     * Gets query for [[NvDays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvDays()
    {
        return $this->hasMany(NvDay::class, ['id_hang_xe' => 'id']);
    }

}
