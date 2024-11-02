<?php

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
?>
<div class="form-nop-phi-thue">

    <?= $this->render('_formNopPhiThue', [
        'model' => $model,
        'idHocVien' => $idHocVien ?? null,
        'hotenNT' => $hotenNT ?? null,
        'cccdNT' => $cccdNT ?? null,
        'diachiNT' => $diachiNT ?? null,
        'sdtNT' => $sdtNT ?? null,
        'hotenHV' => $hotenHV ?? null,
        'cccdHV' => $cccdHV ?? null,
        'diachiHV' => $diachiHV ?? null,
        'sdtHV' => $sdtHV ?? null,
        'idHang' =>$idHang ?? null,
        'idKhoaHoc'=>$idKhoaHoc ?? null,
        'tenKhoaHoc' =>$tenKhoaHoc ?? null,
        'chiphithueDK' => $chiphithueDK,
        'chiphithuePS' => $chiphithuePS ,
    ]) ?>

</div>
