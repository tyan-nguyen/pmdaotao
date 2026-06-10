<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\LoaiXe;
use yii\helpers\ArrayHelper;
use app\modules\giaovien\models\GiaoVien;
use app\modules\daotao\models\GvXe;
use app\custom\CustomFunc;
use app\modules\banhang\models\HangHoa;
use app\modules\demxe\models\DemXe;
use app\modules\taisan\models\PhieuDeNghi;

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
 *
 * @property PtxLoaiXe $loaiXe
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class Xe extends \app\models\PtxXe
{
    const MODEL_ID = 'xe';

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
                'nam_mua'
            ], 'integer'],
            [['ghi_chu', 'dac_diem'], 'string'],
            [['phan_loai', 'ma_so'], 'string', 'max' => 20],
            [['tinh_trang_xe'], 'string', 'max' => 20],
            [['thoi_gian_tao', 'ngay_dang_kiem', 'ngay_cap_nhat_km'], 'safe'],
            [['bien_so_xe', 'ma_bien_so', 'ma_mau'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
            [['bien_so_xe'], 'unique'],
            [[
                'hieu_xe',
                'so_khung',
                'so_may',
                'mau_sac',
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
        ])->orderBy(['ngay_duyet' => SORT_DESC])->one();
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
        ])->andWhere(['>=', 'thoi_gian_bat_dau', $start])
            ->andWhere(['<=', 'thoi_gian_bat_dau', $end])->all();

        foreach ($lichDungXes as $item) {
            $arr[] =  [
                'thoi_gian' => 'Từ ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_bat_dau) . ' đến ' . CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_ket_thuc),
                'noi_dung' => $item->noi_dung,
                'nguoi_phu_trach' => $item->nguoiPhuTrach->ho_ten,
            ];
        }

        //lịch sửa chữa, bảo dưỡng add to list lịch (sét màu đỏ)
        $lichSuaXes = PhieuDeNghi::find()->where([
            'loai_tai_san' => PhieuDeNghi::LOAITAISAN_XE,
            'id_tham_chieu' => $this->id,
        ])->andWhere(['IN', 'trang_thai', PhieuDeNghi::getDmTrangThaiCoSoVaoSo()])->andWhere(['>=', 'ngay_bat_dau', $start])
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

        return $arr;
    }
}
