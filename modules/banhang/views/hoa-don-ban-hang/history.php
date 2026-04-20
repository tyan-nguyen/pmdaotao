<?php

use app\modules\user\models\History;
use app\modules\banhang\models\HoaDon;
?>
<?= History::showHistory(HoaDon::MODEL_ID, $model->id) ?>