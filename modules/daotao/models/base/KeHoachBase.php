<?php

namespace app\modules\daotao\models\base;

use Yii;
use app\modules\daotao\models\TietHoc;
use app\custom\CustomFunc;
use app\modules\giaovien\models\GiaoVien;
use app\modules\user\models\User;

/**
 * This is the model class for table "gd_ke_hoach".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property string $ngay_thuc_hien
 * @property string|null $ghi_chu
 * @property string|null thoi_gian_gui_duyet
 * @property string|null $trang_thai_duyet
 * @property int|null $id_nguoi_duyet
 * @property string|null $noi_dung_duyet
 * @property string|null $thoi_gian_duyet
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property GdTietHoc[] $gdTietHocs
 */
class KeHoachBase extends \app\models\GdKeHoach
{
    const TT_NHAP = 'NHAP';
    const TT_CHODUYET = 'CHODUYET';
    const TT_DADUYET = 'DADUYET';
    const TT_KHONGDUYET = 'KHONGDUYET';
    const TT_HOANTHANH = 'HOANTHANH';
    
    /**
     * Danh muc trang thai all
     * @return string[]
     */
    public static function getDmTrangThai()
    {
        return [
            self::TT_NHAP => 'Nháp',
            self::TT_CHODUYET => 'Chờ duyệt',
            self::TT_DADUYET => 'Đã duyệt',
            self::TT_KHONGDUYET => 'Không duyệt',
            self::TT_HOANTHANH => 'Hoàn thành',
        ];
    }
    
    /**
     * Danh muc trang thai for giao vien
     * @return string[]
     */
    public static function getDmTrangThaiForGiaoVien()
    {
        return [
            self::TT_NHAP => 'Nháp',
           // self::TT_CHODUYET => 'Chờ duyệt',
           // self::TT_HOANTHANH => 'Hoàn thành',
        ];
    }
    
    /**
     * Danh muc trang thai for duyet
     * @return string[]
     */
    public static function getDmTrangThaiDuyet()
    {
        return [
            self::TT_DADUYET => 'Đã duyệt',
            self::TT_KHONGDUYET => 'Không duyệt',
        ];
    }
    
    /**
     * Danh muc trang thai label
     * @param int $val
     * @return string
     */
    public static function getLabelTrangThaiOther($val=NULL)
    {
        switch ($val) {
            case self::TT_NHAP:
                $label = "Nháp";
                break;
            case self::TT_CHODUYET:
                $label = "Chờ duyệt";
                break;
            case self::TT_DADUYET:
                $label = "Đã duyệt";
                break;
            case self::TT_KHONGDUYET:
                $label = "Không duyệt";
                break;
            case self::TT_HOANTHANH:
                $label = "Hoàn thành";
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
    public static function getLabelTrangThaiBadge($val=NULL)
    {
        switch ($val) {
            case self::TT_NHAP:
                $label = '<span class="badge bg-danger"><i class="fa fa-edit"></i> Nháp</span> ';
                break;
            case self::TT_CHODUYET:
                $label = '<span class="badge bg-warning"><i class="fa fa-hourglass-half"></i> Chờ duyệt</span> ';
                break;
            case self::TT_DADUYET:
                $label = '<span class="badge bg-primary"><i class="fa fa-check-circle"></i> Đã duyệt</span> ';
                break;
            case self::TT_KHONGDUYET:
                $label = '<span class="badge bg-danger"><i class="fa fa-remove"></i> Không duyệt</span> ';
                break;
            case self::TT_HOANTHANH:
                $label = '<span class="badge bg-info"><i class="fa fa-check-square-o"></i> Hoàn thành</span> ';
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
            [['trang_thai_duyet', 'id_nguoi_duyet', 'noi_dung_duyet', 'thoi_gian_duyet', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'ngay_thuc_hien'], 'required'],
            [['id_giao_vien', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['ngay_thuc_hien', 'thoi_gian_duyet', 'thoi_gian_tao', 'thoi_gian_gui_duyet'], 'safe'],
            [['noi_dung_duyet', 'ghi_chu'], 'string'],
            [['trang_thai_duyet'], 'string', 'max' => 20],
            [['trang_thai_duyet'], 'required', 'on'=>'duyet-kh'], //bat buoc khi duyet
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_giao_vien' => 'Giáo viên',
            'ngay_thuc_hien' => 'Ngày',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_gui_duyet' => 'Thời gian gửi duyệt',
            'trang_thai_duyet' => 'Trạng thái',
            'id_nguoi_duyet' => 'Người duyệt',
            'noi_dung_duyet' => 'Nội dung duyệt',
            'thoi_gian_duyet' => 'Thời gian duyệt',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->trang_thai_duyet==null)
                $this->trang_thai_duyet = self::TT_NHAP;
            if($this->thoi_gian_duyet!=null)
                $this->thoi_gian_duyet = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_duyet);
        }
        if($this->ngay_thuc_hien!=null)
            $this->ngay_thuc_hien = CustomFunc::convertDMYToYMD($this->ngay_thuc_hien);
        if($this->thoi_gian_duyet!=null)
            $this->thoi_gian_duyet = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_duyet);
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if($this->trang_thai_duyet == self::TT_HOANTHANH){
            foreach ($this->gdTietHocs as $tietHoc){
                if($tietHoc->trang_thai == TietHoc::TT_CHUATHUCHIEN){
                    $tietHoc->trang_thai = TietHoc::TT_DAHOANTHANH;
                    $tietHoc->save(false);
                }
            }
        }        
    }

    /**
     * Gets query for [[GdTietHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdTietHocs()
    {
        return $this->hasMany(TietHoc::class, ['id_ke_hoach' => 'id']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiDuyet()
    {
        return $this->hasOne(User::class, ['id' => 'id_nguoi_duyet']);
    }

}
