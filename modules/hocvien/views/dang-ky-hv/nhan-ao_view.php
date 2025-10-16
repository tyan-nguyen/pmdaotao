<?php
use app\widgets\CardWidget;
use app\custom\CustomFunc;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;

$user = User::findOne($model->nguoi_giao_ao);
?>

<?php CardWidget::begin(['title'=>'Chi tiết nhận áo' ]) ?>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td width="50px" align="center">STT</td>
                <td align="center">Học viên</td>
                <td align="center">Size</td>
                <td align="center">Ngày nhận</td>
                <td align="center">Nơi nhận</td>
                <td align="center">Người giao</td> 
            </tr>
        </thead>
        <tbody>
        <tr>
        	<td>1</td>
        	<td align="center"><?= $model->ho_ten ?></td>     
        	<td align="center"><?= $model->size ?></td>   	
        	<td align="center"><?= CustomFunc::convertYMDToDMY($model->ngay_nhan_ao) ?></td>
        	<td align="center"><?= (isset($user->noi_dang_ky))?DangKyHv::getLabelNoiDangKyOther($user->noi_dang_ky):'' ?></td>
        	<td align="center"><?= $user?$user->ho_ten:'' ?></td>
        </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>