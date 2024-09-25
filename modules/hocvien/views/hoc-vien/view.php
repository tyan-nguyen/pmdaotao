<?php

use yii\widgets\DetailView;
use app\widgets\FileDisplayWidget;
use app\modules\hocvien\models\HocVien;
use app\widgets\KhoDisplayWidget;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view">
 
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin học viên:</h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Tên học viên:</strong> <?= $model-> ho_ten ?></p>
                                        <p><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></p>
                                        <p><strong>Ngày sinh:</strong> <?= $model->ngay_sinh ?></p>
                                        <p><strong>Địa chỉ:</strong> <?= $model->dia_chi ?></p>
                                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
								    </div>
						    </div>
	</div>
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 " style="color: red;">Thông tin khóa học: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                    <p><strong>Tên khóa học:</strong> 
                                        <?php if ($model->id_khoa_hoc === null): ?>
                                                 Học viên chưa được sắp khóa học
                                                <?php else: ?>
                                                 <?= $model->khoaHoc->ten_khoa_hoc ?>
                                        <?php endif; ?>
                                    </p>

                                        <p><strong>Hạng đào tạo :</strong> <?= $model->hangDaoTao->ten_hang ?></p>
								    </div>
						    </div>
	</div>
    </div>
    <div class="col-xl-9 col-md-12">
        <div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="add-timetable-tab" data-bs-toggle="tab" href="#add-timetable" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-calendar"></i> Lịch học</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-student-tab" data-bs-toggle="tab" href="#add-student" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-dollar"></i> Học phí</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true"style="color: blue;"><i class="fa fa-address-card"></i>  Kết quả thi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Hồ sơ học viên</a>
                    </li>
                </ul>
			</div>
                   <div class="card-body">
                      <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">
                        <!-- Nội dung Danh sách lớp -->
                            <div class="tab-pane fade " id="list" role="tabpanel" aria-labelledby="list-tab">
                        <!-- Nội dung hiển thị khi click vào "Danh sách lớp" -->
                                <h3 style="text-align:center;">Kết quả thi</h3>
                               <p> Kết quả thi được hiển thị tại đây </p>
                            </div>

                        <!-- Nội dung Thêm học viên -->
                            <div class="tab-pane fade" id="add-student" role="tabpanel" aria-labelledby="add-student-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                                <h3>Học phí</h3>
                                <p>Hiển thị học phí tại đây.</p>
                             
                            </div>
                             <!-- Nội dung Lịch học -->
                             <div class="tab-pane fade show active" id="add-timetable" role="tabpanel" aria-labelledby="add-timetable-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                                <h3>Lịch học</h3>
                                <p>Hiển thị lịch học tại đây.</p>
                             
                            </div>
                              <!-- Nội dung Tài liệu khóa học -->
                              <div class="tab-pane fade" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                        <?= FileDisplayWidget::widget([
                             'type'=>'ALL',
                             'doiTuong'=>HocVien::MODEL_ID,
                             'idDoiTuong'=>$model->id,
                        ])?>
                        
                        <?= KhoDisplayWidget::widget([
                            'doiTuong' => HocVien::MODEL_ID,
                            'idDoiTuong' => $model->id
                        ]) ?>
                            </div>
                        </div>
                      </div>
                  </div>
        </div>
    </div>
</div>

</div>
