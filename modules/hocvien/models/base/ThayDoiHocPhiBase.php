<?php

namespace app\modules\hocvien\models\base;

use Yii;
use app\modules\hocvien\models\HocPhi;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HangDaoTao;

/**
 * @property int $id
 * @property int $id_hoc_vien
 * @property float $so_tien
 * @property string|null $ly_do
 * @property string|null $thoi_gian_thay_doi
 * @property string|null $ghi_chu
 * @property int $id_hang_cu
 * @property int $id_hang_moi
 * @property int|null $id_hoc_phi_cu
 * @property int|null $id_hoc_phi_moi
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHocPhi $hocPhiCu
 * @property HvHocPhi $hocPhiMoi
 * @property HvHocVien $hocVien
 */
class ThayDoiHocPhiBase extends \app\models\HvHocVienThayDoiHocPhi
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ly_do', 'thoi_gian_thay_doi', 'ghi_chu', 'id_hoc_phi_cu', 'id_hoc_phi_moi', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_hoc_vien', 'so_tien'], 'required'],
            [['id_hoc_vien', 'id_hang_cu', 'id_hang_moi', 'id_hoc_phi_cu', 'id_hoc_phi_moi', 'nguoi_tao'], 'integer'],
            [['so_tien'], 'number'],
            [['ly_do', 'ghi_chu'], 'string'],
            [['thoi_gian_thay_doi', 'thoi_gian_tao'], 'safe'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
            [['id_hoc_phi_cu'], 'exist', 'skipOnError' => true, 'targetClass' => HocPhi::class, 'targetAttribute' => ['id_hoc_phi_cu' => 'id']],
            [['id_hoc_phi_moi'], 'exist', 'skipOnError' => true, 'targetClass' => HocPhi::class, 'targetAttribute' => ['id_hoc_phi_moi' => 'id']],
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
            'so_tien' => 'Số tiền',
            'ly_do' => 'Lý do',
            'thoi_gian_thay_doi' => 'Thời gian thay đổi',
            'ghi_chu' => 'Ghi chú',
            'id_hang_cu' => 'Hạng cũ',
            'id_hang_moi' => 'Hạng mới',
            'id_hoc_phi_cu' => 'Học phí cũ',
            'id_hoc_phi_moi' => 'Học phí mới',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->thoi_gian_thay_doi == null){
                $this->thoi_gian_thay_doi = date('Y-m-d H:i:s');
            }else{
                $this->thoi_gian_thay_doi = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_thay_doi);
            }
        }else{
            $this->thoi_gian_thay_doi = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_thay_doi);
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[HangCu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangCu()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang_cu']);
    }
    
    /**
     * Gets query for [[HangMoi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangMoi()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang_moi']);
    }
    
    /**
     * Gets query for [[HocPhiCu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocPhiCu()
    {
        return $this->hasOne(HocPhi::class, ['id' => 'id_hoc_phi_cu']);
    }
    
    /**
     * Gets query for [[HocPhiMoi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocPhiMoi()
    {
        return $this->hasOne(HocPhi::class, ['id' => 'id_hoc_phi_moi']);
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