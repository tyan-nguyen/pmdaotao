<?php

use yii\db\Migration;

/**
 * Class m260905_000001_create_table_ptx_xe_vung_gioi_han
 */
class m260905_000001_create_table_ptx_xe_vung_gioi_han extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema('ptx_xe_vung_gioi_han');
        if ($tableSchema === null) {
            $this->createTable('ptx_xe_vung_gioi_han', [
                'id' => $this->primaryKey(),
                'ten_vung' => $this->string(255)->notNull()->comment('Tên vùng giới hạn / cơ sở'),
                'loai_vung' => $this->string(50)->notNull()->defaultValue('KHUON_VIEN')->comment('Loại vùng: KHUON_VIEN, SAN_TAP, BAI_XE, KHAC'),
                'toa_do_polygon' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->notNull()->comment('Mảng JSON các đỉnh đa giác [[lat, lng], ...]'),
                'mau_sac' => $this->string(20)->defaultValue('#2563eb')->comment('Mã màu viền/nền đa giác'),
                'trang_thai' => $this->tinyInteger(1)->defaultValue(1)->comment('1: Đang áp dụng/Hoạt động, 0: Ngưng'),
                'ghi_chu' => $this->text()->null()->comment('Ghi chú mô tả'),
                'thoi_gian_tao' => $this->dateTime()->notNull()->comment('Thời gian tạo'),
                'thoi_gian_cap_nhat' => $this->dateTime()->null()->comment('Thời gian cập nhật gần nhất'),
            ]);

            $this->createIndex('idx-ptx_xe_vung_gioi_han-trang_thai', 'ptx_xe_vung_gioi_han', 'trang_thai');
            $this->createIndex('idx-ptx_xe_vung_gioi_han-loai_vung', 'ptx_xe_vung_gioi_han', 'loai_vung');

            // Tọa độ mẫu bao quanh cơ sở Trường Lái Nguyễn Trình (quanh tọa độ GPS 9.807887, 106.345648)
            $defaultCoords = [
                [9.809200, 106.344000],
                [9.809600, 106.346800],
                [9.806600, 106.347200],
                [9.806200, 106.344300],
            ];

            $this->insert('ptx_xe_vung_gioi_han', [
                'ten_vung' => 'Khuôn viên công ty',
                'loai_vung' => 'KHUON_VIEN',
                'toa_do_polygon' => json_encode($defaultCoords),
                'mau_sac' => '#2563eb',
                'trang_thai' => 1,
                'ghi_chu' => 'Khuôn viên trụ sở chính Trường Lái Nguyễn Trình',
                'thoi_gian_tao' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema('ptx_xe_vung_gioi_han');
        if ($tableSchema !== null) {
            $this->dropTable('ptx_xe_vung_gioi_han');
        }
    }
}
