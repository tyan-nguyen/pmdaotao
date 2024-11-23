<?php

use yii\db\Migration;

/**
 * Class m241123_011103_insert_field_buoi
 */
class m241123_011103_insert_field_buoi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('ptx_phieu_thue_xe','buoi',$this->string(25));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('ptx_phieu_thue_xe','buoi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241123_011103_insert_field_buoi cannot be reverted.\n";

        return false;
    }
    */
}
