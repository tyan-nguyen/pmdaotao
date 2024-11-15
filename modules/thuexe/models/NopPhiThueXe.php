<?php

namespace app\modules\thuexe\models;

use Yii;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HocVien;
use app\modules\nhanvien\models\NhanVien;

/**
 * This is the model class for table "ptx_nop_phi_thue_xe".
 *
 * @property int $id
 * @property int|null $id_phieu_thue_xe
 * @property int|null $id_hoc_vien
 * @property string|null $ho_ten_nguoi_thue
 * @property string|null $so_cccd_nguoi_thue
 * @property string|null $dia_chi_nguoi_thue
 * @property string|null $so_dien_thoai_nguoi_thue
 * @property float|null $so_tien_nop
 * @property int|null $nguoi_thu
 * @property string|null $bien_lai
 * @property string|null $ngay_nop
 * @property string |null $trang_thai
 * @property int|null $nguoi_tao
 * @property int|null $thoi_gian_tao
 */
class NopPhiThueXe extends \app\models\PtxNopPhiThueXe
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_nop_phi_thue_xe';
    }
    public $file;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_phieu_thue_xe', 'id_hoc_vien', 'nguoi_thu', 'nguoi_tao', 'thoi_gian_tao'], 'integer'],
            [['so_tien_nop'], 'number'],
            [['ngay_nop'], 'safe'],
            [['ho_ten_nguoi_thue'], 'string', 'max' => 50],
            [['so_cccd_nguoi_thue'], 'string', 'max' => 15],
            [['trang_thai'],'string','max'=>25],
            [['dia_chi_nguoi_thue'], 'string', 'max' => 255],
            [['bien_lai'], 'string'],
            [['so_dien_thoai_nguoi_thue'], 'string', 'max' => 12],
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
            'id_phieu_thue_xe' => 'Id Phieu Thue Xe',
            'id_hoc_vien' => 'Học viên',
            'ho_ten_nguoi_thue' => 'Họ tên người thuê',
            'so_cccd_nguoi_thue' => 'Số CCCD người thuê',
            'dia_chi_nguoi_thue' => 'Địa chỉ người thuê',
            'so_dien_thoai_nguoi_thue' => 'Số điện thoại người thuê',
            'so_tien_nop' => 'Số tiền thu',
            'nguoi_thu' => 'Người thu',
            'bien_lai' => 'Biên lai',
            'ngay_nop' => 'Ngày thu',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'file' => 'Chọn biên lai',
            'trang_thai'=>'Trạng thái',
        ];
    }
    public function beforeSave($insert)
    {     
        $this->ngay_nop = CustomFunc::convertDMYToYMD($this->ngay_nop);   
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
            if (!empty($this->id_phieu_thue_xe)) {
                $phieuThueXe = PhieuThueXe::findOne($this->id_phieu_thue_xe);
                if ($phieuThueXe && $phieuThueXe->chi_phi_thue_phat_sinh === null) {
                    $this->trang_thai = 'Phí thuê xe'; 
                }
                if ($phieuThueXe && $phieuThueXe ->chi_phi_thue_phat_sinh > 0)
                {
                    $this->trang_thai = 'Phí phát sinh';
                }
                if ($phieuThueXe && $phieuThueXe ->chi_phi_thue_phat_sinh == 0)
                {
                    $this->trang_thai = 'Phí thuê xe';
                }
                
            }
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

    public function getHocVien()
     {
         return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
     }
     public function getNguoiThu()
     {
        return $this->hasOne(NhanVien:: class, ['id'=>'nguoi_thu']);
     }
    

    
}
