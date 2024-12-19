<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lh_phong_hoc".
 *
 * @property int $id
 * @property string $ten_phong
 * @property string $so_do_phong
 * @property string $ghi_chu
 * @property int $nguoi_tao
 * @property string $thoi_gian_tao
 *
 * @property LhLichHoc[] $lhLichHocs
 */
class LhPhongHoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_phong_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ten_phong'], 'required'],
            [['id', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_phong'], 'string', 'max' => 50],
            [['so_do_phong'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_phong' => 'Ten Phong',
            'so_do_phong' => 'So Do Phong',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[LhLichHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLhLichHocs()
    {
        return $this->hasMany(LhLichHoc::class, ['id_phong' => 'id']);
    }
}
