<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\hocvien\models\HocVien;
use app\modules\lichhoc\models\LichThi;
/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\KetQuaThi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php
    $modelHV = HocVien::find()->where(['id'=>$idHV])->one();
    $idKH = $modelHV->id_khoa_hoc;
    $lichThi = LichThi::find()->where(['id_khoa_hoc' => $idKH])->one();
    $idLT = $lichThi->id;
?>

<div class="form-ket-qua-thi">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php CardWidget::begin(['title' => 'Thông tin học viên']) ?>
                <p>Họ tên: <span><?= $modelHV->ho_ten?> </span></p>
                <p>Khóa học: <span><?= $modelHV->khoaHoc->ten_khoa_hoc?></span> </p>
            <?php CardWidget::end() ?>
        </div>
        <div class="col-md-6">
            <?php CardWidget::begin(['title'=>'Thông tin lịch thi'])?>
                <p>Ngày thi: <span><?= Yii::$app->formatter->asDatetime($lichThi->thoi_gian_thi, 'php:d-m-Y | H:i') ?></span></p>
                <p>Phòng thi: <span><?=$lichThi->phongThi->ten_phong?>  </span></p>
            <?php CardWidget::end()?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php CardWidget ::begin(['title'=>'Nhập kết quả thi'])?>
               <div class="row">
               <div class="col-md-6">
                  <?php
                    $idHang = $modelHV->id_hang;
                    $listPhanThi = \app\modules\lichhoc\models\PhanThi::find()
                        ->where(['id_hang' => $idHang])
                        ->select(['id', 'ten_phan_thi'])
                        ->asArray()
                        ->all();
                    $listPhanThiDropdown = \yii\helpers\ArrayHelper::map($listPhanThi, 'id', 'ten_phan_thi');
             ?>

             <?= $form->field($model, 'id_phan_thi')->dropDownList(
                  $listPhanThiDropdown,
                 ['prompt' => 'Chọn phần thi','id' => 'dropdown-phan-thi'] 
             ) ?>
        </div>

        <div class="col-md-6">
             <?= $form->field($model, 'lan_thi')->input('number', [
                'min' => 1, 
                'maxlength' => true, 
                'placeholder' => 'Nhập lần thi', 
                'id'=>'input-lan-thi',
             ]) ?>
        </div>

        <div class="col-md-6">
             <?= $form->field($model, 'diem_so')->input('number', [
                 'min' => 0, 
                 'max' => 100, 
                 'step' => 1, 
                 'placeholder' => 'Nhập điểm số', 
                 'id' => 'input-diem-so',
             ]) ?>
        </div>

        <div class="col-md-6">
           <?= $form->field($model, 'ket_qua')->textInput([
                'readonly' => true, 
                'id' => 'input-ket-qua', 
                'placeholder' => 'Tự động cập nhật kết quả',
           ]) ?>          
        </div>
                  <div class="col-md-12">
                    <br>
                        <div class="form-group" style="text-align:center;">
                            <?= Html::button('<i class="fa fa-exchange"> </i> Chuyển ', [
                                'class' => 'btn btn-primary',
                                'id' => 'btn-chuyen'
                            ]) ?>
                        </div>
                  </div>
                </div>
            <?php CardWidget::end()?>
        </div>
        <div class="col-md-6">
    <?php CardWidget::begin(['title' => 'KẾT QUẢ THI']) ?>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Phần thi</th>
                    <th>Điểm số</th>
                    <th>Kết quả</th>
                </tr>
            </thead>

            <tbody id="reloadsTableBody">
                   
            </tbody>
         
            <tbody id="resultsTableBody">
                  
            </tbody>
            <tfoot>
                 <tr id="statusRow">
                     <td colspan="3" style="text-align: center; font-weight: bold;">Kết quả:</td>
                 </tr>
            </tfoot>
        </table>
                 <div class="col-md-12">
                        <div class="form-group" style="text-align:center;">
                            <?= Html::button('<i class="fa fa-history"> </i> Reset ', [
                                'class' => 'btn btn-success',
                                'id' => 'btn-reset'
                            ]) ?>
                        </div>
                 </div>
    <?php CardWidget::end() ?>
</div>

    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    var idHV = <?= $idHV ?>;  
    var idLT = <?= $idLT ?>;
</script>


