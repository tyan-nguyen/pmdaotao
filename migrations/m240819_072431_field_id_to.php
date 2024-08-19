<?php

use yii\db\Migration;

/**
 * Class m240819_072431_field_id_to
 */
class m240819_072431_field_id_to extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('nv_nhan_vien','id_to','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this-> dropColumn('nv_nhan_vien','id_to','integer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240819_072431_field_id_to cannot be reverted.\n";

        return false;
    }
    */
}
