<?



/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
?>
<div class="nhan-vien-view">
    <div class="row">
    <div class="col-xl-4 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 ">Thông tin cá nhân: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Họ Tên:</strong> <?= $model->ho_ten ?></p>
                                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
                                        <p><strong>Địa Chỉ:</strong> <?= $model->dia_chi ?></p>
                                        <p><strong>Điện Thoại:</strong> <?= $model->dien_thoai ?></p>
                                        <p><strong>Email:</strong> <?= $model->email ?></p>
                                        <p><strong>Mã số thuế:</strong> <?= $model->ma_so_thue ?></p>
                                        <p><strong>Tài khoản:</strong> <?= $model->taiKhoan->username ?></p>

								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 ">Thông tin công việc: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                    <p><strong>Phòng:</strong> <?= $model->phongBan->ten_phong_ban ?></p>
                                    <p><strong>Tổ:</strong> <?= $model->to->ten_to ?></p>
                                        <p><strong>Chức vụ:</strong> <?= $model->chuc_vu?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
                                      
								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 ">Thông tin chuyên môn: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Trình độ:</strong> <?= $model->trinh_do ?></p>
                                        <p><strong>Kinh nghiệm làm việc:</strong> <?= $model->kinh_nghiem_lam_viec ?></p>
                                        
                                      
								    </div>
						    </div>
	</div>
</div>


        <div class="col-xl-8 col-md-12">
        
          <?= $this->render('_file_view');?>

        </div>
    </div>


<style>
.info-box {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 15px;
    background-color: #f9f9f9;
    margin-bottom: 15px;
}
.info-box p {
    margin: 0;
    padding: 5px 0;
}
.info-box strong {
    display: inline-block;
    width: 150px; /* Hoặc chiều rộng phù hợp với yêu cầu */
}
</style>