<script>
    $(document).ready(function () {
        var hocVienId = idHV; 
        $.ajax({
            url: '/hocvien/hoc-vien/get-results',
            type: 'GET',
            data: { hocVienId: hocVienId },
            success: function (response) {
                if (response.success) {
                    $('#reloadsTableBody').empty(); 
                    var results = response.data;
                    if (results.length === 0) {
                        console.warn('Dữ liệu trả về rỗng.');
                        return;
                    }
                    results.forEach(function (result) {
                        var ketQuaColor = result.ket_qua === 'ĐẠT' ? 'green' : 'red'; 
                        var ketQuaStyled = `
                             <span style="font-weight: bold; color: ${ketQuaColor};">${result.ket_qua}</span>
                        `;
                        var diemSoStyled = `
                             <span style="font-weight: bold; color: red;">${result.diem_so}</span>
                        `;
                        var row = `
                            <tr>
                                <td>${result.ten_phan_thi}</td>
                                <td>${diemSoStyled}</td>
                                <td>${ketQuaStyled}</td>
                            </tr>
                        `;
                        $('#reloadsTableBody').append(row);
                    });
                } else {
                    alert('Lỗi từ server: ' + (response.message || 'Không rõ nguyên nhân.'));
                    console.error('Lỗi từ server:', response);
                }
            },
            error: function (xhr, status, error) {
                alert('Không thể kết nối đến server. Vui lòng thử lại sau.');
                console.error('Chi tiết lỗi:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
            }
        });
    });
</script>


<script>
$(document).ready(function () {
    let diemDatToiThieu = 0;
    $('#dropdown-phan-thi').on('change', function () {
        let idPhanThi = $(this).val(); 
        if (idPhanThi) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['/hocvien/hoc-vien/get-diem-dat-toi-thieu']) ?>',
                type: 'GET',
                data: { id: idPhanThi },
                success: function (response) {
                    diemDatToiThieu = parseFloat(response);
                },
                error: function () {
                    diemDatToiThieu = 0;
                },
            });
        } else {
            diemDatToiThieu = 0; 
        }
    });

    $('#input-diem-so').on('input', function () {
        let diemSo = parseFloat($(this).val()); 
        if (!isNaN(diemSo)) {
            if (diemSo >= diemDatToiThieu) {
    $('#input-ket-qua')
        .val('ĐẠT')
        .css('color', 'green'); 
      } else {
         $('#input-ket-qua')
        .val('RỚT')
        .css('color', 'red'); 
      }
        } else {
            $('#input-ket-qua').val(''); 
        }
    });
});
</script>

<script>
$(document).ready(function () {
    function checkFields() {
        var phanThi = $('#dropdown-phan-thi').val();
        var lanThi = $('#input-lan-thi').val();
        var diemSo = $('#input-diem-so').val();
        var ketQua = $('#input-ket-qua').val();

        if (phanThi && lanThi && diemSo && ketQua) {
            $('#btn-chuyen').prop('disabled', false);
        } else {
            $('#btn-chuyen').prop('disabled', true);
        }
    }

    $('#dropdown-phan-thi, #input-lan-thi, #input-diem-so, #input-ket-qua').on('input change', function() {
        checkFields();
    });

    checkFields();

    let ketQuaThiData = []; 
    function addKetQuaThi() {
        let idPhanThi = $('#dropdown-phan-thi').val(); 
        let lanThi = $('#input-lan-thi').val();       
        let diemSo = $('#input-diem-so').val();       
        let ketQua = $('#input-ket-qua').val();       
        if (idPhanThi && lanThi && diemSo && ketQua) {
            ketQuaThiData.push({
                id_phan_thi: idPhanThi,
                diem_so: diemSo,
                ket_qua: ketQua,
                lan_thi: lanThi,
            });
            let color = ketQua === 'ĐẠT' ? 'green' : 'red';
            let phanThiName = $('#dropdown-phan-thi option:selected').text();
            let newRow = `<tr>
                            <td>${phanThiName}</td>
                            <td style="color: red; font-weight: bold;">${diemSo}</td>
                            <td style="color: ${color}; font-weight: bold;">${ketQua}</td>
                          </tr>`;
            $('#resultsTableBody').append(newRow); 

            $('#dropdown-phan-thi').val('');
            $('#input-lan-thi').val('');
            $('#input-diem-so').val('');
            $('#input-ket-qua').val('');
        } else {
            alert('Vui lòng điền đầy đủ thông tin!');
        }
    }
  
    $('#btn-chuyen').click(function () {
        addKetQuaThi(); 
    });

    $(document).on('click', '.btn-primary[type="submit"]', function (e) {
        e.preventDefault(); 
        if (ketQuaThiData.length === 0) {
            alert('Chưa có dữ liệu để lưu!');
            return;
        }
        $.ajax({
            url: '/hocvien/hoc-vien/create-ket-qua-thi',
            type: 'POST',
            data: {
                ketQuaThiData: ketQuaThiData, 
                idHV: idHV,                  
                idLT: idLT,                  
            },
            success: function (response) {
                if (response.success) {
                    alert('Lưu thành công!');
                    $('#modal').modal('hide'); 
                    ketQuaThiData = [];        
                    $('#resultsTableBody').empty();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                alert('Không thể gửi dữ liệu. Vui lòng thử lại!');
            },
        });
    });
});
</script>

<script>
$(document).ready(function () {
    $('#btn-reset').click(function () {
        $('#resultsTableBody').empty(); 
        $('#dropdown-phan-thi').val('');
        $('#input-lan-thi').val('');
        $('#input-diem-so').val('');
        $('#input-ket-qua').val('');
    });
});
</script>



<style>
.form-ket-qua-thi label {
    font-weight: bold;
    color:blue;
}
</style>
