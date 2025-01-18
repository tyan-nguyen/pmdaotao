<?php

use yii\db\Migration;

/**
 * Class m250118_085720_insert_field_table_nv_to
 */
class m250118_085720_insert_field_table_nv_to extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('nv_to','nguoi_tao','integer');
        $this->addColumn('nv_to','thoi_gian_tao','datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('nv_to','nguoi_tao');
        $this->dropColumn('nv_to','thoi_gian_tao');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250118_085720_insert_field_table_nv_to cannot be reverted.\n";

        return false;
    }
    */
}
