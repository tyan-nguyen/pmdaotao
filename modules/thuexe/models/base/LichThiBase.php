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
    CONST PHANLOAI_KIEMTRA = 'KIEMTRA';
    
    /**
     * Danh muc loai hoc vien
     * @return string[]
     */
    public static function getDmLoai(){
        return [
            self::PHANLOAI_THI => 'Thi sát hạch',
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

}
