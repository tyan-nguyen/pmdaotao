<?php

namespace app\modules\vanban\models\base;
use app\modules\vanban\models\VanBan;

use Yii;

/**
 * This is the model class for table "vb_file_van_ban".
 *
 * @property int $id
 * @property int $id_van_ban
 * @property string $file_name
 * @property string $file_type
 * @property string $file_size
 * @property string $file_display_name
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property VanBan $vanBan
 */
class FileVanBanBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vb_file_van_ban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_van_ban', 'file_name', 'file_type', 'file_size', 'file_display_name'], 'required'],
            [['id_van_ban', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['file_name', 'file_type', 'file_size', 'file_display_name'], 'string', 'max' => 255],
            [['id_van_ban'], 'exist', 'skipOnError' => true, 'targetClass' => VanBan::class, 'targetAttribute' => ['id_van_ban' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_van_ban' => 'Id Van Ban',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'file_display_name' => 'File Display Name',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[VanBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVanBan()
    {
        return $this->hasOne(VanBan::class, ['id' => 'id_van_ban']);
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
