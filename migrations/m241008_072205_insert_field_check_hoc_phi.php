<?php

use yii\db\Migration;

/**
 * Class m241008_072205_insert_field_check_hoc_phi
 */
class m241008_072205_insert_field_check_hoc_phi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hv_hoc_vien','check_hoc_phi',$this->string(25));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hv_hoc_vien','check_hoc_phi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241008_072205_insert_field_check_hoc_phi cannot be reverted.\n";

        return false;
    }
    */
}
