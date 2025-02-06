<?php
  use yii\helpers\Html;
?>
<div id="hoc-vien-list-container">
    <h4>Danh sách học viên trong khóa học:</h4>
    <ul>
        <?php foreach ($hocVien as $hv): ?>
            <li>
                <?= Html::encode($hv->ten) ?> 
                (<?= Html::encode($hv->trang_thai) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</div>
