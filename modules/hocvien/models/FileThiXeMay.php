<?php

namespace app\modules\hocvien\models;

use app\custom\CustomFunc;
use app\models\HvFileThiXeMay;
use Yii;

class FileThiXeMay extends HvFileThiXeMay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_thi', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['ngay_thi', 'thoi_gian_tao'], 'safe'],
            [['da_doc_file_ok'], 'default', 'value' => 0],
            [['ten_khoa_thi', 'filename', 'url'], 'required'],
            [['nguoi_tao', 'da_doc_file_ok'], 'integer'],
            [['ghi_chu'], 'string'],
            [['ten_khoa_thi', 'filename', 'url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ngay_thi' => 'Ngày thi',
            'ten_khoa_thi' => 'Tên khóa thi',
            'filename' => 'Tên file',
            'url' => 'Url',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'ghi_chu' => 'Ghi chú',
            'da_doc_file_ok' => 'Đã kiểm tra file',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $this->ngay_thi = CustomFunc::convertDMYToYMD($this->ngay_thi);
        if ($insert) {
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->nguoi_tao = Yii::$app->user->getId();
        }
        return parent::beforeSave($insert);
    }

    /**
     * xoa file
     */
    private function deleteFile()
    {
        $filePath = Yii::getAlias('@webroot') . '/uploads/thi-xe-may/' . $this->url;
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
     * check co doc file ok chua
     */
    public function daDocFile()
    {
        if ($this->da_doc_file_ok == 1) //da kiem tra ok
            return true;
        else
            return false;
    }

    /**
     * check co import file chua
     */
    public function daImportFile()
    {
        $checkFile = FileThiXeMayContent::findOne(['id_file' => $this->id]);
        if ($checkFile)
            return true;
        else
            return false;
    }

    /**
     * Gets query for [[HvFileThiXeMayContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvFileThiXeMayContents()
    {
        return $this->hasMany(FileThiXeMayContent::class, ['id_file' => 'id']);
    }
}
