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
        'khoahoc' => [
            'class' => 'app\modules\khoahoc\Khoahoc',
        ],
        'vanban' => [
            'class' => 'app\modules\vanban\Vanban',
        ],
        'nhanvien' => [
            'class' => 'app\modules\nhanvien\Nhanvien',
        ],
        
        'kholuutru' => [
            'class' => 'app\modules\kholuutru\Kholuutru',
        ],
        
        'user' => [
            'class' => 'app\modules\user\UserModule',
        ],
        'giaovien' => [
            'class' => 'app\modules\giaovien\Giaovien',
        ],
        'hocvien' => [
            'class' => 'app\modules\hocvien\Hocvien',
        ],
        'thuexe' => [
            'class' => 'app\modules\thuexe\ThueXe',
        ],
        'lichhoc' => [
            'class' => 'app\modules\lichhoc\Lichhoc',
        ],

        /* 'dynamikjs' => [
            'class' => 'dastanaron\dropzone\DynamicJSModule'
        ], */
       
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
      
        'pdf' => [
            'class' => '\kartik\mpdf\Pdf',
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
        ],
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
        /*'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],*/
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'ssl',
                'host' => 'smtp.hostinger.com',
                'port' => '465',
                'username' => 'notification@vnweb.online',
                'password' => 'vnW@123!@#',
            ],
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
                'nhan_vien/options' => 'nhan_vien/get-options',
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
             //   'kartik\form\ActiveFormAsset' => [
                  //  'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
               // ],
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
