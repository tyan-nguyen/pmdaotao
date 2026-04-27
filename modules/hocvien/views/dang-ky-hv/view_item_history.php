<?php

use app\modules\hocvien\models\HocVien;
use app\modules\user\models\History;
use app\widgets\CardWidget;
?>

<?php
CardWidget::begin([
    'title' => 'Lịch sử thay đổi',
])
?>
<?= History::showHistory(HocVien::MODEL_ID, $model->id) ?>
<?php CardWidget::end() ?>