<?php

namespace app\modules\lichhoc\models;   
use Yii;
use app\modules\khoahoc\models\HangDaoTao;

/**
 * This is the model class for table "lh_phan_thi".
 *
 * @property int $id
 * @property string $ten_phan_thi
 * @property int $id_hang
 * @property int $diem_dat_toi_thieu
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int $thu_tu_thi 
 */
class PhanThi extends \app\models\LhPhanThi
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_phan_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_phan_thi', 'id_hang', 'diem_dat_toi_thieu','thu_tu_thi'], 'required'],
            [['diem_dat_toi_thieu', 'nguoi_tao','id_hang','thu_tu_thi'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_phan_thi'], 'string', 'max' => 40],
            [['trang_thai'], 'string', 'max' => 20],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'ten_phan_thi' => 'Tên Phần Thi',
            'id_hang' => 'Phân Hạng',
            'diem_dat_toi_thieu' => 'Điểm Đạt Tối Thiểu',
            'trang_thai' => 'Trạng Thái',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'thu_tu_thi'=>'Thứ Tự Phần Thi',
        ];
    }

    public function beforeSave($insert)
    {        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
            $this->trang_thai = 'Đang áp dụng';
    
           //Đoạn này bình thường 
            $exists = self::find()
                ->where([
                    'id_hang' => $this->id_hang,
                    'thu_tu_thi' => $this->thu_tu_thi
                ])
                ->exists();
            // Vấn đề nằm ở đoạn này, nó cứ laoding hoài  
            if ($exists) {
                $this->addError('thu_tu_thi', 'Vui lòng đặt lại thứ tự phần thi. Đã có phần thi trùng trong hệ thống.');
                return false; 
            }
        } 
        else {
            // Nếu là cập nhật, cần loại trừ chính bản ghi hiện tại khỏi kiểm tra trùng
            $exists = self::find()
                ->where([
                    'id_hang' => $this->id_hang,
                    'thu_tu_thi' => $this->thu_tu_thi
                ])
                ->andWhere(['!=', 'id', $this->id]) // Loại trừ chính bản ghi hiện tại
                ->exists();
    
            if ($exists) {
                $this->addError('thu_tu_thi', 'Vui lòng đặt lại thứ tự phần thi. Đã có phần thi trùng trong hệ thống.');
                return false; 
            }
        }
    
        return parent::beforeSave($insert);
    }
    
    public function getHangDaoTao()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
}
