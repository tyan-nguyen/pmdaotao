<?php

use yii\db\Migration;
use app\modules\kholuutru\models\LoaiFile;

/**
 * Class m240917_034238_insert_data_for_loai_file
 */
class m241001_034238_insert_data_for_loai_file_van_ban_di extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function safeUp()
    {
        $model = new LoaiFile();
        $model->id = 3;
        $model->ten_loai = 'File VB';
        $model->ho_so_bat_buoc = 0;
        $model->ghi_chu = 'File văn bản đã ký, vô sổ và scan';
        $model->doi_tuong = 'VBDI';
        $model->nguoi_tao = 1;
        $model->save(false);
        
        $model = new LoaiFile();
        $model->id = 4;
        $model->ten_loai = 'File Đính kèm VB đến';
        $model->ho_so_bat_buoc = 0;
        $model->ghi_chu = 'File đính kèm của văn bản';
        $model->doi_tuong = 'VBDI';
        $model->nguoi_tao = 1;
        $model->save(false);
    }
    
    public function safeDown()
    {
        $model = LoaiFile::findOne(3);
        if($model){
            $model->delete();
        }
        $model = LoaiFile::findOne(4);
        if($model){
            $model->delete();
        }
    }
    
}