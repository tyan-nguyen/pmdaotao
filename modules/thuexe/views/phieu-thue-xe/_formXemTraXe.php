<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\custom\CustomFunc;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\modules\nhanvien\models\NhanVien;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$model->ngay_thue_xe = CustomFunc::convertYMDToDMY($model->ngay_tra_xe);
?>

<div class="tra-xe-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-md-6">
    <!-- Yêu cầu duyệt phiếu -->
    <div class="card mb-4">
        <div class="card-header bg-success" style="color: white;">
           Thông tin thuê xe
       </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">        
                    <?php if (!empty($model->id_hoc_vien)):?>
                        <?= Html::label('Học viên', 'hoc-vien') ?>
                        <?= Html::textInput('hoc-vien', $model->hocVien ? $model->hocVien->ho_ten : '(Trống)', ['class' => 'form-control', 'readonly' => true]) ?>
                        <?= $form->field($model, 'id_hoc_vien')->hiddenInput()->label(false) ?>
                    <?php else: ?>
                          <?=$form->field($model,'ho_ten_nguoi_thue')->textInput()?>
                    <?php endif;?>   
                </div>
                <div class="col-md-6">
                       <?= Html:: label('Xe thuê','xe-thue')?>
                       <?= Html:: textInput('xe-thue',$model->xe ? $model->xe->hieu_xe :'(Không có tên)',['class'=>'form-control','readonly'=>true])?>
                       <?= $form->field($model, 'id_xe')->hiddenInput(['id' => 'xe-id'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::label('Loại hình thuê', 'loai-hinh-thue')?>
                    <?= html:: textInput('loai-hinh-thue',$model->loaiHinhThue ? $model->loaiHinhThue->loai_hinh_thue : '(Trống)',['class'=>'form-control','readonly'=> true])?>
                    <?= $form->field($model, 'id_loai_hinh_thue')->hiddenInput(['id' => 'loai-hinh-thue-id'])->label(false) ?>
                </div>
                <div class="col-md-6">
                   <?= Html::label('Thời gian bắt đầu thuê', 'thoi-gian-bat-dau-thue') ?>
                       <?= Html::textInput(
                           'thoi_gian_bat_dau_thue',
                           $model->thoi_gian_bat_dau_thue 
                           ? (function() use ($model) {
                           $dateTime = new \DateTime($model->thoi_gian_bat_dau_thue);
                           $dateTime->modify('-0 hours'); 
                           return Yii::$app->formatter->asDatetime($dateTime, 'php:d-m-Y | H:i:s');
                       })()
                         : '(Trống)',
                         ['class' => 'form-control', 'readonly' => true]
                    ) ?>
                   <?= $form->field($model, 'thoi_gian_bat_dau_thue')->hiddenInput(['id' => 'thoi-gian-bat-dau-thue'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                   <?= Html::label('Thời gian trả xe dự kiến', 'thoi-gian-tra-xe-du-kien') ?>
                       <?= Html::textInput(
                           'thoi_gian_tra_xe_du_kien',
                           $model->thoi_gian_tra_xe_du_kien 
                           ? (function() use ($model) {
                           $dateTime = new \DateTime($model->thoi_gian_tra_xe_du_kien);
                           $dateTime->modify('-0 hours'); 
                           return Yii::$app->formatter->asDatetime($dateTime, 'php:d-m-Y | H:i:s');
                       })()
                         : '(Trống)',
                         ['class' => 'form-control', 'readonly' => true]
                    ) ?>
                   <?= $form->field($model, 'thoi_gian_tra_xe_du_kien')->hiddenInput(['id' => 'thoi-gian-tra-xe-du-kien'])->label(false) ?>
                </div>
               <div class="col-md-6">
                   <?= Html::label('Chi phí thuê','chi-phi-thue-du-kien')?>
                   <?= Html::textInput(
                    'chi-phi-thue-du-kien',
                    $model->chi_phi_thue_du_kien
                       ? Yii::$app->formatter->asDecimal($model->chi_phi_thue_du_kien, 0) . ' VND'
                       : '(Trống)',
                       ['class'=>'form-control','readonly'=>true]
                   )?>
                   <?= $form->field($model, 'chi_phi_thue_du_kien')->hiddenInput()->label(false) ?>
               </div>
            </div>
        </div>
    </div>
    <</div>
    <div class="col-md-6">
    <!-- Kiểm duyệt phiếu -->
    <div class="card mb-4">
       <div class="card-header bg-warning" style="color: white;">
           Thông tin trả xe
       </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Ngày trả xe', 'ngay-tra-xe') ?>
                       <?= Html::textInput(
                           'ngay-tra-xe',
                           $model->ngay_tra_xe 
                           ? (function() use ($model) {
                           $dateTime = new \DateTime($model->ngay_tra_xe);
                           $dateTime->modify('-0 hours'); 
                           return Yii::$app->formatter->asDatetime($dateTime, 'php:d-m-Y');
                       })()
                         : '(Trống)',
                         ['class' => 'form-control', 'readonly' => true]
                    ) ?>
                   <?= $form->field($model, 'ngay_tra_xe')->hiddenInput(['id' => 'ngay-tra-xe'])->label(false) ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Thời gian trả xe', 'thoi-gian-tra-xe') ?>
                       <?= Html::textInput(
                           'thoi_gian_tra_xe',
                           $model->thoi_gian_tra_xe 
                           ? (function() use ($model) {
                           $dateTime = new \DateTime($model->thoi_gian_tra_xe);
                           $dateTime->modify('-0 hours'); 
                           return Yii::$app->formatter->asDatetime($dateTime, 'php:d-m-Y | H:i:s');
                       })()
                         : '(Trống)',
                         ['class' => 'form-control', 'readonly' => true]
                    ) ?>
                   <?= $form->field($model, 'thoi_gian_tra_xe')->hiddenInput(['id' => 'thoi-gian-tra-xe'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                     <?= $form->field($model, 'chi_phi_thue_phat_sinh')->textInput(['id' => 'chi-phi-thue-phat-sinh','readonly' => true]) ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Nhân viên ký trả', 'nhan-vien-ky-tra') ?>
                        <?= Html::textInput('nhan-vien-ky-tra', $model->nhanVienKyTra ? $model->nhanVienKyTra->ho_ten : '(Trống)', ['class' => 'form-control', 'readonly' => true]) ?>
                        <?= $form->field($model, 'id_nhan_vien_ky_tra')->hiddenInput()->label(false) ?>
                </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                    <?= $form->field($model, 'tinh_trang_xe_khi_tra')->textarea(['rows' => 6,'readonly' => true]) ?>
               </div>
            </div>
        </div>
    </div>
    </div>
  </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>

</script>
<style>
 .tra-xe-form label {
   color:blue;
}
</style>
