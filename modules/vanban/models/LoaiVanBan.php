<?php

namespace app\modules\vanban\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dm_loai_van_ban".
 *
 * @property int $id
 * @property string $ten_loai
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property VanBan[] $vanBans
 */
class LoaiVanBan extends \app\models\VbDmLoaiVanBan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai' => 'Ten Loai',
            'ghi_chu' => 'Ghi Chu',
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
        }
        return true;
    }
    
    /**
     * lấy danh sách loại văn bản để fill dropdownlist
     * @return array
     */
    public static function getList(){
        $dsLoaiVanBan = LoaiVanBan::find()->all();
        return ArrayHelper::map($dsLoaiVanBan, 'id', 'ten_loai');
    }
    
    /**
     * Gets query for [[VanBans]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getVanBans()
    // {
    //      return $this->hasMany(VanBan::class, ['id_loai_van_ban' => 'id']);
    //  }
}
