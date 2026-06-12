<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_loai_tai_san".
 *
 * @property int $id
 * @property string $ten
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property CpTaiSan[] $cpTaiSans
 */
class CpLoaiTaiSan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_loai_tai_san';
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
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
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
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[CpTaiSans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpTaiSans()
    {
        return $this->hasMany(CpTaiSan::class, ['loai_tai_san_id' => 'id']);
    }

}
