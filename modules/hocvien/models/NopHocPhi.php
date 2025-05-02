<?php

namespace app\modules\hocvien\models;

use Yii;
use app\modules\hocvien\models\HocVien;
use app\custom\CustomFunc;
use app\modules\user\models\User;
/**
 * This is the model class for table "hv_nop_hoc_phi".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int $id_hoc_phi
 * @property string $loai_phieu
 * @property string $loai_nop
 * @property float $so_tien_nop
 * @property float $chiet_khau
 * @property float $so_tien_con_lai
 * @property string $ngay_nop
 * @property int $ma_so_phieu
 * @property int $so_lan_in_phieu
 * @property string $hinh_thuc_thanh_toan
 * @property int $nguoi_thu
 * @property string $bien_lai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int $da_kiem_tra
 * @property string $ghi_chu
 *
 * @property HocVien $hocVien
 */
class NopHocPhi extends \app\models\HvNopHocPhi
{
    const PHIEUTHULABEL = 'PHIEUTHU';
    const PHIEUCHILABEL = 'PHIEUCHI';
    /**
     * {@inheritdoc}
     */
    /* public static function tableName()
    {
        return 'hv_nop_hoc_phi';
    } */
    public $file;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /* [[ 'so_tien_nop', 'ngay_nop', 'nguoi_thu'], 'required'], */
            [[ 'so_tien_nop', 'ngay_nop', 'hinh_thuc_thanh_toan', 'loai_nop'], 'required'],
            [['id_hoc_vien', 'id_hoc_phi', 'ma_so_phieu', 'so_lan_in_phieu', 'nguoi_thu', 'nguoi_tao', 'da_kiem_tra'], 'integer'],
            [['so_tien_nop', 'chiet_khau', 'so_tien_con_lai'], 'number'],
            [['ngay_nop', 'thoi_gian_tao', 'ghi_chu'], 'safe'],
            [['loai_phieu', 'loai_nop', 'hinh_thuc_thanh_toan'],'string','max'=>20],
            [['bien_lai'], 'string'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
            [['file'], 'file','extensions' => 'png, jpg, jfif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Học viên',
            'id_hoc_phi' => 'Học phí',
            'loai_phieu' => 'Loại phiếu',
            'loai_nop' => 'Loại nộp tiền',
            'ma_so_phieu' => 'Mã số phiếu',
            'so_lan_in_phieu' => 'Số lần in phiếu',
            'hinh_thuc_thanh_toan' => 'Hình thức thanh toán',
            'so_tien_nop' => 'Số tiền nộp',
            'chiet_khau' => 'Chiết khấu',
            'so_tien_con_lai' => 'Số tiền còn lại',
            'ngay_nop' => 'Ngày nộp',
            'nguoi_thu' => 'Người thu',
            'bien_lai' => 'Biên lai',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'da_kiem_tra' => 'Đã kiểm tra',
            'ghi_chu' => 'Ghi chú',
            'file'=>'Chọn Biên lai'
        ];
    }
 
    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
    }
   
    public function getNgayNop(){
        return CustomFunc::convertYMDToDMY($this->ngay_nop);
    }
    
    public function getNguoiTao(){
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
    
    public function getMaSoPhieu($loaiPhieu)
    {
        if($loaiPhieu==null){
            $loaiPhieu = self::PHIEUTHULABEL;
        }
        $maxMaSoPhieu = self::find()->select('MAX(ma_so_phieu)')->where(['loai_phieu'=>$loaiPhieu])->scalar();
        $newMaSoPhieu = $maxMaSoPhieu ? $maxMaSoPhieu + 1 : 1;
        return $newMaSoPhieu;
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->ngay_nop = CustomFunc::convertDMYToYMD($this->ngay_nop);             
            $this->so_lan_in_phieu = 0;
            $this->da_kiem_tra = 0;
            if($this->chiet_khau==null){
                $this->chiet_khau = 0;
            }
            if($this->so_tien_nop < 0){
                $this->loai_phieu = self::PHIEUCHILABEL;
            } else{
                $this->loai_phieu = self::PHIEUTHULABEL;
            }
            $this->ma_so_phieu = $this->getMaSoPhieu($this->loai_phieu);
        }
        // Xử lý trường 'bien_lai'  khi giá trị là Base64 (webcam)
        if (!empty($this->bien_lai)) {
            // Kiểm tra nếu 'bien_lai' chứa dữ liệu Base64
            if (strpos($this->bien_lai, 'data:image') === 0) {
                // Loại bỏ tiền tố Base64
                $data = preg_replace('#^data:image/\w+;base64,#i', '', $this->bien_lai);
                $data = base64_decode($data);
    
                // Kiểm tra xem việc giải mã có thành công không
                if ($data === false) {
                    $this->addError('bien_lai', 'Dữ liệu hình ảnh không hợp lệ.');
                    return false;
                }
    
                // Tạo tên file ngẫu nhiên và đường dẫn lưu file
                $filename = uniqid('bien_lai_') . '.jpg';
                $path = Yii::getAlias('@webroot/uploads/bien_lai/') . $filename;
    
                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }
    
                // Lưu file vào thư mục
                if (file_put_contents($path, $data) === false) {
                    $this->addError('bien_lai', 'Không thể lưu hình ảnh.');
                    return false;
                }
    
                // Gán lại giá trị 'bien_lai' là đường dẫn của file đã lưu
                $this->bien_lai = 'uploads/bien_lai/' . $filename;
              
            } else {
                // Nếu không phải Base64 (ví dụ chọn file bằng cách tải lên), giữ nguyên giá trị
                $this->bien_lai = $this->bien_lai;
            }
        }
        return parent::beforeSave($insert);
    }
    
    
    public function afterSave($insert, $changedAttributes)
     {
         parent::afterSave($insert, $changedAttributes);
         //if($this->so_tien_nop){
            // $this->id_hoc_phi = 25;
            // $this->updateAttributes(['id_hoc_phi']);
         if($this->so_tien_con_lai == null){
             $tongDaDong = NopHocPhi::find()->where(['id_hoc_vien'=>$this->id_hoc_vien])->sum('so_tien_nop');
             $tongChietKhau = NopHocPhi::find()->where(['id_hoc_vien'=>$this->id_hoc_vien])->sum('chiet_khau');
             $this->so_tien_con_lai = $this->hocVien->hocPhi->hoc_phi - $tongChietKhau - $tongDaDong;
             $this->updateAttributes(['so_tien_con_lai']);
             
             if($this->hocVien->thoi_gian_hoan_thanh_ho_so == null){
                 if($this->so_tien_con_lai <= $this->hocVien->hocPhi->hoc_phi/2){
                     ///////////
                     $this->hocVien->thoi_gian_hoan_thanh_ho_so = $this->thoi_gian_tao;
                     $this->hocVien->updateAttributes(['thoi_gian_hoan_thanh_ho_so']);
                 }
             }
         }
        // }
     }
    
    public function getHangXe()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    } 
    
    
    /**
     * Danh muc loai nop
     * @return string[]
     */
    public static function getDmLoaiNop()
    {
        return [
            'NOP100' => 'Nộp 100%',
            'NOP50' => 'Nộp 50%',
            'COC1TR' => 'Cọc 1 triệu',
            'KHAC'=>'Số tiền tùy chọn'            
        ];
    }
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public function getLoaiNop($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->loai_nop;
        }
        switch ($val) {
            case 'NOP100':
                $label = "Nộp 100%";
                break;
            case 'NOP50':
                $label = "Nộp 50%";
                break;
            case 'COC1TR':
                $label = "Cọc 1 triệu";
                break;
            case 'KHAC':
                $label = 'Số tiền tùy chọn';
                break;                
            default:
                $label = '';
        }
        return $label;
    }
    /**
     * Danh muc hinh thuc chuyen khoan
     * @return string[]
     */
    public static function getDmHinhThucThanhToan()
    {
        return [
            'CK' => 'Chuyển khoản',
            'TM' => 'Tiền mặt',
        ];
    }
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public function getHinhThucThanhToan($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->hinh_thuc_thanh_toan;
        }
        switch ($val) {
            case 'CK':
                $label = "Chuyển khoản";
                break;
            case 'TM':
                $label = "Tiền mặt";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    /**
     * Danh muc loai phieu label
     * @param int $val
     * @return string
     */
    public function getTenLoaiPhieu($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->loai_phieu;
        }
        switch ($val) {
            case self::PHIEUTHULABEL:
                $label = "Phiếu thu";
                break;
            case self::PHIEUCHILABEL:
                $label = "Phiếu chi";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
}
