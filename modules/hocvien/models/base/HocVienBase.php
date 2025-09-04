<?php

namespace app\modules\hocvien\models\base;
use app\custom\CustomFunc;
use Yii;

use app\modules\hocvien\models\KhoaHoc;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\khoahoc\models\NhomHoc;
use app\modules\user\models\User;
use app\modules\hocvien\models\HocPhi;
use yii\db\Expression;
use app\modules\giaovien\models\GiaoVien;
use app\modules\hocvien\models\ThayDoiHocPhi;
use app\modules\daotao\models\GvHv;
use app\modules\hocvien\models\BaoLuu;
use app\modules\hocvien\models\DoiSatHach;

/**
 * This is the model class for table "hv_hoc_vien".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property int $id_hoc_phi
 * @property string $ho_ten
 * @property string $so_dien_thoai
 * @property string $so_cccd
 * @property string $ngay_sinh
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string $ngay_sinh
 * @property string $check_hoc_phi
 * @property int|null $id_nhom
  * @property string|null $ngay_het_han_cccd 
 * @property string|null $noi_dang_ky
 * @property int|null $ma_so_phieu 
 * @property int|null $so_lan_in_phieu
 * @property string|null $trang_thai_duyet 
 * @property HvHoSoHocVien[] $hvHoSoHocViens
 * @property HvNopHocPhi[] $hvNopHocPhis
 * @property HvKhoaHoc $khoaHoc
 * @property int|null $nguoi_duyet
 * @property string|null $loai_dang_ky
 * @property string|null $ghi_chu
 * @property string|null thoi_gian_hoan_thanh_ho_so
 * @property int|null $co_ho_so_thue
 * @property int|null $da_nhan_ao
 * @property string|null $size
 * @property string|null $ngay_nhan_ao
 * @property int|null $id_giao_vien
 * @property int|null $huy_ho_so
 * @property string|null $thoi_gian_huy_ho_so
 * @property string|null $ly_do_huy_ho_so
 * @property string|null $loai_ly_do
 * @property float|null $le_phi
 */
class HocVienBase extends \app\models\HvHocVien
{
    const NOIDANGKY_CS1 = 'CS1';
    const NOIDANGKY_CS2 = 'CS2';
    
    const NOIDANGKY_CS3 = 'CS3';
    const NOIDANGKY_CS4 = 'CS4';
    const NOIDANGKY_CS5 = 'CS5';
    
    const HUY_BATKHAKHANG = 'BATKHAKHANG';
    const HUY_KHACHQUAN = 'KHACHQUAN';
    const HUY_CHUQUAN = 'CHUQUAN';
    
