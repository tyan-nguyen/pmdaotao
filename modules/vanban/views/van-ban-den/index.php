<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $vanBanDenDataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách văn bản đến';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="van-ban-den-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Thêm Văn Bản Đến', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $vanBanDenDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'so_vb',
            'ngay_ky',
            'trich_yeu',
            'nguoi_ky',
            'vbden_ngay_den',
            'vbden_so_den',
            'vbden_nguoi_nhan',
            'vbden_ngay_chuyen',
            'ghi_chu',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
