<?php

use yii\db\Migration;
use app\modules\kholuutru\models\LoaiFile;
/**
 * Class m250104_014953_insert_data_table_file_loai_file
 */
class m250104_014953_insert_data_table_file_loai_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $model = new LoaiFile();
        $model->id = 115;
        $model->ten_loai = 'Hợp đồng thuê xe';
        $model->ho_so_bat_buoc = 1;
        $model->ghi_chu = 'Hợp đồng thuê xe đã ký, scan';
        $model->doi_tuong = 'PHIEU_TX';
        $model->nguoi_tao = 1;
        $model->save(false);

        
        $model = new LoaiFile();
        $model->id = 116;
        $model->ten_loai = 'Phiếu thu';
        $model->ho_so_bat_buoc = 1;
        $model->ghi_chu = 'Phiếu thu đã ký, scan';
        $model->doi_tuong = 'PHIEU_TX';
        $model->nguoi_tao = 1;
        $model->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
        $model = LoaiFile::findOne(115);
        if($model){
            $model->delete();
        }
        $model = LoaiFile::findOne(116);
        if($model){
            $model->delete();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250104_014953_insert_data_table_file_loai_file cannot be reverted.\n";

        return false;
    }
    */
}