    public $tongtiennop;//virtual attribute select when report
    //dành cho thay đổi hạng
    public $so_tien;
    public $thoi_gian_thay_doi;
        
    
    /**
     * Danh muc hinh thuc chuyen khoan
     * @return string[]
     */
    public static function getDmNoiDangKy()
    {
        return [
            self::NOIDANGKY_CS1 => 'CS1 - VP Nguyễn Trình',
            self::NOIDANGKY_CS2 => 'CS2 - TL Nguyễn Trình',
            self::NOIDANGKY_CS3 => 'CS3 - CN Càng Long',
            self::NOIDANGKY_CS4 => 'CS4 - CN Duyên Hải',
            self::NOIDANGKY_CS5 => 'CS5 - CN Chợ Lách',
        ];
    }
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public function getLabelNoiDangKy($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->noi_dang_ky;
        }
        switch ($val) {
            case self::NOIDANGKY_CS1:
                $label = "VP Nguyễn Trình";
                break;
            case self::NOIDANGKY_CS2:
                $label = "TL Nguyễn Trình";
                break;
            case self::NOIDANGKY_CS3:
                $label = "CN Càng Long";
                break;
            case self::NOIDANGKY_CS4:
                $label = "CN Duyên Hải";
                break;
            case self::NOIDANGKY_CS5:
                $label = "CN Chợ Lách";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public static function getLabelNoiDangKyOther($val=NULL)
    {
        switch ($val) {
            case self::NOIDANGKY_CS1:
                $label = "VP Nguyễn Trình";
                break;
            case self::NOIDANGKY_CS2:
                $label = "TL Nguyễn Trình";
                break;
            case self::NOIDANGKY_CS3:
                $label = "CN Càng Long";
                break;
            case self::NOIDANGKY_CS4:
                $label = "CN Duyên Hải";
                break;
            case self::NOIDANGKY_CS5:
                $label = "CN Chợ Lách";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public static function getLabelNoiDangKyBadge($val=NULL)
    {
        switch ($val) {
            case self::NOIDANGKY_CS1:
                $label = '<span class="badge bg-primary">'.$val.'</span> ';
                break;
            case self::NOIDANGKY_CS2:
                $label = '<span class="badge bg-info">'.$val.'</span> ';
                break;
            case self::NOIDANGKY_CS3:
                $label = '<span class="badge bg-warning">'.$val.'</span> ';
                break;
            case self::NOIDANGKY_CS4:
                $label = '<span class="badge bg-warning">'.$val.'</span> ';
                break;
            case self::NOIDANGKY_CS5:
                $label = '<span class="badge bg-warning">'.$val.'</span> ';
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
    /**
     * Danh muc ly do huy ho so
     * @return string[]
     */
    public static function getDmLyDoHuy()
    {
        return [
            self::HUY_BATKHAKHANG => 'Bất khả kháng',
            self::HUY_KHACHQUAN => 'Khách quan',
            self::HUY_CHUQUAN => 'Chủ quan',
        ];
    }
    /**
     * Danh muc ly do huy ho so label
     * @return string[]
     */
    public static function getDmLyDoHuyLablel($val=NULL)
    {
        switch ($val) {
            case self::HUY_BATKHAKHANG:
                $label = 'Bất khả kháng';
                break;
            case self::HUY_KHACHQUAN:
                $label = 'Khách quan';
                break;
            case self::HUY_CHUQUAN:
                $label = 'Chủ quan';
                break;
            default:
                $label = '';
        }
        return $label;
    }
    /**
     * Lấy lệ phí theo lý do
     * @return string[]
     */
    public static function getLePhiHuyHoSo($lydo)
    {
        switch ($lydo) {
            case self::HUY_BATKHAKHANG:
                $lePhi = 0;
                break;
            case self::HUY_KHACHQUAN:
                $lePhi = 1000000;
                break;
            case self::HUY_CHUQUAN:
                $lePhi = 2000000;
                break;
            default:
                $lePhi = 0;
        }
        return $lePhi;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /*[['id_hang', 'ho_ten', 'so_cccd','id_hang'], 'required'],*/
            [['id_hang', 'ho_ten', 'noi_dang_ky'], 'required'],
            [['id_khoa_hoc', 'id_hoc_phi', 'nguoi_tao','gioi_tinh','id_hang','id_nhom','nguoi_duyet','ma_so_phieu','so_lan_in_phieu','co_ho_so_thue', 'da_nhan_ao', 'id_giao_vien', 'huy_ho_so'], 'integer'],
            [['thoi_gian_tao', 'thoi_gian_hoan_thanh_ho_so', 'thoi_gian_huy_ho_so', 'ngay_sinh','ngay_het_han_cccd'], 'safe'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai','dia_chi','trang_thai_duyet'], 'string', 'max' => 255],
            [['check_hoc_phi'],'string','max'=>25],
            [['nguoi_lap_phieu'],'string','max'=>55],
            [['noi_dang_ky', 'size'],'string','max'=>50],
            [['loai_ly_do'], 'string', 'max' => 20],
            [['loai_dang_ky'],'string','max'=>15],
            [['tongtiennop', 'le_phi'], 'number'],//virtual attribute select when report
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => NhomHoc::class, 'targetAttribute' => ['id_nhom' => 'id']],
            [['ghi_chu', 'ngay_nhan_ao', 'ly_do_huy_ho_so', 'so_tien', 'thoi_gian_thay_doi'], 'safe'],
            //[['id_giao_vien'], 'required', 'on'=>'phan-cong-giao-vien'], //on phan cong giao vien phu trach cho hoc vien
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khoa_hoc' => 'Khóa học',
            'id_hang'=>'Hạng đào tạo ',
            'id_hoc_phi' => 'Học phí',
            'ho_ten' => 'Họ tên',
            'ngay_sinh'=>'Ngày sinh',
            'so_dien_thoai' => 'Số điện thoại',
            'so_cccd' => 'Số Căn cước công dân',
            'gioi_tinh'=>'Giới tính',
            'dia_chi'=>'Địa chỉ',
            'trang_thai' => 'Trạng thái',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_lap_phieu' => 'Người lặp phiếu',
            'check_hoc_phi' => 'Học phí',
            'id_nhom'=>'Nhóm',
            'loai_dang_ky'=>'Loại hình đăng ký',
            'nguoi_duyet'=>'Người duyệt',
            'trang_thai_duyet'=>'Trạng thái duyệt',
            'ngay_het_han_cccd'=>'Ngày hết hạn CCCD',
            'noi_dang_ky'=>'Nơi đăng ký',
            'ma_so_phieu'=>'Mã số phiếu',
            'so_lan_in_phieu'=>'Số lần in phiếu',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_hoan_thanh_ho_so' => 'Thời gian hoàn thành hồ sơ',
            'co_ho_so_thue' => 'Có hồ sơ thuế',
            'da_nhan_ao' => 'Đã nhận áo',
            'size'=>'Size',
            'ngay_nhan_ao' => 'Ngày nhận áo',
            'id_giao_vien' => 'Giáo viên phụ trách',
            'huy_ho_so' => 'Hủy hồ sơ',
            'thoi_gian_huy_ho_so' => 'Thời gian hủy hồ sơ',
            'ly_do_huy_ho_so' => 'Lý do hủy',
            'loai_ly_do' => 'Loại lý do',
            'le_phi' => 'Lệ phí',
        ];
    }

    /**
     * Gets query for [[HvHoSoHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
 

    /**
     * Gets query for [[HvNopHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvNopHocPhis()
    {
        return $this->hasMany(NopHocPhi::class, ['id_hoc_vien' => 'id']);
    }
    /**
     * query first nop hoc phi >=50%
     * @return \yii\db\ActiveQuery
     */
    /* public function getHvNopHocPhi50()
    {
        return $this->hasOne(NopHocPhi::class, ['id_hoc_vien' => 'id'])->alias('hvhp')
            ->onCondition(new \yii\db\Expression('
                EXISTS (
                    SELECT 1 FROM hv_hoc_phi, hv_hoc_vien 
                    WHERE hv_hoc_phi.id = hv_hoc_vien.id_hoc_phi
                      AND hvhp.so_tien_con_lai <= hv_hoc_phi.hoc_phi/2
                )
            '));
    } */

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }
    public function getHocPhi()
    {
        return $this->hasOne(HocPhi::class, ['id' => 'id_hoc_phi']);
    }
    public function getHangDaoTao()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
    public function getGiaoVien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'id_giao_vien']);
    }
    public function getGiaoVienDay()
    {
        return $this->hasMany(GvHv::class, ['id_hoc_vien' => 'id']);
    }
    public function getNhom()
    {
        return $this->hasOne(NhomHoc::class, ['id' => 'id_nhom']);
    }
    public function getNgaySinh(){
        return CustomFunc::convertYMDToDMY($this->ngay_sinh);
    }
    public function getNgayHetHanCccd(){
        return CustomFunc::convertYMDToDMY($this->ngay_het_han_cccd);
    } 
    public function getMaSoPhieu()
    {
        $hocVien = self::findOne($this->id);
        if ($hocVien && !empty($hocVien->ma_so_phieu) && $hocVien->ma_so_phieu != 0) {
            return $hocVien->ma_so_phieu;
        }
    
        $maxMaSoPhieu = self::find()->select('MAX(ma_so_phieu)')->scalar();
        $newMaSoPhieu = $maxMaSoPhieu ? $maxMaSoPhieu + 1 : 1;

        if ($hocVien) {
            $hocVien->ma_so_phieu = $newMaSoPhieu;
            $hocVien->save(false); 
        }
    
        return $newMaSoPhieu;
    }
    
