<?php

use yii\db\Migration;

/**
 * Class m240820_021612_update_table_kho_ho_so
 */
class m240820_021612_updated_table_kho_ho_so extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Xóa khóa ngoại (foreign key) trước
    $this->dropForeignKey('fk-id_loai_ho_so_loai_ho_so', 'kho_ho_so');
        // Xóa cột id_nhan_vien trong bảng kho_ho_so
    $this->dropColumn('kho_ho_so', 'id_nhan_vien');
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
        // Thêm lại cột id_nhan_vien
    $this->addColumn('kho_ho_so', 'id_nhan_vien', $this->integer());
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
        echo "m240820_021612_update_table_kho_ho_so cannot be reverted.\n";

        return false;
    }
    */
}
