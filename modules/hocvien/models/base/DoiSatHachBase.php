<?php
namespace app\modules\hocvien\models\base;

use Yii;
use app\models\HvHocVienDoiSatHach;
use app\modules\hocvien\models\HocVien;
use app\modules\khoahoc\models\HangDaoTao;
use app\custom\CustomFunc;

/**
 * This is the model class for table "hv_hoc_vien_doi_sat_hach".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int $id_hang
 * @property string $ngay_thi_cu
 * @property string|null $ly_do_doi_lich
 * @property string|null $ngay_thi_moi
 * @property int|null $da_xu_ly
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property HvHangDaoTao $hang
 * @property HvHocVien $hocVien
 */
class DoiSatHachBase extends HvHocVienDoiSatHach
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ly_do_doi_lich', 'ngay_thi_moi', 'da_xu_ly', 'ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_hoc_vien', 'id_hang', 'ngay_thi_cu'], 'required'],
            [['id_hoc_vien', 'id_hang', 'da_xu_ly', 'nguoi_tao'], 'integer'],
            [['ngay_thi_cu', 'ngay_thi_moi', 'thoi_gian_tao'], 'safe'],
            [['ly_do_doi_lich', 'ghi_chu'], 'string'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
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
            'id_hoc_vien' => 'Học viên',
            'id_hang' => 'Hạng đào tạo',
            'ngay_thi_cu' => 'Ngày thi',
            'ly_do_doi_lich' => 'Lý do dời lịch',
            'ngay_thi_moi' => 'Ngày thi mới',
            'da_xu_ly' => 'Đã xử lý',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    
    public function beforeSave($insert) {
        $this->ngay_thi_cu = CustomFunc::convertDMYToYMD($this->ngay_thi_cu);
        $this->ngay_thi_moi = CustomFunc::convertDMYToYMD($this->ngay_thi_moi);
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->da_xu_ly == NULL){
                $this->da_xu_ly = 0;
            }
        }
        return parent::beforeSave($insert);
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
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
    }
    
}
