<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_loai_hang_hoa".
 *
 * @property int $id
 * @property string $ten_loai_hang_hoa
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $is_thu_ho
 *
 * @property HhHangHoa[] $hhHangHoas
 */
class BanleLoaiHangHoa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_loai_hang_hoa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_loai_hang_hoa'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'is_thu_ho'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai_hang_hoa'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_hang_hoa' => 'Ten Loai Hang Hoa',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'is_thu_ho' => 'Thu hộ không tính doanh thu'
        ];
    }

    /**
     * Gets query for [[HhHangHoas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHhHangHoas()
    {
        return $this->hasMany(BanleHangHoa::class, ['id_loai_hang_hoa' => 'id']);
    }

}
