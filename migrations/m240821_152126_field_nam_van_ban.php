<?php

use yii\db\Migration;

/**
 * Class m240821_152126_field_nam_vb
 */
class m240821_152126_field_nam_van_ban extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vb_van_ban','nam','YEAR');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('vb_van_ban','nam');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240821_152126_field_nam_vb cannot be reverted.\n";

        return false;
    }
    */
}
