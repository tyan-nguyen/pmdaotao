<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\hocvien\models\HocVien;
use app\modules\lichhoc\models\LichThi;
use app\modules\lichhoc\models\PhanThi;
use app\modules\lichhoc\models\KetQuaThi;
/** @var yii\web\View $this */
/** @var app\modules\lichhoc\models\KetQuaThi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php
    $modelHV = HocVien::find()->where(['id'=>$idHV])->one();
    $idKH = $modelHV->id_khoa_hoc;
    $lichThi = LichThi::find()->where(['id_khoa_hoc' => $idKH])->one();
    $idLT = $lichThi->id;
    $hangHV = $modelHV->id_hang;
    $phanThi = PhanThi::find()->where(['id_hang' => $hangHV])->all();
    $soLuongPT = count($phanThi);
    $ketQuaThi = KetQuaThi :: find()->where(['id_hoc_vien'=>$modelHV->id])->all();
    if (empty($ketQuaThi)) {
        $ketQuaThi = null; 
    }
?>

<div class="form-ket-qua-thi">
    <?php $form = ActiveForm::begin(); ?>
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
        <table class="table table-bordered text-center" id="resultsTable">
            <thead>
                <tr>
                    <th>Phần thi</th>
                    <th class="hidden-column" style=" display: none;">Thứ tự thi</th>
                    <th>Điểm</th>
                    <th>Kết quả</th>
                </tr>
            </thead>

            <tbody id="reloadsTableBody">
                   
            </tbody>
         
            <tbody id="resultsTableBody">

            </tbody>
            <tfoot>
               <tr id="statusRow">
                   <td colspan="4" style="text-align: center; font-weight: bold;">Kết quả:</td>
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

    <?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
    <?php ActiveForm::end(); ?>

</div>

<script>
    var idHV = <?= $idHV ?>;  
    var idLT = <?= $idLT ?>;
</script>

<script>   
var checkPhanThi = 0; 
function reloadResultsTable(hocVienId) {
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
                            <td>${result.ten_phan_thi} (${result.lan_thi})</td>
                            <td>${diemSoStyled}</td>
                            <td id="idKq">${ketQuaStyled}</td>
                        </tr>
                    `;
                    $('#reloadsTableBody').append(row);

                    if (result.ket_qua === 'ĐẠT') {
                        checkPhanThi++;
                    }
                });

                const soLuongPT = <?= $soLuongPT ?>; 

                let resultText = checkPhanThi === soLuongPT ? "Đủ điều kiện cấp giấy phép" : "Chưa đủ điều kiện cấp giấy phép";
                let resultColor = checkPhanThi === soLuongPT ? "green" : "red";
                $('#statusRow').remove(); 
                $('#resultsTable tfoot').html(`
                    <tr id="statusRow">
                        <td colspan="3" style="text-align: center; font-weight: bold; color: ${resultColor};">
                            Kết quả: ${resultText}
                        </td>
                    </tr>
                `);
                if (resultText === 'Đủ điều kiện cấp giấy phép') {
                   $('#btn-chuyen').hide(); 
                   $('#input-lan-thi').prop('disabled', true);
                   $('#dropdown-phan-thi').prop('disabled', true);
                   $('#input-diem-so').prop('disabled', true);
                   $('#input-ket-qua').prop('disabled', true);
                     } else {
                          $('#btn-chuyen').show(); 
                }  
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
}
</script>

<script>
    $(document).ready(function () {
        var hocVienId = idHV; 
        reloadResultsTable(hocVienId);
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
    let ketQuaThiData = [];

    function checkFields() {
        var phanThi = $('#dropdown-phan-thi').val();
        var lanThi = $('#input-lan-thi').val();
        var diemSo = $('#input-diem-so').val();
        var ketQua = $('#input-ket-qua').val();

        $('#btn-chuyen').prop('disabled', !(phanThi && lanThi && diemSo && ketQua));
    }

    function checkResultsTable() {
        $('#btn-save').prop('disabled', $('#resultsTableBody tr').length === 0);
    }

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
                            <td>${phanThiName} (${lanThi})</td>
                            <td style="color: red; font-weight: bold;">${diemSo}</td>
                            <td style="color: ${color}; font-weight: bold;" id="idKq">${ketQua}</td>
                          </tr>`;

            $('#resultsTableBody').append(newRow);

            $('#dropdown-phan-thi, #input-lan-thi, #input-diem-so, #input-ket-qua').val('');
            checkFields();
            checkResultsTable();
        } else {
            alert('Vui lòng điền đầy đủ thông tin!');
        }
    }

    $('#dropdown-phan-thi, #input-lan-thi, #input-diem-so, #input-ket-qua').on('input change', checkFields);
    $('#btn-chuyen').click(addKetQuaThi);

    $('#btn-reset').click(function () {
        $('#resultsTableBody').empty();
        ketQuaThiData = [];
        $('#dropdown-phan-thi, #input-lan-thi, #input-diem-so, #input-ket-qua').val('');
        checkResultsTable();
    });

    $(document).on('click', '.btn-primary[type="submit2"]', function (e) {
        e.preventDefault();
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
                    checkPhanThi = 0;
                    reloadResultsTable(idHV);
                    $('#modal').modal('hide');
                    ketQuaThiData = [];
                    $('#resultsTableBody').empty();
                    checkResultsTable();
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

    const observer = new MutationObserver(checkResultsTable);
    observer.observe(document.getElementById('resultsTableBody'), { childList: true, subtree: false });

    checkFields();
    checkResultsTable();
});
</script>



<style>
.form-ket-qua-thi label {
    font-weight: bold;
    color:blue;
}
</style>