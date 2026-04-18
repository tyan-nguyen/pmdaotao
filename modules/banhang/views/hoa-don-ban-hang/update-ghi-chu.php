<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['action' => $model->isNewRecord ? '' : ['/banhang/hoa-don-ban-hang/update-ghi-chu', 'id' => $model->id]]);

?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>