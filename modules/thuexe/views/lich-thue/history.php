<?php

use app\modules\user\models\History;
use app\modules\thuexe\models\LichThue;
?>
<?= History::showHistory(LichThue::MODEL_ID, $model->id) ?>