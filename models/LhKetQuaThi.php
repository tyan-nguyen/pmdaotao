<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lh_ket_qua_thi".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int $id_lich_thi
 * @property int $id_phan_thi
 * @property int $diem_so
 * @property string $ket_qua
 * @property int $trang_thai
 * @property int $nguoi_tao
 * @property string $thoi_gian_tao
 * @property int $lan_thi
 */
class LhKetQuaThi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_ket_qua_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hoc_vien', 'id_lich_thi', 'id_phan_thi', 'diem_so', 'ket_qua'], 'required'],
            [['id_hoc_vien', 'id_lich_thi', 'id_phan_thi', 'diem_so', 'trang_thai', 'nguoi_tao','lan_thi'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ket_qua'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Id Hoc Vien',
            'id_lich_thi' => 'Id Lich Thi',
            'id_phan_thi' => 'Id Phan Thi',
            'diem_so' => 'Diem So',
            'ket_qua' => 'Ket Qua',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'lan_thi'=>'Lan Thi',
        ];
    }
}
