<?php

use yii\db\Migration;

/**
 * Class m241111_014249_update_type_field_bien_lai
 */
class m241111_014249_update_type_field_bien_lai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->alterColumn('ptx_nop_phi_thue_xe','bien_lai','text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->alterColumn('ptx_nop_phi_theu_xe','bien_lai','string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241111_014249_update_type_field_bien_lai cannot be reverted.\n";

        return false;
    }
    */
}
