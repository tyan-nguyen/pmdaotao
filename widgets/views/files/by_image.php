<?php

use app\modules\kholuutru\models\File;
use yii\helpers\Html;

foreach ($files as $fileVB) { ?>
    <?php if (strtoupper($fileVB->file_type) == 'JPG' || strtoupper($fileVB->file_type) == 'JPEG' || strtoupper($fileVB->file_type) == 'PNG') { ?>
        <a href="<?= File::FOLDER_DOCUMENTS . $fileVB->fileSaveName ?>" data-fancybox="gallery1" data-caption="<?= $fileVB->file_display_name ?>">
        <?php } ?>
        <?= Html::img($fileVB ? (File::FOLDER_DOCUMENTS . $fileVB->fileSaveName) : '', ['width' => 100, 'height' => 100]) ?>
        <?php if (strtoupper($fileVB->file_type) == 'JPG' || strtoupper($fileVB->file_type) == 'JPEG' || strtoupper($fileVB->file_type) == 'PNG') { ?>
        </a>
    <?php } ?>

<?php } ?>