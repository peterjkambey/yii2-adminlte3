<?php

/* @var $this \yii\web\View */
/* @var $content string */

use dashboard\assets\LoginAsset;
use yii\helpers\Html;

$app = LoginAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <?php $this->registerCsrfMetaTags(); ?>
 
  <title><?= Html::encode($this->title); ?></title>
  <?php $this->head(); ?>

</head>
<body class="hold-transition login-page">
<?php $this->beginBody(); ?>

    <?= $content; ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
