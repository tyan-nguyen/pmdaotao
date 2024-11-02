<?php

use yii\db\Migration;

/**
 * Class m241101_020802_insert_filed_trang_thai
 */
class m241101_020802_insert_filed_trang_thai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('ptx_nop_phi_thue_xe',' trang_thai',$this->string(25));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('ptx_nop_phi_thue_xe','trang_thai');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241101_020802_insert_filed_trang_thai cannot be reverted.\n";

        return false;
    }
    */
}
