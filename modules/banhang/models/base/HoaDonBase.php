<?php
namespace app\modules\banhang\models\base;

use Yii;
use app\modules\banhang\models\KhachHang;
use app\modules\banhang\models\HoaDonChiTiet;
use app\custom\CustomFunc;
use app\modules\user\models\User;

/**
 * This is the model class for table "kh_don_hang".
 *
 * @property int $id
 * @property int $id_khach_hang
 * @property int $so_don_hang
 * @property int|null $so_vao_so
 * @property int|null $nam
 * @property string|null $trang_thai
 * @property string $ngay_dat_hang
 * @property string|null $ngay_xuat
 * @property string $hinh_thuc_thanh_toan
 * @property int|null $so_lan_in
 * @property int|null $da_giao_hang
 * @property string|null $ngay_giao_hang
 * @property float|null $chi_phi_van_chuyen
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $edit_mode
 *
 * @property KhDonHangChiTiet[] $khDonHangChiTiets
 * @property KhKhachHang $khachHang
 */
class HoaDonBase extends \app\models\BanleDonHang
{
    CONST TRANGTHAI_NHAP = 'BAN_NHAP';
    CONST TRANGTHAI_CHUA_TT = 'CHUA_THANH_TOAN';
    CONST TRANGTHAI_DA_TT = 'DA_THANH_TOAN';
    
    CONST THANHTOAN_TM = 'TM';
    CONST THANHTOAN_CK = 'CK';
    /**
     * Danh muc trang thai hoa don
     * @return string[]
     */
    public static function getDmTrangThai(){
        return [
            self::TRANGTHAI_NHAP => 'Bản nháp',
            //self::TRANGTHAI_CHUA_TT => 'Chưa thanh toán',
            self::TRANGTHAI_DA_TT => 'Đã thanh toán',
        ];
    }
    /**
     * Danh muc trang thai phieu xuat kho label
     * @param int $val
     * @return string
     */
    public static function getDmTrangThaiLabel($val){
        $label = '';
        if($val == self::TRANGTHAI_NHAP){
            $label = 'Bản nháp';
        }else if($val == self::TRANGTHAI_CHUA_TT){
            $label = 'Chưa thanh toán';
        }else if($val == self::TRANGTHAI_DA_TT){
            $label = 'Đã xuất';
        }
        return $label;
    }
    /**
     * Danh muc trang thai label with badge
     * @param int $val
     * @return string
     */
    public static function getDmTrangThaiLabelWithBadge($val){
        $label = '';
        if($val == self::TRANGTHAI_NHAP){
            $label = '<span class="badge bg-primary">Bản nháp</span>';
        }else if($val == self::TRANGTHAI_CHUA_TT){
            $label = '<span class="badge bg-warning">Chưa thanh toán</span>';
        }else if($val == self::TRANGTHAI_DA_TT){
            $label = '<span class="badge bg-success">Đã xuất</span>';
        }
        return $label;
    }
    /**
     * danh muc trang thai da vo so phieu
     */
    public static function getDmTrangThaiCoSoHoaDon(){
        return [
            self::TRANGTHAI_CHUA_TT,
            self::TRANGTHAI_DA_TT
        ];
    }
    /**
     * Danh muc hinh thuc thanh toan
     * @return string[]
     */
    public static function getDmHinhThucThanhToan(){
        return [
            self::THANHTOAN_TM => 'Tiền mặt (TM)',
            self::THANHTOAN_CK => 'Chuyển khoản (CK)',
        ];
    }
    /**
     * Danh muc hinh thuc thanh toan label
     * @param int $val
     * @return string
     */
    public static function getDmHinhThucThanhToanLabel($val){
        $label = '';
        if($val == self::THANHTOAN_TM){
            $label = 'Tiền mặt';
        }else if($val == self::THANHTOAN_CK){
            $label = 'Chuyển khoản';
        }
        return $label;
    }    
    
