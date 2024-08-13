<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VanBanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách văn bản đến';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/jquery.min.js', ['depends' => [\yii\web\YiiAsset::class]]);

CrudAsset::register($this);
?>

<div class="van-ban-index">
    <div class="search-toggle">
        <?= Html::a(
            '<i class="fas fa-search" aria-hidden="true"></i> Tìm kiếm nâng cao',
            '#',
            [
                'id' => 'advanced-search-toggle',
                'class' => 'btn btn-custom',
                'title' => 'Tìm kiếm nâng cao'
            ]
        ) ?>
    </div>
    <br>
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar' => [
                ['content' => 
                    Html::a(
                        '<i class="fas fa-plus" aria-hidden="true"></i> Thêm mới',
                        ['create'],
                        [
                            'role' => 'modal-remote',
                            'title' => 'Tambah Van Bans',
                            'class' => 'btn btn-custom'
                        ]
                    ) .
                    Html::a(
                        '<i class="fas fa-sync" aria-hidden="true"></i> Tải lại',
                        [''],
                        [
                            'data-pjax' => 1,
                            'class' => 'btn btn-custom',
                            'title' => 'Reset Grid'
                        ]
                    ) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'after' => BulkButtonWidget::widget([
                    'buttons' => Html::a(
                        '<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa đã chọn',
                        ["bulkdelete"],
                        [
                            "class" => "btn btn-danger btn-xs",
                            'role' => 'modal-remote-bulk',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => 'Aapakah anda yakin?',
                            'data-confirm-message' => 'Apakah Anda yakin akan menghapus data ini?'
                        ]
                    ),
                ]) . '<div class="clearfix"></div>',
            ]
        ]) ?>
    </div>
</div>

<?php Modal::begin([
    "options" => [
        "id" => "ajaxCrudModal",
        "tabindex" => false 
    ],
    "footer" => "",
]) ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'advancedSearchModal',
    'size' => 'modal-lg',
    'title' => '<h4 class="modal-title">Tìm kiếm nâng cao</h4>',
    'footer' => Html::button('Tìm kiếm', ['class' => 'btn btn-primary', 'id' => 'advanced-search-submit']) .
                Html::button('Đóng', ['class' => 'btn btn-default', 'data-bs-dismiss' => 'modal'])
]) ?>
<div class="advanced-search-form">
    <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'advanced-search-form']); ?>
    <?= $form->field($searchModel, 'so_vb') ?>
    <?= $form->field($searchModel, 'ngay_ky')->widget(\kartik\date\DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày ký ...'],
        'pluginOptions' => ['autoclose'=>true, 'format' => 'yyyy-mm-dd']
    ]) ?>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
<?php Modal::end(); ?>

<style>
    #ajaxCrudModal .modal-dialog {
        max-width: 80%;
    }
    #ajaxCrudModal .modal-content {
        max-height: 80vh;
        overflow-y: auto;
    }
    #advancedSearchModal .modal-dialog {
        max-width: 40%;
    }
    #advancedSearchModal .modal-content {
        max-height: 60vh;
    }
    .btn-custom {
        color: #dc3545;
        background-color: #fff;
        border: 1px solid #dc3545;
        padding: 6px 12px;
        text-align: center;
        border-radius: 4px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        margin-right: 5px;
    }
    .btn-custom i {
        margin-right: 5px;
    }
    .btn-custom:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('advanced-search-toggle').addEventListener('click', function() {
            $('#advancedSearchModal').modal('show');
        });
    });

    <?php
    $js = <<<JS
    $(document).on('click', '#advanced-search-submit', function(e) {
        e.preventDefault();
        
       
        $.pjax({
            url: $('#advanced-search-form').attr('action'),
            type: 'GET',
            container: '#ajaxCrudDatatable',
            data: $('#advanced-search-form').serialize(),
            push: false, 
            replace: false 
        });
        
       
        $('#advancedSearchModal').modal('hide');
    });
    JS;
    $this->registerJs($js);
    ?>
</script>
