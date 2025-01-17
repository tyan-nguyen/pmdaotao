<?php
use app\modules\lichhoc\models\LichThi;
use app\modules\lichhoc\models\KetQuaThi;
use app\modules\lichhoc\models\PhanThi;
//use yii\helpers\Html;
//use app\widgets\FileDisplayWidget;

$idHV = $model->id; 
$idKH = $model->id_khoa_hoc;
$lichThi = LichThi::find()->where(['id_khoa_hoc' => $idKH])->one();
$phanThis = PhanThi :: find()->where(['id_hang'=>$model->id_hang])->all();
$ketquaThi = KetQuaThi::find()->where(['id_hoc_vien' => $idHV])->all();
$currentDateTime = new DateTime();
$ketquaThiIndexed = [];
foreach ($ketquaThi as $ketqua) {
    $ketquaThiIndexed[$ketqua->id_phan_thi] = $ketqua;
}
if (!empty($lichThi)) {
    $examDateTime = new DateTime($lichThi->thoi_gian_thi); 
    $isExamPassed = $currentDateTime > $examDateTime;
}
?>

<div id="data-container-<?= $idHV ?>">
     <?= $this->render('_partial_view', ['model' => $model, 'phanThis' => $phanThis, 'ketquaThi' => $ketquaThi]) ?>
</div>

<script>
   function reloadData() {
    $.ajax({
        url: '<?= \yii\helpers\Url::to(['/hocvien/hoc-vien/reload-data', 'idHV' => $idHV]) ?>',
        type: 'GET',
        success: function(response) {
            $('#data-container-<?= $idHV ?>').html(response);
        },
        error: function() {
            console.error('Không thể tải dữ liệu mới.');
        }
    });
   }
       setInterval(reloadData, 5000);
</script>





