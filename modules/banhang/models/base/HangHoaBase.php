<?php

namespace app\modules\banhang\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\banhang\models\LoaiHangHoa;
use app\modules\banhang\models\HangHoaLichSu;
use app\modules\banhang\models\DVT;
/**
 * This is the model class for table "hh_hang_hoa".
 *
 * @property int $id
 * @property int $id_loai_hang_hoa
 * @property string $ma_hang_hoa
 * @property string $ten_hang_hoa
 * @property string|null $ngay_san_xuat
 * @property float|null $so_luong
 * @property float $don_gia
 * @property string $dvt
 * @property string|null $xuat_xu
 * @property string|null $ghi_chu
 * @property int|null $co_ton_kho
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HhHangHoaLichSu[] $hhHangHoaLichSus
 * @property KhDonHangChiTiet[] $khDonHangChiTiets
 * @property HhLoaiHangHoa $loaiHangHoa
 * @property NccChiTietDonHangNcc[] $nccChiTietDonHangNccs
 */
class HangHoaBase extends \app\models\BanleHangHoa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_san_xuat', 'so_luong', 'xuat_xu', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao', 'co_ton_kho'], 'default', 'value' => null],
            [['ma_hang_hoa', 'ten_hang_hoa', 'don_gia', 'dvt'], 'required'],
            [['id_loai_hang_hoa', 'nguoi_tao', 'co_ton_kho'], 'integer'],
            [['ngay_san_xuat', 'thoi_gian_tao'], 'safe'],
            [['so_luong', 'don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['ma_hang_hoa'], 'string', 'max' => 50],
            [['ten_hang_hoa'], 'string', 'max' => 255],
            [['dvt', 'xuat_xu'], 'string', 'max' => 20],
            [['id_loai_hang_hoa'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiHangHoa::class, 'targetAttribute' => ['id_loai_hang_hoa' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_hang_hoa' => 'Loại hàng hóa',
            'ma_hang_hoa' => 'Mã hàng hóa',
            'ten_hang_hoa' => 'Tên hàng hóa',            
            'ngay_san_xuat' => 'Ngày sản xuất',
            'so_luong' => 'Số lượng tồn kho',
            'don_gia' => 'Đơn giá',
            'dvt' => 'ĐVT',
            'xuat_xu' => 'Xuất xứ',
            'ghi_chu' => 'Ghi chú',
            'co_ton_kho' => 'Quản lý tồn kho',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    public function beforeSave($insert) {
        if($this->ngay_san_xuat){
            $this->ngay_san_xuat = CustomFunc::convertDMYToYMD($this->ngay_san_xuat);
        }
        if($this->id_loai_hang_hoa == null){
            $this->id_loai_hang_hoa = 1;//1 là chưa phân loại
        }
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
            if($this->co_ton_kho == null){
                $this->co_ton_kho = 0;
            }
            if(!$this->co_ton_kho){
                $this->so_luong = 0;
            }
        }
        return parent::beforeSave($insert);
    }
    //tạo mã random để gán cho mã sản phẩm
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $hangHoaModel = HangHoaBase::findOne(['ma_hang_hoa'=>$code]);
        if($hangHoaModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }    
    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if($this->co_ton_kho){
                $lichSuTonKho = new HangHoaLichSu();
                $lichSuTonKho->id_hang_hoa = $this->id;
                $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                $lichSuTonKho->loai_thay_doi = HangHoaLichSu::LOAI_NHAPXUATKHO;
                $lichSuTonKho->ghi_chu = 'Nhập số lượng khi thêm mới vào kho';
                $lichSuTonKho->so_luong = $this->so_luong;
                $lichSuTonKho->so_luong_cu = 0;
                $lichSuTonKho->so_luong_moi = $this->so_luong;
                $lichSuTonKho->save();
            }
        }        
        return parent::afterSave($insert, $changedAttributes);
    } 
    /**
     * Gets query for [[HhHangHoaLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLichSuTonKho()
    {
        return $this->hasMany(HangHoaLichSu::class, ['id_hang_hoa' => 'id']);
    }
    
    /**
     * Gets query for [[KhDonHangChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhDonHangChiTiets()
    {
        return $this->hasMany(KhDonHangChiTiet::class, ['id_hang_hoa' => 'id']);
    }
    
    /**
     * Gets query for [[DVT]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonViTinh()
    {
        return $this->hasOne(DVT::class, ['id' => 'dvt']);
    }
    
    /**
     * Gets query for [[LoaiHangHoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiHangHoa()
    {
        return $this->hasOne(LoaiHangHoa::class, ['id' => 'id_loai_hang_hoa']);
    }
    
    /**
     * Gets query for [[NccChiTietDonHangNccs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNccChiTietDonHangNccs()
    {
        return $this->hasMany(NccChiTietDonHangNcc::class, ['id_hang_hoa' => 'id']);
    }
}
