<?php
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $files app\models\FileVanBan[]*/
?>
<div class="van-ban-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_loai_van_ban',
            'so_vb',
            [
                'attribute' => 'ngay_ky',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->ngay_ky, 'php:d-m-Y');
                },
            ],
            'trich_yeu',
            'nguoi_ky',
            [
                'attribute' => 'vbden_ngay_den',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->vbden_ngay_den, 'php:d-m-Y');
                },
            ],
            'vbden_so_den',
            [
                'attribute' => 'vbden_nguoi_nhan',
                'value' => function($model) {
                    return $model->vbdenNguoiNhan->ho_ten; // Trả về tên người nhận từ quan hệ
                },
                'label' => 'Người Nhận', // Tùy chọn: Đặt nhãn cho cột
            ],
            [
                'attribute' => 'vbden_ngay_chuyen',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->vbden_ngay_chuyen, 'php:d-m-Y');
                },
            ],
            'ghi_chu',
            [
                'attribute' => 'nguoi_tao',
                'value' => function() {
                    return Yii::$app->user->identity->username;
                },
                'label' => 'Người Tạo',
            ],
            
            [
                'attribute' => 'thoi_gian_tao',
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->thoi_gian_tao, 'php: H:i:s d-m-Y');
                },
            ],
        ],
    ]) ?>

</div>
