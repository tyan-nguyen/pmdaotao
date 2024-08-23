<?php

use yii\db\Migration;

/**
 * Class m240823_090110_update_kho_file
 */
class m240823_090110_update_kho_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('kho_file', 'doi_tuong', $this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('kho_file', 'doi_tuong', 'string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_090110_update_kho_file cannot be reverted.\n";

        return false;
    }
    */
}
