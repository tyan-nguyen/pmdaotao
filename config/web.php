<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'vi',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'=>[
        'bophan' => [
            'class' => 'app\modules\bophan\Module',
        ],
        'taisan' => [
            'class' => 'app\modules\taisan\Module',
        ],
        'kholuutru' => [
            'class' => 'app\modules\kholuutru\Module',
        ],
        'baotri' => [
            'class' => 'app\modules\baotri\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\UserModule',
        ],
        'dungchung' => [
            'class' => 'app\modules\dungchung\Module',
        ],
        'suachua' => [
            'class' => 'app\modules\suachua\Module',
        ],
        'muasam' => [
            'class' => 'app\modules\muasam\Module',
        ],
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            
            // 'enableRegistration' => true,
            
            // Add regexp validation to passwords. Default pattern does not restrict user and can enter any set of characters.
            // The example below allows user to enter :
            // any set of characters
            // (?=\S{8,}): of at least length 8
            // (?=\S*[a-z]): containing at least one lowercase letter
            // (?=\S*[A-Z]): and at least one uppercase letter
            // (?=\S*[\d]): and at least one number
            // $: anchored to the end of the string
            
            //'passwordRegexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$',
            
            
            // Here you can set your handler to change layout for any controller or action
            // Tip: you can use this event in any module
            'on beforeAction'=>function(yii\base\ActionEvent $event) {
                if ( $event->action->uniqueId == 'user-management/auth/login' )
                {
                    $event->action->controller->layout = '\loginLayout.php';
                };
            },
         ],
         'gridview' =>  [
             'class' => '\kartik\grid\Module'
         ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mFLrLzLWpDqbmj4h6wheaBbx_QfNl17j',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/'=>'/user',
                'taisan/theo-doi-van-hanh/list-calendar' => 'taisan/theo-doi-van-hanh/list-calendar',
                'taisan/xuat-yeu-cau-van-hanh/print' => 'taisan/xuat-yeu-cau-van-hanh/print',
                'taisan/xuat-yeu-cau-van-hanh/print-view' => 'taisan/xuat-yeu-cau-van-hanh/print-view'

            ],
        ],
        
        'user' => [
            //'class' => 'webvimark\modules\UserManagement\components\UserConfig',
            'class' => 'app\modules\user\components\UserConfig',
            
            // Comment this if you don't want to record user logins
            'on afterLogin' => function($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],

        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/main'],
                'baseUrl' => '@web/../themes/main',
            ],
        ],
        
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
        ],
        
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
                ],
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /* $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ]; */

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
