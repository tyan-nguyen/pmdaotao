<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_vien_thay_doi_hoc_phi".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property float $so_tien
 * @property string|null $ly_do
 * @property string|null $thoi_gian_thay_doi
 * @property string|null $ghi_chu
 * @property int|null $id_hang_cu
 * @property int|null $id_hang_moi
 * @property int|null $id_hoc_phi_cu
 * @property int|null $id_hoc_phi_moi
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHangDaoTao $hangCu
 * @property HvHangDaoTao $hangMoi
 * @property HvHocPhi $hocPhiCu
 * @property HvHocPhi $hocPhiMoi
 * @property HvHocVien $hocVien
 */
class HvHocVienThayDoiHocPhi extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien_thay_doi_hoc_phi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ly_do', 'thoi_gian_thay_doi', 'ghi_chu', 'id_hang_cu', 'id_hang_moi', 'id_hoc_phi_cu', 'id_hoc_phi_moi', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_hoc_vien', 'so_tien'], 'required'],
            [['id_hoc_vien', 'id_hang_cu', 'id_hang_moi', 'id_hoc_phi_cu', 'id_hoc_phi_moi', 'nguoi_tao'], 'integer'],
            [['so_tien'], 'number'],
            [['ly_do', 'ghi_chu'], 'string'],
            [['thoi_gian_thay_doi', 'thoi_gian_tao'], 'safe'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
            [['id_hoc_phi_cu'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocPhi::class, 'targetAttribute' => ['id_hoc_phi_cu' => 'id']],
            [['id_hoc_phi_moi'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocPhi::class, 'targetAttribute' => ['id_hoc_phi_moi' => 'id']],
            [['id_hang_cu'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang_cu' => 'id']],
            [['id_hang_moi'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang_moi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Id Hoc Vien',
            'so_tien' => 'So Tien',
            'ly_do' => 'Ly Do',
            'thoi_gian_thay_doi' => 'Thoi Gian Thay Doi',
            'ghi_chu' => 'Ghi Chu',
            'id_hang_cu' => 'Id Hang Cu',
            'id_hang_moi' => 'Id Hang Moi',
            'id_hoc_phi_cu' => 'Id Hoc Phi Cu',
            'id_hoc_phi_moi' => 'Id Hoc Phi Moi',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[HangCu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangCu()
    {
        return $this->hasOne(HvHangDaoTao::class, ['id' => 'id_hang_cu']);
    }

    /**
     * Gets query for [[HangMoi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangMoi()
    {
        return $this->hasOne(HvHangDaoTao::class, ['id' => 'id_hang_moi']);
    }

    /**
     * Gets query for [[HocPhiCu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocPhiCu()
    {
        return $this->hasOne(HvHocPhi::class, ['id' => 'id_hoc_phi_cu']);
    }

    /**
     * Gets query for [[HocPhiMoi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocPhiMoi()
    {
        return $this->hasOne(HvHocPhi::class, ['id' => 'id_hoc_phi_moi']);
    }

    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HvHocVien::class, ['id' => 'id_hoc_vien']);
    }

}
