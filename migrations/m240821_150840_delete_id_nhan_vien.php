<?php

use yii\db\Migration;

/**
 * Class m240821_150840_delete_id_nhan_vien
 */
class m240821_150840_delete_id_nhan_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         // Xóa cột id_nhan_vien trong bảng kho_ho_so
        $this->dropColumn('kho_ho_so', 'id_nhan_vien');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         // Thêm lại cột id_nhan_vien
        $this->addColumn('kho_ho_so', 'id_nhan_vien', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240821_150840_delete_id_nhan_vien cannot be reverted.\n";

        return false;
    }
    */
}
