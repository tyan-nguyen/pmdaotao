<?php

use yii\db\Migration;

/**
 * Class m240821_145941_delete_fk_kho_hs
 */
class m240821_145941_delete_fk_kho_hs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      // Xóa khóa ngoại (foreign key) trước
      $this->dropForeignKey('fk-id_nhan_vien_hs_nhan_vien', 'kho_ho_so');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
            // Phục hồi lại khóa ngoại
            $this->addForeignKey(
                'fk-id_nhan_vien_hs_nhan_vien', 
                'kho_ho_so',
                'id_nhan_vien', 
                'nv_nhan_vien', 
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
        echo "m240821_145941_delete_fk_kho_hs cannot be reverted.\n";

        return false;
    }
    */
}
