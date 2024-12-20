<?php

use yii\db\Migration;

/**
 * Class m241220_021245_insert_field_id_nhom
 */
class m241220_021245_insert_field_id_nhom extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('hv_hoc_vien','id_nhom','integer');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('hv_hoc_vien','id_nhom');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241220_021245_insert_field_id_nhom cannot be reverted.\n";

        return false;
    }
    */
}
