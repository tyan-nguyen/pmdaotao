<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_tai_san".
 *
 * @property int $id
 * @property string|null $autoid
 * @property string $ma_tai_san
 * @property string $ten_tai_san
 * @property int|null $loai_tai_san_id
 * @property int|null $danh_muc_id
 * @property string|null $model
 * @property string|null $serial
 * @property float|null $so_tien
 * @property int|null $nha_cung_cap_id
 * @property string|null $so_hoa_don
 * @property string|null $so_hop_dong
 * @property string|null $ngay_mua
 * @property string|null $thoi_han_bao_hanh
 * @property string|null $ghi_chu_bao_hanh
 * @property int|null $vi_tri_id
 * @property int|null $phong_ban_id
 * @property int|null $nguoi_chiu_trach_nhiem_id
 * @property string|null $muc_dich_su_dung
 * @property string|null $ngay_dua_vao_su_dung
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property CpTaiSanTag[] $cpTaiSanTags
 * @property CpDanhMucTaiSan $danhMuc
 * @property CpLoaiTaiSan $loaiTaiSan
 * @property NvNhanVien $nguoiChiuTrachNhiem
 * @property CpDmDonVi $nhaCungCap
 * @property NvPhongBan $phongBan
 * @property CpViTri $viTri
 */
class CpTaiSan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_tai_san';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['autoid', 'loai_tai_san_id', 'danh_muc_id', 'model', 'serial', 'so_tien', 'nha_cung_cap_id', 'so_hoa_don', 'so_hop_dong', 'ngay_mua', 'thoi_han_bao_hanh', 'ghi_chu_bao_hanh', 'vi_tri_id', 'phong_ban_id', 'nguoi_chiu_trach_nhiem_id', 'muc_dich_su_dung', 'ngay_dua_vao_su_dung', 'trang_thai', 'ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['ma_tai_san', 'ten_tai_san'], 'required'],
            [['loai_tai_san_id', 'danh_muc_id', 'nha_cung_cap_id', 'vi_tri_id', 'phong_ban_id', 'nguoi_chiu_trach_nhiem_id', 'nguoi_tao'], 'integer'],
            [['so_tien'], 'number'],
            [['ngay_mua', 'thoi_han_bao_hanh', 'ngay_dua_vao_su_dung', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu_bao_hanh', 'muc_dich_su_dung', 'ghi_chu'], 'string'],
            [['autoid', 'ma_tai_san'], 'string', 'max' => 100],
            [['ten_tai_san', 'model', 'serial'], 'string', 'max' => 255],
            [['so_hoa_don', 'so_hop_dong'], 'string', 'max' => 200],
            [['trang_thai'], 'string', 'max' => 50],
            [['ma_tai_san'], 'unique'],
            [['loai_tai_san_id'], 'exist', 'skipOnError' => true, 'targetClass' => CpLoaiTaiSan::class, 'targetAttribute' => ['loai_tai_san_id' => 'id']],
            [['danh_muc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CpDanhMucTaiSan::class, 'targetAttribute' => ['danh_muc_id' => 'id']],
            [['nha_cung_cap_id'], 'exist', 'skipOnError' => true, 'targetClass' => CpDmDonVi::class, 'targetAttribute' => ['nha_cung_cap_id' => 'id']],
            [['vi_tri_id'], 'exist', 'skipOnError' => true, 'targetClass' => CpViTri::class, 'targetAttribute' => ['vi_tri_id' => 'id']],
            [['phong_ban_id'], 'exist', 'skipOnError' => true, 'targetClass' => NvPhongBan::class, 'targetAttribute' => ['phong_ban_id' => 'id']],
            [['nguoi_chiu_trach_nhiem_id'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['nguoi_chiu_trach_nhiem_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'autoid' => 'Autoid',
            'ma_tai_san' => 'Ma Tai San',
            'ten_tai_san' => 'Ten Tai San',
            'loai_tai_san_id' => 'Loai Tai San ID',
            'danh_muc_id' => 'Danh Muc ID',
            'model' => 'Model',
            'serial' => 'Serial',
            'so_tien' => 'So Tien',
            'nha_cung_cap_id' => 'Nha Cung Cap ID',
            'so_hoa_don' => 'So Hoa Don',
            'so_hop_dong' => 'So Hop Dong',
            'ngay_mua' => 'Ngay Mua',
            'thoi_han_bao_hanh' => 'Thoi Han Bao Hanh',
            'ghi_chu_bao_hanh' => 'Ghi Chu Bao Hanh',
            'vi_tri_id' => 'Vi Tri ID',
            'phong_ban_id' => 'Phong Ban ID',
            'nguoi_chiu_trach_nhiem_id' => 'Nguoi Chiu Trach Nhiem ID',
            'muc_dich_su_dung' => 'Muc Dich Su Dung',
            'ngay_dua_vao_su_dung' => 'Ngay Dua Vao Su Dung',
            'trang_thai' => 'Trang Thai',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[CpTaiSanTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpTaiSanTags()
    {
        return $this->hasMany(CpTaiSanTag::class, ['tai_san_id' => 'id']);
    }

    /**
     * Gets query for [[DanhMuc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDanhMuc()
    {
        return $this->hasOne(CpDanhMucTaiSan::class, ['id' => 'danh_muc_id']);
    }

    /**
     * Gets query for [[LoaiTaiSan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiTaiSan()
    {
        return $this->hasOne(CpLoaiTaiSan::class, ['id' => 'loai_tai_san_id']);
    }

    /**
     * Gets query for [[NguoiChiuTrachNhiem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiChiuTrachNhiem()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'nguoi_chiu_trach_nhiem_id']);
    }

    /**
     * Gets query for [[NhaCungCap]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhaCungCap()
    {
        return $this->hasOne(CpDmDonVi::class, ['id' => 'nha_cung_cap_id']);
    }

    /**
     * Gets query for [[PhongBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongBan()
    {
        return $this->hasOne(NvPhongBan::class, ['id' => 'phong_ban_id']);
    }

    /**
     * Gets query for [[ViTri]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViTri()
    {
        return $this->hasOne(CpViTri::class, ['id' => 'vi_tri_id']);
    }

}
