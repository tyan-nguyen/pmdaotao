<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VanBan */

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
                'label' => 'Ngày Ký',
            ],
            'trich_yeu',
            'nguoi_ky',
            [
                'attribute' => 'vbden_ngay_den',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->vbden_ngay_den, 'php:d-m-Y');
                },
                'label' => 'Ngày Đến',
            ],
            'vbden_so_den',
            [
                'attribute' => 'vbden_nguoi_nhan',
                'value' => function($model) {
                    return $model->vbdenNguoiNhan ? $model->vbdenNguoiNhan->name : 'N/A'; // Hoặc thuộc tính tên khác
                },
                'label' => 'Người Nhận',
            ],
            [
                'attribute' => 'vbden_ngay_chuyen',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->vbden_ngay_chuyen, 'php:d-m-Y');
                },
                'label' => 'Ngày Chuyển',
            ],
            'ghi_chu',
            [
                'attribute' => 'nguoi_tao',
                'value' => function($model) {
                    return $model->nguoiTao ? $model->nguoiTao->username : 'N/A'; // Hoặc thuộc tính tên khác
                },
                'label' => 'Người Tạo',
            ],
            [
                'attribute' => 'thoi_gian_tao',
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->thoi_gian_tao, 'php:d-m-Y H:i:s');
                },
                'label' => 'Thời Gian Tạo',
            ],
        ],
    ]) ?>
   <?php if (!empty($files)): ?>
        <h4>Danh sách các file văn bản</h4>
        <ul>
            <?php foreach ($files as $file): ?>
                <li>
                    <?= Html::a(Html::encode($file->file_display_name), ['view-file', 'id' => $file->id]) ?>
                    (<?= Html::encode($file->file_name) ?>,<?= Html::encode($file->file_size) ?>, <?= Html::encode($file->file_type) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>