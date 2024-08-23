<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_loai_ho_so".
 *
 * @property int $id
 * @property string $ten_ho_so
 * @property string $loai
 * @property int $ho_so_bat_buoc
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $doi_tuong
 *
 * @property KhoHoSo[] $khoHoSos
 */
class KhoLoaiHoSo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_loai_ho_so';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_ho_so', 'loai', 'ho_so_bat_buoc'], 'required'],
            [['ho_so_bat_buoc', 'nguoi_tao', 'doi_tuong'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_ho_so', 'loai'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_ho_so' => 'Ten Ho So',
            'loai' => 'Loai',
            'ho_so_bat_buoc' => 'Ho So Bat Buoc',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'doi_tuong' => 'Doi Tuong',
        ];
    }

    /**
     * Gets query for [[KhoHoSos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoHoSos()
    {
        return $this->hasMany(KhoHoSo::class, ['id_loai_ho_so' => 'id']);
    }
}
