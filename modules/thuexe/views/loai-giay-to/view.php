<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiGiayTo */
?>
<div class="loai-giay-to-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_loai_giay_to',
            [
                'attribute' => 'la_bat_buoc',
                'format' => 'raw',
                'value' => $model->getLaBatBuocLabel(),
            ],
            [
                'attribute' => 'check_het_han',
                'format' => 'raw',
                'value' => $model->getCheckHetHanLabel(),
            ],
            [
                'attribute' => 'so_ngay_bao_truoc',
                'value' => $model->check_het_han ? ($model->getSoNgayBaoTruocVal() . ' ngày') : 'Không áp dụng',
            ],
            'ghi_chu:ntext',
            [
                'attribute' => 'thoi_gian_tao',
                'value' => CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tao),
            ],
        ],
    ]) ?>

</div>
