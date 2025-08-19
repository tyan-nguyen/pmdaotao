<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxLichThue;
use app\modules\thuexe\models\Xe;
use app\modules\giaovien\models\GiaoVien;
use app\modules\banhang\models\KhachHang;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;
use app\modules\thuexe\models\PhieuThu;
use yii\helpers\Html;

/**
 * This is the model class for table "ptx_lich_thue".
 *
 * @property int $id
 * @property string|null $loai_giao_vien
 * @property int|null $id_giao_vien
 * @property string|null $loai_khach_hang
 * @property int|null $id_khach_hang
 * @property int $id_xe
 * @property string $thoi_gian_bat_dau
 * @property string $thoi_gian_ket_thuc
 * @property float|null $so_gio
 * @property float|null $don_gia
 * @property string|null $hinh_thuc_thanh_toan
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxXe $xe
 */
class LichThueBase extends PtxLichThue
{   
    public $ngay_bat_dau;
    public $gio_bat_dau;
    public $phut_bat_dau;
    public $ngay_ket_thuc;
    public $gio_ket_thuc;
    public $phut_ket_thuc;
    public $idHocVien;//for search
    public $idKhachNgoai;//for search
    public $idGiaoVien;//for search
    public $idGiaoVienNgoai;//for search
    public $tongGio;//use in report
    public $tongTienGio;//use in report
    
    //giá trị phải giống bán hàng  HOCVIEN, KHACHLE
    CONST KH_HOCVIEN = 'HOCVIEN';
    CONST KH_KHACHNGOAI = 'KHACHLE';
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoaiKhachHang(){
        return [
            self::KH_HOCVIEN => 'Học viên',
            self::KH_KHACHNGOAI => 'Khách ngoài',
        ];
    }
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoaiKhachHangLabel($val){
        $label = '';
        if($val == self::KH_HOCVIEN){
            $label = 'Học viên';
        }else if($val == self::KH_KHACHNGOAI){
            $label = 'Khách ngoài';
        }
        return $label;
    }
    
    //giá trị phải giống bán hàng  HOCVIEN, KHACHLE
    CONST GV_GIAOVIEN = 'GIAOVIEN';
    CONST GV_KHACHNGOAI = 'KHACHLE';
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoaiGiaoVien(){
        return [
            self::GV_GIAOVIEN => 'Giáo viên',
            self::GV_KHACHNGOAI => 'Khách ngoài',
        ];
    }
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoaiGiaoVienLabel($val){
        $label = '';
        if($val == self::GV_GIAOVIEN){
            $label = 'Giáo viên';
        }else if($val == self::GV_KHACHNGOAI){
            $label = 'Khách ngoài';
        }
        return $label;
    }
    
    //trạng thái của Lịch thuê LENLICH, XUATHOADON
    CONST TT_LENLICH = 'LENLICH';
    CONST TT_XUATHOADON = 'XUATHOADON';
    
    /**
     * Danh muc trang thai
     * @return string[]
     */
    public static function getDmTrangThai(){
        return [
            self::TT_LENLICH => 'Đã lên lịch',
            self::TT_XUATHOADON => 'Đã xuất hóa đơn',
        ];
    }
    /**
     * danh muc trang thai color
     */
    public static function getTrangThaiColor(){
        return [
            //self::TT_LENLICH => '#ffc107',
            self::TT_LENLICH => '#45aaf2',
            self::TT_XUATHOADON => '#02587b',
        ];
    }
    
    /**
     * Danh muc trang thai label
     * @return string[]
     */
    public static function getDmTrangThaiLabel($val){
        $label = '';
        if($val == self::TT_LENLICH){
            $label = 'Đã lên lịch';
        }else if($val == self::TT_XUATHOADON){
            $label = 'Đã xuất hóa đơn';
        }
        return $label;
    }
    
