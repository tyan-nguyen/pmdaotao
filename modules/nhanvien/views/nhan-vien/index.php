<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\modules\nhanvien\models\PhongBan;
use app\widgets\FilterFormWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\nhanvien\models\search\NhanVienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhân viên';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$totalCount = $dataProvider->getCount(); 


Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = true;
?>


            
<!-- Khung chứa GridView -->
<div id="grid-view-container">
    <?php Pjax::begin(['id' => 'grid-pjax']); ?>
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'summary' => '',
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar' => [
                ['content' =>
                    '<div class="ml-auto">' . 
                        Html::a(
                            '<i class="fas fa-plus" aria-hidden="true"></i> Thêm mới',
                            ['create'],
                            [
                                'role' => 'modal-remote',
                                'title' => 'Thêm mới nhân viên',
                                'class' => 'btn btn-custom mr-2'
                            ]
                        ) .
                        Html::a(
                            '<i class="fas fa-sync" aria-hidden="true"></i> Tải lại',
                            [''],
                            [
                                'data-pjax' => 1,
                                'class' => 'btn btn-custom',
                                'title' => 'Tải lại dữ liệu'
                            ]
                        ) .
                    '</div>'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => '',
                'heading' => '<div class="panel-heading">
                    <div class="panel-title">
                        <h5><i class="fas fa-users"></i> Danh sách Nhân viên</h5>
                    </div>
                 </div>',
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
                            'data-confirm-title' => 'Xác nhận',
                            'data-confirm-message' => 'Bạn có chắc chắn muốn xóa các mục đã chọn?'
                        ]
                    ),
                ]) . '<div class="clearfix"></div>',
            ]
        ]) ?>
    </div>
    <?php Pjax::end(); ?>
</div>

<?php Modal::begin([
    "options" => [
        "id" => "ajaxCrudModal",
        "tabindex" => false
    ],
    "footer" => "",
]) ?>
<?php Modal::end(); ?>

<?php
    $searchContent = $this->render("_search", ["model" => $searchModel]);
    echo FilterFormWidget::widget(["content"=>$searchContent, "description"=>"Nhập thông tin tìm kiếm."]) 
?>
<style>
    /* Customize the modal appearance */
    #ajaxCrudModal .modal-dialog {
        max-width: 70%; /* Reduce modal width */
    }
    #ajaxCrudModal .modal-content {
        max-height: 75vh; /* Adjust max height */
        overflow-y: auto;
    }

    .search-box {
        border: 1px solid #ccc;
        padding: 15px;
        background-color: #fff;
        border-radius: 5px;
        position: relative;
        transition: width 0.3s ease-in-out;
        box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .search-icon {
        cursor: pointer;
        font-size: 17px;
        text-align: left;
        margin-bottom: 0px;
    }

    .search-fields {
        display: none;
        margin-top: 10px;
    }

    .search-box.expanded .search-fields {
        display: block;
    }

    .search-fields .form-group {
        margin-bottom: 15px;
    }

    #grid-view-container {
        margin-top: 20px;
    }
</style>
