<?php

namespace app\modules\giaovien\models\base;

use Yii;
use app\modules\nhanvien\models\To;
use app\modules\nhanvien\models\PhongBan;
use app\modules\user\models\User;
use app\modules\giaovien\models\Day;
use app\custom\CustomFunc;
/**
 * This is the model class for table "nv_nhan_vien".
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
 * @property int|null $id_to
 * @property int|null $gioi_tinh
* @property string|null $ngay_sinh
 * @property Day[] $nvDays
 * @property PhongBan $phongBan
 * @property User $taiKhoan
 * @property To $to
 * @property VanBan[] $vbVanBans
 */
class GiaoVienBase extends \app\models\NvNhanVien
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
            [['id_phong_ban', 'tai_khoan', 'nguoi_tao', 'id_to', 'gioi_tinh'], 'integer'],
            [['ho_ten'], 'required'],
            [['kinh_nghiem_lam_viec','doi_tuong'], 'string'],
            [['thoi_gian_tao','ngay_sinh'], 'safe'],
            [['ho_ten', 'chuc_vu', 'so_cccd', 'dia_chi', 'dien_thoai', 'email', 'trinh_do', 'chuyen_nganh', 'vi_tri_cong_viec', 'ma_so_thue', 'trang_thai'], 'string', 'max' => 255],
            [['id_phong_ban'], 'exist', 'skipOnError' => true, 'targetClass' => PhongBan::class, 'targetAttribute' => ['id_phong_ban' => 'id']],
            [['id_to'], 'exist', 'skipOnError' => true, 'targetClass' => To::class, 'targetAttribute' => ['id_to' => 'id']],
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
            'so_cccd' => 'Số CCCD',
            'dia_chi' => 'Địa chỉ',
            'dien_thoai' => 'Điện thoại',
            'tai_khoan' => 'Tài khoản',
            'email' => 'Email',
            'trinh_do' => 'Trình độ',
            'chuyen_nganh' => 'Chuyên ngành',
            'vi_tri_cong_viec' => 'Vị trí công việc',
            'kinh_nghiem_lam_viec' => 'Kinh Nghiệm Làm Việc',
            'ma_so_thue' => 'Mã Số Thuế',
            'trang_thai' => 'Trạng Thái',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'id_to' => 'Tổ',
            'gioi_tinh' => 'Giới tính',
            'doi_tuong'=>'Đối tượng' ,// Dùng để phân biệt Nhân viên và Giáo viên
            'ngay_sinh'=>'Ngày sinh'
        ];
    }

    /**
     * Gets query for [[NvDays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvDays()
    {
        return $this->hasMany(Day::class, ['id_nhan_vien' => 'id']);
    }

    /**
     * Gets query for [[PhongBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongBan()
    {
        return $this->hasOne(PhongBan::class, ['id' => 'id_phong_ban']);
    }

    /**
     * Gets query for [[TaiKhoan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiKhoan()
    {
        return $this->hasOne(User::class, ['id' => 'tai_khoan']);
    }

    /**
     * Gets query for [[To]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(To::class, ['id' => 'id_to']);
    }
    public function getNgaySinh(){
        return CustomFunc::convertYMDToDMY($this->ngay_sinh);
    }
    /**
     * Gets query for [[VbVanBans]].
     *
     * @return \yii\db\ActiveQuery
     */
   
}
