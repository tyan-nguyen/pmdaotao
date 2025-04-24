<?php

use yii\db\Migration;

/**
 * Class m240821_151135_insert_field_doi_tuong
 */
class m250330_000001_insert_field_ho_ten_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          // Thêm cột doi_tuong trong bảng kho_ho_so
    $this->addColumn('user', 'ho_ten', $this->string()->null()->comment('Họ tên của nhân viên'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       // Xóa các cột đã thêm
    $this->dropColumn('user', 'ho_ten');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240821_151135_insert_field_doi_tuong cannot be reverted.\n";

        return false;
    }
    */
}
