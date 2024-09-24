<?php

namespace app\modules\khoahoc\models\base;
use app\custom\CustomFunc;
use Yii;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HangDaoTao;
/**
 * This is the model class for table "hv_khoa_hoc".
 *
 * @property int $id
 * @property int $id_hang
 * @property string $ten_khoa_hoc
 * @property string $ngay_bat_dau
 * @property string $ngay_ket_thuc
 * @property string|null $ghi_chu
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HangDaoTao $hang
 * @property HocVien[] $hvHocViens
 * @property TaiLieuKhoaHoc[] $hvTaiLieuKhoaHocs
 */
class KhoaHocBase extends \app\models\HvKhoaHoc
{
    /**
     * {@inheritdoc}
     */
    public function getNgayBatDau(){
        return CustomFunc::convertYMDToDMY($this->ngay_bat_dau);
    }
    public function getNgayKetThuc(){
        return CustomFunc::convertYMDToDMY($this->ngay_ket_thuc);
    }
    public static function tableName()
    {
        return 'hv_khoa_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'ten_khoa_hoc'], 'required'],
            [['id_hang', 'nguoi_tao'], 'integer'],
            [['ngay_bat_dau', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ten_khoa_hoc', 'trang_thai'], 'string', 'max' => 255],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hang' => 'Hạng khóa học',
            'ten_khoa_hoc' => 'Tên khóa học',
            'ngay_bat_dau' => 'Ngày bắt đầu',
            'ngay_ket_thuc' => 'Ngày kết thúc',
            'ghi_chu' => 'Ghi chú',
            'trang_thai' => 'Trạng thái',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }

    /**
     * Gets query for [[HvHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocViens()
    {
        return $this->hasMany(HocVien::class, ['id_khoa_hoc' => 'id']);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai='CHUA_HOAN_THANH';
            $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
            $this->ngay_ket_thuc = CustomFunc::convertDMYToYMD($this->ngay_ket_thuc);
        }
  
        return parent::beforeSave($insert);
    }
   
}