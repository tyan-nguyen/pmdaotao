<?php

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichHoc */

?>

<div class="lich-hoc-view">
    <div class="row">
        <div class="col-xl-4 col-md-12 mx-auto">
            <div class="card custom-card shadow-lg">
                <div class="card-header custom-card-header rounded-bottom-0 text-center" style="background-color: #f8f9fa; border-bottom: 2px solid #dc3545;">
                    <h5 class="card-title mb-0" style="color: #dc3545; font-weight: bold;">
                        <i class="fas fa-calendar-alt me-2"></i>Thông Tin Lịch Học
                    </h5>
                </div>
                <div class="card-body" style="background-color: #fdfdfe;">
                    <div class="skill-tags">
                        <p>
                            <i class="fas fa-book-open text-primary me-2"></i>
                            <strong>Khóa học:</strong> <?= $model->khoaHoc->ten_khoa_hoc ?>
                        </p>
                        <p>
                            <i class="fas fa-users text-success me-2"></i>
                            <strong>Nhóm học:</strong> <?= $model->nhomHoc->ten_nhom ?? '(Học chung)'  ?>
                        </p>
                        <p>
                            <i class="fas fa-door-open text-warning me-2"></i>
                            <strong>Phòng học:</strong> <?= $model->phong->ten_phong ?>
                        </p>
                        <p>
                            <i class="fas fa-chalkboard-teacher text-danger me-2"></i>
                            <strong>GVGD:</strong> <?= $model->giaoVien->ho_ten ?>
                        </p>
                        <p>
                            <i class="fas fa-book text-info me-2"></i>
                            <strong>Học phần:</strong> <?= $model->hoc_phan ?>
                        </p>
                        <p>
                            <i class="fas fa-calendar-day text-secondary me-2"></i>
                            <strong>Ngày:</strong> <?= Yii::$app->formatter->asDate($model->ngay, 'php:d-m-Y') ?>
                        </p>
                        <p>
                            <i class="fas fa-clock text-primary me-2"></i>
                            <strong>Tiết bắt đầu:</strong> <?= $model->tiet_bat_dau ?>
                        </p>
                        <p>
                            <i class="fas fa-clock text-danger me-2"></i>
                            <strong>Tiết kết thúc:</strong> <?= $model->tiet_ket_thuc ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
