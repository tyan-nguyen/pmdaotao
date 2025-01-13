<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\KetQuaThi $model */

$this->title = 'Update Ket Qua Thi: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ket Qua This', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ket-qua-thi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
