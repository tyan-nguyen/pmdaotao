<?php
namespace app\modules\kholuutru\models;

use app\modules\kholuutru\models\base\FileBase;

class File extends FileBase{
    CONST FOLDER_ICONS = '/libs/images/icons/';
    /**
     * get icon for file
     * @param string file type: pdf/docx...
     */
    public static function getIcon($icon){
        if(strtoupper($icon) == 'PDF')
            return File::FOLDER_ICONS . 'pdf.png';
        else if(strtoupper($icon) == 'DOCX')
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