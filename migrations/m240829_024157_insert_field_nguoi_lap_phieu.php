<?php

use yii\db\Migration;

/**
 * Class m240829_024157_insert_field_lap_phieu
 */
class m240829_024157_insert_field_nguoi_lap_phieu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('hv_hoc_vien','nguoi_lap_phieu',$this->string(55));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('hv_hoc_vien','nguoi_lap_phieu');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240829_024157_insert_field_lap_phieu cannot be reverted.\n";

        return false;
    }
    */
}
