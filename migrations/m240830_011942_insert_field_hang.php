<?php

use yii\db\Migration;

/**
 * Class m240830_011942_insert_field_hang
 */
class m240830_011942_insert_field_hang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hv_hoc_vien', 'id_hang', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('hv_hoc_vien','id_hang');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240830_011942_insert_field_hang cannot be reverted.\n";

        return false;
    }
    */
}
