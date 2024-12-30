<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichThi */

?>
<div class="lich-thi-view">
    <div class="row">
        <div class="col-xl-4 col-md-10 mx-auto">
            <div class="card custom-card shadow-lg">
                <div class="card-header custom-card-header rounded-bottom-0 text-center" style="background-color: #f8f9fa; border-bottom: 2px solid #0d6efd;">
                    <h5 class="card-title mb-0" style="color: #0d6efd; font-weight: bold;">
                        <i class="fas fa-calendar-alt me-2"></i>Thông Tin Lịch Thi
                    </h5>
                </div>
                <div class="card-body" style="background-color: #fdfdfe;">
                    <div class="skill-tags">
                        <p>
                            <i class="fas fa-book text-success me-2"></i>
                            <strong>Khóa học:</strong> <?= Html::encode($model->khoaHoc->ten_khoa_hoc) ?>
                        </p>
                        <p>
                            <i class="fas fa-users text-warning me-2"></i>
                            <strong>Nhóm:</strong> <?= Html::encode($model->nhomHoc->ten_nhom ?? '(Chung)' ) ?>
                        </p>
            
                        <p>
                            <i class="fas fa-door-open text-danger me-2"></i>
                            <strong>Phòng thi:</strong> <?= Html::encode($model->phongThi->ten_phong) ?>
                        </p>
                        <p>
                            <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                            <strong>Giáo viên giám sát:</strong> <?= Html::encode($model->giaoVien->ho_ten) ?>
                        </p>
                        <p>
                            <i class="fas fa-clock text-success me-2"></i>
                            <strong>Thời gian thi:</strong> <?= Yii::$app->formatter->asDatetime($model->thoi_gian_thi, 'php:H:i | d-m-Y') ?>
                        </p>
                        <p>
                            <i class="fas fa-check-circle text-warning me-2"></i>
                            <strong>Trạng thái:</strong> <?= Html::encode($model->trang_thai) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
