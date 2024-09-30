<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\giaovien\models\Day;

/* @var $this yii\web\View */
/* @var $model app\modules\giaovien\models\GiaoVien */
?>

<?php
// Tìm tất cả các phân công dạy của giáo viên hiện tại
$phanCongDay = Day::find()->where(['id_nhan_vien' => $model->id])->all();
?>

<div id="dayContent" class="phan-cong-day-view">
    <?php if (empty($phanCongDay)): ?>
        <!-- Giáo viên chưa có phân công dạy -->
        <p>Giáo viên này chưa được phân công giảng dạy.</p>
        <?= Html::a( '<i class="fa fa-tag"> </i> Phân công',
                        ['/giaovien/day/create', 
                         'id_nhan_vien' => $model->id,
                        ],
                        [
                            'class'=>'btn btn-primary',
                            'style' => 'color: white;',
                            'role'=>'modal-remote-2'
                        ]
                    ) ?>
    <?php else: ?>
        <!-- Giáo viên đã có phân công dạy -->
        <?= Html::a( '<i class="fa fa-plus"> </i> ',
                        ['/giaovien/day/create', 
                         'id_nhan_vien' => $model->id
                        ],
                        [
                            'class'=>'btn btn-primary',
                            'title' => 'Thêm phân công',
                            'style' => 'color: white;',
                            'role'=>'modal-remote-2'
                        ]
                    ) ?><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hạng xe</th>
                    <th>Lý thuyết</th>
                    <th>Thực hành</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($phanCongDay as $phanCong): ?>
                    <tr>
                        <td><?= Html::encode($phanCong->hangXe->ten_hang) ?></td>
                        <td><?= $phanCong->ly_thuyet ? '✔' : '✘' ?></td>
                        <td><?= $phanCong->thuc_hanh ? '✔' : '✘' ?></td>
                        <td>
                            <?= Html::a( '<i class="fa fa-pencil"> </i> ',
                                ['/giaovien/day/update', 
                                   'id' => $phanCong->id
                                ],
                                [
                                    'class' => 'btn ripple btn-info btn-sm',
                                    'title' => 'Cập nhật',
                                    'style' => 'color: white;',
                                    'role'=>'modal-remote-2',
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
function funcUploadDay($data){
    $('#dayContent').html($data);
}
</script>
