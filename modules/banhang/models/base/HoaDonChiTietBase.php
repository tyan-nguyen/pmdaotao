<?php

namespace app\modules\banhang\models\base;

use Yii;
use app\modules\banhang\models\HoaDon;
use app\modules\banhang\models\HangHoa;

/**
 * This is the model class for table "kh_don_hang_chi_tiet".
 *
 * @property int $id
 * @property int $id_don_hang
 * @property int $id_hang_hoa
 * @property float $so_luong
 * @property float|null $don_gia
 * @property float $chiet_khau
 * @property float $thanh_tien
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 *
 * @property KhDonHang $donHang
 * @property HhHangHoa $hangHoa
 */
class HoaDonChiTietBase extends \app\models\BanleDonHangChiTiet
{  
    public $tongSoLuongSanPham;//su dung trong report
    public $tongTienSanPham;
    public $tongChietKhauSanPham;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['don_gia', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['id_don_hang', 'id_hang_hoa', 'so_luong'], 'required'],
            [['id_don_hang', 'id_hang_hoa', 'nguoi_tao'], 'integer'],
            [['so_luong', 'don_gia', 'chiet_khau', 'thanh_tien'], 'number'],
            [['thoi_gian_tao', 'tongSoLuongSanPham', 'tongTienSanPham', 'tongChietKhauSanPham'], 'safe'],
            [['ghi_chu'], 'string'],
            [['id_don_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HoaDon::class, 'targetAttribute' => ['id_don_hang' => 'id']],
            [['id_hang_hoa'], 'exist', 'skipOnError' => true, 'targetClass' => HangHoa::class, 'targetAttribute' => ['id_hang_hoa' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_don_hang' => 'Đơn hàng',
            'id_hang_hoa' => 'Hàng hóa',
            'so_luong' => 'Số lượng',
            'don_gia' => 'Đơn giá',
            'chiet_khau' => 'Chiết khấu',
            'thanh_tien' => 'Thành tiền',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'ghi_chu' => 'Ghi chú',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->nguoi_tao = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[DonHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonHang()
    {
        return $this->hasOne(HoaDon::class, ['id' => 'id_don_hang']);
    }
    
    /**
     * Gets query for [[HangHoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangHoa()
    {
        return $this->hasOne(HangHoa::class, ['id' => 'id_hang_hoa']);
    }
    
    public function getSoLuong(){
        return $this->so_luong?$this->so_luong:0;
    }
    public function getDonGia(){
        return $this->don_gia?$this->don_gia:0;
    }
    public function getChietKhau(){
        return $this->chiet_khau?$this->chiet_khau:0;
    }
    
}