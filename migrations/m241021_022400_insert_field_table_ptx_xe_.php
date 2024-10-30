<?php

use yii\db\Migration;

/**
 * Class m241021_022400_insert_field_table_ptx_xe_
 */
class m241021_022400_insert_field_table_ptx_xe_ extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('ptx_xe','nguoi_tao','integer');
       $this->addColumn('ptx_xe','thoi_gian_tao','datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ptx_xe','nguoi_tao');
        $this->dropColumn('ptx_xe','thoi_gian_tao');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_022400_insert_field_table_ptx_xe_ cannot be reverted.\n";

        return false;
    }
    */
}
