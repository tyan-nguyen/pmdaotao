<?php

use yii\db\Migration;

/**
 * Class m241125_031510_insert_fk_ptx_hinh_xe
 */
class m241125_031510_insert_fk_ptx_hinh_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-id_xe_hinh_xe',
            'ptx_hinh_xe',
            'id_xe',
            'ptx_xe',
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
            'fk-id_xe_hinh_xe',
            'ptx_hinh_xe'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241125_031510_insert_fk_ptx_hinh_xe cannot be reverted.\n";

        return false;
    }
    */
}
