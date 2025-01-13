<?php

use yii\db\Migration;

/**
 * Class m250109_010933_insert_field_lan_thi
 */
class m250109_010933_insert_field_lan_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lh_ket_qua_thi','lan_thi','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('lh_ket_qua_thi','lan_thi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250109_010933_insert_field_lan_thi cannot be reverted.\n";

        return false;
    }
    */
}
