<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_lich_dung_xe".
 *
 * @property int $id
 * @property int $id_xe
 * @property int $id_nguoi_phu_trach
 * @property int|null $id_tai_xe
 * @property string $noi_dung
 * @property string $thoi_gian_bat_dau
 * @property string $thoi_gian_ket_thuc
 * @property float|null $so_gio
 * @property string|null $trang_thai
 * @property string $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $nguoiPhuTrach
 * @property NvNhanVien $taiXe
 * @property PtxXe $xe
 */
class PtxXeLichDungXe extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_lich_dung_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tai_xe', 'so_gio', 'trang_thai', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_xe', 'id_nguoi_phu_trach', 'noi_dung', 'thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'ghi_chu'], 'required'],
            [['id_xe', 'id_nguoi_phu_trach', 'id_tai_xe', 'nguoi_tao'], 'integer'],
            [['noi_dung', 'ghi_chu'], 'string'],
            [['thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['so_gio'], 'number'],
            [['trang_thai'], 'string', 'max' => 20],
            [['id_nguoi_phu_trach'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_nguoi_phu_trach' => 'id']],
            [['id_tai_xe'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_tai_xe' => 'id']],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXe::class, 'targetAttribute' => ['id_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_xe' => 'Id Xe',
            'id_nguoi_phu_trach' => 'Id Nguoi Phu Trach',
            'id_tai_xe' => 'Id Tai Xe',
            'noi_dung' => 'Noi Dung',
            'thoi_gian_bat_dau' => 'Thoi Gian Bat Dau',
            'thoi_gian_ket_thuc' => 'Thoi Gian Ket Thuc',
            'so_gio' => 'So Gio',
            'trang_thai' => 'Trang Thai',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[NguoiPhuTrach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiPhuTrach()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'id_nguoi_phu_trach']);
    }

    /**
     * Gets query for [[TaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiXe()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'id_tai_xe']);
    }

    /**
     * Gets query for [[Xe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(PtxXe::class, ['id' => 'id_xe']);
    }

}
