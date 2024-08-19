<?php

namespace app\modules\giaovien\models\base;
use yii;
use app\modules\user\models\User;
use app\modules\nhanvien\models\PhongBan;
use app\modules\nhanvien\models\base\NhanVienBase;
/**
 * This is the model class for table "nhan_vien".
 *
 * @property int $id
 * @property int|null $id_phong_ban
 * @property string $ho_ten
 * @property string|null $chuc_vu
 * @property string|null $so_cccd
 * @property string|null $dia_chi
 * @property string|null $dien_thoai
 * @property int|null $tai_khoan
 * @property string|null $email
 * @property string|null $trinh_do
 * @property string|null $chuyen_nganh
 * @property string|null $vi_tri_cong_viec
 * @property string|null $kinh_nghiem_lam_viec
 * @property string|null $ma_so_thue
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property Day[] $days
 * @property HoSoNhanVien[] $hoSoNhanViens
 * @property User $taiKhoan
 * @property VanBan[] $vanBans
 */
class GiaoVienBase extends NhanVienBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_nhan_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_phong_ban', 'tai_khoan', 'nguoi_tao','check_giao_vien'], 'integer'],
            [['ho_ten'], 'required'],
            [['kinh_nghiem_lam_viec'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ho_ten', 'chuc_vu', 'so_cccd', 'dia_chi', 'dien_thoai', 'email', 'trinh_do', 'chuyen_nganh', 'vi_tri_cong_viec', 'ma_so_thue', 'trang_thai'], 'string', 'max' => 255],
            [['tai_khoan'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tai_khoan' => 'id']],
         
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_phong_ban' => 'Phòng ban',
            'ho_ten' => 'Họ tên',
            'chuc_vu' => 'Chức vụ',
            'so_cccd' => 'Số cccd',
            'dia_chi' => 'Địa chỉ',
            'dien_thoai' => 'Điện thoại',
            'tai_khoan' => 'Tài khoản',
            'email' => 'Email',
            'trinh_do' => 'Trình độ',
            'chuyen_nganh' => 'Chuyên ngành',
            'vi_tri_cong_viec' => 'Vị trí công việc',
            'kinh_nghiem_lam_viec' => 'Kinh nghiệm làm việc',
            'ma_so_thue' => 'Mã số thuế',
            'trang_thai' => 'Trạng thái',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'check_giao_vien'=>'Là giáo viên ?',
        ];
    }

    public function getPhongBan()
    {
        return $this->hasOne(PhongBan::class, ['id' => 'id_phong_ban']);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
              
                $this->check_giao_vien=1;
                $this->nguoi_tao = Yii::$app->user->identity->id; 
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

}