<?php
namespace app\modules\demxe\models;
use Yii;
use app\models\PtxXeFileTrichXuat;

class FileTrichXuat extends PtxXeFileTrichXuat{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thoi_gian_tu' => 'Thời gian từ',
            'thoi_gian_den' => 'Thời gian đến',
            'filename' => 'File name',
            'url' => 'Url',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'ghi_chu' => 'Ghi chú',
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
     * xoa file QR code
     */
    private function deleteFile()
    {
        $filePath = Yii::getAlias('@webroot') . '/uploads/dem-xe/' . $this->url;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    /**
     * {@inheritdoc}
     * xoa file anh, tai lieu, lich su sau khi xoa du lieu
     */
    public function afterDelete()
    {
        //xoa file
        $this->deleteFile();
        
        return parent::afterDelete();
    }
    /**
     * check co doc file chua
     */
    public function daDocFile(){
        $checkFile = FileTrichXuatContent::findOne(['id_file'=>$this->id]);
        if($checkFile)
            return true;
        else 
            return false;
    }
    /**
     * check co import file chua
     */
    public function daImportFile(){
        $checkFile = DemXe::findOne(['id_file'=>$this->id]);
        if($checkFile)
            return true;
            else
                return false;
    }
    
    
}