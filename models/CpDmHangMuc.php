<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_dm_hang_muc".
 *
 * @property int $id
 * @property int $id_loai_hang_muc
 * @property string $ten
 * @property string $dvt
 * @property float $don_gia
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property CpPhieuChiTiet[] $cpPhieuChiTiets
 * @property CpDmLoaiHangMuc $loaiHangMuc
 */
class CpDmHangMuc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_dm_hang_muc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['id_loai_hang_muc', 'ten', 'dvt', 'don_gia'], 'required'],
            [['id_loai_hang_muc', 'nguoi_tao'], 'integer'],
            [['don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten'], 'string', 'max' => 200],
            [['dvt'], 'string', 'max' => 20],
            [['ten'], 'unique'],
            [['id_loai_hang_muc'], 'exist', 'skipOnError' => true, 'targetClass' => CpDmLoaiHangMuc::class, 'targetAttribute' => ['id_loai_hang_muc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_hang_muc' => 'Id Loai Hang Muc',
            'ten' => 'Ten',
            'dvt' => 'Dvt',
            'don_gia' => 'Don Gia',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[CpPhieuChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpPhieuChiTiets()
    {
        return $this->hasMany(CpPhieuChiTiet::class, ['id_hang_muc' => 'id']);
    }

    /**
     * Gets query for [[LoaiHangMuc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiHangMuc()
    {
        return $this->hasOne(CpDmLoaiHangMuc::class, ['id' => 'id_loai_hang_muc']);
    }

}
