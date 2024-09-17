<?php
use yii\helpers\Html;

?>
<?php if ($model->id == $currentFileId): ?>
    <div>
        <h5 class="text-primary"><?= Html::encode($model->file_display_name) ?></h5>
        <p class="text-muted fs-13 mb-0"><?= Html::encode($model->file_name) ?></p>
    </div>
    <div class="ms-auto">
        <h6 class="fs-11 text-muted"><?= Html::encode($model->file_size) ?></h6>
    </div>
<?php else: ?>
    <p>File không tồn tại hoặc không khớp với ID hiện tại.</p>
<?php endif; ?>
