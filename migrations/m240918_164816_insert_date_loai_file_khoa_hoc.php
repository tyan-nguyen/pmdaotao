<?php

use yii\db\Migration;
use app\modules\kholuutru\models\LoaiFile;
/**
 * Class m240918_164816_insert_date_loai_file_khoa_hoc
 */
class m240918_164816_insert_date_loai_file_khoa_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new LoaiFile();
        $model->id = 11;
        $model->ten_loai = 'File_KH';
        $model->ho_so_bat_buoc = 0;
        $model->ghi_chu = 'File Tài liệu khóa học';
        $model->doi_tuong = 'KHOAHOC';
        $model->nguoi_tao = 1;
        $model->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $model = LoaiFile::findOne(11);
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
        echo "m240918_164816_insert_date_loai_file_khoa_hoc cannot be reverted.\n";

        return false;
    }
    */
}
