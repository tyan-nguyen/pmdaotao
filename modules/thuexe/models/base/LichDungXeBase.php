<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXeLichDungXe;
use app\modules\user\models\User;
use app\modules\thuexe\models\Xe;
use app\custom\CustomFunc;
use app\modules\nhanvien\models\NhanVien;

/**
 * This is the model class for table "ptx_xe_lich_dung_xe".
 *
 * @property int $id
 * @property int $id_xe
 * @property int $id_nguoi_phu_trach
 * @property int|null $id_tai_xe
 * @property string $noi_dung
 * @property string $thoi_gian_bat_dau
 * @property string $thoi_gian_ket_thuc
 * @property string|null $trang_thai
 * @property string $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property float|null $so_gio
 *
 * @property User $nguoiPhuTrach
 * @property User $taiXe
 * @property PtxXe $xe
 */
class LichDungXeBase extends PtxXeLichDungXe
{
    public $ngay_bat_dau;
    public $gio_bat_dau;
    public $phut_bat_dau;
    public $ngay_ket_thuc;
    public $gio_ket_thuc;
    public $phut_ket_thuc;
    
    //trạng thái của Lịch thuê LENLICH, XUATHOADON
    CONST TT_DRAFT = 'DRAFT';
    CONST TT_ACTIVE = 'ACTIVE';
    
    
    /**
     * Danh muc trang thai
     * @return string[]
     */
    public static function getDmTrangThai(){
        return [
            self::TT_DRAFT => 'Nháp',
            self::TT_ACTIVE => 'Thực hiện',
        ];
    }
    /**
     * danh muc trang thai color
     */
    public static function getTrangThaiColor(){
        return [
            //self::TT_LENLICH => '#ffc107',
            self::TT_DRAFT => '#45aaf2',
            self::TT_ACTIVE => '#02587b',
        ];
    }
    
    /**
     * Danh muc trang thai label
     * @return string[]
     */
    public static function getDmTrangThaiLabel($val){
        $label = '';
        if($val == self::TT_DRAFT){
            $label = 'Nháp';
        }else if($val == self::TT_ACTIVE){
            $label = 'Thực hiện';
        }
        return $label;
    }
    
    /**
     * Danh muc trang thai label with badge
     * @return string[]
     */
    public static function getDmTrangThaiLabelWithBadge($val){
        $label = '';
        if($val == self::TT_DRAFT){
            $label = '<span class="badge bg-warning"><i class="fa fa-calendar-check-o"></i>&nbsp; Nháp</span>';
        }else if($val == self::TT_ACTIVE){
            $label = '<span class="badge bg-success"><i class="fa fa-check"></i> &nbsp;Thực hiện</span>';
        }
        return $label;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tai_xe', 'trang_thai', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_xe', 'id_nguoi_phu_trach', 'noi_dung'], 'required'],
            [['id_xe', 'id_nguoi_phu_trach', 'id_tai_xe', 'nguoi_tao'], 'integer'],
            [['noi_dung', 'ghi_chu'], 'string'],
            [['thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'thoi_gian_tao', 
                'ngay_bat_dau', 'gio_bat_dau', 'phut_bat_dau', 
                'ngay_ket_thuc', 'gio_ket_thuc', 'phut_ket_thuc'], 'safe'],
            [['trang_thai'], 'string', 'max' => 20],
            [['id_nguoi_phu_trach'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['id_nguoi_phu_trach' => 'id']],
            [['id_tai_xe'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['id_tai_xe' => 'id']],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => Xe::class, 'targetAttribute' => ['id_xe' => 'id']],
            [['so_gio'], 'number'],
            ['ngay_ket_thuc', 'validateThoiGianKetThuc', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['ngay_bat_dau', 'validateTimeConflict', 'skipOnEmpty' => false, 'skipOnError' => false],
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
            'id_xe' => 'Xe',
            'id_nguoi_phu_trach' => 'Người phụ trách',
            'id_tai_xe' => 'Tài xế',
            'noi_dung' => 'Nội dung',
            'thoi_gian_bat_dau' => 'Thời gian bắt đầu',
            'thoi_gian_ket_thuc' => 'Thời gian kết thúc',
            'so_gio' => 'Số giờ',
            'trang_thai' => 'Trạng thái',
            'ghi_chu' => 'Ghi chú',
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
                $this->trang_thai = self::TT_DRAFT;
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
    
    /**
     * Gets query for [[NguoiPhuTrach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiPhuTrach()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'id_nguoi_phu_trach']);
    }
    
    /**
     * Gets query for [[TaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiXe()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'id_tai_xe']);
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
    
    public function getNguoiTao(){
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
    
}
