<?php

use yii\db\Migration;

/**
 * Class m240814_010353_upload_fk_nhan_vien
 */
class m240814_010353_upload_fk_nhan_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-id_phong_ban_nv',
            'nv_nhan_vien',
            'id_phong_ban',
            'nv_phong_ban',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-id_phong_ban_nv',
            'nhan_vien'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240814_010353_upload_fk_nhan_vien cannot be reverted.\n";

        return false;
    }
    */
}
