<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\nhanvien\models\PhongBan;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\widgets\CardWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/giaoVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);

$phongBans = PhongBan::find()->all();
$listPhongBan = ArrayHelper::map($phongBans, 'id', 'ten_phong_ban');

$taiKhoans = User::find()->all();
$listTaiKhoan = ArrayHelper::map($taiKhoans, 'id', 'username');
?>

<div class="giao-vien-form"  id ="pbContent">
    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin cá nhân giáo viên']) ?>
       <div class="row">
           <div class="col-lg-3 col-md-6">
                <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'gioi_tinh')->dropDownList([
                    1 => 'Nam',
                    0 => 'Nữ',
                    ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control']) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                   'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
                   'pluginOptions' => [
                   'autoclose' => true,
                   'format' => 'dd/mm/yyyy',
                    ]
               ]); ?>
            </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'dien_thoai')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'ma_so_thue')->textInput(['maxlength' => true]) ?>
           </div>
           <div class="col-lg-3 col-md-6">
               <?= $form->field($model, 'tai_khoan')->dropDownList(
                 $listTaiKhoan,
                 ['prompt' => 'Chọn tài khoản...']
               ) ?>
           </div>
      </div>
        <?php CardWidget::end([]) ?>

        <?php CardWidget::begin(['title'=>'Thông tin công việc']) ?>
          <div class="row">
          <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0">Phòng ban</label>
                        <?= Html::a('<i class="fa fa-plus"> </i>', 
                                             ['/giaovien/giao-vien/insert-phong-ban'],
                                                [
                                                   'class' => 'btn ripple btn-primary btn-sm',
                                                   'title' => 'Cập nhật',
                                                   'style' => 'color: white;font-size: 0.6rem;padding: 0.2rem 0.5rem;',
                                                   'role' => 'modal-remote-2',
                                                ]
                        ) ?>
                </div>
   
               <div class="mt-1">
                   <?= $form->field($model, 'id_phong_ban')->dropDownList(
                       $listPhongBan,
                         [
                           'prompt' => 'Chọn phòng ban...',
                           'id' => 'phong-bans-dropdown',
                         ]
                   )->label(false) ?>
               </div>
          </div>


          <div class="col-lg-3 col-md-6">
              <div class="d-flex align-items-center gap-2">
                 <label class="form-label mb-0">Tổ</label>
                        <?= Html::a('<i class="fa fa-plus"> </i>', 
                                             ['/giaovien/giao-vien/insert-to'],
                                                [
                                                   'class' => 'btn ripple btn-primary btn-sm',
                                                   'title' => 'Cập nhật',
                                                   'style' => 'color: white;font-size: 0.6rem;padding: 0.2rem 0.5rem;',
                                                   'role' => 'modal-remote-2',
                                                ]
                        ) ?>
               </div>
               <div class="mt-1">
                  <?= $form->field($model, 'id_to')->dropDownList(
                      [],
                        [
                          'prompt' => 'Chọn tổ...', 
                          'id' => 'to-dropdown'
                        ]
                  )->label(false) ?>
              </div>
          </div>

             <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'chuc_vu')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'chuyen_nganh')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'vi_tri_cong_viec')->textInput(['maxlength' => true]) ?>
             </div>
             <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'trang_thai')->dropDownList([
                     'Đang làm việc' => 'Đang làm việc',
                     'Đã nghỉ việc' => 'Đã nghỉ việc',
                  ], ['prompt' => 'Chọn trạng thái']) ?>
             </div>
       </div>
    <?php CardWidget::end([]) ?>
    <?php CardWidget::begin(['title'=>'Thông tin chuyên môn']) ?>

    <div class="row">
       <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'trinh_do')->textInput(['maxlength' => true]) ?>
       </div> 
       <div class="col-lg-9 col-md-12">
            <?= $form->field($model, 'kinh_nghiem_lam_viec')->textarea(['rows' => 6]) ?>
        </div>
      
</div>

    <?php CardWidget::end([]) ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("
    $('#phong-bans-dropdown').change(function() {
        var idPhongBan = $(this).val();
        $.ajax({
            url: '" . \yii\helpers\Url::to(['get-to-list']) . "',
            data: {id_phong_ban: idPhongBan},
            success: function(data) {
                var response = $.parseJSON(data);
                var options = '';
                if (response.no_to) {
                    options = '<option value=\"\">' + response.no_to + '</option>';
                } else {
                    options = '<option value=\"\">Chọn tổ...</option>';
                    $.each(response, function(id, ten_to) {
                        options += '<option value=\"' + id + '\">' + ten_to + '</option>';
                    });
                }
                $('#to-dropdown').html(options);
            }
        });
    });
");
?>





