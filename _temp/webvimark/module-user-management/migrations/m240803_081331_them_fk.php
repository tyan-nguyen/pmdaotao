<?php

use yii\db\Migration;

/**
 * Class m240803_081331_them_fk
 */
class m240803_081331_them_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          //fk cho bảng van_ban
          $this->addForeignKey(
            'fk-id_loai_van_ban_dm_loai_van_ban',
            'van_ban',
            'id_loai_van_ban',
            'dm_loai_van_ban',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_vbden_nguoi_nhan_nhan_vien',
            'van_ban',
            'vbden_nguoi_nhan',
            'nhan_vien',
            'id',
            'CASCADE'
        );
         //fk cho bảng file_van_ban
         $this->addForeignKey(
            'fk-id_van_ban_van_ban',
            'file_van_ban',
            'id_van_ban',
            'van_ban',
            'id',
            'CASCADE'
        );
          //fk cho bảng file_van_ban_dinh_kem
          $this->addForeignKey(
            'fk-id_van_ban_dk_van_ban',
            'vb_dinh_kem',
            'id_van_ban',
            'van_ban',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_van_ban_dk_van_ban_dk',
            'vb_dinh_kem',
            'id_van_ban_dinh_kem',
            'vb_dinh_kem',
            'id',
            'CASCADE'
        );
          //fk cho bảng ke
          $this->addForeignKey(
            'fk-id_kho_kho',
            'ke',
            'id_kho',
            'kho',
            'id',
            'CASCADE'
        );
            //fk cho bảng ngan
            $this->addForeignKey(
                'fk-id_ke_ke',
                'ngan',
                'id_ke',
                'ke',
                'id',
                'CASCADE'
            );
             //fk cho bảng hop
             $this->addForeignKey(
                'fk-id_ngan_ngan',
                'hop',
                'id_ngan',
                'ngan',
                'id',
                'CASCADE'
            ); 

            //Chạy đúng 
            // fk cho bảng luu_kho 
            $this->addForeignKey(
                'fk-id_kho_luu_kho',
                'luu_kho',
                'id_kho',
                'kho',
                'id',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-id_ngan_luu_ngan',
                'luu_kho',
                'id_ngan',
                'ngan',
                'id',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-id_ke_luu_ke',
                'luu_kho',
                'id_ke',
                'ke',
                'id',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-id_hop_luu_hop',
                'luu_kho',
                'id_hop',
                'hop',
                'id',
                'CASCADE'
            );
            //Tạo khóa ngoại cho bảng hoc_vien 
            $this->addForeignKey(
                'fk-id_khoa_hoc_khoa_hoc',
                'hoc_vien',
                'id_khoa_hoc',
                'khoa_hoc',
                'id',
                'CASCADE'
            );
            //Tạo khóa ngoại cho bảng khóa học
          $this->addForeignKey(
            'fk-id_hang_kh_hang',
            'khoa_hoc',
            'id_hang',
            'hang_dao_tao',
            'id',
            'CASCADE'
        );
        //Tạo khóa ngoại cho bảng hoc_phi
        $this->addForeignKey(
            'fk-id_hang_hp_hang',
            'hoc_phi',
            'id_hang',
            'hang_dao_tao',
            'id',
            'CASCADE'
        );
        //Chạy đến đây 
        //Tạo khóa ngoại cho bảng tai_lieu_khoa_hoc
        $this->addForeignKey(
            'fk-id_khoa_hoc_tl_khoa_hoc',
            'tai_lieu_khoa_hoc',
            'id_khoa_hoc',
            'khoa_hoc',
            'id',
            'CASCADE'
        );
        //Tạo khóa ngoại cho bảng nộp học phí 
        $this->addForeignKey(
            'fk-id_hoc_vien_hp_hoc_vien',
            'nop_hoc_phi',
            'id_hoc_vien',
            'hoc_vien',
            'id',
            'CASCADE'
        );
        //Tạo khóa ngoại cho bảng ho_so_hoc_vien 
        $this->addForeignKey(
            'fk-id_hoc_vien_hs_hoc_vien',
            'ho_so_hoc_vien',
            'id_hoc_vien',
            'hoc_vien',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_loai_ho_so_ho_so',
            'ho_so_hoc_vien',
            'id_loai_ho_so',
            'loai_ho_so',
            'id',
            'CASCADE'
        );
        
        //Tạo khóa ngoại cho bảng nhan_vien
        $this->addForeignKey(
            'fk-tai_khoan_user',
            'nhan_vien',
            'tai_khoan',
            'user',
            'id',
            'CASCADE'
        );
        // Tạo kháo ngoại cho bảng day
        $this->addForeignKey(
            'fk-id_nhan_vien_day_nhan_vien',
            'day',
            'id_nhan_vien',
            'nhan_vien',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_hang_xe_hang_xe',
            'day',
            'id_hang_xe',
            'hang_xe',
            'id',
            'CASCADE'
        );
        //Tạo kháo ngoại cho bảng ho_so_nhan_vien 
        $this->addForeignKey(
            'fk-id_loai_ho_so_loai_ho_so',
            'ho_so_nhan_vien',
            'id_loai_ho_so',
            'loai_ho_so',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_nhan_vien_hs_nhan_vien',
            'ho_so_nhan_vien',
            'id_nhan_vien',
            'nhan_vien',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       // Xóa khóa ngoại trước khi xóa bảng
       $this->dropForeignKey(
        'fk-id_loai_van_ban_dm_loai_van_ban',
        'van_ban'
    );
    $this->dropForeignKey(
        'fk-id_loai_van_ban_dm_loai_van_ban',
        'file_van_ban'
    );
    $this->dropForeignKey(
        'fk-id_van_ban_van_ban',
        'van_ban_dinh_kem'
    );
    $this->dropForeignKey(
        'fk-id_van_ban_dk_van_ban_dk',
        'van_ban_dinh_kem'
    );
    $this->dropForeignKey(
        'fk-id_kho_kho',
        'ke'
    );
    $this->dropForeignKey(
        'fk-id_ke_ke',
        'ngan'
    );
    $this->dropForeignKey(
        'fk-id_ngan_ngan',
        'hop'
    );
    $this->dropForeignKey(
        'fk-id_kho_luu_kho',
        'luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_ke_luu_ke',
        'luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_ngan_luu_ngan',
        'luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_hop_luu_hop',
        'luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_khoa_hoc_khoa_hoc',
        'hoc_vien'
    );
    $this->dropForeignKey(
        'fk-id_hang_kh_hang',
        'khoa_hoc'
    );
    $this->dropForeignKey(
        'fk-id_khoa_hoc_tl_khoa_hoc',
        'tai_lieu_khoa_hoc'
    );
    $this->dropForeignKey(
        'fk-id_hoc_vien_hp_hoc_vien',
        'nop_hoc_phi'
    );
    $this->dropForeignKey(
        'fk-id_hoc_vien_hoc_vien',
        'ho_so_hoc_vien'
    );
    $this->dropForeignKey(
        'fk-id_loai_ho_so_hs_ho_so',
        'ho_so_hoc_vien'
    );
    $this->dropForeignKey(
        'fk-tai_khoan_user',
        'nhan_vien'
    );
    $this->dropForeignKey(
        'fk-id_nhan_vien_day_nhan_vien',
        'day'
    );
    $this->dropForeignKey(
        'fk-id_hang_xe_hang_xe',
        'day'
    );
    $this->dropForeignKey(
        'fk-id_loai_ho_so_loai_ho_so',
        'ho_so_nhan_vien'
    );
    $this->dropForeignKey(
        'fk-id_nhan_vien_hs_nhan_vien',
        'ho_so_nhan_vien'
    );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240803_081331_them_fk cannot be reverted.\n";

        return false;
    }
    */
}
