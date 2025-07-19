<?php

namespace app\modules\banhang\models\base;

use Yii;
use app\custom\CustomFunc;
/**
 * This is the model class for table "hh_dvt".
 *
 * @property int $id
 * @property string $ten_dvt
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property int|null $thoi_gian_tao
 */
class HangHoaDvtBase extends \app\models\BanleDvt
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_dvt'], 'required'],
            [['ten_dvt'], 'unique'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'thoi_gian_tao'], 'integer'],
            [['ten_dvt'], 'string', 'max' => 50],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_dvt' => 'Tên đơn vị tính',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    
}