    /**
     * phần chỉnh sửa học phí - hạng đào tạo
     */
    //get học phí thực tế theo bảng thay đổi học phí, học phí thực tế = học phí ban đầu + sum tất cả thay đổi học phí của học viên
    public function getTienHocPhi(){
        if($this->thayDoiHangs!=null){
            return $this->hocPhi->hoc_phi + $this->getThayDoiHangs()->sum('so_tien');
        } else {
            return $this->hocPhi->hoc_phi;
        }
        
    }
    //get học phí thực tế theo bảng thay đổi học phí tìm theo thời gian,
    //học phí thực tế = học phí ban đầu + sum tất cả thay đổi học phí trong khoảng thời gian của học viên (<= mốc thời gian)
    public function getTienHocPhiTheoThoiGian($endTime){
        $thayDoiHangs = $this->getThayDoiHangs()->andWhere("thoi_gian_thay_doi <= '".$endTime."' ");
       // $thayDoiHangs = ThayDoiHocPhi::find()->where(['id_hoc_vien'=>$this->id])->andWhere("thoi _gian_tao >= '".$endTime."' ");
        if($thayDoiHangs!=null){
            return $this->hocPhi->hoc_phi + $thayDoiHangs->sum('so_tien');
        } else {
            return $this->hocPhi->hoc_phi;
        }
    }
    //get list thay doi
    public function getThayDoiHangs()
    {
        return $this->hasMany(ThayDoiHocPhi::class, ['id_hoc_vien' => 'id']);
    }
    //get list bao luu
    public function getBaoLuus()
    {
        return $this->hasMany(BaoLuu::class, ['id_hoc_vien' => 'id']);
    }
    //get list bao luu
    public function getDoiNgaySatHachs()
    {
        return $this->hasMany(DoiSatHach::class, ['id_hoc_vien' => 'id']);
    }
    /**
     * kết thúc phần chỉnh sửa học phí - hạng đào tạo
     */
    
