<?php
use app\widgets\FileDisplayWidget;
use app\widgets\KhoDisplayWidget;
use app\modules\giaovien\models\GiaoVien;
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
                                        <p><strong>Địa Chỉ:</strong> <?= $model->diaChi ?></p>
                                        <p><strong>Điện Thoại:</strong> <?= $model->dien_thoai ?></p>
                                        <p><strong>Email:</strong> <?= $model->email ?></p>
                                        <p><strong>Mã số thuế:</strong> <?= $model->ma_so_thue ?></p>
                                        <p><strong>Tài khoản:</strong> <?= $model->taiKhoan ? $model->taiKhoan->username :'Trống'?></p>

								    </div>
						    </div>
	</div>
    
    
</div>


        <div class="col-xl-9 col-md-12">
        
        <div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="add-detail-tab" data-bs-toggle="tab" href="#add-detail" role="tab" aria-controls="add-detail" aria-selected="false"style="color: blue;"><i class="fa fa-address-card"></i> Thông tin chi tiết</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-file"></i> Hồ sơ</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-phancong-tab" data-bs-toggle="tab" href="#add-phancong" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-gavel"></i> Phân công </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-lichday-tab" data-bs-toggle="tab" href="#add-lichday" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-calendar"></i> Lịch dạy</a>
                    </li>
                </ul>
			</div>
                   <div class="card-body">
                      <div class="skill-tags">
                      
                        <div class="tab-content" id="myTabContent">
                              <!-- Nội dung File hồ sơ giáo viên -->
                              <div class="tab-pane fade  " id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                                    <!-- Nội dung hiển thị khi click vào "Hồ sơ giáo viên " -->
                                    <?= FileDisplayWidget::widget([
                                         'type'=>'ALL',
                                         'doiTuong'=>GiaoVien::MODEL_ID,
                                         'idDoiTuong'=>$model->id,
                                    ])?>
                                     <?= KhoDisplayWidget::widget([
                                          'doiTuong' => GIAOVIEN::MODEL_ID,
                                          'idDoiTuong' => $model->id
                                     ]) ?>
                             </div>


                             <div class="tab-pane fade" id="add-phancong" role="tabpanel" aria-labelledby="add-phancong-tab">
                                    <!-- Nội dung hiển thị khi click vào "Phân công dạy " -->
                                   <?= $this->render('phan_cong_day', ['model' => $model]) ?>
                             </div>

                             <div class="tab-pane fade" id="add-lichday" role="tabpanel" aria-labelledby="add-lichday-tab">
                                    <!-- Nội dung hiển thị khi click vào "Lịch dạy " -->
                                    <?= $this->render('testTKB',['model'=>$model,'weeks'=>$weeks,'months'=>$months]) ?>
                             </div>
                             <div class="tab-pane fade show active" id="add-detail" role="tabpanel" aria-labelledby="add-detail-tab">
                                    <!-- Nội dung hiển thị khi click vào "Thông tin chi tiết " -->
                                    <?= $this->render('tt_chitiet', ['model' => $model]) ?>
                                
                             </div>
                        </div>
                      </div>
                  </div>
        </div>
    </div>

        </div>

</div>
