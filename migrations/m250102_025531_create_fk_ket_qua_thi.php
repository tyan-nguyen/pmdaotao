<?php

use yii\db\Migration;

/**
 * Class m250102_025531_create_fk_ket_qua_thi
 */
class m250102_025531_create_fk_ket_qua_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_hoc_vien-ket_qua_thi',
            'lh_ket_qua_thi',
            'id_hoc_vien',
            'hv_hoc_vien',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_phan_thi-ket_qua_thi',
            'lh_ket_qua_thi',
            'id_phan_thi',
            'lh_phan_thi',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_lich_thi-ket_qua_thi',
            'lh_ket_qua_thi',
            'id_lich_thi',
            'lh_lich_thi',
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
           'fk_hoc_vien-ket_qua_thi',
           'lh_ket_qua_thi'
        );

        $this->dropForeignKey(
            'fk_lich_thi-ket_qua_thi',
            'lh_ket_qua_thi'
            );
        $this->dropForeignKey(
            'fk_phan_thi-ket_qua_thi',
            'lh_ket_qua_thi'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250102_025531_create_fk_ket_qua_thi cannot be reverted.\n";

        return false;
    }
    */
}
