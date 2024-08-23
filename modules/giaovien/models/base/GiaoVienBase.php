<?php

namespace app\modules\giaovien\models\base;

use Yii;
use app\modules\nhanvien\models\To;
use app\modules\nhanvien\models\PhongBan;
use app\modules\user\models\User;
use app\modules\giaovien\models\Day;
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
 *
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
    CONST GV_VALUE = 'GIAO_VIEN';
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
            [['thoi_gian_tao'], 'safe'],
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
            'id_to' => 'Id To',
            'gioi_tinh' => 'Gioi Tinh',
            'doi_tuong'=>'Đối tượng' // Dùng để phân biệt Nhân viên và Giáo viên
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

    /**
     * Gets query for [[VbVanBans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
          
        }
        return parent::beforeSave($insert);
    }
}
