<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_luu_kho".
 *
 * @property int $id
 * @property string|null $loai_file
 * @property int $id_file
 * @property int $id_kho
 * @property int $id_ke
 * @property int $id_ngan
 * @property int $id_hop
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong 
 * @property KhoHop $hop
 * @property KhoKe $ke
 * @property KhoKho $kho
 * @property KhoNgan $ngan
 */
class KhoLuuKho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_luu_kho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ho_so', 'id_kho', 'id_ke', 'id_ngan', 'id_hop'], 'required'],
            [['id_file', 'id_kho', 'id_ke', 'id_ngan', 'id_hop', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['loai_file'], 'string', 'max' => 255],
            [['doi_tuong','string','max'=>20]],
            [['id_hop'], 'exist', 'skipOnError' => true, 'targetClass' => KhoHop::class, 'targetAttribute' => ['id_hop' => 'id']],
            [['id_ke'], 'exist', 'skipOnError' => true, 'targetClass' => KhoKe::class, 'targetAttribute' => ['id_ke' => 'id']],
            [['id_kho'], 'exist', 'skipOnError' => true, 'targetClass' => KhoKho::class, 'targetAttribute' => ['id_kho' => 'id']],
            [['id_ngan'], 'exist', 'skipOnError' => true, 'targetClass' => KhoNgan::class, 'targetAttribute' => ['id_ngan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_file' => 'Loai File',
            'id_file' => 'Id File',
            'id_kho' => 'Id Kho',
            'id_ke' => 'Id Ke',
            'id_ngan' => 'Id Ngan',
            'id_hop' => 'Id Hop',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'doi_tuong'=>'Đối tượng'
        ];
    }

    /**
     * Gets query for [[Hop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHop()
    {
        return $this->hasOne(KhoHop::class, ['id' => 'id_hop']);
    }

    /**
     * Gets query for [[Ke]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKe()
    {
        return $this->hasOne(KhoKe::class, ['id' => 'id_ke']);
    }

    /**
     * Gets query for [[Kho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKho()
    {
        return $this->hasOne(KhoKho::class, ['id' => 'id_kho']);
    }

    /**
     * Gets query for [[Ngan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNgan()
    {
        return $this->hasOne(KhoNgan::class, ['id' => 'id_ngan']);
    }
}
