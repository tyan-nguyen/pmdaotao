<?php

namespace app\modules\thuexe\models;

use Yii;
use app\modules\thuexe\models\LoaiXe;
use app\modules\thuexe\models\PhieuThueXe;
use app\custom\CustomFunc;
/**
 * This is the model class for table "ptx_loai_hinh_thue".
 *
 * @property int $id
 * @property string $loai_hinh_thue
 * @property int $id_loai_xe
 * @property float $gia_thue
 * @property string $ngay_ap_dung
 * @property string $ngay_ket_thuc
 * @property string $dang_ap_dung
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxLoaiXe $loaiXe
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class LoaiHinhThue extends \app\models\PtxLoaiHinhThue
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_loai_hinh_thue';
    }

    /**
     * {@inheritdoc}
     */
    public function getNgayApDung(){
        return CustomFunc::convertYMDToDMY($this->ngay_ap_dung);
    }
    public function getNgayKetThuc(){
        return CustomFunc::convertYMDToDMY($this->ngay_ket_thuc);
    }
    public function rules()
    {
        return [
            [['loai_hinh_thue', 'id_loai_xe', 'gia_thue', 'ngay_ap_dung', 'ngay_ket_thuc'], 'required'],
            [['id_loai_xe', 'nguoi_tao','dang_ap_dung'], 'integer'],
            [['gia_thue'], 'number'],
            [['ngay_ap_dung', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['loai_hinh_thue'], 'string', 'max' => 20],
            [['id_loai_xe'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiXe::class, 'targetAttribute' => ['id_loai_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_hinh_thue' => 'Loại Hình Thuê',
            'id_loai_xe' => 'Loại Xe',
            'gia_thue' => 'Giá Thuê',
            'ngay_ap_dung' => 'Ngày áp dụng',
            'ngay_ket_thuc' => 'Ngày Kết Thúc',
            'dang_ap_dung'=>'Đang Áp Dụng',
            'nguoi_tao' => 'Nguười Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
        ];
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
     * Gets query for [[PtxPhieuThueXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxPhieuThueXes()
    {
        return $this->hasMany(PhieuThueXe::class, ['id_loai_hinh_thue' => 'id']);
    }

    public function beforeSave($insert)
    {
        // Chuyển đổi định dạng ngày tháng trước khi lưu, bất kể là tạo mới hay cập nhật
        $this->ngay_ap_dung = CustomFunc::convertDMYToYMD($this->ngay_ap_dung);
        $this->ngay_ket_thuc = CustomFunc::convertDMYToYMD($this->ngay_ket_thuc);
        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
        }
    
        return parent::beforeSave($insert);
    }
}
