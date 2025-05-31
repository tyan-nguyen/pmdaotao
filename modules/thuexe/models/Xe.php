<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\LoaiXe;
use yii\helpers\ArrayHelper;
use app\modules\giaovien\models\GiaoVien;
/**
 * This is the model class for table "ptx_xe".
 *
 * @property int $id
 * @property int $id_loai_xe
 * @property string|null $phan_loai
 * @property string|null $hieu_xe
 * @property string|null $bien_so_xe
 * @property string|null $tinh_trang_xe
 * @property string|null $trang_thai
 * @property int|null $id_giao_vien
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
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
    const PHANLOAI_TAPLAI = 'TAPLAI';
    
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
            self::PHANLOAI_TAPLAI => 'Xe tập lái',
            self::PHANLOAI_SATHACH => 'Xe sát hạch',
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
                $label = "Xe tập lái";
                break;
            case self::PHANLOAI_SATHACH:
                $label = "Xe sát hạch";
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
            [['id_loai_xe', 'phan_loai'], 'required'],
            [['id_loai_xe', 'nguoi_tao', 'id_giao_vien'], 'integer'],
            [['ghi_chu'], 'string'],
            [['phan_loai'], 'string', 'max' => 20],
            [['tinh_trang_xe'], 'string', 'max' => 20],
            [['thoi_gian_tao'], 'safe'],
            [['hieu_xe', 'bien_so_xe'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
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
            'id_loai_xe' => 'Tên loại xe',
            'phan_loai' => 'Phân loại xe',
            'phan_loai' => 'Phân loại xe',
            'hieu_xe' => 'Hiệu Xe',
            'bien_so_xe' => 'Biển Số Xe',
            'tinh_trang_xe' => 'Tình Trạng Xe',
            'ghi_chu' => 'Ghi chú',
            'trang_thai' => 'Trạng Thái',
            'id_giao_vien' => 'Giáo viên phụ trách',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
        ];
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
     * relation for giao vien
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
    
    public function beforeSave($insert)
    {        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
        }
        return parent::beforeSave($insert);
    }
}
