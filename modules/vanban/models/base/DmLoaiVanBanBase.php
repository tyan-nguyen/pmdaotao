<?php

namespace app\modules\vanban\models\base;

use Yii;

/**
 * This is the model class for table "dm_loai_van_ban".
 *
 * @property int $id
 * @property string $ten_loai
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property VanBan[] $vanBans
 */
class DmLoaiVanBanBase extends \app\models\VbDmLoaiVanBan
{
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
            'ten_loai' => 'Tên loại văn bản',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }       
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[VanBans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVanBans()
    {
        return $this->hasMany(VanBanBase::class, ['id_loai_van_ban' => 'id']);
    }
}
