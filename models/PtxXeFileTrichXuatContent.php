<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_file_trich_xuat_content".
 *
 * @property int $id
 * @property int $id_file
 * @property string $camera
 * @property string $ma_xe
 * @property string $bien_so_xe
 * @property string $thoi_gian
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property PtxXeFileTrichXuat $file
 */
class PtxXeFileTrichXuatContent extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_file_trich_xuat_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_file', 'camera', 'ma_xe', 'thoi_gian'], 'required'],
            [['id_file', 'nguoi_tao'], 'integer'],
            [['thoi_gian', 'thoi_gian_tao'], 'safe'],
            [['camera', 'ma_xe', 'bien_so_xe'], 'string', 'max' => 50],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXeFileTrichXuat::class, 'targetAttribute' => ['id_file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_file' => 'Id File',
            'camera' => 'Camera',
            'ma_xe' => 'Ma Xe',
            'bien_so_xe' => 'Bien so xe',
            'thoi_gian' => 'Thoi Gian',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(PtxXeFileTrichXuat::class, ['id' => 'id_file']);
    }

}
