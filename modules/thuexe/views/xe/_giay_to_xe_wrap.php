<?php

use yii\bootstrap5\Html;
use app\custom\CustomFunc;

$giayTos = $model->getGiayTosMoiNhat();
?>
<div class="xe-giay-to-subview">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-primary font-weight-bold d-flex align-items-center">
            <span><i class="fa fa-folder-open"></i> Danh sách giấy tờ hiện hành của xe <?= Html::encode($model->bien_so_xe) ?> (<span id="giay-to-wrap-count"><?= count($giayTos) ?></span>)</span>
            <span class="ms-2" id="giay-to-status-badge"><?= $model->getTrangThaiGiayToBadge() ?></span>
        </h6>
        <?= Html::a(
            '<i class="fa fa-plus"></i> Thêm giấy tờ cho xe',
            ['/thuexe/xe-giay-to/create', 'id_xe' => $model->id, 'modalType' => 'modal-remote-2'],
            ['role' => 'modal-remote-2', 'class' => 'btn btn-primary btn-sm', 'title' => 'Thêm giấy tờ', 'style' => 'color:white']
        ) ?>
    </div>

    <div id="giay-to-content" style="max-height: 300px;overflow-y: auto;overflow-x: hidden;">
        <?= $this->render('_giay_to_xe', ['model' => $model]) ?>
    </div>


</div>

<script>
    if ($('#giay-to-count-badge').length) {
        $('#giay-to-count-badge').text('<?= count($giayTos) ?>');
    }
</script>