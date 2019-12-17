<?php

namespace dashboard\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css = [
        'dist/css/adminlte.css',
        'plugins/fontawesome-free/css/all.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    ];
    public $js = [
        //'plugins/jquery/jquery.min.js',
        'dist/js/adminlte.min.js',
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
    ];
    public $depends = [
        '\yii\web\JqueryAsset',
    ];
}
