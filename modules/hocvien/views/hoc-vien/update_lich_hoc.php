<?php

use yii\bootstrap5\Html;

?>
<div class="lich-hoc-update">
    <?= $this->render('_formUDLichHoc', [
        'model' => $model,
        'giaoVienList'=>$giaoVienList,
        'idKhoaHoc'=>$idKhoaHoc,
    ]) ?>
</div>