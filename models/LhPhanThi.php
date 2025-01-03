<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lh_phan_thi".
 *
 * @property int $id
 * @property string $ten_phan_thi
 * @property int $id_hang
 * @property int $diem_dat_toi_thieu
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int $thu_tu_thi
 */
class LhPhanThi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_phan_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_phan_thi', 'id_hang', 'diem_dat_toi_thieu','thu_tu_thi'], 'required'],
            [['diem_dat_toi_thieu', 'nguoi_tao','id_hang','thu_tu_thi'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_phan_thi'], 'string', 'max' => 40],
            [['trang_thai'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_phan_thi' => 'Ten Phan Thi',
            'id_hang' => 'Hang',
            'diem_dat_toi_thieu' => 'Diem Dat Toi Thieu',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'thu_tu_thi'=>'Thu Tu Thi',
        ];
    }
}
