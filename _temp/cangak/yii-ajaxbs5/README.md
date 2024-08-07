yii2-ajaxcrud 
=============

Features
------------
+ Create, read, update, delete in onpage with Ajax
+ Bulk delete suport
+ Pjax widget suport
+ Export function(pdf,html,text,csv,excel,json)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist cangak/yii-ajaxbs5 "*"
```

or add

```
"cangak/yii-ajaxbs5": "*"
```
to the require section of your `composer.json` file.


Usage
-----
For first you must enable Gii module Read more about [Gii code generation tool](http://www.yiiframework.com/doc-2.0/guide-tool-gii.html)

Because this extension used [kartik-v/yii2-grid](https://github.com/kartik-v/yii2-grid) extensions so we must config gridview module before

Let 's add into modules config in your main config file
````php
'modules' => [
    'gridview' =>  [
        'class' => '\kartik\grid\Module'
    ]       
]

````
janganlupa di AppAsset.php
````php
ublic $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        // '\rmrevin\yii\fontawesome\AssetBundle'

    ];
````
lalu di param
````php
      'bsVersion' => '5.x', // this will set globally `bsVersion` to Bootstrap 5.x for all Krajee Extensions
````
You can then access Gii through the following URL:

http://localhost/path/to/index.php?r=gii

and you can see <b>Ajax CRUD Generator</b>
