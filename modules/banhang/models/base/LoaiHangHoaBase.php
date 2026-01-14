<?php

namespace app\modules\banhang\models\base;

use Yii;
use app\custom\CustomFunc;

/**
 * This is the model class for table "hh_loai_hang_hoa".
 *
 * @property int $id
 * @property string $ten_loai_hang_hoa
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $is_thu_ho
 *
 * @property HhHangHoa[] $hhHangHoas
 */
class LoaiHangHoaBase extends \app\models\BanleLoaiHangHoa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_loai_hang_hoa'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'is_thu_ho'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai_hang_hoa'], 'string', 'max' => 250],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_hang_hoa' => 'Tên loại hàng hóa',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'is_thu_ho' => 'Thu hộ không tính doanh thu'
        ];
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            if($this->is_thu_ho == null)
                $this->is_thu_ho = 0;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[HhHangHoas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHhHangHoas()
    {
        return $this->hasMany(HangHoa::class, ['id_loai_hang_hoa' => 'id']);
    }
}
