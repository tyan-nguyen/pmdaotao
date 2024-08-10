<?php

namespace app\modules\nhanvien\models\base;

use app\modules\user\models\User;

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
class NhanVienBase extends \yii\db\ActiveRecord
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
            [['id_phong_ban', 'tai_khoan', 'nguoi_tao'], 'integer'],
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
            'id_phong_ban' => 'Id Phong Ban',
            'ho_ten' => 'Ho Ten',
            'chuc_vu' => 'Chuc Vu',
            'so_cccd' => 'So Cccd',
            'dia_chi' => 'Dia Chi',
            'dien_thoai' => 'Dien Thoai',
            'tai_khoan' => 'Tai Khoan',
            'email' => 'Email',
            'trinh_do' => 'Trinh Do',
            'chuyen_nganh' => 'Chuyen Nganh',
            'vi_tri_cong_viec' => 'Vi Tri Cong Viec',
            'kinh_nghiem_lam_viec' => 'Kinh Nghiem Lam Viec',
            'ma_so_thue' => 'Ma So Thue',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }


  
}