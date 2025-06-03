<?php
use yii\helpers\Html;
?>
<table class="table table-bordered">
    <thead>
        <tr>
        	<th>STT</th>
            <th>Mã Module</th>
            <th>Tên Module</th>
            <th>Số giờ theo QĐ</th>
            <th>Số giờ TT</th>
            <th>Hiệu lực</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
	<?php 
	foreach ($model as $iM=>$m){
	?>
	<tr>
		<td><?= ($iM+1) ?></td>
		<td><?= $m->mon->ma_mon ?></td>
		<td><?= $m->mon->ten_mon  . ($m->mon->ten_mon_sub?' ('.$m->mon->ten_mon_sub.')':'') ?></td>
		<td><?= $m->mon->so_gio_qd ?></td>
		<td><?= $m->mon->so_gio_tt ?></td>
		<td><?= $m->dang_hieu_luc ? 'Có' : 'Không' ?></td>
		<td>
            <?= Html::a( '<i class="fa fa-pencil"> </i> ',
                ['/daotao/hang-mon-hoc/update-from-hang', 
                    'id' => $m->id
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
	<?php } ?>
	</tbody>
</table>