<?php

use yii\db\Migration;

/**
 * Class m240821_151135_insert_field_doi_tuong
 */
class m240821_151135_insert_field_doi_tuong extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          // Thêm cột doi_tuong trong bảng kho_ho_so
    $this->addColumn('kho_ho_so', 'doi_tuong', $this->string()->notNull()->comment('1: Nhân viên, 2: Giáo viên, 3: Học viên'));

    // Thêm cột id_doi_tuong trong bảng kho_ho_so
     $this->addColumn('kho_ho_so', 'id_doi_tuong', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       // Xóa các cột đã thêm
    $this->dropColumn('kho_ho_so', 'doi_tuong');
    $this->dropColumn('kho_ho_so', 'id_doi_tuong');
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
