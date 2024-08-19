<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vb_dm_loai_van_ban".
 *
 * @property int $id
 * @property string $ten_loai
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property VbVanBan[] $vbVanBans
 */
class VbDmLoaiVanBan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vb_dm_loai_van_ban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai' => 'Ten Loai',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[VbVanBans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVbVanBans()
    {
        return $this->hasMany(VbVanBan::class, ['id_loai_van_ban' => 'id']);
    }
}
