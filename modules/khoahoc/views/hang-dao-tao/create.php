<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\HangDaoTao */

?>
<div class="hang-dao-tao-create">
    <?= $this->render('_form', [
        'model' => $model,
        'idKH' =>$idKH,
    ]) ?>
</div>
