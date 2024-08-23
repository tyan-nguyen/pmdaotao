<?php

use yii\db\Migration;

/**
 * Class m240823_085726_upload
 */
class m240823_085726_upload extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('kho_loai_file', 'doi_tuong', $this->string(20));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('kho_loai_file', 'doi_tuong','integer');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_085726_upload cannot be reverted.\n";

        return false;
    }
    */
}
