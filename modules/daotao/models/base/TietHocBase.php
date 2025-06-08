<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\models\GdTietHoc;
use app\modules\hocvien\models\HocVien;
use app\modules\daotao\models\DmThoiGian;
use app\modules\thuexe\models\Xe;
use app\modules\giaovien\models\GiaoVien;
use app\modules\daotao\models\MonHoc;
use app\modules\daotao\models\KeHoach;

/**
 * This is the model class for table "gd_tiet_hoc".
 *
 * @property int $id
 * @property int $id_ke_hoach
 * @property int $id_hoc_vien
 * @property int $id_giao_vien
 * @property int $id_xe
 * @property int $id_mon_hoc
 * @property int $id_thoi_gian_hoc
 * @property float $so_gio
 * @property string $thoi_gian_bd
 * @property string $thoi_gian_kt
 * @property string|null $ghi_chu
 * @property float|null $so_km
 * @property string|null $trang_thai
 * @property string|null $trang_thai_duyet
 * @property string|null $ngay_duyet
 * @property int|null $id_nguoi_duyet
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVien
 * @property HvHocVien $hocVien
 * @property GdMonHoc $monHoc
 * @property GdDmThoiGian $thoiGianHoc
 * @property PtxXe $xe
 */
class TietHocBase extends GdTietHoc
{
    const TT_CHUATHUCHIEN = 'CHUATHUCHIEN';
    const TT_DAHOANTHANH = 'DAHOANTHANH';
    const TT_HOCVIENHUY = 'HOCVIENHUY';
    const TT_DAHUY = 'DAHUY';
    
    /**
     * Danh muc trang thai
     * @return string[]
     */
    public static function getDmTrangThai()
    {
        return [
            self::TT_CHUATHUCHIEN => 'Chưa thực hiện',
            self::TT_DAHOANTHANH => 'Đã hoàn thành',
            self::TT_HOCVIENHUY => 'Học viên hủy',
            self::TT_DAHUY => 'Đã hủy',
        ];
    }
    
    /**
     * Danh muc trang thai cho giao vien
     * @return string[]
     */
    public static function getDmTrangThaiForGiaoVien()
    {
        return [
            self::TT_CHUATHUCHIEN => 'Chưa thực hiện',
            self::TT_DAHOANTHANH => 'Đã hoàn thành',
            self::TT_HOCVIENHUY => 'Học viên hủy'
        ];
    }
    
    /**
     * Danh muc trang thai chua thuc hien
     * @return string[]
     */
    public static function getDmTrangThaiChuaDuyet()
    {
        return [
            self::TT_CHUATHUCHIEN => 'Chưa thực hiện',
        ];
    }
    
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public static function getLabelTinhTrangXeOther($val=NULL)
    {
        switch ($val) {
            case self::TT_CHUATHUCHIEN:
                $label = "Chưa thực hiện";
                break;
            case self::TT_DAHOANTHANH:
                $label = "Đã hoàn thành";
                break;
            case self::TT_HOCVIENHUY:
                $label = "Học viên hủy";
                break;
            case self::TT_DAHUY:
                $label = "Đã hủy";
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
            case self::TT_CHUATHUCHIEN:
                $label = '<span class="badge bg-info">Chưa thực hiện</span> ';
                break;
            case self::TT_DAHOANTHANH:
                $label = '<span class="badge bg-primary">Đã hoàn thành</span> ';
                break;
            case self::TT_HOCVIENHUY:
                $label = '<span class="badge bg-danger">Học viên hủy</span> ';
                break;
            case self::TT_DAHUY:
                $label = '<span class="badge bg-warning">Đã hủy</span> ';
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
            [['ghi_chu', 'trang_thai', 'trang_thai_duyet', 'ngay_duyet', 'id_nguoi_duyet', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_hoc_vien', 'id_giao_vien', 'id_xe', 'id_mon_hoc', 'id_thoi_gian_hoc', 'id_ke_hoach'], 'required'],
            [['id_hoc_vien', 'id_giao_vien', 'id_xe', 'id_mon_hoc', 'id_thoi_gian_hoc', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['so_gio', 'so_km'], 'number'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'ngay_duyet', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['trang_thai', 'trang_thai_duyet'], 'string', 'max' => 20],
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => GiaoVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
            [['id_mon_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => MonHoc::class, 'targetAttribute' => ['id_mon_hoc' => 'id']],
            [['id_thoi_gian_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => DmThoiGian::class, 'targetAttribute' => ['id_thoi_gian_hoc' => 'id']],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => Xe::class, 'targetAttribute' => ['id_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ke_hoach' => 'Kế hoạch ngày',
            'id_hoc_vien' => 'Học viên',
            'id_giao_vien' => 'Giáo viên',
            'id_xe' => 'Xe',
            'id_mon_hoc' => 'Môn học',
            'id_thoi_gian_hoc' => 'Thời gian học',
            'so_gio' => 'Số giờ',
            'thoi_gian_bd' => 'Thời gian bắt đầu',
            'thoi_gian_kt' => 'Thời gian kết thúc',
            'ghi_chu' => 'Ghi chú',
            'so_km' => 'Số Km',
            'trang_thai' => 'Trạng thái',
            'trang_thai_duyet' => 'Trạng thái duyệt',
            'ngay_duyet' => 'Ngày duyệt',
            'id_nguoi_duyet' => 'Người duyệt',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'id_giao_vien']);
    }

    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
    }

    /**
     * Gets query for [[MonHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMonHoc()
    {
        return $this->hasOne(MonHoc::class, ['id' => 'id_mon_hoc']);
    }

    /**
     * Gets query for [[ThoiGianHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThoiGianHoc()
    {
        return $this->hasOne(DmThoiGian::class, ['id' => 'id_thoi_gian_hoc']);
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
    /**
     * Gets query for [[KeHoach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeHoach()
    {
        return $this->hasOne(KeHoach::class, ['id' => 'id_ke_hoach']);
    }
}
