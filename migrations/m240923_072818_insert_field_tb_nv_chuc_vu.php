<?php

use yii\db\Migration;

/**
 * Class m240923_072818_insert_field_tb_nv_chuc_vu
 */
class m240923_072818_insert_field_tb_nv_chuc_vu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('nv_chuc_vu','nguoi_tao','integer');
       $this->addColumn('nv_chuc_vu','thoi_gian_tao',$this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('nv_chuc_vu','nguoi_tao');
        $this->dropColumn('nv_chuc_vu','thoi_gian_tao');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240923_072818_insert_field_tb_nv_chuc_vu cannot be reverted.\n";

        return false;
    }
    */
}
