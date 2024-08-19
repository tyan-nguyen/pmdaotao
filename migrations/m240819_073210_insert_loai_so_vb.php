<?php

use yii\db\Migration;

/**
 * Class m240819_073210_insert_loai_so_vb
 */
class m240819_073210_insert_loai_so_vb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vb_van_ban','so_loai_van_ban','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vb_van_ban','so_loai_van_ban');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240819_073210_insert_loai_so_vb cannot be reverted.\n";

        return false;
    }
    */
}
