<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\LoaiXe;
use yii\helpers\ArrayHelper;
use app\modules\giaovien\models\GiaoVien;
use app\modules\daotao\models\GvXe;
use app\custom\CustomFunc;
use app\modules\banhang\models\HangHoa;
use app\modules\daotao\models\KeHoach;
use app\modules\daotao\models\TietHoc;
use app\modules\demxe\models\DemXe;
use app\modules\taisan\models\PhieuDeNghi;
use app\models\PtxXeVitriGps;

/**
 * This is the model class for table "ptx_xe".
 *
 * @property int $id
 * @property string|null $ma_so
 * @property int $id_loai_xe
 * @property string|null $phan_loai
 * @property string|null $hieu_xe
 * @property string|null $bien_so_xe
 * @property string|null $ma_bien_so
 * @property string|null $tinh_trang_xe
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property string|null $so_khung
 * @property string|null $so_may
 * @property string|null $ngay_dang_kiem
 * @property string|null $mau_sac
 * @property string|null $ma_mau
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
 * @property int|null $so_km_ban_dau 
 * @property string|null $ngay_cap_nhat_km 
 * @property int|null $nam_san_xuat
 * @property int|null $nam_mua
 * @property string|null $imei_gps
 * @property int|null $id_don_vi_so_huu
 *
 * @property PtxLoaiXe $loaiXe
 * @property \app\modules\thuexe\models\DonViSoHuu $donViSoHuu
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class Xe extends \app\models\PtxXe
{
    const MODEL_ID = 'xe';
    const QR_FOLDER = '/uploads/qrxe/';
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
    public static function getLabelTinhTrangXeOther($val = NULL)
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
    public static function getLabelTinhTrangXeBadge($val = NULL)
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
                $label = 'Chưa phân loại';
        }
        return $label;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_xe', 'bien_so_xe', 'ma_bien_so'], 'required'],
            [[
                'id_loai_xe',
                'la_xe_cu',
                'nguoi_tao',
                'id_giao_vien',
                'stt',
                'so_km_ban_dau',
                'nam_san_xuat',
                'nam_mua',
                'id_don_vi_so_huu'
            ], 'integer'],
            [['ghi_chu', 'dac_diem'], 'string'],
            [['imei_gps'], 'trim'],
            [['phan_loai', 'ma_so', 'imei_gps'], 'string', 'max' => 20],
            [['tinh_trang_xe'], 'string', 'max' => 20],
            [['thoi_gian_tao', 'ngay_dang_kiem', 'ngay_cap_nhat_km'], 'safe'],
            [['bien_so_xe', 'ma_bien_so'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
            [['bien_so_xe'], 'unique'],
            [[
                'hieu_xe',
                'so_khung',
                'so_may',
                'mau_sac',
                'ma_mau',
                'nha_cung_cap',
                'so_hoa_don',
                'so_hop_dong'
            ], 'string', 'max' => 250],
            [
                ['id_loai_xe'],
                'exist',
                'skipOnError' => true,
                'targetClass' => LoaiXe::class,
                'targetAttribute' => ['id_loai_xe' => 'id']
            ],
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
            'ma_bien_so' => 'Mã Biển Số',
            'tinh_trang_xe' => 'Tình Trạng Xe',
            'ghi_chu' => 'Ghi chú',
            'so_khung' => 'Số khung',
            'so_may' => 'Số máy/Số động cơ',
            'ngay_dang_kiem' => 'Ngày đăng kiểm',
            'mau_sac' => 'Màu sắc',
            'ma_mau' => 'Mã màu',
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
            'stt' => 'STT',
            'so_km_ban_dau' => 'Số km ban đầu',
            'ngay_cap_nhat_km' => 'Ngày cập nhật km',
            'nam_san_xuat' => 'Năm sản xuất',
            'nam_mua' => 'Năm mua',
            'imei_gps' => 'Số IMEI GPS',
            'id_don_vi_so_huu' => 'Đơn vị sở hữu',
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
    public static function getListAll()
    {
        $dsXe = Xe::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return ArrayHelper::map($dsXe, 'id', function ($model) {
            return '+ ' . $model->bien_so_xe;
        }, function ($model) {
            return $model->loaiXe->ten_loai_xe;
        });
    }
    public static function getList()
    {
        $dsXe = Xe::find()
            ->where(['trang_thai' => 'Khả dụng'])
            ->orderBy(['hieu_xe' => SORT_ASC])
            ->all();

        return ArrayHelper::map($dsXe, 'id', function ($model) {
            return '+ ' . $model->hieu_xe;
        });
    }

    public static function getList2()
    {
        $dsXe = Xe::find()
            ->orderBy(['hieu_xe' => SORT_ASC])
            ->all();

        return ArrayHelper::map($dsXe, 'id', function ($model) {
            return '+ ' . $model->hieu_xe;
        });
    }

    public static function getListByGiaoVien($idgv)
    {
        $dsXe = Xe::find()->where(['id_giao_vien' => $idgv])
            ->orderBy(['hieu_xe' => SORT_ASC])
            ->all();

        return ArrayHelper::map($dsXe, 'id', function ($model) {
            return '+ ' . $model->bien_so_xe;
        });
    }
    public static function getListByGiaoVienDay($idgv)
    {
        $dsXe = GvXe::find()->where(['id_giao_vien' => $idgv])->all();

        return ArrayHelper::map($dsXe, 'id_xe', function ($model) {
            return '+ ' . $model->xe->bien_so_xe;
        }, function ($model) {
            return $model->xe->loaiXe->ten_loai_xe;
        });
    }
    /**
     * get giáo viên được phân công sử dụng xe
     */
    public function getListGiaoVienSuDung()
    {
        $dsGv = GvXe::find()->where(['id_xe' => $this->id])->all();
        return $dsGv;
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if ($this->la_xe_cu == null) {
                $this->la_xe_cu = 0;
            }
            if ($this->stt == null) {
                $this->stt = 0;
            }
            if ($this->so_km_ban_dau != null) {
                $this->ngay_cap_nhat_km = date('Y-m-d H:i:s');
            }
        } else {
            if ($this->isAttributeChanged('so_km_ban_dau')) {
                $this->ngay_cap_nhat_km = date('Y-m-d H:i:s'); // field trang_thai đã thay đổi
            }
        }
        if ($this->ngay_dang_kiem != null) {
            $this->ngay_dang_kiem = CustomFunc::convertDMYToYMD($this->ngay_dang_kiem);
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
        if (empty($this->ma_bien_so)) {
            return;
        }

        $qrFile = Yii::getAlias('@webroot') . self::QR_FOLDER . $this->ma_bien_so . '.png';

        // Chỉ xử lý khi thêm mới hoặc mã biển số có thay đổi
        if (!$insert && !array_key_exists('ma_bien_so', $changedAttributes) && file_exists($qrFile)) {
            return;
        }
        // Chưa có file QR thì mới tạo
        if (!file_exists($qrFile)) {
            CustomFunc::createQRcode(self::QR_FOLDER, $this->ma_bien_so);
        }
    }

    /**
     * xoa file QR code
     */
    private function deleleQr()
    {
        $filePath = Yii::getAlias('@webroot') . $this::QR_FOLDER . $this->ma_bien_so . '.png';
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
        $filePath = Yii::getAlias('@webroot') . $this::QR_FOLDER . $this->ma_bien_so . '.png';
        $fileWeb = Yii::getAlias('@web') . $this::QR_FOLDER . $this->ma_bien_so . '.png';
        return file_exists($filePath) ? $fileWeb : '';
    }
    /**
     * hien thi ten xe
     */
    public function getTenXeShort()
    {
        //return $this->bien_so_xe . ($this->ma_so?(' (Số '.$this->ma_so.')'):'');
        return ($this->ma_so ? (' Số ' . $this->ma_so) : '') . ' (' . $this->bien_so_xe . ')';
    }
    /**
     * hien thi ten xe with hang
     */
    public function getTenXeShort2()
    {
        //return $this->bien_so_xe . ($this->ma_so?(' (Số '.$this->ma_so.')'):'');
        return ($this->ma_so ? (' Xe ' . $this->ma_so) : '') . ' (' . ($this->loaiXe ? $this->loaiXe->ma_loai_xe : '') . ')';
    }
    public function getTenXeLong()
    {
        return ($this->ma_so ? ('Xe số ' . $this->ma_so) : '') . ' - ' . $this->bien_so_xe
            . ($this->loaiXe ? (' - ' . $this->loaiXe->ten_loai_xe) : '');
    }
    /**
     * lấy giá xe thuê theo mã
     */
    public function getGiaXeThue()
    {
        $ma = $this->phan_loai . $this->id_loai_xe;
        $hangHoa = HangHoa::find()->where(['ma_hang_hoa' => $ma])->one();
        if ($hangHoa) {
            return $hangHoa->don_gia;
        } else
            return 0;
    }
    /**
     * lay anh dai dien
     */
    public function getAnhDaiDien()
    {
        $hinhDaiDien = HinhXe::find()->where(['id_xe' => $this->id, 'la_dai_dien' => 1])->one();
        return $hinhDaiDien != null ? $hinhDaiDien : HinhXe::find()->where(['id_xe' => $this->id])->one();
    }
    /**
     * lay danh sach hinh anh xe
     */
    public function getHinhAnhs()
    {
        return $this->hasMany(HinhXe::class, ['id_xe' => 'id']);
    }
    /**
     * get km xe hien tai theo lan cap nhat gan nhat
     * neu tim trong bang phieu sua chua cua xe thay thi lay cai sort theo phieu moi nhat
     * neu khong co ban sua chua thi lay theo km ban dau trong bang ptx_xe
     */
    public function getKmHienTai()
    {
        $km_ban_dau = $this->so_km_ban_dau ?? 0;
        $phieuSuaChua = PhieuDeNghi::find()->where([
            'id_tham_chieu' => $this->id,
            'loai_phieu' => PhieuDeNghi::LOAIPHIEU_SUACHUA,
            'loai_tai_san' => PhieuDeNghi::LOAITAISAN_XE,
            'loai_yeu_cau' => PhieuDeNghi::LOAISUAXE_BAODUONG,
        ])->andWhere([
            'in',
            'trang_thai',
            [
                PhieuDeNghi::TRANGTHAI_HOANTHANH,
                PhieuDeNghi::TRANGTHAI_DADUYET
            ]
        ])->orderBy(['id' => SORT_DESC])->one();
        if ($phieuSuaChua) {
            return $phieuSuaChua->so_km_luc_yeu_cau > $km_ban_dau ? $phieuSuaChua->so_km_luc_yeu_cau : $km_ban_dau;
        } else {
            return $km_ban_dau;
        }
    }
    /**
     * get ngay lay km hien tai theo lan cap nhat gan nhat
     * neu tim trong bang phieu sua chua cua xe thay thi lay cai sort theo phieu moi nhat
     * neu khong co ban sua chua thi lay theo ngay nhap km ban dau trong bang ptx_xe
     */
    public function getNgayCapNhatKmHienTai()
    {
        $km_ban_dau = $this->so_km_ban_dau ?? 0;
        $phieuSuaChua = PhieuDeNghi::find()->where([
            'id_tham_chieu' => $this->id,
            'loai_phieu' => PhieuDeNghi::LOAIPHIEU_SUACHUA,
            'loai_tai_san' => PhieuDeNghi::LOAITAISAN_XE,
            'loai_yeu_cau' => PhieuDeNghi::LOAISUAXE_BAODUONG,
        ])->andWhere([
            'in',
            'trang_thai',
            [
                PhieuDeNghi::TRANGTHAI_HOANTHANH,
                PhieuDeNghi::TRANGTHAI_DADUYET
            ]
        ])->orderBy(['ngay_duyet' => SORT_DESC])->one();
        if ($phieuSuaChua) {
            if ($phieuSuaChua->so_km_luc_yeu_cau > $km_ban_dau) {
                return $phieuSuaChua->thoi_gian_tao;
            } else {
                return $this->ngay_cap_nhat_km;
            }
        } else {
            return $this->ngay_cap_nhat_km;
        }
    }

    /** for api xe */
    public function getXeDangSuDungQuaCamera()
    {
        $demXe = DemXe::find()->where(['id_xe' => $this->id])->orderBy('ID DESC')->one();
        if ($demXe != null && $demXe->thoi_gian_kt == null) {
            return true;
        } else {
            return false;
        }
    }
    //get list hoat dong theo ngay
    public function getListHoatDongTheoNgay($ngay = null)
    {
        $arr = [];
        if ($ngay == null)
            $ngay = date('Y-m-d');
        $start = $ngay . ' 00:00:00';
        $end = $ngay . ' 23:59:59';

        $lichDungXes = LichDungXe::find()->where([
            'id_xe' => $this->id,
            'trang_thai' => LichDungXe::TT_ACTIVE
        ])->andWhere(['>=', 'thoi_gian_ket_thuc', $start])
            ->andWhere(['<=', 'thoi_gian_bat_dau', $end])->all();

        foreach ($lichDungXes as $item) {
            $arr[] =  [
                'thoi_gian' => 'Từ ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_bat_dau)
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_ket_thuc),
                'noi_dung' => $item->noi_dung,
                'nguoi_phu_trach' => $item->nguoiPhuTrach->ho_ten,
            ];
        }

        //lịch sửa chữa, bảo dưỡng add to list lịch (sét màu đỏ)
        $lichSuaXes = PhieuDeNghi::find()->where([
            'loai_tai_san' => PhieuDeNghi::LOAITAISAN_XE,
            //'loai_phieu' => PhieuDeNghi::LOAIPHIEU_SUACHUA,
            'id_tham_chieu' => $this->id,
        ])->andWhere(['IN', 'trang_thai', PhieuDeNghi::getDmTrangThaiCoSoVaoSo()])
            ->andWhere(['>=', 'ngay_hoan_thanh', $start])
            ->andWhere(['<=', 'ngay_bat_dau', $end])->all();

        foreach ($lichSuaXes as $item) {
            if ($item->ngay_bat_dau != null && $item->ngay_hoan_thanh != null) {
                $arr[] =  [
                    'thoi_gian' => CustomFunc::convertYMDHISToDMY($item->ngay_bat_dau),
                    'noi_dung' => 'Nội dung: ' . $item->noi_dung_de_nghi
                        . ' - Trạng thái: ' . PhieuDeNghi::getTrangThaiList()[$item->trang_thai],
                    'nguoi_phu_trach' => ($item->nguoiDeNghi ? $item->nguoiDeNghi->hoTen : ''),
                ];
            }
        }
        //giảng dạy
        $contactLog = TietHoc::find()->alias('t')
            ->joinWith(['keHoach k'])
            ->andWhere(['t.id_xe' => $this->id])
            ->andWhere(['>=', 't.thoi_gian_kt', $start])
            ->andWhere(['<=', 't.thoi_gian_bd', $end])
            ->andWhere(['k.trang_thai_duyet' => KeHoach::getDmTrangThaiForLichSuDungXe()])
            ->orderBy(['t.thoi_gian_bd' => SORT_ASC])->all();




        $merged = [];
        $current = null;

        foreach ($contactLog as $item) {
            $start = $item->thoi_gian_bd;
            $end   = $item->thoi_gian_kt;

            $gv = $item->giaoVien ? $item->giaoVien->ho_ten : '';
            $hv = $item->hocVien ? $item->hocVien->ho_ten : '';
            $idHv = $item->id_hoc_vien;
            $trangThai = $item->trang_thai;
            $bienSoXe = $item->xe->bien_so_xe;
            $monHoc = $item->monHoc->ten_mon;

            if ($current === null) {
                // bắt nhóm đầu tiên
                $current = [
                    'start' => $start,
                    'end' => $end,
                    'giao_vien' => $gv,
                    'hoc_vien' => $hv,
                    'id_hoc_vien' => $idHv,
                    'trang_thai' => $trangThai,
                    'mon_hoc' => $monHoc,
                    'bien_so_xe' => $bienSoXe
                ];
            } else {
                // Điều kiện gộp:
                // 1. Liền kề về thời gian
                // 2. Cùng học viên
                // 3. Cùng trạng thái
                // 4. Cùng môn học
                if (
                    $start == $current['end'] &&
                    $idHv == $current['id_hoc_vien'] &&
                    $trangThai == $current['trang_thai'] &&
                    $monHoc = $current['mon_hoc']
                ) {
                    // gộp: tăng giờ kết thúc
                    $current['end'] = $end;
                } else {
                    // đóng nhóm cũ, mở nhóm mới
                    $merged[] = $current;

                    $current = [
                        'start' => $start,
                        'end' => $end,
                        'giao_vien' => $gv,
                        'hoc_vien' => $hv,
                        'id_hoc_vien' => $idHv,
                        'trang_thai' => $trangThai,
                        'mon_hoc' => $monHoc,
                        'bien_so_xe' => $bienSoXe
                    ];
                }
            }
        }

        // đẩy nhóm cuối
        if ($current !== null) {
            $merged[] = $current;
        }

        $eventData = [];

        foreach ($merged as $m) {

            $arr[] =  [
                'thoi_gian' => 'Từ ' . CustomFunc::convertYMDHISToDMYHI($m['start'])
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($m['end']),
                'noi_dung' => 'Xe:' . $m['bien_so_xe'] . ' - GV: ' . $m['giao_vien'] . ' - HV: ' . $m['hoc_vien']
                    . ' dạy từ ' . CustomFunc::convertYMDHISToDMYHI($m['start'])
                    . ' đến ' . CustomFunc::convertYMDHISToDMYHI($m['end'])
                    . ' Môn học: ' . $m['mon_hoc']
                    . ' Trạng thái: ' . TietHoc::getDmTrangThai()[$m['trang_thai']],
                'nguoi_phu_trach' => 'GV: ' . $m['giao_vien'],
            ];
        }

        //thue xe cam bien
        //$contactLog = ContactLogPolicy::getContactLogByStaff();
        $contactLog = LichThue::find()
            //->joinWith(['xe as x'])
            ->andWhere(['id_xe' => $this->id])
            ->andWhere(['>=', 'thoi_gian_ket_thuc', $start])->andWhere(['<=', 'thoi_gian_bat_dau', $end])
            ->orderBy(['thoi_gian_tao' => SORT_DESC])
            //->andWhere(['x.id_loai_xe'=>$model->id])
            ->all();

        //$colorList = ContactLogForm::getStatusColorHexList();
        $colorList = LichThue::getTrangThaiColor();
        //$eventData = [];
        foreach ($contactLog as $item) {
            $calendarTitle = 'Xe ' . $item->xe->ma_so;
            //$calendarDescription = $item->so_gio >=2 ? '' : ('Biển số ' .$item->xe->bien_so_xe . ' - ');
            $calendarDescription = 'Biển số ' . $item->xe->bien_so_xe . ' - ';
            $calendarDescription .= 'GV: ' . ($item->giaoVien ? $item->giaoVien->ho_ten : '') . ' - HV: '
                . ($item->khachHang ? $item->khachHang->ho_ten : '') . ' thuê từ '
                . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_bat_dau) . ' đến '
                . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_ket_thuc);
            $arr[] =  [
                'thoi_gian' => 'Từ ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_bat_dau) . ' đến ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_ket_thuc),
                'noi_dung' => $calendarDescription,
                'nguoi_phu_trach' => ($item->giaoVien ? $item->giaoVien->ho_ten : ''),
            ];
        }


        return $arr;
    }

    /**
     * Gets query for all GPS positions of this vehicle
     * @return \yii\db\ActiveQuery
     */
    public function getViTriGpsList()
    {
        return $this->hasMany(PtxXeVitriGps::class, ['id_xe' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * Gets query for the latest GPS position of this vehicle
     * @return \yii\db\ActiveQuery
     */
    public function getViTriGpsMoiNhat()
    {
        return $this->hasOne(PtxXeVitriGps::class, ['id_xe' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * Lấy vùng giới hạn hiện tại của xe dựa trên vị trí GPS gần nhất
     * @return \app\models\PtxXeVungGioiHan|null
     */
    public function getVungHienTai()
    {
        $vt = $this->viTriGpsMoiNhat;
        if (!$vt || !$vt->latitude || !$vt->longitude) {
            return null;
        }
        $zones = \app\models\PtxXeVungGioiHan::getDanhSachVungDangApDung();
        foreach ($zones as $zone) {
            if ($zone->isPointInside($vt->latitude, $vt->longitude)) {
                return $zone;
            }
        }
        return null;
    }

    /**
     * Trả về HTML Badge trạng thái vùng của xe (Khuôn viên, Vùng X, hoặc Ngoài đường)
     * @return string
     */
    public function getTrangThaiVungBadge()
    {
        $vt = $this->viTriGpsMoiNhat;
        if (!$vt || !$vt->latitude || !$vt->longitude) {
            return '<span class="badge bg-secondary">Chưa có GPS</span>';
        }
        $vung = $this->getVungHienTai();
        if ($vung) {
            $color = $vung->mau_sac ?: '#2563eb';
            return '<span class="badge" style="background-color:' . $color . '; color:#fff;"><i class="fa fa-building"></i> ' . \yii\helpers\Html::encode($vung->ten_vung) . '</span>';
        }
        return '<span class="badge bg-warning text-dark"><i class="fa fa-road"></i> Ngoài đường</span>';
    }

    /**
     * Danh sách giấy tờ của xe
     * @return \yii\db\ActiveQuery
     */
    public function getXeGiayTos()
    {
        return $this->hasMany(\app\modules\thuexe\models\XeGiayTo::class, ['id_xe' => 'id']);
    }

    /**
     * Lấy danh sách giấy tờ mới nhất cho từng loại giấy tờ của xe
     * Mỗi id_loai_giay_to chỉ lấy 1 bản ghi có id lớn nhất
     * @return \app\modules\thuexe\models\XeGiayTo[]
     */
    public function getGiayTosMoiNhat()
    {
        $subQuery = \app\modules\thuexe\models\XeGiayTo::find()
            ->select(['MAX(id)'])
            ->where(['id_xe' => $this->id])
            ->groupBy('id_loai_giay_to');

        return \app\modules\thuexe\models\XeGiayTo::find()
            ->where(['id' => $subQuery])
            ->with(['loaiGiayTo'])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    /**
     * Tổng hợp tình trạng hạn các giấy tờ của xe
     * - Chỉ check thiếu giấy tờ đối với các loại giấy tờ có la_bat_buoc = 1.
     * - Đối với các giấy tờ hiện có trên xe, nếu loại có check_het_han = 1 thì kiểm tra ngày hết hạn.
     *
     * @param bool $detailed Nếu true trả về mảng chi tiết
     * @return string|array Trả về mã trạng thái hoặc mảng thông tin chi tiết
     */
    public function getTrangThaiGiayToXe($detailed = false)
    {
        static $cachedLoaiGiayTos = null;
        if ($cachedLoaiGiayTos === null) {
            $cachedLoaiGiayTos = \app\modules\thuexe\models\LoaiGiayTo::find()->all();
        }
        $loaiGiayTos = $cachedLoaiGiayTos;

        if (empty($loaiGiayTos)) {
            $res = [
                'status' => 'KHONG_YEU_CAU',
                'expired' => [],
                'warning' => [],
                'missing' => [],
                'valid' => [],
            ];
            return $detailed ? $res : 'KHONG_YEU_CAU';
        }

        $expired = [];
        $warning = [];
        $missing = [];
        $valid = [];

        foreach ($loaiGiayTos as $loai) {
            $latest = \app\modules\thuexe\models\XeGiayTo::find()
                ->where([
                    'id_xe' => $this->id,
                    'id_loai_giay_to' => $loai->id,
                    'is_active' => \app\modules\thuexe\models\base\XeGiayToBase::STATUS_ACTIVE,
                ])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if (!$latest) {
                // Chỉ check chưa đủ giấy tờ đối với loại giấy tờ có la_bat_buoc = 1 / true
                if ($loai->la_bat_buoc == \app\modules\thuexe\models\base\LoaiGiayToBase::BAT_BUOC_CO) {
                    $missing[] = $loai;
                }
            } else {
                if ($loai->check_het_han == \app\modules\thuexe\models\base\LoaiGiayToBase::CHECK_HET_HAN_CO) {
                    $han = $latest->getTrangThaiHan();
                    if ($han === \app\modules\thuexe\models\base\XeGiayToBase::HAN_DA_HET) {
                        $expired[] = ['loai' => $loai, 'giay_to' => $latest];
                    } elseif ($han === \app\modules\thuexe\models\base\XeGiayToBase::HAN_SAP_HET) {
                        $warning[] = ['loai' => $loai, 'giay_to' => $latest];
                    } else {
                        $valid[] = ['loai' => $loai, 'giay_to' => $latest];
                    }
                } else {
                    $valid[] = ['loai' => $loai, 'giay_to' => $latest];
                }
            }
        }

        if (!empty($expired)) {
            $status = \app\modules\thuexe\models\base\XeGiayToBase::HAN_DA_HET;
        } elseif (!empty($warning)) {
            $status = \app\modules\thuexe\models\base\XeGiayToBase::HAN_SAP_HET;
        } elseif (!empty($missing)) {
            $status = 'THIEU_GIAY_TO';
        } elseif (!empty($valid)) {
            $status = \app\modules\thuexe\models\base\XeGiayToBase::HAN_CON_HAN;
        } else {
            $status = 'KHONG_YEU_CAU';
        }

        if ($detailed) {
            return [
                'status' => $status,
                'expired' => $expired,
                'warning' => $warning,
                'missing' => $missing,
                'valid' => $valid,
            ];
        }

        return $status;
    }

    /**
     * Badge hiển thị tổng hợp tình trạng hạn giấy tờ xe
     * @return string
     */
    public function getTrangThaiGiayToBadge()
    {
        $info = $this->getTrangThaiGiayToXe(true);
        $status = $info['status'];
        switch ($status) {
            case \app\modules\thuexe\models\base\XeGiayToBase::HAN_DA_HET:
                $names = array_map(function ($item) {
                    return $item['loai']->ten_loai_giay_to;
                }, $info['expired']);
                $title = 'Giấy tờ hết hạn: ' . implode(', ', $names);
                return '<span class="badge bg-danger" title="' . \yii\helpers\Html::encode($title) . '"><i class="fa fa-times-circle"></i> Có giấy tờ hết hạn (' . count($info['expired']) . ')</span>';
            case \app\modules\thuexe\models\base\XeGiayToBase::HAN_SAP_HET:
                $names = array_map(function ($item) {
                    return $item['loai']->ten_loai_giay_to;
                }, $info['warning']);
                $title = 'Giấy tờ sắp hết hạn: ' . implode(', ', $names);
                return '<span class="badge bg-warning text-dark" title="' . \yii\helpers\Html::encode($title) . '"><i class="fa fa-exclamation-triangle"></i> Sắp hết hạn (' . count($info['warning']) . ')</span>';
            case 'THIEU_GIAY_TO':
                $names = array_map(function ($loai) {
                    return $loai->ten_loai_giay_to;
                }, $info['missing']);
                $title = 'Thiếu giấy tờ bắt buộc: ' . implode(', ', $names);
                return '<span class="badge bg-secondary" title="' . \yii\helpers\Html::encode($title) . '"><i class="fa fa-question-circle"></i> Chưa đủ giấy tờ (' . count($info['missing']) . ')</span>';
            case \app\modules\thuexe\models\base\XeGiayToBase::HAN_CON_HAN:
                return '<span class="badge bg-success"><i class="fa fa-check-circle"></i> Giấy tờ hợp lệ</span>';
            default:
                return '<span class="badge bg-secondary">Không yêu cầu</span>';
        }
    }

    /**
     * Gets query for [[DonViSoHuu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonViSoHuu()
    {
        return $this->hasOne(\app\modules\thuexe\models\DonViSoHuu::class, ['id' => 'id_don_vi_so_huu']);
    }

    /**
     * Gets query for [[CameraLogs]].
     * Liên kết với bảng ptx_xe_camera_logs qua ma_xe = ma_bien_so
     * @return \yii\db\ActiveQuery
     */
    public function getCameraLogs()
    {
        return $this->hasMany(\app\modules\thuexe\models\XeCameraLogs::class, ['ma_xe' => 'ma_bien_so']);
    }

    /**
     * Lấy danh sách các mã màu của xe dưới dạng mảng
     * @return array
     */
    public function getDanhSachMaMau()
    {
        if (empty($this->ma_mau)) {
            return [];
        }
        $colors = explode(',', $this->ma_mau);
        $res = [];
        foreach ($colors as $c) {
            $c = trim($c);
            if (!empty($c)) {
                $res[] = $c;
            }
        }
        return array_values(array_unique($res));
    }

    /**
     * Render vòng tròn màu sắc cho xe (hỗ trợ cả 1 màu và nhiều màu dạng conic-gradient)
     * @param int $size Kích thước đường kính vòng tròn (pixel)
     * @return string
     */
    public function renderBadgeMauSac($size = 20)
    {
        $colors = $this->getDanhSachMaMau();
        if (empty($colors)) {
            return '-';
        }

        $title = !empty($this->mau_sac) ? \yii\helpers\Html::encode($this->mau_sac) : implode(', ', $colors);
        $n = count($colors);
        $baseStyle = "width:{$size}px; height:{$size}px; border-radius:50%; display:inline-block; vertical-align:middle; border:1px solid #cbd5e1; box-shadow:0 1px 3px rgba(0,0,0,0.15); cursor:pointer;";

        if ($n === 1) {
            $bgStyle = "background-color: {$colors[0]};";
        } else {
            // Chia đều góc 360 độ cho N màu bằng conic-gradient
            $step = 360 / $n;
            $segments = [];
            for ($i = 0; $i < $n; $i++) {
                $startDeg = round($i * $step, 1);
                $endDeg = round(($i + 1) * $step, 1);
                $segments[] = "{$colors[$i]} {$startDeg}deg {$endDeg}deg";
            }
            $bgStyle = "background: conic-gradient(" . implode(', ', $segments) . ");";
        }

        return '<span class="xe-color-badge" title="' . $title . '" data-bs-toggle="tooltip" style="' . $baseStyle . ' ' . $bgStyle . '"></span>';
    }
}
