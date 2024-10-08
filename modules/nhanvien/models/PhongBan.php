<?php

namespace app\modules\nhanvien\models;
use Yii;


/**
 * This is the model class for table "nv_phong_ban".
 *
 * @property int $id
 * @property string $ten_phong_ban
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 */
class PhongBan extends \app\models\NvPhongBan
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_phong_ban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_phong_ban'], 'required'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_phong_ban'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_phong_ban' => 'Ten Phong Ban',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }
    
    
}
