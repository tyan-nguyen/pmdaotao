<?php
use app\widgets\FileDisplayWidget;
use app\modules\nhanvien\models\NhanVien;
use app\widgets\KhoDisplayWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
?>
<div class="nhan-vien-view">
 
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin cá nhân: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Họ Tên:</strong> <?= $model->ho_ten ?></p>
                                        <p><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></p>
										<p><strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?></p>
                                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
                                        <p><strong>Địa Chỉ:</strong> <?= $model->dia_chi ?></p>
                                        <p><strong>Điện Thoại:</strong> <?= $model->dien_thoai ?></p>
                                        <p><strong>Email:</strong> <?= $model->email ?></p>
                                        <p><strong>Mã số thuế:</strong> <?= $model->ma_so_thue ?></p>
										<p><strong>Tài khoản:</strong> <?= isset($model->taiKhoan->username) && $model->taiKhoan->username != '' ? $model->taiKhoan->username : 'Trống' ?></p>


								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin công việc: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                    <p><strong>Phòng:</strong> <?= $model->phongBan ? $model->phongBan->ten_phong_ban : 'Chưa có phòng ban' ?></p>
                                    <p><strong>Tổ:</strong> <?= $model->to ? $model->to->ten_to : 'Chưa có tổ'?></p>
                                        <p><strong>Chức vụ:</strong> <?= $model->chuc_vu?></p>
										<p><strong>Vị trí công việc:</strong> <?= $model->vi_tri_cong_viec?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
                                      
								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 " style="color:red;">Thông tin chuyên môn: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Trình độ:</strong> <?= $model->trinh_do ?></p>
                                        <p><strong>Kinh nghiệm làm việc:</strong> <br> <?= $model->kinh_nghiem_lam_viec ?></p> 
								    </div>
						    </div>
	</div>
</div>


        <div class="col-xl-9 col-md-12">
                        <?= FileDisplayWidget::widget([
                            'type'=>'ALL',
                            'doiTuong'=>NhanVien::MODEL_ID,
                            'idDoiTuong'=>$model->id,
                         ])?>     
						<?= KhoDisplayWidget::widget([
                             'doiTuong' => NhanVien::MODEL_ID,
                             'idDoiTuong' => $model->id
                         ]) ?>    
        </div>
    </div>

        </div>

</div>
