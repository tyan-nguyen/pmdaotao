<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ViboonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets/css/style.css?v=6',
        'assets/css/plugins.css',
        'assets/css/icons.css',
        'assets/switcher/css/switcher.css',
        'assets/switcher/demo.css',
        'css/site.css?v=1.6',
        'assets/fontawesome-free-6.4.0-web/css/all.min.css',
        'js/fancybox/fancybox.css',
        'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'
    ];
    public $js = [
        'assets/plugins/bootstrap/popper.min.js',
        'assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js',
        'assets/plugins/perfect-scrollbar/p-scroll-1.js',
        'assets/plugins/sidemenu/sidemenu.js',
        'assets/plugins/sidebar/sidebar.js',
        'assets/js/sticky.js',
        'assets/plugins/notify/js/jquery.growl.js',
        'assets/plugins/notify/js/notifIt.js',
        
        //'assets/plugins/calendar/underscore-min.js',
        'assets/plugins/fullcalendar/moment.min.js',
        'assets/plugins/fullcalendar/fullcalendar.min.js',
        'assets/plugins/fullcalendar/locales/vi.js',
        //'assets/js/fullcalendar.js',
        'assets/js/custom.js?v=1',
        //'assets/js/custom-switcher.js',
        //'assets/switcher/js/switcher.js',        
        'assets/js/tooltip.js',
        'assets/plugins/owl-carousel/owl.carousel.js',
        'assets/plugins/multislider/multislider.js',
        'assets/js/carousel.js',
        'js/print-this/printThis.js',
        'js/ModalRemote.js?v=2',
        'js/ajaxcrud.js?v=2',
        'js/tinymce/tinymce_5.10.7.min.js',
        'https://cdn.jsdelivr.net/npm/flatpickr',
        //fancybox
        'js/fancybox/fancybox.umd.js',
        'js/custom.js?v=1',
        //'assets/plugins/tabs/jquery.multipurpose_tabcontent.js',
        //'assets/plugins/tabs/tab-content.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
        'kartik\select2\Select2Asset'
    ];
}
