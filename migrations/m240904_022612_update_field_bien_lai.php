<?php

use yii\db\Migration;

/**
 * Class m240904_022612_update_field_bien_lai
 */
class m240904_022612_update_field_bien_lai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->alterColumn('hv_nop_hoc_phi','bien_lai',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('hv_nop_hoc_phi','bien_lai',$this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240904_022612_update_field_bien_lai cannot be reverted.\n";

        return false;
    }
    */
}
