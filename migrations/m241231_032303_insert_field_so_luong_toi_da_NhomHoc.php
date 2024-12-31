<?php

use yii\db\Migration;

/**
 * Class m241231_032303_insert_field_so_luong_toi_da_NhomHoc
 */
class m241231_032303_insert_field_so_luong_toi_da_NhomHoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hv_nhom','so_luong_hoc_vien','int');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hv_nhom','so_luong_hoc_vien');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241231_032303_insert_field_so_luong_toi_da_NhomHoc cannot be reverted.\n";

        return false;
    }
    */
}
