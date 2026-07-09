<?php

use app\modules\taisan\models\TaiSan;
use app\modules\user\models\History;
use app\widgets\CardWidget;
?>

<?php
/* CardWidget::begin([
    'title' => 'Lịch sử thay đổi',
]) */
?>
<?= History::showHistory(TaiSan::MODEL_ID, $model->id) ?>
<?php /* CardWidget::end() */ ?>