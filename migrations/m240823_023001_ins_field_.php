<?php

use yii\db\Migration;

/**
 * Class m240823_023001_ins_field_
 */
class m240823_023001_ins_field_ extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('nv_nhan_vien','doi_tuong','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('nv_nhan_vien','doi_tuong');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_023001_ins_field_ cannot be reverted.\n";

        return false;
    }
    */
}
