<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_hinh_anh".
 *
 * @property int $id
 * @property string $loai KEHOACH,LICHDUNGXE
 * @property int $id_giao_vien
 * @property string $date
 * @property string $file_name
 * @property int $file_size
 * @property string $extension
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class GdHinhAnh extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_hinh_anh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['loai', 'id_giao_vien', 'date', 'file_name', 'file_size', 'extension'], 'required'],
            [['id_giao_vien', 'file_size', 'nguoi_tao'], 'integer'],
            [['date', 'thoi_gian_tao'], 'safe'],
            [['loai', 'extension'], 'string', 'max' => 20],
            [['file_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai' => 'Loai',
            'id_giao_vien' => 'Id Giao Vien',
            'date' => 'Date',
            'file_name' => 'File Name',
            'file_size' => 'File Size',
            'extension' => 'Extension',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

}
