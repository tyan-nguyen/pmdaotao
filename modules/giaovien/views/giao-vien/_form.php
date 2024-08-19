<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\nhanvien\models\PhongBan;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
/* @var $form yii\widgets\ActiveForm */
// Lấy danh sách phòng ban
$phongBans = PhongBan::find()->all();
$listPhongBan = ArrayHelper::map($phongBans, 'id', 'ten_phong_ban');
// Lấy danh sách tài khoản
$taiKhoans = User::find()->all();
$listTaiKhoan = ArrayHelper::map($taiKhoans, 'id', 'username');
?>

<div class="nhan-vien-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'id_phong_ban')->dropDownList(
                $listPhongBan, 
                ['prompt' => 'Chọn phòng ban...'] 
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'chuc_vu')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dien_thoai')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'tai_khoan')->dropDownList(
                $listTaiKhoan, 
                ['prompt' => 'Chọn tài khoản...'] 
            ) ?>
      
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'trinh_do')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'chuyen_nganh')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vi_tri_cong_viec')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ma_so_thue')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'kinh_nghiem_lam_viec')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'trang_thai')->dropDownList([
                'Đang làm việc' => 'Đang làm việc',
                'Đã nghỉ việc' => 'Đã nghỉ việc',
            ], ['prompt' => 'Chọn trạng thái']) ?>
        </div>
        <div class="col-md-4">
    <?= $form->field($model, 'check_giao_vien', [
        'template' => "{label}\n<div class='checkbox-container'>{input}</div>\n{hint}\n{error}",
        'labelOptions' => ['class' => 'control-label'],
    ])->checkbox([], false) ?>
</div>




    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
