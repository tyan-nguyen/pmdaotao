<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NopPhiThueXe */

$this->title = 'Chi Tiết Biên Lai';
$this->params['breadcrumbs'][] = ['label' => 'Danh Sách Thuê Xe', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bien-lai-view">
    <div class="card">
        <div class="card-body">
            <?php if ($model->bien_lai): ?>
                <div class="text-center">
                    <?= Html::img(Yii::getAlias('@web') . '/' . $model->bien_lai, [
                        'alt' => 'Biên Lai',
                        'class' => 'img-fluid', // Tự động co dãn theo kích thước màn hình
                        'style' => 'max-width: 100%; height: auto;', // Giới hạn kích thước ảnh cho phù hợp
                    ]) ?>
                </div>
            <?php else: ?>
                <p>Không có biên lai nào được tải lên.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

