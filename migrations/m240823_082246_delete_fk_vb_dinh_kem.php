<?php

use yii\db\Migration;

/**
 * Class m240823_082246_delete_fk_vb_dinh_kem
 */
class m240823_082246_delete_fk_vb_dinh_kem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          // Xóa khóa ngoại bảng van_ban_dinh_kem
          $this->dropForeignKey('fk-id_van_ban_dk_van_ban', 'vb_vb_dinh_kem');
          // Xóa khóa ngoại bảng van_ban_dinh_kem
      $this->dropForeignKey('fk-id_van_ban_dk_van_ban_dk', 'vb_vb_dinh_kem');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey(
            'fk-id_van_ban_dk_van_ban', 
            'vb_vb_dinh_kem',
            'id_van_ban', 
            'vb_van_ban', 
            'id', 
            'CASCADE', 
            'CASCADE' 
        );
        $this->addForeignKey(
            'fk-id_van_ban_dk_van_ban_dk', 
            'vb_vb_dinh_kem',
            'id_van_ban_dinh_kem', 
            'vb_vb_dinh_kem', 
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
        echo "m240823_082246_delete_fk_vb_dinh_kem cannot be reverted.\n";

        return false;
    }
    */
}
