<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_dot_tong_hop".
 *
 * @property int $id
 * @property string $code
 * @property string|null $ngay_tong_hop
 * @property string|null $trang_thai_thanh_toan
 * @property string|null $ngay_thanh_toan
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property CpPhieuDeNghi[] $cpPhieuDeNghis
 */
class CpDotTongHop extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_dot_tong_hop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_thanh_toan', 'ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['trang_thai_thanh_toan'], 'default', 'value' => 'CHUA_THANH_TOAN'],
            [['code'], 'required'],
            [['ngay_tong_hop', 'ngay_thanh_toan', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['trang_thai_thanh_toan'], 'string', 'max' => 20],
            [['code'], 'unique'],
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
            'ngay_tong_hop' => 'Ngay Tong Hop',
            'trang_thai_thanh_toan' => 'Trang Thai Thanh Toan',
            'ngay_thanh_toan' => 'Ngay Thanh Toan',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[CpPhieuDeNghis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpPhieuDeNghis()
    {
        return $this->hasMany(CpPhieuDeNghi::class, ['id_dot_tong_hop' => 'id']);
    }

}
