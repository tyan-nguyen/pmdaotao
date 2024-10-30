<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_loai_hinh_thue".
 *
 * @property int $id
 * @property string $loai_hinh_thue
 * @property int $id_loai_xe
 * @property float $gia_thue
 * @property string $ngay_ap_dung
 * @property string $ngay_ket_thuc
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxLoaiXe $loaiXe
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class PtxLoaiHinhThue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_loai_hinh_thue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_hinh_thue', 'id_loai_xe', 'gia_thue', 'ngay_ap_dung', 'ngay_ket_thuc'], 'required'],
            [['id_loai_xe', 'nguoi_tao'], 'integer'],
            [['gia_thue'], 'number'],
            [['ngay_ap_dung', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['loai_hinh_thue'], 'string', 'max' => 20],
            [['id_loai_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxLoaiXe::class, 'targetAttribute' => ['id_loai_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_hinh_thue' => 'Loai Hinh Thue',
            'id_loai_xe' => 'Id Loai Xe',
            'gia_thue' => 'Gia Thue',
            'ngay_ap_dung' => 'Ngay Ap Dung',
            'ngay_ket_thuc' => 'Ngay Ket Thuc',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[LoaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiXe()
    {
        return $this->hasOne(PtxLoaiXe::class, ['id' => 'id_loai_xe']);
    }

    /**
     * Gets query for [[PtxPhieuThueXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxPhieuThueXes()
    {
        return $this->hasMany(PtxPhieuThueXe::class, ['id_loai_hinh_thue' => 'id']);
    }
}
