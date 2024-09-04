<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\File */
?>
<div class="file-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_loai_ho_so',
            'file_name',
            'file_type',
            'file_size',
            'file_display_name',
            'nguoi_tao',
            'thoi_gian_tao',
            'doi_tuong',
            'id_doi_tuong',
        ],
    ]) ?>

</div>
