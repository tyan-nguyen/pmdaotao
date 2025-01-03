<?php

use yii\db\Migration;

/**
 * Class m250103_031313_create_fk_phan_thi
 */
class m250103_031313_create_fk_phan_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_hang-phan_thi',
            'lh_phan_thi',
            'id_hang',
            'hv_hang_dao_tao',
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
            'fk_hang-phan_thi',
            'lh_phan_thi'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250103_031313_create_fk_phan_thi cannot be reverted.\n";

        return false;
    }
    */
}
