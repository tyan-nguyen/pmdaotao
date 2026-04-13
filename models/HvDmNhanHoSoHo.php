<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_dm_nhan_ho_so_ho".
 *
 * @property int $id
 * @property string $loai_don_vi
 * @property string $ten_don_vi
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class HvDmNhanHoSoHo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_dm_nhan_ho_so_ho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['loai_don_vi', 'ten_don_vi'], 'required'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao'], 'integer'],
            [['loai_don_vi'], 'string', 'max' => 20],
            [['ten_don_vi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_don_vi' => 'Loai Don Vi',
            'ten_don_vi' => 'Ten Don Vi',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

}
