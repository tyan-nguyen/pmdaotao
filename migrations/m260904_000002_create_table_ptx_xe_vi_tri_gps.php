<?php

use yii\db\Migration;

/**
 * Class m260904_000002_create_table_ptx_xe_vi_tri_gps
 */
class m260904_000002_create_table_ptx_xe_vi_tri_gps extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema('ptx_xe_vi_tri_gps');
        if ($tableSchema === null) {
            $this->createTable('ptx_xe_vi_tri_gps', [
                'id' => $this->primaryKey(),
                'id_xe' => $this->integer()->notNull()->comment('ID xe trong ptx_xe'),
                'imei' => $this->string(20)->notNull()->comment('Mã IMEI thiết bị GPS'),
                'latitude' => $this->decimal(11, 8)->notNull()->comment('Vĩ độ'),
                'longitude' => $this->decimal(11, 8)->notNull()->comment('Kinh độ'),
                'speed' => $this->float()->defaultValue(0)->comment('Tốc độ km/h'),
                'rotation' => $this->float()->defaultValue(0)->comment('Góc quay/hướng di chuyển'),
                'acc' => $this->tinyInteger(1)->defaultValue(0)->comment('Khóa điện/động cơ: 1=bật, 0=tắt'),
                'status' => $this->integer()->null()->comment('Trạng thái xe từ MID'),
                'status_device' => $this->integer()->null()->comment('Trạng thái thiết bị từ MID'),
                'signal_quality' => $this->integer()->null()->comment('Chất lượng sóng vệ tinh/GSM'),
                'fuel_lit' => $this->float()->null()->comment('Nhiên liệu (lít)'),
                'fuel_percent' => $this->float()->null()->comment('% Nhiên liệu'),
                'time_record' => $this->dateTime()->null()->comment('Thời gian thiết bị GPS ghi nhận'),
                'thoi_gian_tao' => $this->dateTime()->notNull()->comment('Thời gian hệ thống lưu dữ liệu'),
                'du_lieu_json' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->null()->comment('JSON thô trả về từ MID API'),
            ]);

            $this->createIndex('idx-ptx_xe_vi_tri_gps-id_xe', 'ptx_xe_vi_tri_gps', 'id_xe');
            $this->createIndex('idx-ptx_xe_vi_tri_gps-imei', 'ptx_xe_vi_tri_gps', 'imei');
            $this->createIndex('idx-ptx_xe_vi_tri_gps-thoi_gian_tao', 'ptx_xe_vi_tri_gps', 'thoi_gian_tao');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema('ptx_xe_vi_tri_gps');
        if ($tableSchema !== null) {
            $this->dropTable('ptx_xe_vi_tri_gps');
        }
    }
}
