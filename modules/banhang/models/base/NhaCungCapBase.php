<?php

namespace app\modules\banhang\models\base;

use Yii;

/**
 * This is the model class for table "ncc_nha_cung_cap".
 *
 * @property int $id
 * @property string $ten_nha_cung_cap
 * @property string $so_dien_thoai
 * @property string|null $dia_chi
 * @property int|null $tong_hop_cong_no
 * @property int|null $da_thanh_toan
 * @property int|null $con_lai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NccCongNoNhaCungCap[] $nccCongNoNhaCungCaps
 * @property NccDonHangNhaCungCap[] $nccDonHangNhaCungCaps
 */
class NhaCungCapBase extends \app\models\BanleNhaCungCap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_nha_cung_cap', 'so_dien_thoai'], 'required'],
            [['tong_hop_cong_no', 'da_thanh_toan', 'con_lai', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_nha_cung_cap', 'dia_chi'], 'string', 'max' => 255],
            [['so_dien_thoai'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_nha_cung_cap' => 'Tên nhà cung cấp',
            'so_dien_thoai' => 'Số điện thoại',
            'dia_chi' => 'Địa chỉ',
            'tong_hop_cong_no' => 'Tổng hợp công nợ',
            'da_thanh_toan' => 'Đã thanh toán',
            'con_lai' => 'Còn lại',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    public function beforeSave($insert) {
      
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');        
        }
        return parent::beforeSave($insert);
    }
}
