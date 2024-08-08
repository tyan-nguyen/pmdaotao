<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VanBan */

$this->title = $model->so_vb;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách văn bản đến', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="van-ban-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sửa', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Bạn có chắc chắn muốn xóa mục này?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
