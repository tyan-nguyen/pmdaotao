<?php

namespace app\modules\kholuutru\models\base;

use Yii;
use app\modules\kholuutru\models\File;

/**
 * This is the model class for table "kho_file".
 *
 * @property int $id
 * @property int $loai_file
 * @property string|null $file_name
 * @property string|null $file_type
 * @property string|null $file_size
 * @property string $file_display_name
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $doi_tuong
 * @property int $id_doi_tuong
 * @property string|null $ghi_chu
 *
 * @property KhoLoaiFile $loaiFile
 */
class FileBase extends \app\models\KhoFile
{
    CONST FOLDER_DOCUMENTS = '/uploads/vanban/';
    CONST FOLDER_ICONS = '/libs/images/icons/';
    public $file; //sử dụng trong form
    
    public static function getFolderRootDocument(){
        //return Yii::getAlias('@webroot') . '\\uploads\\vanban\\';
        return Yii::getAlias('@webroot') . FileBase::FOLDER_DOCUMENTS;
    }
    /**
     * kho file save name
     */
    public function getFileSaveName(){
        return $this->id . '.' . $this->file_type;
    }   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_display_name', 'id_doi_tuong'], 'required'],
            [['loai_file', 'nguoi_tao', 'id_doi_tuong'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['file_name', 'file_type', 'file_size', 'file_display_name'], 'string', 'max' => 255],
            [['doi_tuong'], 'string', 'max' => 20],
            [['file'], 'file'],
            [['loai_file'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiFileBase::class, 'targetAttribute' => ['loai_file' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_file' => 'Loại file',
            'file_name' => 'Tên file',
            'file_type' => 'Loại tệp',
            'file_size' => 'Dung lượng',
            'file_display_name' => 'Tên hiển thị',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'doi_tuong' => 'Đối tượng', //<vanban/hocvien..>
            'id_doi_tuong' => 'ID đối tượng tham chiếu', //id từ table van_ban, hoc_vien...
            'ghi_chu' => 'Ghi chú',
            'file' => 'Tệp tin'
        ];
    }
    
    /**
     * xoa file QR code
     */
    private function deleteFile()
    {
        $filePath = $this::getFolderRootDocument() . $this->getFileSaveName();
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    /**
     * xoa tat ca file tham chieu
     */
    public static function deleteFileThamChieu($doiTuong, $idDoiTuong){
        $files = File::findAll(['doi_tuong'=>$doiTuong, 'id_doi_tuong'=>$idDoiTuong]);
        if($files){
            foreach ($files as $file){
                $file->delete();
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
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
}