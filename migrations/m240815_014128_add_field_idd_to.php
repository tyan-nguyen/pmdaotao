<?php

use yii\db\Migration;

/**
 * Class m240815_014128_add_field_id_to
 */
class m240815_014128_add_field_idd_to extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        $this->addForeignKey(
            'fk-id_to_nv',
            'nv_nhan_vien',
            'id_to',
            'nv_to',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-id_to_nv',
            'nv_nhan_vien'
        );
     
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240815_014128_add_field_to cannot be reverted.\n";

        return false;
    }
    */
}
