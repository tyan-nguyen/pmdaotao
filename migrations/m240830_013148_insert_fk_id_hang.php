<?php

use yii\db\Migration;

/**
 * Class m240830_013148_insert_fk_id_hang
 */
class m240830_013148_insert_fk_id_hang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-id_hang_hang_dao_tao', 
            'hv_hoc_vien',
            'id_hang', 
            'hv_hang_dao_tao', 
            'id', 
            'CASCADE', 
            'CASCADE' 
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-id_hang_hang_dao_tao', 'hv_hoc_vien');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240830_013148_insert_fk_id_hang cannot be reverted.\n";

        return false;
    }
    */
}
