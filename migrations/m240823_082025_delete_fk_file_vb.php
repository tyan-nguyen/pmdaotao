<?php

use yii\db\Migration;

/**
 * Class m240823_082025_delete_fk_file_vb
 */
class m240823_082025_delete_fk_file_vb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-id_van_ban_van_ban', 'vb_file_van_ban');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       // Phục hồi lại khóa ngoại
       $this->addForeignKey(
        'fk-id_van_ban_van_ban', 
        'vb_file_van_ban',
        'id_van_ban', 
        'vb_van_ban', 
        'id', 
        'CASCADE', 
        'CASCADE' 
    );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_082025_delete_fk_file_vb cannot be reverted.\n";

        return false;
    }
    */
}
