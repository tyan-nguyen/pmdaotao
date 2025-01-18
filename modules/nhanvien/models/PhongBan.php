<?php

namespace app\modules\nhanvien\models;
use Yii;
use yii\helpers\ArrayHelper;

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
            'ten_phong_ban' => 'Tên Phòng Ban',
            'nguoi_tao' => 'Người Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
        ];
    }

    public static function getList()
    {
        $dsPhongBan = PhongBan::find()
            ->orderBy(['ten_phong_ban' => SORT_ASC])
            ->all();
        return ArrayHelper::map($dsPhongBan, 'id', function($model) {
            return '+ ' . $model->ten_phong_ban;
        });
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    
}
