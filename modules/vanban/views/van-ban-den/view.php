<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VanBan */
/* @var $files app\models\FileVanBan[] */
?>

<div class="van-ban-view">

    <div class="row">
        <div class="col-md-3">
            <p><b>ID:</b></p>
            <p><?= Html::encode($model->id) ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Loại Văn Bản:</b></p>
            <p><?= Html::encode($model->id_loai_van_ban) ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Số VB:</b></p>
            <p><?= Html::encode($model->so_vb) ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Ngày Ký:</b></p>
            <p><?= Yii::$app->formatter->asDate($model->ngay_ky, 'php:d-m-Y') ?></p>
        </div>
    </div>
    
    <div class="row">
       
        <div class="col-md-3">
            <p><b>Trích Yếu:</b></p>
            <p><?= Html::encode($model->trich_yeu) ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Người Ký:</b></p>
            <p><?= Html::encode($model->nguoi_ky) ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Ngày Đến:</b></p>
            <p><?= Yii::$app->formatter->asDate($model->vbden_ngay_den, 'php:d-m-Y') ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Số Đến:</b></p>
            <p><?= Html::encode($model->vbden_so_den) ?></p>
        </div>
    </div>

    <div class="row">
       
       
        <div class="col-md-3">
            <p><b>Người Nhận:</b></p>
            <p><?= $model->vbdenNguoiNhan ? Html::encode($model->vbdenNguoiNhan->ho_ten) : 'N/A' ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Ngày Chuyển:</b></p>
            <p><?= Yii::$app->formatter->asDate($model->vbden_ngay_chuyen, 'php:d-m-Y') ?></p>
        </div>
       

        <div class="col-md-3">
            <p><b>Người Tạo:</b></p>
            <p><?= Html::encode(Yii::$app->user->identity->username) ?></p>
        </div>
        <div class="col-md-3">
            <p><b>Thời Gian Tạo:</b></p>
            <p><?= Yii::$app->formatter->asDatetime($model->thoi_gian_tao, 'php:H:i:s d-m-Y') ?></p>
        </div>
    </div>

    

    <div class="row">
    <div class="col-md-3">
            <p><b>Ghi Chú:</b></p>
            <p><?= Html::encode($model->ghi_chu) ?></p>
        </div>
    </div>
    <?php if (!empty($files)): ?>
    <h4 style="color: red;">Danh sách các file văn bản</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên File</th>
                <th>Tên Hiển Thị</th>
                <th>Kích Thước</th>
                <th>Loại</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): ?>
                <tr>
                    <td><?= Html::encode($file->file_name) ?></td>
                    <td><?= Html::encode($file->file_display_name) ?></td>
                    <td><?= Html::encode($file->file_size) ?></td>
                    <td><?= Html::encode($file->file_type) ?></td>
                    <td><?= Html::a('Xem', ['view-file', 'id' => $file->id], ['class' => 'btn btn-info btn-sm']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</div>
