<?php

namespace app\modules\demxe\models;
use Yii;
use app\models\PtxXeFileTrichXuatContent;

class FileTrichXuatContent extends PtxXeFileTrichXuatContent
{
    public function rules()
    {
        return [
            [['thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_file', 'camera', 'ma_xe', 'thoi_gian'], 'required'],
            [['id_file', 'nguoi_tao'], 'integer'],
            [['thoi_gian', 'thoi_gian_tao'], 'safe'],
            [['camera', 'ma_xe', 'bien_so_xe'], 'string', 'max' => 50],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => FileTrichXuat::class, 
                'targetAttribute' => ['id_file' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_file' => 'File',
            'camera' => 'Camera',
            'ma_xe' => 'Mã biển số',
            'bien_so_xe' => 'Biển số xe',
            'thoi_gian' => 'Thời gian',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    
    /**
     * beforesave
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::beforeSave()
     */
    public function beforeSave($insert) {
        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(FileTrichXuat::class, ['id' => 'id_file']);
    }
}
