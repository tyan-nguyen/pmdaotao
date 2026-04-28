<?php

use app\custom\CustomFunc;
use app\modules\demxe\models\DemXe;
use app\modules\user\models\History;
use app\modules\user\models\User;
use app\widgets\CardWidget;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\DemXe */
?>
<div class="dem-xe-view">

    <div class="row">
        <div class="col-lg-6">
            <?php CardWidget::begin([
                'title' => 'Thông tin lượt xe',
            ]) ?>

            <h3 class="mb-3"><?= $model->xe ? $model->xe->bien_so_xe : $model->bien_so_xe  ?></h3>
            <p><strong>Mã cổng:</strong> <?= $model->ma_cong ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Số phút:</strong> <?= $model->so_phut ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>File:</strong> <?= $model->file->filename ?>
            </p>
            <p><strong>Bắt đầu:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_bd) ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Kết thúc:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_kt) ?>
            </p>
            <p><strong>Ghi chú:</strong> <?= $model->ghi_chu ?></p>
            <p><strong>Ngày tạo:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao) ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Người tạo:</strong> <?= User::findOne($model->nguoi_tao)->ho_ten ?? '' ?>
            </p>
            <?php CardWidget::end() ?>
        </div>
        <div class="col-lg-6">
            <?php CardWidget::begin([
                'title' => 'Hình ảnh xe',
            ]) ?>
            <?php if ($model->xe) { ?>
                <img src="<?= Yii::$app->request->baseUrl ?>/images/hinh-xe/<?= $model->xe->anhDaiDien->hinh_anh ?>" alt="<?= $model->xe->bien_so_xe ?>" class="img-fluid" style="max-width: 400px; max-height: 400px;">
            <?php } ?>
            <?php CardWidget::end() ?>
        </div>
        <div class="col-lg-12">
            <?php CardWidget::begin([
                'title' => 'Lịch sử thay đổi',
            ]) ?>
            <?= History::showHistory(DemXe::MODEL_ID, $model->id) ?>
            <?php CardWidget::end() ?>
        </div>

    </div>

</div>