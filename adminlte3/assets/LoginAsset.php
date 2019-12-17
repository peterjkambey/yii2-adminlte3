<?php

namespace dashboard\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css = [
        //'dist/css/adminlte.css',
        'dist/css/adminlte.min.css',
        'plugins/fontawesome-free/css/all.min.css',
        'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    ];
    public $js = [
        'plugins/jquery/jquery.min.js',
        'dist/js/adminlte.min.js',
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
    ];
    public $depends = [
    ];
}
