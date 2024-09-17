<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\giaovien\models\Day;

/* @var $this yii\web\View */
/* @var $model app\modules\giaovien\models\GiaoVien */
?>

<?php
// Tìm phân công dạy của giáo viên hiện tại
$phanCongDay = Day::find()->where(['id_nhan_vien' => $model->id])->one();
?>

<div id="dayContent"  class="phan-cong-day-view">
    <?php if ($phanCongDay === null): ?>
        <!-- Giáo viên chưa có phân công dạy -->
        <p>Giáo viên này chưa được phân công giảng dạy.</p>
        <?= Html::a( '<i class="fa fa-tag"> </i> Phân công',
                        ['/giaovien/day/create', 
                         'id_nhan_vien' => $model->id
                        ],
                        [
                            'class'=>'btn btn-primary',
                            'style' => 'color: white;',
                             'role'=>'modal-remote-2'
                         ]
                        ) ?>
    <?php else: ?>
        <!-- Giáo viên đã có phân công dạy -->
      
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hạng xe</th>
                    <th>Lý thuyết</th>
                    <th>Thực hành</th>
                    <th>Hành động </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td><?= Html::encode($phanCongDay->hangXe->ten_hang) ?></td>
                    <td><?= $phanCongDay->ly_thuyet ? '✔' : '✘' ?></td>
                    <td> <?= $phanCongDay->thuc_hanh ? '✔' : '✘' ?></td>
                    <td> <?= Html::a( '<i class="fa fa-pencil"> </i> Cập nhật',
                        ['/giaovien/day/update', 
                           'id' => $phanCongDay->id
                        ],
                        [
                            'class'=>'btn btn-primary',
                            'style' => 'color: white;',
                             'role'=>'modal-remote-2',
                           
                         ]
                        ) ?>
                    </td>
                </tr>
            </tbody>
        </table>
       
    <?php endif; ?>
</div>

<script>
function funcUploadDay($data){
	$('#dayContent').html($data);
}
</script>