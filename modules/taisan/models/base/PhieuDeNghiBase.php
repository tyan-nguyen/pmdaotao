<?php

namespace app\modules\taisan\models\base;

use app\custom\CustomFunc;
use app\models\CpPhieuDeNghi;
use app\modules\taisan\models\DmDonVi;
use app\modules\taisan\models\PhieuChiTiet;
use app\modules\user\models\History;
use Yii;

/**
 * This is the model class for table "cp_phieu_de_nghi".
 *
 * @property int $id
 * @property string|null $loai_phieu
 * @property string|null $loai_tai_san
 * @property int $id_tham_chieu
 * @property int|null $nguoi_de_nghi
 * @property string|null $loai_yeu_cau
 * @property int|null $so_km_luc_yeu_cau
 * @property string $noi_dung_de_nghi
 * @property string|null $ngay_bat_dau
 * @property string|null $ngay_hoan_thanh
 * @property string|null $trang_thai
 * @property string|null $thoi_gian_gui_duyet
 * @property int|null $nguoi_duyet
 * @property string|null $ngay_duyet
 * @property string|null $ghi_chu_duyet
 * @property int|null $phieu_co_chi_tiet
 * @property float|null $tong_tien_du_kien
 * @property float|null $tong_tien_thuc_te
 * @property int|null $id_dot_tong_hop
  * @property int|null $da_thanh_toan
 * @property string|null $ngay_thanh_toan
 * @property string|null $hinh_thuc_thanh_toan
 * @property int|null $nguoi_thanh_toan
 * @property string|null $loai_thanh_toan thanh toan le hay theo dot
 * @property int|null $so_lan_in
 * @property int|null $edit_mode
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 * @property int|null $id_don_vi_thuc_hien
 *
 * @property CpDotTongHop $dotTongHop
 */
