<?php

namespace app\modules\kholuutru\models\base;

use Yii;
use app\modules\kholuutru\models\Ngan;
use app\modules\kholuutru\models\Kho;
use app\modules\kholuutru\models\Ke;
use app\modules\kholuutru\models\Hop;
/**
 * This is the model class for table "kho_luu_kho".
 *
 * @property int $id
 * @property string|null $loai_ho_so
 * @property int $id_ho_so
 * @property int $id_kho
 * @property int $id_ke
 * @property int $id_ngan
 * @property int $id_hop
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property Hop $hop
 * @property Ke $ke
 * @property Kho $kho
 * @property Ngan $ngan
 */
class LuuKhoBase extends \yii\db\ActiveRecord
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
            [['id_ho_so', 'id_kho', 'id_ke', 'id_ngan', 'id_hop', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['loai_ho_so'], 'string', 'max' => 255],
            [['id_hop'], 'exist', 'skipOnError' => true, 'targetClass' => Hop::class, 'targetAttribute' => ['id_hop' => 'id']],
            [['id_ke'], 'exist', 'skipOnError' => true, 'targetClass' => Ke::class, 'targetAttribute' => ['id_ke' => 'id']],
            [['id_kho'], 'exist', 'skipOnError' => true, 'targetClass' => Kho::class, 'targetAttribute' => ['id_kho' => 'id']],
            [['id_ngan'], 'exist', 'skipOnError' => true, 'targetClass' => Ngan::class, 'targetAttribute' => ['id_ngan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_ho_so' => 'Loai Ho So',
            'id_ho_so' => 'Id Ho So',
            'id_kho' => 'Id Kho',
            'id_ke' => 'Id Ke',
            'id_ngan' => 'Id Ngan',
            'id_hop' => 'Id Hop',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Hop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHop()
    {
        return $this->hasOne(Hop::class, ['id' => 'id_hop']);
    }

    /**
     * Gets query for [[Ke]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKe()
    {
        return $this->hasOne(Ke::class, ['id' => 'id_ke']);
    }

    /**
     * Gets query for [[Kho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKho()
    {
        return $this->hasOne(Kho::class, ['id' => 'id_kho']);
    }

    /**
     * Gets query for [[Ngan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNgan()
    {
        return $this->hasOne(Ngan::class, ['id' => 'id_ngan']);
    }
}
