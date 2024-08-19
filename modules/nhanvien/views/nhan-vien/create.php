<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
$this->registerJsVar('listLoaiHoSo', $listLoaiHoSo);
?>
<div class="nhan-vien-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