    /**
     * Danh muc trang thai label with badge
     * @return string[]
     */
    public static function getDmTrangThaiLabelWithBadge($val){
        $label = '';
        if($val == self::TT_LENLICH){
            $label = '<span class="badge bg-warning"><i class="fa fa-calendar-check-o"></i>&nbsp; Đã lên lịch</span>';
        }else if($val == self::TT_XUATHOADON){
            $label = '<span class="badge bg-success"><i class="fa fa-check"></i> &nbsp;Đã xuất HĐ</span>';
        }
        return $label;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_giao_vien', 'id_giao_vien', 'loai_khach_hang', 'id_khach_hang', 'so_gio', 'don_gia', 'trang_thai', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao', 'hinh_thuc_thanh_toan'], 'default', 'value' => null],
            [['id_giao_vien', 'id_khach_hang', 'id_xe', 'nguoi_tao', 'idHocVien', 'idKhachNgoai', 'idGiaoVien', 'idGiaoVienNgoai'], 'integer'],
            //[['id_xe', 'thoi_gian_bat_dau', 'thoi_gian_ket_thuc'], 'required'],
            [['ngay_bat_dau', 'gio_bat_dau', 'phut_bat_dau', 'ngay_ket_thuc', 'gio_ket_thuc', 'phut_ket_thuc','id_xe'], 'required'],
            [['thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'thoi_gian_tao', 'ngay_bat_dau', 'gio_bat_dau', 'phut_bat_dau', 'ngay_ket_thuc', 'gio_ket_thuc', 'phut_ket_thuc',
                'tongGio', 'tongTienGio'
            ], 'safe'],
            [['so_gio', 'don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['loai_giao_vien', 'loai_khach_hang', 'trang_thai', 'hinh_thuc_thanh_toan'], 'string', 'max' => 20],
            ['ngay_ket_thuc', 'validateThoiGianKetThuc', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['ngay_bat_dau', 'validateTimeConflict', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => Xe::class, 'targetAttribute' => ['id_xe' => 'id']],            
        ];
    }
    
    /**
     * custom rule
     */
    public function validateThoiGianKetThuc($attribute, $params)
    {
        $this->thoi_gian_bat_dau = CustomFunc::createCustomStartDate($this->ngay_bat_dau, $this->gio_bat_dau, $this->phut_bat_dau);
        $this->thoi_gian_ket_thuc = CustomFunc::createCustomEndDate($this->ngay_ket_thuc, $this->gio_ket_thuc, $this->phut_ket_thuc);
        if ($this->thoi_gian_ket_thuc <= $this->thoi_gian_bat_dau) {
            $this->addError('ngay_ket_thuc', 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.');
        }
        
    }
    /**
     * custom rule
     */
    public function validateTimeConflict($attribute, $params)
    {
        $this->thoi_gian_bat_dau = CustomFunc::createCustomStartDate($this->ngay_bat_dau, $this->gio_bat_dau, $this->phut_bat_dau);
        $this->thoi_gian_ket_thuc = CustomFunc::createCustomEndDate($this->ngay_ket_thuc, $this->gio_ket_thuc, $this->phut_ket_thuc);
        /* if (!$this->thoi_gian_bat_dau || !$this->thoi_gian_ket_thuc) {
            return;
        } */
        
        // Lấy bản ghi chồng lấn
        $query = self::find()
        ->where(['id_xe' => $this->id_xe]) // kiểm tra theo xe (hoặc điều kiện khác)
        ->andWhere(['!=', 'id', $this->id ?? 0]) // tránh so với chính mình khi update
        ->andWhere([
            'and',
            ['<', 'thoi_gian_bat_dau', $this->thoi_gian_ket_thuc],
            ['>', 'thoi_gian_ket_thuc', $this->thoi_gian_bat_dau]
        ]);
        
        if ($query->exists()) {
            $this->addError('ngay_bat_dau', 'Khoảng thời gian bị trùng với lịch khác.');
            $this->addError('ngay_ket_thuc', 'Khoảng thời gian bị trùng với lịch khác.');
            $this->addError('id_xe', 'Khoảng thời gian bị trùng với lịch khác.');
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_giao_vien' => 'Loại giáo viên',
            'id_giao_vien' => 'Giáo viên',
            'loai_khach_hang' => 'Loại khách hàng',
            'id_khach_hang' => 'Khách hàng',
            'id_xe' => 'Xe thuê',
            'thoi_gian_bat_dau' => 'Thời gian bắt đầu',
            'thoi_gian_ket_thuc' => 'Thời gian kết thúc',
            'so_gio' => 'Số giờ',
            'don_gia' => 'Đơn giá',
            'trang_thai' => 'Trạng thái',
            'ghi_chu' => 'Ghi chú',
            'hinh_thuc_thanh_toan' => 'Hình thức thanh toán',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'ngay_bat_dau' => 'Ngày BĐ',
            'gio_bat_dau' => 'Giờ',
            'phut_bat_dau' => 'Phút',
            'ngay_ket_thuc' => 'Ngày KT',
            'gio_ket_thuc' => 'Giờ',
            'phut_ket_thuc' => 'Phút',            
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->trang_thai == null)
                $this->trang_thai = self::TT_LENLICH;
        }
        if($this->ngay_bat_dau && $this->gio_bat_dau && $this->phut_bat_dau){
            $this->thoi_gian_bat_dau = CustomFunc::createCustomStartDate($this->ngay_bat_dau, $this->gio_bat_dau, $this->phut_bat_dau);
        }
        if($this->ngay_ket_thuc && $this->gio_ket_thuc && $this->phut_ket_thuc){
            $this->thoi_gian_ket_thuc = CustomFunc::createCustomEndDate($this->ngay_ket_thuc, $this->gio_ket_thuc, $this->phut_ket_thuc);
        }
        
        $start = new \DateTime($this->thoi_gian_bat_dau);
        $end = new \DateTime($this->thoi_gian_ket_thuc);
        $interval = $start->diff($end);        
        $hours = $interval->days * 24 + $interval->h + ($interval->i / 60);
        $this->so_gio = $hours;
        
        $xe = Xe::findOne($this->id_xe);
        if($xe){
            if($this->don_gia == null){
                $this->don_gia = $xe->getGiaXeThue();
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    
    public function afterFind()
    {
        parent::afterFind();
        $this->ngay_bat_dau = CustomFunc::convertYMDHISToDMY($this->thoi_gian_bat_dau);
        $this->gio_bat_dau = CustomFunc::convertYMDHISToH($this->thoi_gian_bat_dau);
        $this->phut_bat_dau = CustomFunc::convertYMDHISToI($this->thoi_gian_bat_dau);
        $this->ngay_ket_thuc = CustomFunc::convertYMDHISToDMY($this->thoi_gian_ket_thuc);
        $this->gio_ket_thuc = CustomFunc::convertYMDHISToH($this->thoi_gian_ket_thuc);
        $this->phut_ket_thuc = CustomFunc::convertYMDHISToI($this->thoi_gian_ket_thuc);
    }
    
    /* public function getNgay_bat_dau(){
        if($this->thoi_gian_bat_dau)
            return CustomFunc::convertYMDHISToDMY($this->thoi_gian_bat_dau);
        else 
            return NULL;
    }
    
    public function getGio_bat_dau(){
        if($this->thoi_gian_bat_dau)
            return CustomFunc::convertYMDHISToH($this->thoi_gian_bat_dau);
        else
            return NULL;
    }
    
    public function getPhut_bat_dau(){
        if($this->thoi_gian_bat_dau)
            return CustomFunc::convertYMDHISToI($this->thoi_gian_bat_dau);
        else
            return NULL;
    }
    
    public function getNgay_ket_thuc(){
        if($this->thoi_gian_ket_thuc)
            return CustomFunc::convertYMDHISToDMY($this->thoi_gian_ket_thuc);
        else 
            return NULL;
    }
    
    public function getGio_ket_thuc(){
        if($this->thoi_gian_ket_thuc)
            return CustomFunc::convertYMDHISToH($this->thoi_gian_ket_thuc);
        else
            return NULL;
    }
    
    public function getPhut_ket_thuc(){
        if($this->thoi_gian_ket_thuc)
            return CustomFunc::convertYMDHISToI($this->thoi_gian_ket_thuc);
        else
            return NULL;
    } */
    
    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        if($this->loai_giao_vien == self::GV_GIAOVIEN){
            return $this->hasOne(GiaoVien::class, ['id' => 'id_giao_vien']);
        } else if ($this->loai_giao_vien == self::GV_KHACHNGOAI){
            return $this->hasOne(KhachHang::class, ['id' => 'id_giao_vien']);
        } else{
            return null;
        }
    }
    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        if($this->loai_khach_hang == self::KH_HOCVIEN){
            return $this->hasOne(DangKyHv::class, ['id' => 'id_khach_hang']);
        } else if ($this->loai_khach_hang == self::KH_KHACHNGOAI){
            return $this->hasOne(KhachHang::class, ['id' => 'id_khach_hang']);
        } else{
            return null;
        }
    }
    
    /**
     * Gets query for [[PhieuThu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhieuThus()
    {
        return $this->hasMany(PhieuThu::class, ['id_lich_thue' => 'id']);
    }
    
    /**
     * Gets query for [[Xe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(Xe::class, ['id' => 'id_xe']);
    }
    
    /**
     * get tong tien cua 1 lich thue xe
     */
    public function getTongTien(){
        return $this->don_gia*$this->so_gio;
    }
    
    public function getTienDaNop(){//bao gom tong so tien nop am + duong
        return PhieuThu::find()->where(['id_lich_thue'=>$this->id])->sum('so_tien');
    }
    public function getTienDaNopDuong(){//bao gom tong so tien nop > 0
        return PhieuThu::find()->where(['id_lich_thue'=>$this->id])->andWhere('so_tien > 0')->sum('so_tien');
    }
    public function getTienDaNopDuongTM(){//bao gom tong so tien nop > 0
        return PhieuThu::find()->where(['id_lich_thue'=>$this->id, 'hinh_thuc_thanh_toan'=>'TM'])->andWhere('so_tien > 0')->sum('so_tien');
    }
    public function getTienDaNopDuongCK(){//bao gom tong so tien nop > 0
        return PhieuThu::find()->where(['id_lich_thue'=>$this->id, 'hinh_thuc_thanh_toan'=>'CK'])->andWhere('so_tien > 0')->sum('so_tien');
    }
    public function getTienDaNopAm(){//bao gom tong so tien nop > 0
        return PhieuThu::find()->where(['id_lich_thue'=>$this->id])->andWhere('so_tien < 0')->sum('so_tien');
    }
    public function getTienChietKhau(){//bao gom tong so tien da chiet khau
        return PhieuThu::find()->where(['id_lich_thue'=>$this->id])->sum('chiet_khau');
    }
    public function getTienDaThanhToan(){//bao gom so tien nop va chiet khau
        $tt = PhieuThu::find()->where(['id_lich_thue'=>$this->id])->sum('so_tien');
        $ck = PhieuThu::find()->where(['id_lich_thue'=>$this->id])->sum('chiet_khau');
        return $tt + $ck;
    }
    /**
     * tính tiền chưa thanh toán toàn thời gian
     * @return number
     */
    public function getTienChuaThanhToan(){ //chua thanh toan hoc phi - so tien nop - chiet khau
        $tt = PhieuThu::find()->where(['id_lich_thue'=>$this->id])->sum('so_tien');
        $ck = PhieuThu::find()->where(['id_lich_thue'=>$this->id])->sum('chiet_khau');
        return $this->tongTien - $tt - $ck;
    }
    /**
     * hiển thị trạng thái thanh toán dựa trên số tiền đã thanh toán
     */
    public function getTrangThaiThanhToan(){
        $trangThaiLabel = '';
        $tienChuaThanhToan = $this->tienChuaThanhToan;
        if($tienChuaThanhToan == 0)
            $trangThaiLabel = 'Đã thanh toán';
        else if($tienChuaThanhToan == $this->tongTien)
            $trangThaiLabel = 'Chưa thanh toán';
        else if($tienChuaThanhToan > 0 && $tienChuaThanhToan < $this->tongTien)
            $trangThaiLabel = 'Đã cọc';
        else if($tienChuaThanhToan  > $this->tongTien || $tienChuaThanhToan < 0)
            $trangThaiLabel = 'Thừa tiền';
        return $trangThaiLabel;
    }
    /**
     * hiển thị trạng thái thanh toán dựa trên số tiền đã thanh toán
     */
    public function getTrangThaiThanhToanWithBadge(){
        $trangThaiLabel = '';
        $tienChuaThanhToan = $this->tienChuaThanhToan;
        if($tienChuaThanhToan == 0)
            $trangThaiLabel = '<span class="badge bg-primary"> Đã thanh toán</span>&nbsp;' 
                . Html::img('/uploads/icons/smile.png', ['width'=>30]);
        else if($tienChuaThanhToan > 0 && $tienChuaThanhToan < $this->tongTien)
            $trangThaiLabel = '<span class="badge bg-info">Đã cọc</span>&nbsp;' 
                . Html::img('/uploads/icons/smile_1.png', ['width'=>30]);
        else if($tienChuaThanhToan == $this->tongTien)
            $trangThaiLabel = '<span class="badge bg-warning">Chưa thanh toán</span>&nbsp;'
                . Html::img('/uploads/icons/angry.png', ['width'=>30]);
       else if($tienChuaThanhToan  > $this->tongTien || $tienChuaThanhToan < 0)
            $trangThaiLabel = '<span class="badge bg-danger">Thừa tiền</span>&nbsp;'
                . Html::img('/uploads/icons/sad.png', ['width'=>30]);
        return $trangThaiLabel;
    }
    
}
