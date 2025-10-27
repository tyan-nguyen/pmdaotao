<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\LoaiXe;
use yii\helpers\ArrayHelper;
use app\modules\giaovien\models\GiaoVien;
use app\modules\daotao\models\GvXe;
use app\custom\CustomFunc;
use app\modules\banhang\models\HangHoa;
/**
 * This is the model class for table "ptx_xe".
 *
 * @property int $id
 * @property string|null $ma_so
 * @property int $id_loai_xe
 * @property string|null $phan_loai
 * @property string|null $hieu_xe
 * @property string|null $bien_so_xe
 * @property string|null $tinh_trang_xe
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property string|null $so_khung
 * @property string|null $so_may
 * @property string|null $ngay_dang_kiem
 * @property string|null $mau_sac
 * @property string|null $dac_diem
 * @property int|null $la_xe_cu
 * @property float|null $so_tien
 * @property string|null $nha_cung_cap
 * @property string|null $so_hoa_don
 * @property string|null $so_hop_dong
 * @property int|null $id_giao_vien
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $stt
 *
 * @property PtxLoaiXe $loaiXe
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class Xe extends \app\models\PtxXe
{
    const XE_BINHTHUONG = 'BINHTHUONG';
    const XE_HUHONG = 'HUHONG';
    const XE_SUACHUA = 'SUACHUA';
    const XE_BAOTRI = 'BAOTRI';
    
    const PHANLOAI_SATHACH = 'SATHACH';
    const PHANLOAI_TAPLAI = 'DAOTAO';
    const PHANLOAI_CHUAPHANLOAI = 'CHUAPHANLOAI';
    
    /**
     * Danh muc hinh thuc chuyen khoan
     * @return string[]
     */
    public static function getDmTinhTrangXe()
    {
        return [
            self::XE_BINHTHUONG => 'Bình thường',
            self::XE_HUHONG => 'Hư hỏng',
            self::XE_SUACHUA => 'Sửa chữa',
            self::XE_BAOTRI => 'Bảo trì',
        ];
    }
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public function getLabelTinhTrangXe($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->noi_dang_ky;
        }
        switch ($val) {
            case self::XE_BINHTHUONG:
                $label = "Bình thường";
                break;
            case self::XE_HUHONG:
                $label = "Hư hỏng";
                break;
            case self::XE_SUACHUA:
                $label = "Sửa chữa";
                break;
            case self::XE_BAOTRI:
                $label = "Bảo trì";
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
    public static function getLabelTinhTrangXeOther($val=NULL)
    {
        switch ($val) {
            case self::XE_BINHTHUONG:
                $label = "Bình thường";
                break;
            case self::XE_HUHONG:
                $label = "Hư hỏng";
                break;
            case self::XE_SUACHUA:
                $label = "Sửa chữa";
                break;
            case self::XE_BAOTRI:
                $label = "Bảo trì";
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
    public static function getLabelTinhTrangXeBadge($val=NULL)
    {
        switch ($val) {
            case self::XE_BINHTHUONG:
                $label = '<span class="badge bg-primary">Bình thường</span> ';
                break;
            case self::XE_HUHONG:
                $label = '<span class="badge bg-danger">Hư hỏng</span> ';
                break;
            case self::XE_SUACHUA:
                $label = '<span class="badge bg-warning">Sửa chữa</span> ';
                break;
            case self::XE_BAOTRI:
                $label = '<span class="badge bg-info">Bảo trì</span> ';
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
    /**
     * Danh muc phan loai xe
     * @return string[]
     */
    public static function getDmPhanLoaiXe()
    {
        return [
            self::PHANLOAI_TAPLAI => 'Xe đào tạo',
            self::PHANLOAI_SATHACH => 'Xe sát hạch',
            self::PHANLOAI_CHUAPHANLOAI => 'Chưa phân loại',
        ];
    }
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public function getLabelPhanLoaiXe($val = NULL)
    {
        if ($val == NULL) {
            $val = $this->phan_loai;
        }
        switch ($val) {
            case self::PHANLOAI_TAPLAI:
                $label = "Xe đào tạo";
                break;
            case self::PHANLOAI_SATHACH:
                $label = "Xe sát hạch";
                break;
            case self::PHANLOAI_CHUAPHANLOAI:
                $label = "Chưa phân loại";
                break;
            default:
                $label = '';
        }
        return $label;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_xe', 'bien_so_xe'], 'required'],
            [['id_loai_xe', 'la_xe_cu', 'nguoi_tao', 'id_giao_vien', 'stt'], 'integer'],
            [['ghi_chu', 'dac_diem'], 'string'],
            [['phan_loai', 'ma_so'], 'string', 'max' => 20],
            [['tinh_trang_xe'], 'string', 'max' => 20],
            [['thoi_gian_tao', 'ngay_dang_kiem'], 'safe'],
            [['bien_so_xe'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
            [['bien_so_xe'], 'unique'],
            [['hieu_xe', 'so_khung', 'so_may', 'mau_sac', 'nha_cung_cap', 'so_hoa_don', 'so_hop_dong'], 'string', 'max' => 250],
            [['id_loai_xe'], 'exist', 'skipOnError' => true, 'targetClass' =>LoaiXe::class, 'targetAttribute' => ['id_loai_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_so' => 'Mã số',
            'id_loai_xe' => 'Tên loại xe',
            'phan_loai' => 'Phân loại xe',
            'hieu_xe' => 'Hiệu Xe',
            'bien_so_xe' => 'Biển Số Xe',
            'tinh_trang_xe' => 'Tình Trạng Xe',
            'ghi_chu' => 'Ghi chú',
            'so_khung' => 'Số khung',
            'so_may' => 'Số máy/Số động cơ',
            'ngay_dang_kiem' => 'Ngày đăng kiểm',
            'mau_sac' => 'Màu sắc',
            'dac_diem' => 'Đặc điểm',
            'la_xe_cu' => 'Xe đã qua sử dụng',
            'so_tien' => 'Giá trị(VND)',
            'nha_cung_cap' => 'Nhà cung cấp',
            'so_hoa_don' => 'Số hóa đơn',
            'so_hop_dong' => 'Số hợp đồng',
            'trang_thai' => 'Trạng Thái',
            'id_giao_vien' => 'Giáo viên phụ trách',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'stt' => 'STT'
        ];
    }
    /**
     * Gets query for [[GdGvXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGvs()
    {
        return $this->hasMany(GvXe::class, ['id_xe' => 'id']);
    }

    /**
     * Gets query for [[LoaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiXe()
    {
        return $this->hasOne(LoaiXe::class, ['id' => 'id_loai_xe']);
    }
    /**
     * relation for giao vien (người quản lý)
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'id_giao_vien']);
    }

    /**
     * Gets query for [[PtxPhieuThueXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxPhieuThueXes()
    {
        return $this->hasMany(PhieuThueXe::class, ['id_xe' => 'id']);
    }
    public static function getList()
    {
        $dsXe = Xe::find()
            ->where(['trang_thai' => 'Khả dụng']) 
            ->orderBy(['hieu_xe' => SORT_ASC])
            ->all();
    
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return '+ ' . $model->hieu_xe; 
        });
    }

    public static function getList2()
    {
        $dsXe = Xe::find()
            ->orderBy(['hieu_xe' => SORT_ASC])
            ->all();
    
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return '+ ' . $model->hieu_xe; 
        });
    }
    
    public static function getListByGiaoVien($idgv)
    {
        $dsXe = Xe::find()->where(['id_giao_vien'=>$idgv])
        ->orderBy(['hieu_xe' => SORT_ASC])
        ->all();
        
        return ArrayHelper::map($dsXe, 'id', function($model) {
            return '+ ' . $model->bien_so_xe;
        });
    }
    public static function getListByGiaoVienDay($idgv)
    {
        $dsXe = GvXe::find()->where(['id_giao_vien'=>$idgv])->all();
        
        return ArrayHelper::map($dsXe, 'id_xe', function($model) {
            return '+ ' . $model->xe->bien_so_xe;
        },function($model) {
            return $model->xe->loaiXe->ten_loai_xe;
        });
    }
    
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
            if($this->la_xe_cu == null){
                $this->la_xe_cu = 0;
            }
            if($this->stt==null){
                $this->stt = 0;
            }
        }
        if($this->ngay_dang_kiem != null){
            $this->ngay_dang_kiem = CustomFunc::convertDMYToYMD($this->ngay_dang_kiem);
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * hien thi ten xe
     */
    public function getTenXeShort(){
        //return $this->bien_so_xe . ($this->ma_so?(' (Số '.$this->ma_so.')'):'');
        return ($this->ma_so?(' Số '.$this->ma_so):'') . ' (' . $this->bien_so_xe . ')';
    }
    /**
     * hien thi ten xe with hang
     */
    public function getTenXeShort2(){
        //return $this->bien_so_xe . ($this->ma_so?(' (Số '.$this->ma_so.')'):'');
        return ($this->ma_so?(' Số '.$this->ma_so):'') . ' (' . ($this->loaiXe?$this->loaiXe->ma_loai_xe:'') . ')';
    }
    public function getTenXeLong(){
        return ($this->ma_so ? ('Xe số ' . $this->ma_so) : '' ) . ' - ' . $this->bien_so_xe
        . ($this->loaiXe ? (' - ' . $this->loaiXe->ten_loai_xe) : '' );
    }
    /**
     * lấy giá xe thuê theo mã
     */
    public function getGiaXeThue(){
        $ma = $this->phan_loai . $this->id_loai_xe;
        $hangHoa = HangHoa::find()->where(['ma_hang_hoa'=>$ma])->one();
        if($hangHoa){
            return $hangHoa->don_gia;
        } else 
            return 0;
    }
}
