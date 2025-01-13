<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\KetQuaThi $model */

$this->title = 'Create Ket Qua Thi';
$this->params['breadcrumbs'][] = ['label' => 'Ket Qua This', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ket-qua-thi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