    public static function getDmNamHoaDon(){
        $start = 2025;
        $end = date('Y');
        $year_array = array();
        for($year = $end; $year>= $start; $year--){
            $year_array[$year] = $year;
        }
        return $year_array;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_vao_so', 'nam', 'trang_thai', 'ngay_xuat', 'so_lan_in','da_giao_hang', 'ngay_giao_hang', 'chi_phi_van_chuyen',  'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_khach_hang'], 'required'],
            [['id_khach_hang', 'so_don_hang', 'so_vao_so', 'nam', 'so_lan_in', 'da_giao_hang', 'nguoi_tao', 'edit_mode'], 'integer'],
            [['ngay_dat_hang', 'ngay_xuat', 'ngay_giao_hang', 'thoi_gian_tao'], 'safe'],
            [['chi_phi_van_chuyen'], 'number'],
            [['ghi_chu'], 'string'],
            [['trang_thai', 'hinh_thuc_thanh_toan'], 'string', 'max' => 20],
            [['id_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => KhachHang::class, 'targetAttribute' => ['id_khach_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khach_hang' => 'Khách hàng',
            'so_don_hang' => 'Số đơn hàng',
            'so_vao_so' => 'Số vào sổ',
            'nam' => 'Năm',
            'trang_thai' => 'Trạng thái',
            'ngay_dat_hang' => 'Ngày đặt hàng',
            'ngay_xuat' => 'Ngày xuất',
            'hinh_thuc_thanh_toan' => 'Hình thức thanh toán',
            'so_lan_in' => 'Số lần in',
            'da_giao_hang' => 'Đã giao hàng',
            'ngay_giao_hang' => 'Ngày giao hàng',
            'chi_phi_van_chuyen' => 'Chi phí vận chuyển',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'edit_mode' => 'Chế độ sửa dữ liệu'
        ];
    }
    
    /** -------xu ly cho so hoa don */
    /* public function getDaDuyet(){
     if($this->trang_thai=='DA_XUAT')
     return true;
     else
     return false;
     } */
     
     public function getSoHoaDon(){
         if($this->so_vao_so != null){
             //return 'HĐ-' . $this->fillNumber($this->so_vao_so) . '/' . $this->namVaoSo;
             return $this->fillNumber($this->so_vao_so) . '/' . $this->namVaoSo;
         } else {
             return 'BN-' . $this->fillNumber($this->getSoHoaDonCuoi($this->nam) + 1) . '/' . $this->namVaoSo;
         }
     }
     
     public function getSoHoaDonCuoi($year=NULl){
         if($year==null)
             $year = date('Y');
             $hoaDonCuoi = $this::find()->where([
                 'nam'=>$year,
             ])->andFilterWhere(['IN','trang_thai',$this::getDmTrangThaiCoSoHoaDon()])
             ->orderBy(['so_vao_so' => SORT_DESC])->one();
             
             if($hoaDonCuoi != null)
                 return $hoaDonCuoi->so_vao_so;
                 else
                     return 0;
     }
     
     public function getSoDonHangCuoi(){
        
             $hoaDonCuoi = $this::find()->where(['IN','trang_thai',$this::getDmTrangThaiCoSoHoaDon()])
                 ->orderBy(['so_don_hang' => SORT_DESC])->one();
             
             if($hoaDonCuoi != null)
                 return $hoaDonCuoi->so_don_hang;
                 else
                     return 0;
     }
     
     public function getNamVaoSo(){
         if($this->nam != null){
             return $this->nam;
         } else {
             $this->nam = date('Y');
             if($this->save()){
                 return date('Y');
             }
         }
     }
     
     public function fillNumber($number){
         $num = strlen($number);
         if( $num < 5){
             $str0 = '';
             for($i=1;$i<=(5-$num); $i++){
                 $str0 .= '0';
             }
             return $str0 . $number;
         } else {
             return $number;
         }
     }
     /** //-------end xu ly cho so hoa don */
     
     /**
      * {@inheritdoc}
      */
     public function beforeSave($insert) {
         $this->ngay_dat_hang = CustomFunc::convertDMYToYMD($this->ngay_dat_hang);
         $this->ngay_giao_hang = CustomFunc::convertDMYToYMD($this->ngay_giao_hang);
         if ($this->isNewRecord) {
             $this->thoi_gian_tao = date('Y-m-d H:i:s');
             $this->nguoi_tao = Yii::$app->user->id;
             if($this->nam == NULL)
                 $this->nam = date('Y');
             if($this->trang_thai == NULL)
                 $this->trang_thai = self::TRANGTHAI_NHAP;
             if($this->so_don_hang == NULL)
                 $this->so_don_hang = $this->soDonHangCuoi + 1;
             if($this->edit_mode == NULL)
                 $this->edit_mode = 0;
         }
         return parent::beforeSave($insert);
     }

    /**
     * Gets query for [[DonHangChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHoaDonChiTiets()
    {
        return $this->hasMany(HoaDonChiTiet::class, ['id_don_hang' => 'id']);
    }

    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(KhachHang::class, ['id' => 'id_khach_hang']);
    }
    
    public function getNguoiTao(){
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
}
