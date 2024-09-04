<?php
use yii\helpers\Html;
use app\modules\kholuutru\models\File;
?>
<div>
    <h5 class="text-primary"><?= $model->file_display_name ?></h5>
    <p class="text-muted fs-13 mb-0"><?= $model->file_name ?></p>
</div>
<div class="ms-auto">
    <h6 class="fs-11 text-muted"><?= $model->file_size ?></h6>
</div>