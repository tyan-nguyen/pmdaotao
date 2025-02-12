<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\HangDaoTao */

?>
<div class="them-phan-thi">
    <?= $this->render('_formThemPhanThi', [
     //   'phanThi'=>$phanThi,
     'model'=>$model,
    ]) ?>
</div>