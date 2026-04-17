<?php

use app\custom\CustomFunc;

$dateDMY = '09/12/1998';
$dateYMD = CustomFunc::convertDMYToYMD($dateDMY);

echo $dateYMD;
