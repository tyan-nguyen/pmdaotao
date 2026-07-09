<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\TaiSan */
?>
<div class="tai-san-view">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <p>
                <strong>Loại tài sản:</strong> <?= $model->loaiTaiSan->ten ?>
                <span style="margin-left: 30px;"></span> <strong>Danh mục tài sản</strong> <?= $model->danhMuc->ten ?>
            </p>
            <p><strong>Model:</strong> <?= $model->model ?></p>
            <p><strong>Serial:</strong> <?= $model->serial ?></p>
        </div>

        <div>
            <?= $model->qrLink ? Html::img($model->qrLink, ['style' => 'width:100px;height:100px; display:block;']) : '' ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'autoid',
            'ma_tai_san',
            'ten_tai_san',
            'loai_tai_san_id',
            'danh_muc_id',
            'model',
            'serial',
            'so_tien',
            'nha_cung_cap_id',
            'so_hoa_don',
            'so_hop_dong',
            'ngay_mua',
            'thoi_han_bao_hanh',
            'ghi_chu_bao_hanh:ntext',
            'vi_tri_id',
            'phong_ban_id',
            'nguoi_chiu_trach_nhiem_id',
            'muc_dich_su_dung:ntext',
            'ngay_dua_vao_su_dung',
            'trang_thai',
            'ghi_chu:ntext',
            'thoi_gian_tao',
            'nguoi_tao',
        ],
    ]) ?>

</div>