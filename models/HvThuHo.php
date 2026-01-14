<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_thu_ho".
 *
 * @property int $id
 * @property int $id_hang
 * @property float $so_tien
 * @property string $ghi_chu
 * @property int $active
 * @property int $nguoi_tao
 * @property string $thoi_gian_tao
 *
 * @property HvHangDaoTao $hang
 */
class HvThuHo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_thu_ho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'so_tien', 'ghi_chu', 'active', 'nguoi_tao', 'thoi_gian_tao'], 'required'],
            [['id_hang', 'active', 'nguoi_tao'], 'integer'],
            [['so_tien'], 'number'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hang' => 'Id Hang',
            'so_tien' => 'So Tien',
            'ghi_chu' => 'Ghi Chu',
            'active' => 'Active',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HvHangDaoTao::class, ['id' => 'id_hang']);
    }

}
