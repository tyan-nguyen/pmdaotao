<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_muon_xe".
 *
 * @property int $id
 * @property string $thoi_gian_muon
 * @property int $id_nguoi_muon
 * @property string $ghi_chu_nguoi_muon
 * @property int $id_xe_muon
 * @property int $id_nguoi_duyet
 * @property string $ghi_chu_nguoi_duyet
 * @property string $thoi_gian_duyet
 * @property string $thoi_gian_tra
 * @property string $thoi_gian_tra_du_kien
 * @property string $trang_thai
 */
class PtxMuonXe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_muon_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'thoi_gian_muon', 'id_nguoi_muon', 'ghi_chu_nguoi_muon', 'id_xe_muon', 'id_nguoi_duyet', 'ghi_chu_nguoi_duyet', 'thoi_gian_duyet', 'thoi_gian_tra', 'thoi_gian_tra_du_kien', 'trang_thai'], 'required'],
            [['id', 'id_nguoi_muon', 'id_xe_muon', 'id_nguoi_duyet'], 'integer'],
            [['thoi_gian_muon', 'thoi_gian_duyet', 'thoi_gian_tra', 'thoi_gian_tra_du_kien'], 'safe'],
            [['ghi_chu_nguoi_muon', 'ghi_chu_nguoi_duyet'], 'string'],
            [['trang_thai'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thoi_gian_muon' => 'Thoi Gian Muon',
            'id_nguoi_muon' => 'Id Nguoi Muon',
            'ghi_chu_nguoi_muon' => 'Ghi Chu Nguoi Muon',
            'id_xe_muon' => 'Id Xe Muon',
            'id_nguoi_duyet' => 'Id Nguoi Duyet',
            'ghi_chu_nguoi_duyet' => 'Ghi Chu Nguoi Duyet',
            'thoi_gian_duyet' => 'Thoi Gian Duyet',
            'thoi_gian_tra' => 'Thoi Gian Tra',
            'thoi_gian_tra_du_kien' => 'Thoi Gian Tra Du Kien',
            'trang_thai' => 'Trang Thai',
        ];
    }
}
