<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_dm_don_vi".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten
 * @property int|null $co_sua_chua
 * @property int|null $co_ban_hang
 * @property string|null $ghi_chu
 * @property int|null $stt
 * @property int|null $nguoi_tao
 * @property string $thoi_gian_tao
 */
class CpDmDonVi extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_dm_don_vi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['stt'], 'default', 'value' => 0],
            [['ten'], 'required'],
            [['co_sua_chua', 'co_ban_hang', 'stt', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['code'], 'string', 'max' => 50],
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
            'code' => 'Code',
            'ten' => 'Ten',
            'co_sua_chua' => 'Co Sua Chua',
            'co_ban_hang' => 'Co Ban Hang',
            'ghi_chu' => 'Ghi Chu',
            'stt' => 'Stt',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

}
