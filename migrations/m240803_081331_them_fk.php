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
            'vb_van_ban',
            'id_loai_van_ban',
            'vb_dm_loai_van_ban',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-vbden_nguoi_nhan_nhan_vien',
            'vb_van_ban',
            'vbden_nguoi_nhan',
            'nv_nhan_vien',
            'id',
            'CASCADE'
        );
         //fk cho bảng file_van_ban
         $this->addForeignKey(
            'fk-id_van_ban_van_ban',
            'vb_file_van_ban',
            'id_van_ban',
            'vb_van_ban',
            'id',
            'CASCADE'
        );
          //fk cho bảng file_van_ban_dinh_kem
          $this->addForeignKey(
            'fk-id_van_ban_dk_van_ban',
            'vb_vb_dinh_kem',
            'id_van_ban',
            'vb_van_ban',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_van_ban_dk_van_ban_dk',
            'vb_vb_dinh_kem',
            'id_van_ban_dinh_kem',
            'vb_vb_dinh_kem',
            'id',
            'CASCADE'
        );
          //fk cho bảng ke
          $this->addForeignKey(
            'fk-id_kho_kho',
            'kho_ke',
            'id_kho',
            'kho_kho',
            'id',
            'CASCADE'
        );
            //fk cho bảng ngan
            $this->addForeignKey(
                'fk-id_ke_ke',
                'kho_ngan',
                'id_ke',
                'kho_ke',
                'id',
                'CASCADE'
            );
             //fk cho bảng hop
             $this->addForeignKey(
                'fk-id_ngan_ngan',
                'kho_hop',
                'id_ngan',
                'kho_ngan',
                'id',
                'CASCADE'
            ); 

            //Chạy đúng 
            // fk cho bảng luu_kho 
            $this->addForeignKey(
                'fk-id_kho_luu_kho',
                'kho_luu_kho',
                'id_kho',
                'kho_kho',
                'id',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-id_ngan_luu_ngan',
                'kho_luu_kho',
                'id_ngan',
                'kho_ngan',
                'id',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-id_ke_luu_ke',
                'kho_luu_kho',
                'id_ke',
                'kho_ke',
                'id',
                'CASCADE'
            );
            $this->addForeignKey(
                'fk-id_hop_luu_hop',
                'kho_luu_kho',
                'id_hop',
                'kho_hop',
                'id',
                'CASCADE'
            );
            //Tạo khóa ngoại cho bảng hoc_vien 
            $this->addForeignKey(
                'fk-id_khoa_hoc_khoa_hoc',
                'hv_hoc_vien',
                'id_khoa_hoc',
                'hv_khoa_hoc',
                'id',
                'CASCADE'
            );
            //Tạo khóa ngoại cho bảng khóa học
          $this->addForeignKey(
            'fk-id_hang_kh_hang',
            'hv_khoa_hoc',
            'id_hang',
            'hv_hang_dao_tao',
            'id',
            'CASCADE'
        );
        //Tạo khóa ngoại cho bảng hoc_phi
        $this->addForeignKey(
            'fk-id_hang_hp_hang',
            'hv_hoc_phi',
            'id_hang',
            'hv_hang_dao_tao',
            'id',
            'CASCADE'
        );
        //Chạy đến đây 
        //Tạo khóa ngoại cho bảng tai_lieu_khoa_hoc
        $this->addForeignKey(
            'fk-id_khoa_hoc_tl_khoa_hoc',
            'hv_tai_lieu_khoa_hoc',
            'id_khoa_hoc',
            'hv_khoa_hoc',
            'id',
            'CASCADE'
        );
        //Tạo khóa ngoại cho bảng nộp học phí 
        $this->addForeignKey(
            'fk-id_hoc_vien_hp_hoc_vien',
            'hv_nop_hoc_phi',
            'id_hoc_vien',
            'hv_hoc_vien',
            'id',
            'CASCADE'
        );
        //Tạo khóa ngoại cho bảng ho_so_hoc_vien 
        $this->addForeignKey(
            'fk-id_hoc_vien_hs_hoc_vien',
            'hv_ho_so_hoc_vien',
            'id_hoc_vien',
            'hv_hoc_vien',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_loai_ho_so_ho_so',
            'hv_ho_so_hoc_vien',
            'id_loai_ho_so',
            'hv_loai_ho_so',
            'id',
            'CASCADE'
        );
        
        //Tạo khóa ngoại cho bảng nhan_vien
        $this->addForeignKey(
            'fk-tai_khoan_user',
            'nv_nhan_vien',
            'tai_khoan',
            'user',
            'id',
            'CASCADE'
        );
        // Tạo kháo ngoại cho bảng day
        $this->addForeignKey(
            'fk-id_nhan_vien_day_nhan_vien',
            'nv_day',
            'id_nhan_vien',
            'nv_nhan_vien',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_hang_xe_hang_xe',
            'nv_day',
            'id_hang_xe',
            'nv_hang_xe',
            'id',
            'CASCADE'
        );
        //Tạo kháo ngoại cho bảng ho_so_nhan_vien 
        $this->addForeignKey(
            'fk-id_loai_ho_so_loai_ho_so',
            'nv_ho_so_nhan_vien',
            'id_loai_ho_so',
            'hv_loai_ho_so',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-id_nhan_vien_hs_nhan_vien',
            'nv_ho_so_nhan_vien',
            'id_nhan_vien',
            'nv_nhan_vien',
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
        'vb_van_ban'
    );
    $this->dropForeignKey(
        'fk-id_loai_van_ban_dm_loai_van_ban',
        'vb_file_van_ban'
    );
    $this->dropForeignKey(
        'fk-id_van_ban_van_ban',
        'vb_vb_dinh_kem'
    );
    $this->dropForeignKey(
        'fk-id_van_ban_dk_van_ban_dk',
        'vb_vb_dinh_kem'
    );
    $this->dropForeignKey(
        'fk-id_kho_kho',
        'kho_ke'
    );
    $this->dropForeignKey(
        'fk-id_ke_ke',
        'kho_ngan'
    );
    $this->dropForeignKey(
        'fk-id_ngan_ngan',
        'kho_hop'
    );
    $this->dropForeignKey(
        'fk-id_kho_luu_kho',
        'kho_luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_ke_luu_ke',
        'kho_luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_ngan_luu_ngan',
        'kho_luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_hop_luu_hop',
        'kho_luu_kho'
    );
    $this->dropForeignKey(
        'fk-id_khoa_hoc_khoa_hoc',
        'hv_hoc_vien'
    );
    $this->dropForeignKey(
        'fk-id_hang_kh_hang',
        'hv_khoa_hoc'
    );
    $this->dropForeignKey(
        'fk-id_khoa_hoc_tl_khoa_hoc',
        'hv_tai_lieu_khoa_hoc'
    );
    $this->dropForeignKey(
        'fk-id_hoc_vien_hp_hoc_vien',
        'hv_nop_hoc_phi'
    );
    $this->dropForeignKey(
        'fk-id_hoc_vien_hoc_vien',
        'hv_ho_so_hoc_vien'
    );
    $this->dropForeignKey(
        'fk-id_loai_ho_so_hs_ho_so',
        'hv_ho_so_hoc_vien'
    );
    $this->dropForeignKey(
        'fk-tai_khoan_user',
        'nv_nhan_vien'
    );
    $this->dropForeignKey(
        'fk-id_nhan_vien_day_nhan_vien',
        'nv_day'
    );
    $this->dropForeignKey(
        'fk-id_hang_xe_hang_xe',
        'nv_day'
    );
    $this->dropForeignKey(
        'fk-id_loai_ho_so_loai_ho_so',
        'nv_ho_so_nhan_vien'
    );
    $this->dropForeignKey(
        'fk-id_nhan_vien_hs_nhan_vien',
        'nv_ho_so_nhan_vien'
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
