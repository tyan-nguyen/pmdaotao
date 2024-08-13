<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\modules\nhanvien\models\NhanVien;

// Lấy danh sách nhân viên
$nhanViens = NhanVien::find()->all();
$listNhanVien = ArrayHelper::map($nhanViens, 'id', 'ho_ten');
?>

<div class="van-ban-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ký ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vbden_ngay_chuyen')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày chuyển ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 6])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vbden_so_den')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'vbden_ngay_den')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày đến ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vbden_nguoi_nhan')->dropDownList(
                $listNhanVien, 
                ['prompt' => 'Chọn người nhận...'] 
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <!-- Phần thêm file văn bản -->
    <div class="row">
        <div class="col-md-12">
            <h4>Thêm file văn bản</h4>
            <table id="file-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>File Type</th>
                        <th>File Display Name</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary" onclick="addFileRow()">Thêm file văn bản</button>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<script>
    let fileCount = 0;

    function addFileRow() {
        fileCount++;

        let table = document.getElementById('file-table').getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();

        let cell1 = newRow.insertCell(0);
        let cell2 = newRow.insertCell(1);
        let cell3 = newRow.insertCell(2);
        let cell4 = newRow.insertCell(3);
        let cell5 = newRow.insertCell(4);
        let cell6 = newRow.insertCell(5);

        cell1.innerHTML = fileCount;
        cell2.innerHTML = '<input type="text" name="FileVanBan[' + fileCount + '][file_name]" class="form-control" />';
        cell3.innerHTML = '<input type="text" name="FileVanBan[' + fileCount + '][file_size]" class="form-control" />';
        cell4.innerHTML = '<input type="text" name="FileVanBan[' + fileCount + '][file_type]" class="form-control" />';
        cell5.innerHTML = '<input type="text" name="FileVanBan[' + fileCount + '][file_display_name]" class="form-control" />';
        cell6.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeFileRow(this)">Xóa</button>';
    }

    function removeFileRow(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
