<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichHoc */

?>
<div class="lich-hoc-create">
    <?= $this->render('_formCreateLH', [
        'model' => $model,
        'idKhoaHoc'=>$idKhoaHoc,
    ]) ?>
</div>