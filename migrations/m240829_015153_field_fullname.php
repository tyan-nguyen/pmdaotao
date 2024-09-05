<?php

use yii\db\Migration;

/**
 * Class m240829_015153_field_fullname
 */
class m240829_015153_field_fullname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','fullname', $this->string(55));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('user','fullname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240829_015153_field_fullname cannot be reverted.\n";

        return false;
    }
    */
}
