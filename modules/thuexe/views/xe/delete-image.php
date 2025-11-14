<?php
use yii\helpers\Html;
?>

<div>
    <div class="row" id="hinhContent">
        <?php foreach ($hinhXeList as $hinh): ?>
            <div class="col-md-4 text-center">
                <div class="image-wrapper">
                    <img src="<?= Yii::getAlias('@web/images/hinh-xe/' . $hinh->hinh_anh) ?>" 
                         alt="Hình xe" 
                         class="img-thumbnail">
                    <p>
                        <?= Html::button('Xóa', [
                            'class' => 'btn btn-danger btn-delete-image',
                            'data-id' => $hinh->id, 
                        ]) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
$(document).on('click', '.btn-delete-image', function () {
    const imageId = $(this).data('id'); 
    const parentDiv = $(this).closest('.col-md-4'); 

    if (confirm('Bạn có chắc chắn muốn xóa hình này không?')) {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['delete-single-image']) ?>', 
            type: 'POST',
            data: {id: imageId}, 
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    parentDiv.fadeOut(300, function () { 
                        $(this).remove();
                    });
                } else {
                    alert(response.message);
                }
            },
        });
    }
});

</script>
<style>
    .uniform-img {
    width: 100%; 
    height: 150px; 
    object-fit: cover; 
    border-radius: 8px; 
}
</style>

