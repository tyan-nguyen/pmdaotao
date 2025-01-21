<?php
use app\modules\hocvien\models\HocVien;
use app\modules\khoahoc\models\NhomHoc; 
use yii\helpers\Html;

$modelNhom = NhomHoc::find()->where(['id_khoa_hoc'=>$model->id])->all();
if(empty($modelNhom))
{
  echo '<p style="text-align:center;">KHÔNG CÓ NHÓM HỌC CHO KHÓA HỌC NÀY </p>';
}

echo '<div style="display: flex; flex-wrap: wrap; gap: 20px;">';

foreach ($modelNhom as $nhom) {
    $soLuongHocVien = HocVien::find()->where(['id_nhom' => $nhom->id])->count();

    echo Html::a(
      '<h4 style="margin: 0;">' . $nhom->ten_nhom . '</h4>' .
      '<p style="margin: 5px 0;">Số lượng HV: <span style="color: red; font-weight: bold;">' . $soLuongHocVien . '</span></p>',
      ['/khoahoc/khoa-hoc/group-details', 'id' => $nhom->id], 
      [
          'class' => 'btn ripple btn-outline-primary', 
          'role' => 'modal-remote-2',
          'style' => 'border: 1px solid black; border-radius: 10px; padding: 10px; width: 150px; text-align: center; text-decoration: none; color: black;',
          'title' => 'Xem chi tiết nhóm ' . $nhom->ten_nhom, 
      ]
  );
}

echo '</div>';
?>
