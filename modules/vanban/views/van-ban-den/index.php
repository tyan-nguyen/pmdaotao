<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap5\Modal;

/* @var $this yii\web\View */
/* @var $vanBanDenDataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách văn bản đến';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="van-ban-den-index">

    <?= Html::a('Tạo mới ', ['create'], [
    'class' => 'btn btn-success',
    'id' => 'create-vanban-button',
]) ?>

<br>
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
           

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

Modal::begin([
    'title' => '<h5 class="modal-title">Tạo Văn Bản Đến</h5>',
    'id' => 'modal-tao-vanban-den',
    'size' => 'modal-lg',
    'options' => ['tabindex' => false], // Thêm tùy chọn để cải thiện khả năng truy cập
    'headerOptions' => [
        'class' => 'modal-header', // Thêm lớp để tuỳ chỉnh nếu cần
    ],
    'footer' => Html::button('Đóng', [
        'class' => 'btn btn-secondary',
        'data-bs-dismiss' => 'modal',
        'aria-label' => 'Close'
    ]),
]);

echo '<div class="modal-body"></div>';

Modal::end();
?>


<?php
$this->registerJs("
    $('#create-vanban-button').on('click', function() {
        $('#modal-tao-vanban-den').modal('show')
            .find('.modal-body')
            .load($(this).attr('href'));
        return false; // Ngăn chặn hành vi mặc định của thẻ <a>
    });
");
?>