    //lấy ngày hoàn thành hồ sơ, query lấy ngày nộp tiền 50% hoặc 100% đầu tiên
    public function getNgayHoanThanhHoSo(){
        $nopTien = NopHocPhi::find()->alias('t2')
        ->joinWith(['hocVien as hv', 'hocVien.hocPhi as hp'])
        ->where(['id_hoc_vien'=>$this->id])
        ->andWhere('t2.so_tien_con_lai <= hp.hoc_phi/2')->one(); //còn lại <= 50% học phí là ok
        return $nopTien==null?'':CustomFunc::convertYMDHISToDMY($nopTien->thoi_gian_tao);
    }
    public function getNguoiTao(){
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
    public function getTienDaNop(){//bao gom tong so tien nop am + duong
        return NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->sum('so_tien_nop');
    }
    public function getTienDaNopDuong(){//bao gom tong so tien nop > 0
        return NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->andWhere('so_tien_nop > 0')->sum('so_tien_nop');
    }
    public function getTienDaNopDuongTM(){//bao gom tong so tien nop > 0
        return NopHocPhi::find()->where(['id_hoc_vien'=>$this->id, 'hinh_thuc_thanh_toan'=>'TM'])->andWhere('so_tien_nop > 0')->sum('so_tien_nop');
    }
    public function getTienDaNopDuongCK(){//bao gom tong so tien nop > 0
        return NopHocPhi::find()->where(['id_hoc_vien'=>$this->id, 'hinh_thuc_thanh_toan'=>'CK'])->andWhere('so_tien_nop > 0')->sum('so_tien_nop');
    }
    public function getTienDaNopAm(){//bao gom tong so tien nop > 0
        return NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->andWhere('so_tien_nop < 0')->sum('so_tien_nop');
    }
    public function getTienChietKhau(){//bao gom tong so tien da chiet khau
        return NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->sum('chiet_khau');
    }
    public function getTienDaThanhToan(){//bao gom so tien nop va chiet khau
       $tt = NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->sum('so_tien_nop');
       $ck = NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->sum('chiet_khau');
       return $tt + $ck;
    }
    /**
     * tính tiền chưa thanh toán toàn thời gian
     * @return number
     */
    public function getTienChuaThanhToan(){ //chua thanh toan hoc phi - so tien nop - chiet khau
        $tt = NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->sum('so_tien_nop');
        $ck = NopHocPhi::find()->where(['id_hoc_vien'=>$this->id])->sum('chiet_khau');
        //return $this->hocPhi->hoc_phi - $tt - $ck;
        return $this->tienHocPhi - $tt - $ck;
    }
    
    /**
     * Tính tiền học phí chưa thanh toán từ lúc đầu tới mốc thời gian
     * chua thanh toan hoc phi - so tien nop - chiet khau (tinh tu dau toi moc thoi gian)
     * datime: $endtime Y-m-d H:i:s
     * @return number
     */
    public function getTienChuaThanhToanByEndTime($endtime){
        $tt = NopHocPhi::find()
            /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
        
            ->where(['id_hoc_vien'=>$this->id]);
            
			//->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])
            if($endtime != NULL){
		      $tt = $tt->andWhere("thoi_gian_tao <= '".$endtime . "'");
            }
            $tt = $tt->sum('so_tien_nop');
        $ck = NopHocPhi::find()
            /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
      
            ->where(['id_hoc_vien'=>$this->id]);
			//  ->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])
            if($endtime != NULL){
                $ck = $ck->andWhere("thoi_gian_tao <= '".$endtime . "'");
            }
            $ck = $ck->sum('chiet_khau');
        //return $this->hocPhi->hoc_phi - $tt - $ck;
        
            $tienHocPhi = $this->tienHocPhi;
            if($endtime != NULL){
                $tienHocPhi = $this->getTienHocPhiTheoThoiGian($endtime);
            }
            return $tienHocPhi - $tt - $ck;
    }
    
}