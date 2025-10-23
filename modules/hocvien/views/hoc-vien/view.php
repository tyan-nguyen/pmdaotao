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
                                        <p><strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?></p>
                                        <p><strong>Địa chỉ:</strong> <?= $model->diaChi ?></p>
                                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
                                        <p><strong>Ngày hết hạn CCCD:</strong> <?= $model->getNgayHetHanCccd() ?></p>
                                        <p><strong>Nơi đăng ký:</strong> <?= $model->noi_dang_ky ?></p>
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
                        <a class="nav-link show active " id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Hồ sơ học viên</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-student-tab" data-bs-toggle="tab" href="#add-student" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-adjust"></i> Học phí</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ketquahoc-tab" data-bs-toggle="tab" href="#ketquahoc" role="tab" aria-controls="ketquahoc" aria-selected="false"style="color: blue;"><i class="fa fa-adjust"></i> Thời gian học</a>
                    </li>
                 
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="add-timetable-tab" data-bs-toggle="tab" href="#add-timetable" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-calendar"></i> Lịch học</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="exsche-tab" data-bs-toggle="tab" href="#add-exsche" role="tab" aria-controls="add-exsche" aria-selected="false"style="color: blue;"><i class="fa fa-table"></i> Lịch thi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true"style="color: blue;"><i class="fa fa-address-card"></i>  Kết quả thi</a>
                    </li>
                   
                </ul>
			</div>
                   <div class="card-body">
                      <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">
                        <!-- Nội dung Kết quả thi -->
                            <div class="tab-pane fade " id="list" role="tabpanel" aria-labelledby="list-tab">
                        <!-- Nội dung hiển thị khi click vào "Kết quả thi" -->
                        <?= $this->render('ket_qua_thi', ['model' => $model]) ?>
                            </div>

                        <!-- Nội dung Học phí  -->
                            <div class="tab-pane fade" id="add-student" role="tabpanel" aria-labelledby="add-student-tab">
                        <!-- Nội dung hiển thị khi click vào "Học phí" -->
                             <?= $this->render('hoc_phi', ['model' => $model]) ?>
                             
                            </div>
                            
                            <!-- Nội dung thời gian học  -->
                            <div class="tab-pane fade" id="ketquahoc" role="tabpanel" aria-labelledby="ketquahoc-tab">

                             <?= $this->render('ket_qua_hoc', ['model' => $model]) ?>
                             
                            </div>

                             <!-- Nội dung Lịch học -->
                             <div class="tab-pane fade " id="add-timetable" role="tabpanel" aria-labelledby="add-timetable-tab">
                        <!-- Nội dung hiển thị khi click vào "Lịch học " -->
                            <?= $this->render('testTKB',['modelHV'=>$model, 'weeks' => $weeks]) ?>
                            </div>

                            <!-- Nội dung Lịch thi -->
                            <div class="tab-pane fade " id="add-exsche" role="tabpanel" aria-labelledby="add-exsche-tab">
                        <!-- Nội dung hiển thị khi click vào "Lịch thi " -->
                            <?= $this->render('_exsche',['model'=>$model]) ?>
                            </div>

                              <!-- Nội dung Tài liệu khóa học -->
                              <div class="tab-pane fade show active" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">

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
