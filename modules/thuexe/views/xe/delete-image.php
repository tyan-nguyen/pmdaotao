<?php
use yii\helpers\Html;
?>

<div>
    <div class="row" id="hinhContent">
        <?php foreach ($hinhXeList as $hinh): ?>
            <div class="col-md-4 text-center">
                <div class="image-wrapper">
                    <p><img src="<?= Yii::getAlias('@web/images/hinh-xe/' . $hinh->hinh_anh) ?>" 
                         alt="Hình xe" 
                         class="img-thumbnail"
                         style="<?= $hinh->la_dai_dien ? 'border:1px solid blue' : '' ?>">
                    </p>
                    <p>
                        <?= Html::button('Xóa', [
                            'class' => 'btn btn-danger btn-delete-image',
                            'data-id' => $hinh->id, 
                        ]) ?>
                        
                        <?= Html::button('Làm ảnh đại diện', [
                            'class' => 'btn btn-primary btn-make-primary',
                            'data-id' => $hinh->id,
                        ]) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .uniform-img {
    width: 100%; 
    height: 150px; 
    object-fit: cover; 
    border-radius: 8px; 
}
</style>

