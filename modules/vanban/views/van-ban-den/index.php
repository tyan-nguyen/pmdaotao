<?php
use yii\helpers\Url;
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

CrudAsset::register($this);

?>
<div class="van-ban-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
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
            
           
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa đã chọn',
                                ["bulkdelete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Aapakah anda yakin?',
                                    'data-confirm-message'=>'Apakah Anda yakin akan menghapus data ini?'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
   "options" => [
    "id"=>"ajaxCrudModal",
    "tabindex" => false 
],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// 
])?>
<?php Modal::end(); ?>

<style>
    #ajaxCrudModal .modal-dialog {
        max-width: 80%; 
    }

    #ajaxCrudModal .modal-content {
        max-height: 80vh; 
        overflow-y: auto;
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
