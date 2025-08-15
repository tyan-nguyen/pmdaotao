<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_phieu_thu".
 *
 * @property int $id
 * @property int $id_lich_thue
 * @property string|null $loai_phieu PHIEUTHU;PHIEUCHI
 * @property float $so_tien
 * @property float|null $chiet_khau
 * @property float|null $so_tien_con_lai
 * @property int|null $ma_so_phieu
 * @property int|null $so_lan_in_phieu
 * @property string|null $hinh_thuc_thanh_toan
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 *
 * @property PtxLichThue $lichThue
 */
class PtxPhieuThu extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_phieu_thu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_phieu', 'chiet_khau', 'so_tien_con_lai', 'ma_so_phieu', 'so_lan_in_phieu', 'hinh_thuc_thanh_toan', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['id_lich_thue', 'so_tien'], 'required'],
            [['id_lich_thue', 'ma_so_phieu', 'so_lan_in_phieu', 'nguoi_tao'], 'integer'],
            [['so_tien', 'chiet_khau', 'so_tien_con_lai'], 'number'],
            [['thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['loai_phieu', 'hinh_thuc_thanh_toan'], 'string', 'max' => 20],
            [['id_lich_thue'], 'exist', 'skipOnError' => true, 'targetClass' => PtxLichThue::class, 'targetAttribute' => ['id_lich_thue' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lich_thue' => 'Id Lich Thue',
            'loai_phieu' => 'Loai Phieu',
            'so_tien' => 'So Tien',
            'chiet_khau' => 'Chiet Khau',
            'so_tien_con_lai' => 'So Tien Con Lai',
            'ma_so_phieu' => 'Ma So Phieu',
            'so_lan_in_phieu' => 'So Lan In Phieu',
            'hinh_thuc_thanh_toan' => 'Hinh Thuc Thanh Toan',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

    /**
     * Gets query for [[LichThue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLichThue()
    {
        return $this->hasOne(PtxLichThue::class, ['id' => 'id_lich_thue']);
    }

}
