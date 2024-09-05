<?php

use yii\db\Migration;

/**
 * Class m240830_023719_update_id_khoa_hoc
 */
class m240830_023719_update_id_khoa_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('hv_hoc_vien', 'id_khoa_hoc', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('hv_hoc_vien', 'id_khoa_hoc', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240830_023719_update_id_khoa_hoc cannot be reverted.\n";

        return false;
    }
    */
}
