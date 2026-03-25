<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_dm_lien_ket".
 *
 * @property int $id
 * @property string $loai_lien_ket
 * @property string $ten_lien_ket
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class HvDmLienKet extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_dm_lien_ket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['loai_lien_ket', 'ten_lien_ket'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
            [['loai_lien_ket'], 'string', 'max' => 20],
            [['ten_lien_ket'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_lien_ket' => 'Loai Lien Ket',
            'ten_lien_ket' => 'Ten Lien Ket',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

}
