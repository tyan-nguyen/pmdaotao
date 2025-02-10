<?php

use yii\db\Migration;

/**
 * Class m250210_021617_insert_field_table_lh_lich_thi
 */
class m250210_021617_insert_field_table_lh_lich_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lh_lich_thi','ten_ky_thi',$this->string(50));
        $this->addColumn('lh_lich_thi','loai_lich_thi',$this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lh_lich_thi','ten_ky_thi');
        $this->dropColumn('lh_lich_thi','loai_lich_thi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250210_021617_insert_field_table_lh_lich_thi cannot be reverted.\n";

        return false;
    }
    */
}
