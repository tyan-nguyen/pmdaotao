<?php

namespace app\modules\khoahoc\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hv_nhom".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property string $ten_nhom
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int $so_luong_hoc_vien
 * @property HvKhoaHoc $khoaHoc
 */
class NhomHoc extends \app\models\HvNhom
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_nhom';
    }

    /**
     * {@inheritdoc}
     */
    public $so_luong_hoc_vien = 5;
    public function rules()
    {
        return [
            [['id_khoa_hoc', 'ten_nhom','so_luong_hoc_vien'], 'required'],
            [['id_khoa_hoc', 'nguoi_tao','so_luong_hoc_vien'], 'integer'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_nhom'], 'string', 'max' => 50],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khoa_hoc' => 'Khóa Học',
            'ten_nhom' => 'Tên Nhóm',
            'ghi_chu' => 'Ghi Chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'so_luong_hoc_vien'=>'Số lượng học viên',
        ];
    }

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }

    public static function getList($idKhoaHoc)
    {
        $query = self::find()->where(['id_khoa_hoc' => $idKhoaHoc]);
        $list = $query->all();
        $options = [null => 'Chung'];  
        foreach ($list as $item) {
            $options[$item->id] = $item->ten_nhom;
        } 
        return $options;
    }
    
    
    public static function getListNhom()
    {
        $dsNhom = NhomHoc::find()
            ->orderBy(['ten_nhom' => SORT_ASC])
            ->all();
        return ArrayHelper::map($dsNhom, 'id', function($model) {
            return '+ ' . $model->ten_nhom; 
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
