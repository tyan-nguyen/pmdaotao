<?php
use yii\helpers\Html;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\NopHocPhi;
use app\widgets\CardWidget;
// Tìm học viên hiện tại
$hocVien = HocVien::findOne($model->id);
// Tìm thông tin các lần nộp học phí của học viên
$hocPhi = NopHocPhi::find()->where(['id_hoc_vien' => $hocVien->id])->all();
?>
<div id="hpContent" class="hoc-phi-view">
    <?php if (empty($hocPhi)): ?>
        <!-- Học viên chưa đóng học phí -->
        <p style="color:red">Học viên chưa đóng học phí !.</p>
    <?php else: ?>
       
        <?php CardWidget::begin(['title'=>'Danh sách Biên lai']) ?>
    <div class="receipt-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach ($hocPhi as $hcPhi): ?>
            <div class="receipt-item" style="flex: 1 1 calc(50% - 10px); max-width: 48%; box-sizing: border-box;">
                <img src="<?= Yii::getAlias('@web') . '/' . Html::encode($hcPhi->bien_lai) ?>" alt="Biên lai" 
                     style="width: 100%; height: 220px; aspect-ratio: 5/2; object-fit: cover;">
            </div>
        <?php endforeach; ?>
    </div>
<?php CardWidget::end() ?>




    <?php endif; ?>
</div>
