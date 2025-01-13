<?php

use app\modules\lichhoc\models\KetQuaThi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\search\KetQuaThiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ket Qua This';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ket-qua-thi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ket Qua Thi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_hoc_vien',
            'id_lich_thi',
            'id_phan_thi',
            'diem_so',
            //'ket_qua',
            //'trang_thai',
            //'nguoi_tao',
            //'thoi_gian_tao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, KetQuaThi $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
