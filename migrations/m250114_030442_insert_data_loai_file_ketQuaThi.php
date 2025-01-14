<?php

use yii\db\Migration;
use app\modules\kholuutru\models\LoaiFile;

/**
 * Class m250114_030442_insert_data_loai_file_ketQuaThi
 */
class m250114_030442_insert_data_loai_file_ketQuaThi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new LoaiFile();
        $model->id = 117;
        $model->ten_loai = 'Giấy phép lái xe';
        $model->ho_so_bat_buoc = 0;
        $model->ghi_chu = 'Giấy phép lái xe học viên đã scan lưu trữ';
        $model->doi_tuong = 'GIAY_PHEP_LX';
        $model->nguoi_tao = 1;
        $model->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $model = LoaiFile::findOne(117);
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
        echo "m250114_030442_insert_data_loai_file_ketQuaThi cannot be reverted.\n";

        return false;
    }
    */
}
