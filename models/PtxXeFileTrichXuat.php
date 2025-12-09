<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_file_trich_xuat".
 *
 * @property int $id
 * @property string|null $thoi_gian_tu
 * @property string|null $thoi_gian_den
 * @property string $filename
 * @property string $url
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 *
 * @property PtxXeDemXe[] $ptxXeDemXes
 * @property PtxXeFileTrichXuatContent[] $ptxXeFileTrichXuatContents
 */
class PtxXeFileTrichXuat extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_file_trich_xuat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thoi_gian_tu', 'thoi_gian_den', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['thoi_gian_tu', 'thoi_gian_den', 'thoi_gian_tao'], 'safe'],
            [['filename', 'url'], 'required'],
            [['nguoi_tao'], 'integer'],
            [['ghi_chu'], 'string'],
            [['filename', 'url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thoi_gian_tu' => 'Thoi Gian Tu',
            'thoi_gian_den' => 'Thoi Gian Den',
            'filename' => 'Filename',
            'url' => 'Url',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

    /**
     * Gets query for [[PtxXeDemXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxXeDemXes()
    {
        return $this->hasMany(PtxXeDemXe::class, ['id_file_trich_xuat' => 'id']);
    }

    /**
     * Gets query for [[PtxXeFileTrichXuatContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxXeFileTrichXuatContents()
    {
        return $this->hasMany(PtxXeFileTrichXuatContent::class, ['id_file' => 'id']);
    }

}
