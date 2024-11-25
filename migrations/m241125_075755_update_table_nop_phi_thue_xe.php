<?php

use yii\db\Migration;

/**
 * Class m241125_075755_update_table_nop_phi_thue_xe
 */
class m241125_075755_update_table_nop_phi_thue_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('ptx_nop_phi_thue_xe','thoi_gian_tao','datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('ptx_nop_phi_thue_xe','thoi_gian_tao','integer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241125_075755_update_table_nop_phi_thue_xe cannot be reverted.\n";

        return false;
    }
    */
}
