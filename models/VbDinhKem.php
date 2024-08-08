<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vb_dinh_kem".
 *
 * @property int $id
 * @property int $id_van_ban
 * @property int|null $id_van_ban_dinh_kem
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property VanBan $vanBan
 * @property VbDinhKem $vanBanDinhKem
 * @property VbDinhKem[] $vbDinhKems
 */
class VbDinhKem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vb_dinh_kem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_van_ban'], 'required'],
            [['id_van_ban', 'id_van_ban_dinh_kem', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => VanBan::class, 'targetAttribute' => ['id_van_ban' => 'id']],
            [['id_van_ban_dinh_kem'], 'exist', 'skipOnError' => true, 'targetClass' => VbDinhKem::class, 'targetAttribute' => ['id_van_ban_dinh_kem' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_van_ban' => 'Id Van Ban',
            'id_van_ban_dinh_kem' => 'Id Van Ban Dinh Kem',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[VanBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVanBan()
    {
        return $this->hasOne(VanBan::class, ['id' => 'id_van_ban']);
    }

    /**
     * Gets query for [[VanBanDinhKem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVanBanDinhKem()
    {
        return $this->hasOne(VbDinhKem::class, ['id' => 'id_van_ban_dinh_kem']);
    }

    /**
     * Gets query for [[VbDinhKems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVbDinhKems()
    {
        return $this->hasMany(VbDinhKem::class, ['id_van_ban_dinh_kem' => 'id']);
    }
}
