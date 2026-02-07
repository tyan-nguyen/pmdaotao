<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_dem_xe".
 *
 * @property int $id
 * @property int|null $id_xe
 * @property string $ma_xe
 * @property string|null $bien_so_xe
 * @property string|null $ma_cong
 * @property string|null $thoi_gian_bd
 * @property string|null $thoi_gian_kt
 * @property float|null $so_gio
 * @property string|null $so_phut
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $id_file
 * @property string|null $ghi_chu
 * @property int|null $id_start
 * @property int|null $id_end
 *
 * @property PtxXeFileTrichXuat $file
 */
class PtxXeDemXe extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_dem_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_xe', 'bien_so_xe', 'ma_cong', 'thoi_gian_bd', 'thoi_gian_kt', 'so_gio', 'so_phut', 'nguoi_tao', 'thoi_gian_tao', 'id_file', 'ghi_chu', 'id_start', 'id_end'], 'default', 'value' => null],
            [['id_xe', 'nguoi_tao', 'id_file', 'id_start', 'id_end'], 'integer'],
            [['ma_xe'], 'required'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'thoi_gian_tao'], 'safe'],
            [['so_gio'], 'number'],
            [['ghi_chu'], 'string'],
            [['ma_xe', 'bien_so_xe', 'so_phut'], 'string', 'max' => 50],
            [['ma_cong'], 'string', 'max' => 20],
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
            'id_xe' => 'Id Xe',
            'ma_xe' => 'Ma Xe',
            'bien_so_xe' => 'Bien So Xe',
            'ma_cong' => 'Ma Cong',
            'thoi_gian_bd' => 'Thoi Gian Bd',
            'thoi_gian_kt' => 'Thoi Gian Kt',
            'so_gio' => 'So Gio',
            'so_phut' => 'So Phut',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'id_file' => 'Id File',
            'ghi_chu' => 'Ghi Chu',
            'id_start' => 'Id Start',
            'id_end' => 'Id End',
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
