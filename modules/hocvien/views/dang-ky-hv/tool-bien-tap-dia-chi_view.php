<?php
use app\widgets\CardWidget;
use app\custom\CustomFunc;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;

$user = User::findOne($model->nguoi_tao);
?>

<?php CardWidget::begin(['title'=>'Thông tin học viên' ]) ?>

<div class="table-responsive p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td width="50px" align="center">STT</td>
                <td align="center">Học viên</td>
                <td align="center">Ngày sinh</td>
                <td align="center">Hạng đào tạo</td>
                <td align="center">Địa chỉ</td>
                <td align="center">Nhân viên phụ trách</td>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<td>1</td>
            	<td align="center"><?= $model->ho_ten ?></td>
            	<td align="center"><?= CustomFunc::convertYMDToDMY($model->ngay_sinh) ?></td>
            	<td align="center"><?= $model->hang->ten_hang ?></td>
            	<td align="left">
            		<strong>Địa chỉ cũ:</strong> <br/><?= $model->dia_chi?$model->dia_chi:'-' ?> <br/>
            		<strong>Địa chỉ sau cập nhật:</strong> <br/><?= $model->diaChiText?$model->diaChiText:'-' ?>
            	</td>
            	<td align="center"><?= $user?$user->username:'' ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>