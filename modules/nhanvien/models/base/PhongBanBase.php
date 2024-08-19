<?php

namespace app\modules\nhanvien\models\base;
use Yii;


/**
 * This is the model class for table "nv_phong_ban".
 *
 * @property int $id
 * @property string $ten_phong_ban
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 */
class PhongBanBase extends \yii\db\ActiveRecord
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
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
               

                $this->nguoi_tao = Yii::$app->user->identity->id; 
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
}
