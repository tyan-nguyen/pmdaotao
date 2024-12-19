<?php

namespace app\modules\lichhoc\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "lh_phong_hoc".
 *
 * @property int $id
 * @property string $ten_phong
 * @property string $so_do_phong
 * @property string $ghi_chu
 * @property int $nguoi_tao
 * @property string $thoi_gian_tao
 *
 * @property LhLichHoc[] $lhLichHocs
 */
class PhongHoc extends \app\models\LhPhongHoc
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_phong_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public $file;
    public function rules()
    {
        return [
          
            [['id', 'nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_phong'], 'string', 'max' => 50],
            [['so_do_phong'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['file'], 'file','extensions' => 'png, jpg, jfif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_phong' => 'Tên Phòng',
            'so_do_phong' => 'Sơ đồ phòng',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[LhLichHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLhLichHocs()
    {
        return $this->hasMany(LichHoc::class, ['id_phong' => 'id']);
    }

     
    public static function getList()
    {
        $dsKH = PhongHoc::find()->orderBy(['ten_phong' => SORT_ASC])->all();
        return ArrayHelper::map($dsKH, 'id', function($model) {
            return '+ ' . $model->ten_phong; 
        });
    }

    public function beforeSave($insert)
    {        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
        }
        return parent::beforeSave($insert);
    }
}
