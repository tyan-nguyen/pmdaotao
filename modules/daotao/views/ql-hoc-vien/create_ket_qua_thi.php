<?php
use yii\bootstrap5\Html;
?>
<div class="ket-qua-thi-create">
    <?= $this->render('_formKetQuaThi', [
        'model' => $model,
        'idHV'=>$idHV,
    ]) ?>
</div>