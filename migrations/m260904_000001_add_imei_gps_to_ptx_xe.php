<?php

use yii\db\Migration;

/**
 * Class m260904_000001_add_imei_gps_to_ptx_xe
 */
class m260904_000001_add_imei_gps_to_ptx_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema('ptx_xe');
        if ($tableSchema && $tableSchema->getColumn('imei_gps') === null) {
            $this->addColumn('ptx_xe', 'imei_gps', $this->string(20)->null()->comment('Số IMEI thiết bị định vị GPS'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema('ptx_xe');
        if ($tableSchema && $tableSchema->getColumn('imei_gps') !== null) {
            $this->dropColumn('ptx_xe', 'imei_gps');
        }
    }
}
