<?php

use yii\db\Migration;

/**
 * Class m241016_034324_insert
 */
class m241016_034324_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('hv_khoa_hoc','id_hoc_phi','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hv_khoa_hoc','id_hoc_phi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241016_034324_insert cannot be reverted.\n";

        return false;
    }
    */
}
