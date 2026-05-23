<?php

use app\custom\CustomFunc;
use app\modules\banhang\models\HoaDon;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\user\models\User;
use app\widgets\CardWidget;
use app\widgets\FileDisplayWidget;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\PhieuDeNghi */
/* @var $form yii\widgets\ActiveForm */

$model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_hoan_thanh = CustomFunc::convertYMDToDMY($model->ngay_hoan_thanh);
$nguoiDeNghiValue = '';
if ($model->nguoi_de_nghi) {
    $userNDN = User::findOne($model->nguoi_de_nghi);
    $nguoiDeNghiValue = $userNDN ?
        ('+ ' . $userNDN->ho_ten . ' (' . $userNDN->username . ')')
        : '';
}
$oldTGD = $model->ngay_duyet;
if (!$model->isNewRecord) {
    if ($model->ngay_duyet != null)
        $model->ngay_duyet = CustomFunc::convertYMDHISToDMYHIS($model->ngay_duyet);
}
?>

<div class="phieu-de-nghi-form">

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link show active " id="info-tab" data-bs-toggle="tab" href="#info-div" role="tab" aria-controls="info-div" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Thông tin phiếu</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="file-tab" data-bs-toggle="tab" href="#file-div" role="tab" aria-controls="file-div" aria-selected="false" style="color: blue;"><i class="fa fa-paperclip"></i> Tệp đính kèm</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">
                            <!-- thông tin học viên  -->
                            <div class="tab-pane fade show active" id="info-div" role="tabpanel" aria-labelledby="info-tab">

                                <div class="row">

                                    <div class="col-md-12">
                                        <?php $form = ActiveForm::begin(); ?>

                                        <?php CardWidget::begin(['title' => 'THÔNG TIN PHIẾU ĐỀ NGHỊ']) ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $form->errorSummary($model); ?>
                                            </div>

                                            <?php if ($model->isNewRecord) { ?>
                                                <div class="col-md-12">
                                                    <div class="alert alert-outline-success" role="alert">
                                                        <button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
                                                            <span aria-hidden="true">×</span></button>
                                                        <strong><span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-bell"></i></span> Thêm phiếu đề nghị</strong>:
                                                        <ul>
                                                            <li><i class="fa fa-angle-double-right mb-2 me-2"></i> Chọn loại yêu cầu.</li>
                                                            <li><i class="fa fa-angle-double-right mb-2 me-2"></i> Nhập km lúc yêu cầu (đối với xe) và nội dung đề nghị.</li>
                                                            <li><i class="fa fa-angle-double-right mb-2 me-2"></i> Chọn xe hoặc thiết bị.</li>
                                                            <li><i class="fa fa-angle-double-right mb-2 me-2"></i> Chọn ngày bắt đầu và ngày hoàn thành.</li>
                                                            <li><i class="fa fa-angle-double-right mb-2 me-2"></i> Bấm lưu lại để xuất hiện danh sách chi tiết nội dung muốn đề nghị.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="col-md-2">
                                                <?= $form->field($model, 'loai_phieu')->dropDownList(PhieuDeNghi::getLoaiPhieuList(), [
                                                    'prompt' => '- Chọn loại phiếu -'
                                                ]) ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'loai_tai_san')->dropDownList(PhieuDeNghi::getLoaiTaiSanList(), [
                                                    'prompt' => '- Chọn loại tài sản -'
                                                ]) ?>
                                            </div>

                                            <div class="col-md-4">
                                                <?= $form->field($model, 'nguoi_de_nghi')->widget(Select2::class, [
                                                    'initValueText' => $nguoiDeNghiValue, // This shows selected text on form load
                                                    'language' => 'vi',
                                                    'data' => User::getList(),
                                                    'options' => [
                                                        'placeholder' => 'Chọn người đề nghị...',
                                                        'class' => 'form-control dropdown-with-arrow',
                                                        'id' => 'idNguoiDeNghi'
                                                    ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                                                        'width' => '100%',
                                                        'minimumInputLength' => 0, // ← allow fetch without typing
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'loai_yeu_cau')->dropDownList(PhieuDeNghi::getLoaiSuaXeList(), [
                                                    'prompt' => '- Chọn yêu cầu sửa xe -'
                                                ]) ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'so_km_luc_yeu_cau')->textInput()->label('Số Km') ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?= $form->field($model, 'noi_dung_de_nghi')->textInput() ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'dd/mm/yyyy',
                                                        'todayHighlight' => true,
                                                        'todayBtn' => true
                                                    ]
                                                ]); ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'ngay_hoan_thanh')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'dd/mm/yyyy',
                                                        'todayHighlight' => true,
                                                        'todayBtn' => true
                                                    ]
                                                ]); ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'trang_thai')->dropDownList(PhieuDeNghi::getTrangThaiList(), [
                                                    'prompt' => '- Chọn trạng thái -'
                                                ]) ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'nguoi_duyet')->widget(Select2::class, [
                                                    //'initValueText' => $nguoiDuyetValue, // This shows selected text on form load
                                                    'language' => 'vi',
                                                    'data' => User::getListUserDuyetKeHoach(),
                                                    'options' => [
                                                        'placeholder' => 'Chọn người duyệt...',
                                                        'class' => 'form-control dropdown-with-arrow',
                                                        'id' => 'idNguoiDuyet'
                                                    ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                                                        'width' => '100%',
                                                        'minimumInputLength' => 0, // ← allow fetch without typing
                                                    ],
                                                ]); ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'ngay_duyet')->textInput(['id' => 'time']) ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?= $form->field($model, 'ghi_chu_duyet')->textInput() ?>
                                            </div>
                                            <!-- <div class="col-md-2">
            <label>Có chi tiết</label>
            <?= $form->field($model, 'phieu_co_chi_tiet')->checkbox(['label' => false]) ?>
        </div>-->
                                            <div class="col-md-2">
                                                <?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(
                                                    HoaDon::getDmHinhThucThanhToan(),
                                                    ['prompt' => '-Tất cả-']
                                                )->label('HT.TT') ?>
                                            </div>
                                            <div class="col-md-2">
                                                <label><?= $model->getAttributeLabel('edit_mode') ?></label>
                                                <?= $form->field($model, 'edit_mode')->checkbox(['label' => false]) ?>
                                            </div>



                                        </div>
                                        <?php if (!Yii::$app->request->isAjax) { ?>
                                            <div class="form-group">
                                                <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                            </div>
                                        <?php } ?>

                                        <?php CardWidget::end() ?>

                                        <?php ActiveForm::end(); ?>
                                    </div><!-- col-md-8 -->


                                </div>

                            </div>

                            <!-- Thông tin file -->
                            <div class="tab-pane fade" id="file-div" role="tabpanel" aria-labelledby="file-tab">

                                <!-- Thông tin file -->
                                <div class="col-xl-12 col-md-12">

                                    <div class="card custom-card">
                                        <!-- <div class="card-header custom-card-header rounded-bottom-0">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link show active " id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Thông tin phiếu</a>
                                                </li>

                                            </ul>
                                        </div> -->
                                        <div class="card-body">
                                            <div class="skill-tags">
                                                <!-- Nội dung Tài liệu khóa học -->
                                                <div class="tab-pane fade show active" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">

                                                    <?= FileDisplayWidget::widget([
                                                        'type' => 'ALL',
                                                        'doiTuong' => PhieuDeNghi::MODEL_ID,
                                                        'idDoiTuong' => $model->id,
                                                    ]) ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>








    </div><!-- row-->

    <?php if (!$model->isNewRecord) { ?>

        <?php CardWidget::begin(['title' => 'CHI TIẾT PHIẾU ĐỀ NGHỊ']) ?>

        <div id="objHoaDonChiTiet" style="margin-top:10px;">
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <div class="box">
                        <!-- <div class="box-header">
                            <h3 class="box-title">CHI TIẾT HÓA ĐƠN</h3>+
                        </div> -->
                        <div class="box-body no-padding">
                            <!-- <button type="button" onClick="AddVatTu()">Thêm vật tư</button> -->

                            <!-- ..............here------------------------- -->
                            <form id="idForm" method="post" action="/taisan/phieu-de-nghi-chi-tiet/save?id=<?= $model->id ?>">
                                <table id="vtTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:3%">STT</th>
                                            <th style="width:10%">Loại hạng mục</th>
                                            <th style="width:17%">Tên hạng mục</th>
                                            <th style="width:9%">ĐVT</th>
                                            <th style="width:9%">Số lượng</th>
                                            <th style="width:9%">Đơn giá(VND)</th>
                                            <th style="width:9%">Chiết khấu(VND)</th>
                                            <th style="width:9%">Thành tiền(VND)</th>
                                            <th style="width:10%">Ghi chú</th>
                                            <th style="width:15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr :id="'tr' + result.id" v-for="(result, indexResult) in results.dsVatTu" :key="result.id">
                                            <td :id="'td' + indexResult">{{ (indexResult + 1) }}</td>
                                            <td>{{ result.tenLoaiHangMuc }}</td>
                                            <td>{{ result.tenHangMuc }}</td>
                                            <td>{{ result.dvt }}</td>
                                            <td style="text-align: right">{{ result.soLuong.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                            <td style="text-align: right">{{ result.donGia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                            <td style="text-align: right">{{ result.chietKhau.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                            <td style="text-align: right">{{ result.thanhTien!=null?result.thanhTien.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0 }}</td>
                                            <td>{{ result.ghiChu }}</td>

                                            <td>
                                                <?php if ($model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP || $model->edit_mode) { ?>
                                                    <span class="lbtn-remove btn btn-primary btn-sm" v-on:click="editVT(indexResult, 0)"><i class="fa fa-edit"></i> Sửa</span>
                                                    <span class="lbtn-remove btn btn-danger btn-sm" v-on:click="deleteVT(result.id)"><i class="fa fa-trash"></i> Xóa</span>
                                                <?php } ?>

                                                <?php /*if($model->trang_thai!='BAN_NHAP' && $model->edit_mode==1){ ?>
                    					<span class="lbtn-remove btn btn-default btn-xs" v-on:click="editVT(indexResult, 1)"><i class="fa fa-edit"></i> Sửa</span>
                    					<?php }*/ ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7" style="text-align: right">Tổng cộng(VND)</th>
                                            <th style="text-align: right"><span style="font-weight:bold">{{ results.tongTien!=null?results.tongTien.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0 }}</span></th>
                                            <th></th>
                                            <!-- <th style="width:10%">Ghi chú</th>-->
                                        </tr>

                                    </tfoot>
                                </table>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end #obj -->

        <?php if ($model->trang_thai == PhieuDeNghi::TRANGTHAI_NHAP || $model->edit_mode) { ?>
            <a href="#" onClick="AddVatTu()" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Thêm chi tiết</a>
            <a href="/taisan/dm-hang-muc/create-from-phieu" class="btn btn-primary btn-sm" data-bs-target="#ajaxCrudModal2"
                role="modal-remote-2" data-bs-placement="top" data-bs-toggle="tooltip">
                <i class="fa-solid fa-plus"></i> Thêm hạng mục</a>
        <?php } ?>
        <a href="#" onClick="InHoaDon()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Phiếu đề nghị (<span id="soLanIn"><?= $model->so_lan_in ?? 0 ?></span>)</a>
        <?php if ($model->trang_thai == PhieuDeNghi::TRANGTHAI_DADUYET || $model->trang_thai == PhieuDeNghi::TRANGTHAI_HOANTHANH) { ?>
            <a class="btn btn-primary btn-sm" href="/taisan/phieu-de-nghi/thanh-toan?id=<?= $model->id ?>" role="modal-remote"><i class="fa-solid fa-file-export"></i> Thanh toán</a>

            <a href="#" onClick="InHoaDonChiPhi()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Phiếu chi phí</a>
        <?php } ?>

        <?php CardWidget::end() ?>

    <?php } else { //end if isNewRecord 
    ?>
        <?php CardWidget::begin(['title' => 'CHI TIẾT PHIẾU ĐỀ NGHỊ']) ?>
        <span class="text-success">Vui lòng lưu thông tin PHIẾU ĐỀ NGHỊ trước để nhập chi tiết nội dung!</span>
        <?php CardWidget::end() ?>

    <?php } //end else if isNewRecord
    ?>
    <div style="display:none">
        <div id="printHD">
            <?php // $model->isNewRecord ? '' : $this->render('_print_phieu', compact('model')) 
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    //var fp = flatpickr.localize(flatpickr.l10ns.vn);
    var fp = $("#time").flatpickr({
        enableTime: true,
        enableSeconds: true, // This enables the seconds input
        dateFormat: "d/m/Y H:i:s",
        time_24hr: true,
        allowInput: true
    });
    fp.setDate(new Date("<?= $oldTGD ?>"));

    var vue1 = new Vue({
        el: '#objHoaDonChiTiet',
        data: {
            results: <?= json_encode($model->dsChiTiet()) ?>
        },
        methods: {
            editVT: function(indexResult) {
                editVatTu(this.results.dsVatTu[indexResult]);
            },
            deleteVT: function(id) {
                var result = confirm("Xác nhận xóa chi tiết khỏi phiếu đề nghị?");
                if (result) {
                    deleteVatTu(id);
                }
            }
        },
        computed: {},
    });

    function deleteVatTu(id) {
        $.ajax({
            type: 'post',
            url: '/taisan/phieu-de-nghi-chi-tiet/delete-vat-tu?id=' + id,
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    vue1.results = data.results;
                } else if (data.status == 'error') {
                    alert(data.message);
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function AddVatTu() {
        var formRow = '<tr id="idTr">';
        formRow += '<td>STT</td>';
        formRow += '<td><div style="display:none"><input type="text" name="loaiVatTu" id="lvtNew" value="VAT-TU" /></div><span id="loaiVatTuNew">Loại hàng hóa</span></td>';
        formRow += '<td><select id="idVatTuAdd" name="idVatTu" required></select></td>';
        formRow += '<td><span id="donViTinhNew">Đơn vị tính</span></td>';
        formRow += '<td><input type="text" name="soLuong" id="soLuongNew" required style="width:80px"/></td>';
        formRow += '<td><input type="text" name="donGia" id="donGiaNew" required style="width:80px"/></td>';
        formRow += '<td><input type="text" name="chietKhau" id="chietKhauNew" style="width:80px"/></td>';
        formRow += '<td><span id="thanhTienNew">Thành tiền</span></td>';
        formRow += '<td><input type="text" name="ghiChu" /></td>';
        formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="remove()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span></td>';
        formRow += '</tr>';

        if ($('#idTr').length <= 0) {
            $('#vtTable tbody').append(formRow);

            //fill dropdown vat tu
            fillVatTuDropDown('#idVatTuAdd', '');

            $('#idVatTuAdd').select2({
                dropdownParent: $('#ajaxCrudModal'),
                selectOnClose: true,
                width: '100%'
            });
            $('#idVatTuAdd').on("select2:select", function(e) {
                //alert(this.value);
                getVatTuAjax(this.value);
            });
            //focus and open select 2
            // $('#idVatTuAdd').select2('focus');
            // $('#idVatTuAdd').select2('open');


            $("#soLuongNew").on("input", function() {
                // alert($(this).val()); 
                $('#thanhTienNew').text(($(this).val() * $('#donGiaNew').val() - $('#chietKhauNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
            $("#donGiaNew").on("input", function() {
                //alert($(this).val()); 
                $('#thanhTienNew').text(($(this).val() * $('#soLuongNew').val() - $('#chietKhauNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
            $("#chietKhauNew").on("input", function() {
                $('#thanhTienNew').text(($('#donGiaNew').val() * $('#soLuongNew').val() - $(this).val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
            /*$("#thanhTienNew").on("input", function() {
               $('#thanhTienNew').text(($(this).val()*$('#soLuongNew').val()-$('#chietKhauNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });*/
        } else {
            alert('Vui lòng lưu dữ liệu đang nhập trước!');
        }
    }

    function editVatTu(arr) {
        if ($("#idTrUpdate").length > 0) {
            alert('Bạn đang chỉnh sửa chi tiết hàng hóa, vui lòng lưu dữ liệu hoặc hủy bỏ để tránh sai số, nhầm lẫn!');
        } else {
            //alert(arr['slyc']);
            var formRow = '<tr id="idTrUpdate">';
            formRow += '<td><input type="text" name="id" value="' + arr['id'] + '" style="display:none" />' + arr['id'] + '</td>';
            formRow += '<td>' + arr['loaiVatTu'] + '</td>';
            formRow += '<td>' + arr['tenVatTu'] + '</td>';
            //formRow += '<td><select id="idVatTuEdit" name="idVatTu"></select></td>';
            formRow += '<td>' + arr['dvt'] + '</td>';
            formRow += '<td><input type="text" name="soLuong" value="' + (arr['loaiVatTu'] == 'NHOM' ? arr['soLuongCayNhom'] : arr['soLuong']) + '" id="soLuongEdit" required  style="width:80px"/></td>';
            formRow += '<td><input type="text" name="donGia" value="' + arr['donGia'] + '" id="donGiaEdit" required  style="width:80px"/></td>';
            formRow += '<td><input type="text" name="chietKhau" value="' + arr['chietKhau'] + '" id="chietKhauEdit"  style="width:80px"/></td>';
            formRow += '<td><span id="thanhTienEdit">' + arr['thanhTien'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' </span></td>';
            /*formRow += '<td><span id="chietKhauEdit">'+ arr['chietKhau'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' </span></td>';*/
            formRow += '<td><input type="text" name="ghiChu" value="' + arr['ghiChu'] + '" /></td>';
            formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="removeEdit()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span> </td>';
            formRow += '</tr>';

            $('#tr' + arr['id']).hide();
            $('#tr' + arr['id']).after(formRow);

            $('#idTrUpdate input[name="slyc"]').focus();
            $('#idTrUpdate input[name="slyc"]').select();

            //fill dropdown vat tu
            //fillVatTuDropDown('#idVatTuEdit', arr['idVatTu']);
            /* $('#idVatTuEdit').select2({
          placeholder: 'Select an option',
           width: '100%'
        }); */

            $("#soLuongEdit").on("input", function() {
                $('#thanhTienEdit').text(($(this).val() * $('#donGiaEdit').val() - $('#chietKhauEdit').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
            $("#donGiaEdit").on("input", function() {
                //alert($(this).val()); 
                $('#thanhTienEdit').text(($(this).val() * $('#soLuongEdit').val() - $('#chietKhauEdit').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            });
            $("#chietKhauEdit").on("input", function() {
                $('#thanhTienEdit').text(($('#donGiaEdit').val() * $('#soLuongEdit').val() - $(this).val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });

        }
    }

    function removeEdit() {
        if ($("#idTrUpdate").length > 0) {
            $('#idTrUpdate').prev("tr").show();
            $('#idTrUpdate').remove();
        }
    }

    function remove() {
        if ($("#idTr").length > 0) {
            $('#idTr').remove();
        }
    }

    var frm = $('#idForm');

    frm.submit(function(e) {

        e.preventDefault();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    if (data.type == 'create') {
                        $('#idTr').remove();
                    } else if (data.type == 'update') {
                        $('#idTrUpdate').remove();
                        $('#tr' + data.vatTuXuat['id']).show();
                    }
                    vue1.results = data.results
                } else if (data.status == 'error') {
                    alert(data.message);
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });

    function fillVatTuDropDown(dropdownId, selected) {

        $.ajax({
            type: 'post',
            url: '/taisan/phieu-de-nghi-chi-tiet/get-list-vat-tu?selected=' + selected + '&loai=',
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                $(dropdownId).html(data.options);
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function getVatTuAjax(idvt) {
        $.ajax({
            type: 'post',
            url: '/taisan/phieu-de-nghi-chi-tiet/get-vat-tu-ajax?idvt=' + idvt,
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    $('#idTr #donGiaNew').val(data.donGia);
                    $('#idTr #loaiVatTuNew').text(data.loaiVatTu);
                    $('#idTr #donViTinhNew').text(data.dvt);
                    $('#idTr #soLuongNew').val(1);
                    //set thanh tien
                    $('#thanhTienNew').text(($('#soLuongNew').val() * $('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                } else {
                    alert('Danh mục này không còn tồn tại trên hệ thống!');
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function fillNhomDropDown(dropdownId, selected) {

        $.ajax({
            type: 'post',
            url: '/banhang/hoa-don-chi-tiet/get-list-nhom?selected=' + selected,
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                $(dropdownId).html(data.options);
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function getNhomAjax(idvt) {
        $.ajax({
            type: 'post',
            url: '/banhang/hoa-don-chi-tiet/get-nhom-ajax?idvt=' + idvt,
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    $('#idTr #donGiaNew').val(data.donGia);
                    $('#idTr #loaiVatTuNew').text(data.loaiVatTu);
                    $('#idTr #donViTinhNew').text(data.dvt);
                    $('#idTr #soLuongNew').val(1);
                    //set thanh tien
                    $('#thanhTienNew').text(($('#soLuongNew').val() * $('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                } else {
                    alert('Vật tư không còn tồn tại trên hệ thống!');
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function InHoaDon() {
        //load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
        $.ajax({
            type: 'post',
            url: '/taisan/phieu-de-nghi/get-phieu-in-ajax?idPhieu=' + <?= $model->id ? $model->id : "''" ?>,
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    $('#printHD').html(data.content);
                    printHoaDon(); //call from script.js
                    setTimeout(function() {
                        updatePrintCount(<?= $model->id ? $model->id : "''" ?>);
                    }, 1000); // Đợi 1 giây sau khi in để cập nhật
                } else {
                    alert('Vật tư không còn tồn tại trên hệ thống!');
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }
    // Hàm cập nhật số lần in
    function updatePrintCount(id) {
        $.ajax({
            type: 'POST',
            url: '/taisan/phieu-de-nghi/update-print-count?id=' + id,
            success: function(response) {
                if (response.success) {
                    $('#soLanIn').text(response.so_lan_in); // Cập nhật số lần in
                } else {
                    alert('Cập nhật số lần in thất bại!');
                }
            },
            error: function() {
                alert('Lỗi kết nối server!');
            }
        });
    }

    function InHoaDonChiPhi() {
        //load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
        $.ajax({
            type: 'post',
            url: '/taisan/phieu-de-nghi/get-phieu-in-chi-phi-ajax?idPhieu=' + <?= $model->id ? $model->id : "''" ?>,
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    $('#printHD').html(data.content);
                    printHoaDon(); //call from script.js
                } else {
                    alert('Vật tư không còn tồn tại trên hệ thống!');
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }







    function getKhachHangAjax(idkh) {
        $.ajax({
            type: 'post',
            url: '/banhang/khach-hang/get-khach-hang-ajax?idkh=' + idkh + '&loai=' + $('#ddlLoaiKhachHang').val(),
            //data: frm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                if (data.status == 'success') {
                    $('#khHoTen').val(data.khHoTen);
                    $('#khSDT').val(data.khSDT);
                    $('#khDiaChi').val(data.khDiaChi);
                    $('#khCCCD').val(data.khCCCD);
                } else {
                    alert('Thông tin Khách hàng không còn tồn tại trên hệ thống!');
                }
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function clearInfoKhachHang() {
        $('#khHoTen').val('');
        $('#khSDT').val('');
        $('#khDiaChi').val('');
        $('#khCCCD').val('');
    }

    $('#khach-hang-dropdown').on("select2:select", function(e) {
        if (this.value != '') {
            getKhachHangAjax(this.value);
        } else {
            clearInfoKhachHang();
        }
    });
    $('#khach-hang-dropdown').on('select2:clear', function(e) {
        clearInfoKhachHang();
    });

    function runFunc(sendVal) {
        var url = '/banhang/khach-hang/refresh-select2?selected=' + sendVal;
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                var $select = $('#khach-hang-dropdown');
                $select.empty(); // Xóa hết option cũ
                var selectedValue = null;

                $.each(response, function(i, item) {
                    var isSelected = item.selected === true;
                    var option = new Option(item.text, item.id, false, isSelected);

                    $select.append(option);

                    if (isSelected) {
                        selectedValue = item.id;
                    }
                });

                // Cập nhật Select2 giao diện
                if (selectedValue !== null) {
                    $select.val(selectedValue).trigger('change');
                    getKhachHangAjax(selectedValue); //doc du lieu de lay thong tin
                } else {
                    $select.trigger('change');
                }
            },
            contentType: false,
            cache: false,
            processData: false
        });
    }
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>