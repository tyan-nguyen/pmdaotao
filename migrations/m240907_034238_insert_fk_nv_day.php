<?php

use yii\db\Migration;

/**
 * Class m240907_034238_insert_fk_nv_day
 */
class m240907_034238_insert_fk_nv_day extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-id_hang_xe_hang_xe',
            'nv_day',
            'id_hang_xe',
            'hv_hang_dao_tao',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-id_hang_xe_hang_xe','nv_day');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240907_034238_insert_fk_nv_day cannot be reverted.\n";

        return false;
    }
    */
}
