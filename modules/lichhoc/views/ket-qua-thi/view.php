<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\KetQuaThi $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ket Qua This', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ket-qua-thi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_hoc_vien',
            'id_lich_thi',
            'id_phan_thi',
            'diem_so',
            'ket_qua',
            'trang_thai',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
