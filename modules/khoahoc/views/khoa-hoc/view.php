<?php
use app\widgets\FileDisplayWidget;
use app\modules\khoahoc\models\KhoaHoc;
use app\widgets\KhoDisplayWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\KhoaHoc */
?>
<div class="khoa-hoc-view">
 
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin khóa học: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Tên khóa học:</strong> <?= $model->ten_khoa_hoc ?></p>
                                        <p><strong>Hạng đào tạo:</strong> <?= $model->hang->ten_hang ?></p>
                                        <p><strong>Ngày bắt đầu:</strong> <?= $model->ngayBatDau ?></p>
                                        <p><strong>Ngày kết thúc:</strong> <?= $model->ngayKetThuc ?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
                                     

								    </div>
						    </div>
	</div>
    </div>
    <div class="col-xl-9 col-md-12">
        <div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#listHv" role="tab" aria-controls="list" aria-selected="true"style="color: blue;"><i class="fa fa-list"></i>  Danh sách học viên</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-timetable-tab" data-bs-toggle="tab" href="#add-timetable" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-calendar"></i> Lịch học</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-file"></i> Tài liệu</a>
                    </li>
                </ul>
			</div>
                   <div class="card-body">
                      <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">
                        <!-- Nội dung Danh sách lớp -->
                            <div class="tab-pane fade show active" id="listHv" role="tabpanel" aria-labelledby="list-tab">
                        <!-- Nội dung hiển thị khi click vào "Danh sách lớp" -->
                                <h3 style="text-align:center;">Danh sách học viên</h3>
                                <?= $this->render('xem_hv', ['model' => $model]) ?>
                            </div>
                             <!-- Nội dung Lịch học -->
                             <div class="tab-pane fade" id="add-timetable" role="tabpanel" aria-labelledby="add-timetable-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                                <h3>Lịch học</h3>
                                <p>Hiển thị lịch học tại đây.</p>
                             
                            </div>
                              <!-- Nội dung Tài liệu khóa học -->
                              <div class="tab-pane fade" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                        <!-- Nội dung hiển thị khi click vào "Thêm học viên" -->
                                <?= FileDisplayWidget::widget([
                                    'type'=>'ALL',
                                     'doiTuong'=>KhoaHoc::MODEL_ID,
                                     'idDoiTuong'=>$model->id,
                                ])?>
                                <?= KhoDisplayWidget::widget([
                                     'doiTuong' => KhoaHoc::MODEL_ID,
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