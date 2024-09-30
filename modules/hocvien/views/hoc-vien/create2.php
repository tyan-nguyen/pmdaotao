<?php

use yii\bootstrap5\Html;



/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */

?>
<div class="hv-hoc-phi-create">
    <?= $this->render('form_hp', [
        'model' => $model,
        'hoTenHocVien' => $hoTenHocVien,
    ]) ?>
</div>
