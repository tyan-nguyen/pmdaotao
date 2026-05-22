<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_phieu_chi_tiet".
 *
 * @property int $id
 * @property int $id_phieu_de_nghi
 * @property int $id_hang_muc
 * @property string|null $chi_tiet
 * @property float|null $so_luong
 * @property float|null $don_gia
 * @property float $chiet_khau
 * @property float|null $thanh_tien
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property CpDmHangMuc $hangMuc
 * @property CpPhieuDeNghi $phieuDeNghi
 */
class CpPhieuChiTiet extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_phieu_chi_tiet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chi_tiet', 'thanh_tien', 'ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['chiet_khau'], 'default', 'value' => 0],
            [['id_phieu_de_nghi', 'id_hang_muc'], 'required'],
            [['id_phieu_de_nghi', 'id_hang_muc', 'nguoi_tao'], 'integer'],
            [['chi_tiet', 'ghi_chu'], 'string'],
            [['so_luong', 'don_gia', 'chiet_khau', 'thanh_tien'], 'number'],
            [['thoi_gian_tao'], 'safe'],
            [['id_phieu_de_nghi'], 'exist', 'skipOnError' => true, 'targetClass' => CpPhieuDeNghi::class, 'targetAttribute' => ['id_phieu_de_nghi' => 'id']],
            [['id_hang_muc'], 'exist', 'skipOnError' => true, 'targetClass' => CpDmHangMuc::class, 'targetAttribute' => ['id_hang_muc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_phieu_de_nghi' => 'Id Phieu De Nghi',
            'id_hang_muc' => 'Id Hang Muc',
            'chi_tiet' => 'Chi Tiet',
            'so_luong' => 'So Luong',
            'don_gia' => 'Don Gia',
            'chiet_khau' => 'Chiet Khau',
            'thanh_tien' => 'Thanh Tien',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[HangMuc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangMuc()
    {
        return $this->hasOne(CpDmHangMuc::class, ['id' => 'id_hang_muc']);
    }

    /**
     * Gets query for [[PhieuDeNghi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhieuDeNghi()
    {
        return $this->hasOne(CpPhieuDeNghi::class, ['id' => 'id_phieu_de_nghi']);
    }

}
