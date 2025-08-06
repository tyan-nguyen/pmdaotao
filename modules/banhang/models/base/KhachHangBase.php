<?php

namespace app\modules\banhang\models\base;

use Yii;
use app\models\BanleKhachHang;
use app\modules\banhang\models\LoaiKhachHang;

/**
 * This is the model class for table "banle_khach_hang".
 *
 * @property int $id
 * @property int|null $id_loai_khach_hang
 * @property string $ho_ten
 * @property string|null $so_dien_thoai
 * @property string $so_cccd
 * @property string|null $dia_chi
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class KhachHangBase extends BanleKhachHang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_dien_thoai', 'dia_chi', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['ho_ten', 'so_dien_thoai'], 'required'],
            [['thoi_gian_tao'], 'safe'],
            [['nguoi_tao', 'id_loai_khach_hang'], 'integer'],
            [['ho_ten', 'so_cccd'], 'string', 'max' => 200],
            [['so_dien_thoai'], 'string', 'max' => 50],
            [['dia_chi'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_khach_hang' => 'Loại khách hàng',
            'ho_ten' => 'Họ tên',
            'so_cccd' => 'Số CCCD',
            'so_dien_thoai' => 'Số điện thoại',
            'dia_chi' => 'Địa chỉ',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    /**
     * Gets query for [[LoaiKhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiKhachHang()
    {
        return $this->hasOne(LoaiKhachHang::class, ['id' => 'id_loai_khach_hang']);
    }

}
