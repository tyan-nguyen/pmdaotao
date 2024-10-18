<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $hocPhis app\models\HocPhi[] */

$this->title = 'Danh sách học phí theo hạng';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id ="hpContent" class="hoc-phi-index">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Học phí</th>
                <th>Ngày áp dụng</th>
                <th>Ngày kết thúc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hocPhis as $index => $hocPhi): ?>
                <tr>
                    <td>
                        <?= $index + 1 ?>
                        <?php if ($index === count($hocPhis) - 1): // Kiểm tra nếu đây là phần tử cuối cùng ?>
                            <span style="color: red;">*</span> <!-- Dấu sao màu đỏ -->
                        <?php endif; ?>
                    </td>
                    <td><?= number_format($hocPhi->hoc_phi, 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?= Yii::$app->formatter->asDate($hocPhi->ngay_ap_dung, 'php:d/m/Y') ?></td>
                    <td><?= Yii::$app->formatter->asDate($hocPhi->ngay_ket_thuc, 'php:d/m/Y') ?></td>
                    <td>
                        <?= Html::a('<i class="fa fa-pencil"> </i>', 
                                    ['/khoahoc/hang-dao-tao/update-list-hoc-phi', 'id' => $hocPhi->id],
                                    [
                                        'class' => 'btn ripple btn-info btn-sm',
                                        'title' => 'Cập nhật',
                                        'style' => 'color: white;',
                                        'role' => 'modal-remote-2',
                                    ]
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
