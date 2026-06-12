<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_danh_muc_tai_san".
 *
 * @property int $id
 * @property string $ten
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property CpTaiSan[] $cpTaiSans
 */
class CpDanhMucTaiSan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_danh_muc_tai_san';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['ten'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Ten',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[CpTaiSans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpTaiSans()
    {
        return $this->hasMany(CpTaiSan::class, ['danh_muc_id' => 'id']);
    }

}
