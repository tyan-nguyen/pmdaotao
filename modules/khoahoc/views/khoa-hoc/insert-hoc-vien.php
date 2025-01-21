<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\KhoaHoc */

?>
<div class="add-hoc-vien">
    <?= $this->render('form_add_hv', [
        'model' => $model,
    ]) ?>
</div>