class PhieuDeNghiBase extends CpPhieuDeNghi
{
    public const MODEL_ID = 'PHIEU_DE_NGHI';
    //loại phiếu
    public const LOAIPHIEU_MUASAM = 'MUA_SAM';
    public const LOAIPHIEU_SUACHUA = 'SUA_CHUA';
    public static function getLoaiPhieuList()
    {
        return [
            self::LOAIPHIEU_MUASAM => 'Phiếu Mua sắm',
            self::LOAIPHIEU_SUACHUA => 'Phiếu Sửa chữa',
        ];
    }
    public static function getLoaiPhieuLabel($loai)
    {
        $list = self::getLoaiPhieuList();
        $class = [
            self::LOAIPHIEU_MUASAM => 'bg-primary',
            self::LOAIPHIEU_SUACHUA => 'bg-warning',
        ];

        $label = $list[$loai] ?? 'Chưa phân loại';
        $css = $class[$loai] ?? 'bg-danger';

        return "<span class=\"badge {$css}\">{$label}</span>";
    }
    //loại tài sản đề nghị
    public const LOAITAISAN_THIETBI = 'THIET_BI';
    public const LOAITAISAN_XE = 'XE';
    public static function getLoaiTaiSanList()
    {
        return [
            self::LOAITAISAN_THIETBI => 'Thiết bị',
            self::LOAITAISAN_XE => 'Xe',
        ];
    }
    public static function getLoaiTaiSanLabel($loai)
    {
        $list = self::getLoaiTaiSanList();
        $class = [
            self::LOAITAISAN_THIETBI => 'bg-primary',
            self::LOAITAISAN_XE => 'bg-warning',
        ];

        $label = $list[$loai] ?? 'Chưa phân loại';
        $css = $class[$loai] ?? 'bg-danger';

        return "<span class=\"badge {$css}\">{$label}</span>";
    }
    //loại yêu cầu cho xe (bảo dưởng/sửa chữa)
    public const LOAISUAXE_BAODUONG = 'BAO_DUONG';
    public const LOAISUAXE_SUACHUA = 'SUA_CHUA';
    public static function getLoaiSuaXeList()
    {
        return [
            self::LOAISUAXE_BAODUONG => 'Bảo dưỡng',
            self::LOAISUAXE_SUACHUA => 'Sửa chữa',
        ];
    }
    public static function getLoaiSuaXeLabel($loai)
    {
        $list = self::getLoaiSuaXeList();
        $class = [
            self::LOAISUAXE_BAODUONG => 'bg-primary',
            self::LOAISUAXE_SUACHUA => 'bg-warning',
        ];

        $label = $list[$loai] ?? 'Chưa phân loại';
        $css = $class[$loai] ?? 'bg-danger';

        return "<span class=\"badge {$css}\">{$label}</span>";
    }
    //trạng thái duyệt
    public const TRANGTHAI_NHAP = 'NHAP';
    public const TRANGTHAI_CHODUYET = 'CHO_DUYET';
    public const TRANGTHAI_DADUYET = 'DA_DUYET';
    public const TRANGTHAI_HOANTHANH = 'HOAN_THANH';
    public const TRANGTHAI_KHONGDUYET = 'KHONG_DUYET';
    public static function getTrangThaiList()
    {
        return [
            self::TRANGTHAI_NHAP => 'Nháp',
            self::TRANGTHAI_CHODUYET => 'Chờ duyệt',
            self::TRANGTHAI_DADUYET => 'Đã duyệt',
            self::TRANGTHAI_HOANTHANH => 'Hoàn thành',
            self::TRANGTHAI_KHONGDUYET => 'Không duyệt',
        ];
    }
    public static function getTrangThaiForNhanVienList()
    {
        return [
            self::TRANGTHAI_NHAP => 'Nháp',
            self::TRANGTHAI_CHODUYET => 'Chờ duyệt',
        ];
    }
    public static function getDmTrangThaiDuyet()
    {
        return [
            self::TRANGTHAI_DADUYET => 'Đã duyệt',
            self::TRANGTHAI_KHONGDUYET => 'Không duyệt',
        ];
    }
    public static function getTrangThaiLabel($trangthai)
    {
        $list = self::getTrangThaiList();
        $class = [
            self::TRANGTHAI_NHAP => 'bg-default',
            self::TRANGTHAI_CHODUYET => 'bg-warning',
            self::TRANGTHAI_DADUYET => 'bg-success',
            self::TRANGTHAI_HOANTHANH => 'bg-info',
            self::TRANGTHAI_KHONGDUYET => 'bg-danger',
        ];
        $icon = [
            self::TRANGTHAI_NHAP => 'ion-document',
            self::TRANGTHAI_CHODUYET => 'ion-paper-airplane',
            self::TRANGTHAI_DADUYET => 'ion-compose',
            self::TRANGTHAI_HOANTHANH => 'ion-ios7-checkmark',
            self::TRANGTHAI_KHONGDUYET => 'ion-close-circled',
        ];

        $label = $list[$trangthai] ?? 'Chưa phân loại';
        $css = $class[$trangthai] ?? 'bg-danger';
        $icon = $icon[$trangthai] ?? '';

        return "<span class=\"badge {$css}\"><i class=\"{$icon}\"></i> {$label}</span>";
    }
    /**
     * danh muc trang thai da vo so phieu
     */
    public static function getDmTrangThaiCoSoVaoSo()
    {
        return [
            self::TRANGTHAI_DADUYET,
            self::TRANGTHAI_HOANTHANH,
        ];
    }
    //loại thanh toán
    public const LOAITT_THEO_DOT = 'TT_THEO_DOT';
    public const LOAITT_LE = 'TT_LE';
    public static function getThanhToanList()
    {
        return [
            self::LOAITT_THEO_DOT => 'Thanh toán theo đợt',
            self::LOAITT_LE => 'Thanh toán lẻ',
        ];
    }
    public static function getThanhToanLabel($loai)
    {
        $list = self::getThanhToanList();
        $class = [
            self::LOAITT_THEO_DOT => 'bg-primary',
            self::LOAITT_LE => 'bg-warning',
        ];

        $label = $list[$loai] ?? 'Chưa phân loại';
        $css = $class[$loai] ?? 'bg-danger';

        return "<span class=\"badge {$css}\">{$label}</span>";
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_phieu', 'so_vao_so', 'nam', 'loai_phieu', 'loai_tai_san', 'nguoi_de_nghi', 'loai_yeu_cau', 'so_km_luc_yeu_cau', 'ngay_bat_dau', 'ngay_hoan_thanh', 'nguoi_duyet', 'ngay_duyet', 'ghi_chu_duyet', 'phieu_co_chi_tiet', 'id_dot_tong_hop', 'ngay_thanh_toan', 'hinh_thuc_thanh_toan', 'nguoi_thanh_toan', 'loai_thanh_toan', 'so_lan_in', 'edit_mode', 'nguoi_tao', 'thoi_gian_gui_duyet',
            'id_don_vi_thuc_hien'
            ], 'default', 'value' => null],
            [['trang_thai'], 'default', 'value' => 'NHAP'],
            [['tong_tien_thuc_te'], 'default', 'value' => 0.00],
            [['da_thanh_toan'], 'default', 'value' => 0],
            [['so_phieu', 'so_vao_so', 'nam', 'id_tham_chieu', 'nguoi_de_nghi', 'so_km_luc_yeu_cau', 'nguoi_duyet', 'phieu_co_chi_tiet', 'id_dot_tong_hop', 'da_thanh_toan', 'nguoi_thanh_toan', 'so_lan_in', 'edit_mode', 'nguoi_tao', 'id_don_vi_thuc_hien'], 'integer'],
            [['id_tham_chieu', 'noi_dung_de_nghi'], 'required'],
            [['noi_dung_de_nghi', 'ghi_chu_duyet'], 'string'],
            [['ngay_bat_dau', 'ngay_hoan_thanh', 'ngay_duyet', 'ngay_thanh_toan', 'thoi_gian_tao', 'thoi_gian_gui_duyet'], 'safe'],
            [['tong_tien_du_kien', 'tong_tien_thuc_te'], 'number'],
            [['loai_phieu', 'loai_tai_san', 'loai_yeu_cau', 'trang_thai', 'hinh_thuc_thanh_toan', 'loai_thanh_toan'], 'string', 'max' => 20],
            [['id_dot_tong_hop'], 'exist', 'skipOnError' => true, 'targetClass' => DotTongHopBase::class, 'targetAttribute' => ['id_dot_tong_hop' => 'id']],
            [['trang_thai'], 'required', 'on' => 'duyet-phieu'], //bat buoc khi duyet
        ];
    }

    public static function getDmNamVaoSo()
    {
        $start = 2025;
        $end = date('Y');
        $year_array = array();
        for ($year = $end; $year >= $start; $year--) {
            $year_array[$year] = $year;
        }
        return $year_array;
    }

    public function getSoVaoSo()
    {
        if ($this->so_vao_so != null) {
            //return 'HĐ-' . $this->fillNumber($this->so_vao_so) . '/' . $this->namVaoSo;
            return $this->fillNumber($this->so_vao_so) . '/' . $this->namVaoSo;
        } else {
            return 'Chưa có';
        }
    }

    public function getSoVaoSoCuoi($year = NULl)
    {
        if ($year == null)
            $year = date('Y');
        $hoaDonCuoi = $this::find()->where([
            'nam' => $year,
        ])->andFilterWhere(['IN', 'trang_thai', $this::getDmTrangThaiCoSoVaoSo()])
            ->orderBy(['so_vao_so' => SORT_DESC])->one();

        if ($hoaDonCuoi != null)
            return $hoaDonCuoi->so_vao_so;
        else
            return 0;
    }

    public function getSoPhieuCuoi()
    {

        $hoaDonCuoi = $this::find()->orderBy(['so_phieu' => SORT_DESC])->one();

        if ($hoaDonCuoi != null)
            return $hoaDonCuoi->so_phieu;
        else
            return 0;
    }

    public function getNamVaoSo()
    {
        if ($this->nam != null) {
            return $this->nam;
        } else {
            $this->nam = date('Y');
            if ($this->save()) {
                return date('Y');
            }
        }
    }

    public function fillNumber($number)
    {
        $num = strlen($number);
        if ($num < 5) {
            $str0 = '';
            for ($i = 1; $i <= (5 - $num); $i++) {
                $str0 .= '0';
            }
            return $str0 . $number;
        } else {
            return $number;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã phiếu đề nghị',
            'loai_phieu' => 'Loại phiếu',
            'loai_tai_san' => 'Loại tài sản',
            'id_tham_chieu' => 'Tham chiếu',
            'nguoi_de_nghi' => 'Người đề nghị',
            'loai_yeu_cau' => 'Loại yêu cầu',
            'so_km_luc_yeu_cau' => 'Số KM lúc yêu cầu',
            'noi_dung_de_nghi' => 'Nội dung đề nghị',
            'ngay_bat_dau' => 'Ngày bắt đầu',
            'ngay_hoan_thanh' => 'Ngày hoàn thành',
            'trang_thai' => 'Trạng thái',
            'nguoi_duyet' => 'Người duyệt',
            'ngay_duyet' => 'Ngày duyệt',
            'ghi_chu_duyet' => 'Ghi chú duyệt',
            'phieu_co_chi_tiet' => 'Phiếu có chi tiết',
            'tong_tien_du_kien' => 'Tổng tiền dự kiến',
            'tong_tien_thuc_te' => 'Tổng tiền thực tế',
            'id_dot_tong_hop' => 'Đợt tổng hợp',
            'da_thanh_toan' => 'Đã thanh toán',
            'ngay_thanh_toan' => 'Ngày thanh toán',
            'hinh_thuc_thanh_toan' => 'Hình thức thanh toán',
            'nguoi_thanh_toan' => 'Người thanh toán',
            'loai_thanh_toan' => 'Loại thanh toán',
            'so_lan_in' => 'Số lần in',
            'edit_mode' => 'Edit Mode',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
            'id_don_vi_thuc_hien' => 'Đơn vị thực hiện',
        ];
    }

    //ham lay danh sach vat tu
    public function getChiTiets()
    {
        return $this->hasMany(PhieuChiTiet::class, ['id_phieu_de_nghi' => 'id']);
    }
    //hàm beforeSave, set nguoi_tao
    public function beforeSave($insert)
    {
        $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
        $this->ngay_hoan_thanh = CustomFunc::convertDMYToYMD($this->ngay_hoan_thanh);
        $this->ngay_duyet = CustomFunc::convertDMYHISToYMDHIS($this->ngay_duyet);
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if ($this->nam == NULL)
                $this->nam = date('Y');
            if ($this->trang_thai == NULL)
                $this->trang_thai = self::TRANGTHAI_NHAP;
            if ($this->so_phieu == NULL)
                $this->so_phieu = $this->soPhieuCuoi + 1;
            if ($this->edit_mode == NULL)
                $this->edit_mode = 0;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //History::addHistoryPhieuDeNghi($this::MODEL_ID, $changedAttributes, $this, $insert);
    }

    /**
     * Gets query for [[DotTongHop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDotTongHop()
    {
        return $this->hasOne(DotTongHopBase::class, ['id' => 'id_dot_tong_hop']);
    }

    public function getDonViThucHien()
    {
        return $this->hasOne(DmDonVi::class, ['id' => 'id_don_vi_thuc_hien']);
    }
}
