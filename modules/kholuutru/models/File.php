<?php
namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\FileBase;
use app\modules\vanban\models\VanBanDen;
use app\modules\user\models\User;

class File extends FileBase{
    /**
     * Gets query for [[LoaiFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiFile()
    {
        return $this->hasOne(LoaiFile::class, ['id' => 'loai_file']);
    }
    /**
     * Gets query for [[TaiKhoan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiKhoan()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
    /**
     * get model theo loại đối tượng
     * @param string $doituong
     * @param int $idDoiTuong
     */
    public static function getModelByDoiTuong($doiTuong, $idDoiTuong){
        $model = null;
        if($doiTuong == VanBanDen::MODEL_ID){
            $model = VanBanDen::findOne($idDoiTuong);
        }
        //.............
        return $model;        
    }
    public static function getFileSizeInString($size){
        if($size/1024 < 0){
            return round($size/1024,2) . ' KB';
        } if($size/1024 > 0 && $size/1024 <=102.4 ){
            return round($size/1024,1) . ' KB';
        }else {
            return round($size/1024/1024,2) . ' MB';
        }
    }
    /**
     * get icon for file
     * @param string file type: pdf/docx...
     */
    public static function getIcon($icon){
        if(strtoupper($icon) == 'PDF')
            return File::FOLDER_ICONS . 'pdf.png';
        else if(strtoupper($icon) == 'DOCX')
            return File::FOLDER_ICONS . 'docx.png';
        else if(strtoupper($icon) == 'PNG')
            return File::FOLDER_ICONS . 'docx.png';
        else 
            return File::FOLDER_ICONS . 'none.png';
    }
     
    /**
     * lấy tất cả file của đối tượng
     * @param string $doiTuong
     * @param int $idDoiTuong
     */
    public static function getAllByDoiTuong($doiTuong, $idDoiTuong){
        return File::find()->where([
            'doi_tuong' => $doiTuong,
            'id_doi_tuong' => $idDoiTuong
        ])->all();
    }
    /**
     * lấy 1 file của đối tượng
     * @param string $doiTuong
     * @param int $idDoiTuong
     */
    public static function getOneByDoiTuong($doiTuong, $idDoiTuong){
        return File::find()->where([
            'doi_tuong' => $doiTuong,
            'id_doi_tuong' => $idDoiTuong
        ])->one();
    }
    /**
     * lấy tất cả file của đối tượng và loại file
     * @param $loaiFile : id lấy từ bảng file_loai_file
     * @param string $doiTuong
     * @param int $idDoiTuong
     */
    public static function getAllByLoaiFile($loaiFile, $doiTuong, $idDoiTuong){
        return File::find()->where([
            'loai_file' => $loaiFile,
            'doi_tuong' => $doiTuong,
            'id_doi_tuong' => $idDoiTuong
        ])->all();
    }
    /**
     * lấy 1 file của đối tượng
     * @param $loaiFile : id lấy từ bảng file_loai_file
     * @param string $doiTuong
     * @param int $idDoiTuong
     */
    public static function getOneByLoaiFile($loaiFile, $doiTuong, $idDoiTuong){
        return File::find()->where([
            'loai_file' => $loaiFile,
            'doi_tuong' => $doiTuong,
            'id_doi_tuong' => $idDoiTuong
        ])->one();
    }
}