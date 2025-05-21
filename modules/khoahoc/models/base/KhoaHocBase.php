<?php

namespace app\modules\khoahoc\models\base;
use app\custom\CustomFunc;
use Yii;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\HocPhi;
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
 * @property int|null $id_hoc_phi
 * @property int| $so_hoc_vien_khoa_hoc 
 * @property HangDaoTao $hang
 * @property HocVien[] $hvHocViens
 * @property TaiLieuKhoaHoc[] $hvTaiLieuKhoaHocs
 */
class KhoaHocBase extends \app\models\HvKhoaHoc
{
   CONST TRANGTHAI_CHUAHOANTHANH = 'CHUA_HOAN_THANH';//MỚI TẠO CHƯA ĐỦ HỌC VIÊN
   CONST TRANGTHAI_DAHOANTHANH = 'DA_HOAN_THANH';//ĐÃ KẾT THÚC KHÓA HỌC
   CONST TRANGTHAI_DANGHOC = 'DANG_HOC';//KHÓA HỌC ĐANG HỌC HOẶC ĐÃ ĐỦ HỌC VIÊN
   //show list trang thai
   public function getListTrangThai(){
       return [
           self::TRANGTHAI_CHUAHOANTHANH => $this->getLabelTrangThai(self::TRANGTHAI_CHUAHOANTHANH),
           self::TRANGTHAI_DANGHOC => $this->getLabelTrangThai(self::TRANGTHAI_DANGHOC),
           self::TRANGTHAI_DAHOANTHANH => $this->getLabelTrangThai(self::TRANGTHAI_DAHOANTHANH),
       ];
   }
   //get label trang thai by value
   public function getLabelTrangThai($trangThai){
       $label = '';
       switch ($trangThai){
           case self::TRANGTHAI_CHUAHOANTHANH:
               $label = 'Chưa hoàn thành';
               break;
           case self::TRANGTHAI_DAHOANTHANH:
               $label = 'Hoàn thành';
               break;
           case self::TRANGTHAI_DANGHOC:
               $label = 'Đào tạo/Đủ học viên';
               break;
       }
       return $label;
   }
   //get label trang thai cua model
   public function getTenTrangThai(){
       return $this->getLabelTrangThai($this->trang_thai);
   }
    /**
     * {@inheritdoc}
     */
    public function getNgayBatDau(){
        return CustomFunc::convertYMDToDMY($this->ngay_bat_dau);
    }
    public function getNgayKetThuc(){
        return CustomFunc::convertYMDToDMY($this->ngay_ket_thuc);
    }
    /* public static function tableName()
    {
        return 'hv_khoa_hoc';
    } */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id_hang', 'ten_khoa_hoc','so_hoc_vien_khoa_hoc'], 'required'],
            [['ten_khoa_hoc','so_hoc_vien_khoa_hoc'], 'required'],
            [['id_hang', 'nguoi_tao','id_hoc_phi','so_hoc_vien_khoa_hoc'], 'integer'],
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
            'id_hoc_phi'=>'Id học phí',
            'so_hoc_vien_khoa_hoc'=>'Số học viên khóa học',
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
    public function getHocPhi()
    {
        return $this->hasOne(HocPhi::class,['id'=>'id_hoc_phi']);
    }

    /**
     * Gets query for [[HvHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocViens()
    {
        return $this->hasMany(HocVien::class, ['id_khoa_hoc' => 'id'])->where(['huy_ho_so'=>0]);
    }

    public function beforeSave($insert)
    {
        $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
        $this->ngay_ket_thuc = CustomFunc::convertDMYToYMD($this->ngay_ket_thuc);
        if (strtotime($this->ngay_ket_thuc) < strtotime($this->ngay_bat_dau)) {
            $this->addError('ngay_ket_thuc', 'Ngày kết thúc không được nhỏ hơn ngày bắt đầu.');
            return false; 
        }
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->trang_thai = 'CHUA_HOAN_THANH';
            /* $hocPhiMax = HocPhi::find()
                ->where(['id_hang' => $this->id_hang])
                ->orderBy(['id' => SORT_DESC])
                ->one();   
            $this->id_hoc_phi = $hocPhiMax ? $hocPhiMax->id : null; */
        }
        return parent::beforeSave($insert);
    }
}