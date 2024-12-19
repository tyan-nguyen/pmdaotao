<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_nhom".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property string $ten_nhom
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvKhoaHoc $khoaHoc
 */
class HvNhom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_nhom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_khoa_hoc', 'ten_nhom'], 'required'],
            [['id_khoa_hoc', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_nhom'], 'string', 'max' => 50],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => HvKhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
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
            'ten_nhom' => 'Ten Nhom',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(HvKhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }
}
