<?php

use yii\db\Migration;

/**
 * Class m241227_031311_insert_field_check_hang
 */
class m241227_031311_insert_field_check_hang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('hv_hang_dao_tao','check_phan_hang',$this->string(15));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hv_hang_dao_tao','check_phan_hang');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241227_031311_insert_field_check_hang cannot be reverted.\n";

        return false;
    }
    */
}
