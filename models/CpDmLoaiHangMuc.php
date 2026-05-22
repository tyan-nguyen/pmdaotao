<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_dm_loai_hang_muc".
 *
 * @property int $id
 * @property string $ten
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string $thoi_gian_tao
 */
class CpDmLoaiHangMuc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_dm_loai_hang_muc';
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
            [['ten'], 'string', 'max' => 200],
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

}
