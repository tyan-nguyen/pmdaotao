<?php

use yii\db\Migration;

/**
 * Class m240923_072019_table_chuc_vu
 */
class m240923_072019_table_chuc_vu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('nv_chuc_vu', [
            'id' => $this->primaryKey(),
            'ten_chuc_vu' => $this->string(55)->notNull(),
            'ghi_chu' => $this->text(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('nv_chuc_vu');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240923_072019_table_chuc_vu cannot be reverted.\n";

        return false;
    }
    */
}
