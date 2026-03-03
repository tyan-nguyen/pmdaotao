<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\custom\CustomFunc;
use app\models\PtxLichThi;

/**
 * This is the model class for table "ptx_lich_thi".
 *
 * @property int $id
 * @property string|null $phan_loai
 * @property string|null $ten_ky_thi
 * @property string $thoi_gian_bd
 * @property string $thoi_gian_kt
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 */
class LichThiBase extends PtxLichThi
{
    CONST PHANLOAI_THI = 'THI';
    CONST PHANLOAI_TN = 'TOTNGHIEP';
    CONST PHANLOAI_KIEMTRA = 'KIEMTRA';
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoai(){
        return [
            self::PHANLOAI_THI => 'Thi sát hạch',
            self::PHANLOAI_TN => 'Thi tốt nghiệp',
            self::PHANLOAI_KIEMTRA => 'Kiểm tra/Khảo sát/Bảo trì',
        ];
    }
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoaiLabel($val){
        $label = '';
        if($val == self::PHANLOAI_THI){
            $label = 'Thi sát hạch';
        }else if($val == self::PHANLOAI_KIEMTRA){
            $label = 'Kiểm tra/Khảo sát/Bảo trì';
        }else if($val == self::PHANLOAI_TN){
            $label = 'Thi tốt nghiệp';
        }
        return $label;
    }
    /**
     * Danh muc loai hoc vien html
     * @return string[]
     */
    public static function getDmLoaiLabelWithBadge($val){
        $label = '';
        if($val == self::PHANLOAI_THI){
            $label = '<span class="badge bg-primary">Thi sát hạch</span>';
        }else if($val == self::PHANLOAI_KIEMTRA){
            $label = '<span class="badge bg-warning">Kiểm tra/Khảo sát/Bảo trì</span>';
        }else if($val == self::PHANLOAI_TN){
            $label = '<span class="badge bg-success">Thi tốt nghiệp</span>';
        }
        return $label;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phan_loai', 'ten_ky_thi', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['thoi_gian_bd', 'thoi_gian_kt'], 'required'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['phan_loai'], 'string', 'max' => 20],
            [['ten_ky_thi'], 'string', 'max' => 255],
            ['thoi_gian_kt', 'validateThoiGianKetThuc', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }
    
    /**
     * custom rule
     */
    public function validateThoiGianKetThuc($attribute, $params)
    {
        if ($this->thoi_gian_kt <= $this->thoi_gian_bd) {
            $this->addError('thoi_gian_kt', 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.');
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phan_loai' => 'Phân loại',
            'ten_ky_thi' => 'Tên kỳ thi',
            'thoi_gian_bd' => 'Thời gian bắt đầu',
            'thoi_gian_kt' => 'Thời gian kết thúc',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
    public function beforeSave($insert) {
        $this->thoi_gian_bd = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_bd);
        $this->thoi_gian_kt = CustomFunc::convertDMYHISToYMDHIS($this->thoi_gian_kt);
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * Trả về trạng thái kỳ thi dựa vào hai cột `thoi_gian_bd` và `thoi_gian_kt` của bản ghi.
     * So sánh với một thời điểm được cung cấp hoặc thời điểm hiện tại của hệ thống nếu không truyền.
     *
     * Quy tắc:
     * - nếu thời điểm nằm trong khoảng (thoi_gian_bd, thoi_gian_kt): "Đang thi"
     * - nếu thời điểm lớn hơn thoi_gian_kt: "Đã thực hiện"
     * - nếu thời điểm nhỏ hơn thoi_gian_bd nhưng cách thoi_gian_bd không quá 7 ngày: "Sắp bắt đầu"
     * - nếu thời điểm nhỏ hơn thoi_gian_bd và cách nhiều hơn 7 ngày: "Đã lên lịch"
     *
     * @param string|null $thoi_gian_db thời điểm kiểm tra (dạng Y-m-d H:i:s); mặc định là thời điểm hiện tại hệ thống
     * @return string trạng thái
     */
    public function getTrangThaiTheoThoiGian($thoi_gian_db = null)
    {
        if ($thoi_gian_db === null) {
            $thoi_gian_db = date('Y-m-d H:i:s');
        }
        $t = strtotime($thoi_gian_db);
        $bd = strtotime($this->thoi_gian_bd);
        $kt = strtotime($this->thoi_gian_kt);

        // đang thi
        if ($t >= $bd && $t <= $kt) {
            return '<span class="badge bg-danger">Đang thi</span>';
        }

        // đã thực hiện (đã kết thúc)
        if ($t > $kt) {
            return 'Đã thực hiện';
        }

        // thời điểm nhỏ hơn bắt đầu -> kiểm tra khoảng cách
        $diff = $bd - $t; // giây
        $days = $diff / 86400;
        if ($days <= 7) {
            return '<span class="badge bg-warning">Sắp bắt đầu</span>';
        }

        return '<span class="badge bg-secondary">Đã lên lịch</span>';
    }

}
