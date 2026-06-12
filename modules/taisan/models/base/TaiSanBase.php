<?php

namespace app\modules\taisan\models\base;

use app\custom\CustomFunc;
use app\models\CpTaiSan;
use app\modules\taisan\models\DanhMucTaiSan;
use app\modules\taisan\models\LoaiTaiSan;
use Yii;

class TaiSanBase extends CpTaiSan
{
    const MODEL_ID = 'taisan';
    const QR_FOLDER = '/uploads/qrtaisan/';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_tai_san_id', 'danh_muc_id', 'model', 'serial', 'so_tien', 'nha_cung_cap_id', 'so_hoa_don', 'so_hop_dong', 'ngay_mua', 'thoi_han_bao_hanh', 'ghi_chu_bao_hanh', 'vi_tri_id', 'phong_ban_id', 'nguoi_chiu_trach_nhiem_id', 'muc_dich_su_dung', 'ngay_dua_vao_su_dung', 'trang_thai', 'ghi_chu'], 'default', 'value' => null],
            [['ten_tai_san'], 'required'],
            [[
                'loai_tai_san_id',
                'danh_muc_id',
                'nha_cung_cap_id',
                'vi_tri_id',
                'phong_ban_id',
                'nguoi_chiu_trach_nhiem_id',
                'nguoi_tao'
            ], 'integer'],
            [['so_tien'], 'number'],
            [['ngay_mua', 'thoi_han_bao_hanh', 'ngay_dua_vao_su_dung', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu_bao_hanh', 'muc_dich_su_dung', 'ghi_chu'], 'string'],
            [['ma_tai_san', 'autoid'], 'string', 'max' => 100],
            [['ten_tai_san', 'model', 'serial'], 'string', 'max' => 255],
            [['so_hoa_don', 'so_hop_dong'], 'string', 'max' => 200],
            [['trang_thai'], 'string', 'max' => 50],
            [['ma_tai_san', 'autoid'], 'unique'],
            [['loai_tai_san_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiTaiSan::class, 'targetAttribute' => ['loai_tai_san_id' => 'id']],
            [['danh_muc_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanhMucTaiSan::class, 'targetAttribute' => ['danh_muc_id' => 'id']],
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
            'autoid' => 'Code',
            'ma_tai_san' => 'Mã tài sản',
            'ten_tai_san' => 'Tên tài sản',
            'loai_tai_san_id' => 'Loại tài sản',
            'danh_muc_id' => 'Danh mục',
            'model' => 'Model',
            'serial' => 'Số serial',
            'so_tien' => 'Số tiền',
            'nha_cung_cap_id' => 'Nhà cung cấp',
            'so_hoa_don' => 'Số hóa đơn',
            'so_hop_dong' => 'Số hợp đồng',
            'ngay_mua' => 'Ngày mua',
            'thoi_han_bao_hanh' => 'Thơi hạn bảo hành',
            'ghi_chu_bao_hanh' => 'Ghi chú bảo hành',
            'vi_tri_id' => 'Vị trí',
            'phong_ban_id' => 'Phòng ban',
            'nguoi_chiu_trach_nhiem_id' => 'Người chịu trách nhiệm',
            'muc_dich_su_dung' => 'Mục đích sử dụng',
            'ngay_dua_vao_su_dung' => 'Ngày đưa vào sử dụng',
            'trang_thai' => 'Trạng thái',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }

    public static function generateCode()
    {
        $autoid = null;
        do {
            $autoid = 'TS'
                . date('YmdHis')
                . rand(100, 999);
        } while (self::find()->where(['autoid' => $autoid])->exists());

        return $autoid;
    }

    //hàm beforeSave, set nguoi_tao
    public function beforeSave($insert)
    {
        if ($this->autoid == null) {
            $this->autoid = self::generateCode();
        }
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //create qr code
        if (empty($this->autoid)) {
            return;
        }

        $qrFile = Yii::getAlias('@webroot') . self::QR_FOLDER . $this->autoid . '.png';

        // Chỉ xử lý khi thêm mới hoặc mã biển số có thay đổi
        if (!$insert && !array_key_exists('autoid', $changedAttributes) && file_exists($qrFile)) {
            return;
        }
        // Chưa có file QR thì mới tạo
        if (!file_exists($qrFile)) {
            CustomFunc::createQRcode(self::QR_FOLDER, $this->autoid);
        }
    }

    /**
     * xoa file QR code
     */
    private function deleleQr()
    {
        $filePath = Yii::getAlias('@webroot') . $this::QR_FOLDER . $this->autoid . '.png';
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    /**
     * {@inheritdoc}
     * xoa file anh, tai lieu, lich su sau khi xoa du lieu
     */
    public function afterDelete()
    {
        //xoa qr
        $this->deleleQr();
        return parent::afterDelete();
    }

    public function getQrLink()
    {
        $filePath = Yii::getAlias('@webroot') . $this::QR_FOLDER . $this->autoid . '.png';
        $fileWeb = Yii::getAlias('@web') . $this::QR_FOLDER . $this->autoid . '.png';
        return file_exists($filePath) ? $fileWeb : '';
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
        return $this->hasOne(DanhMucTaiSan::class, ['id' => 'danh_muc_id']);
    }

    /**
     * Gets query for [[LoaiTaiSan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiTaiSan()
    {
        return $this->hasOne(LoaiTaiSan::class, ['id' => 'loai_tai_san_id']);
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
