<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="language" content="en" />
        <meta name="author" content="Elvis Sonatha"/>
        <!--toshifirmansyah@yahoo.com-->
        <meta name="description" content="Ebizu Admin Centre" />

        <!-- blueprint CSS framework -->
        <!-- <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>/css/main.css" /> -->
        <!-- <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>/css/form.css" /> -->
        <link rel="shortcut icon" href="<?= Yii::$app->params['imageUrl'] ?>favicon.ico">
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/styles.css?=120">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

        <link href='<?= Yii::$app->homeUrl ?>demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
        <link href='<?= Yii::$app->homeUrl ?>demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
        <style type="text/css">
            #form_login {
                /*background-image: url(<?= Yii::$app->params['imageUrl'] ?>header_bar_bg.gif);
                background-repeat: repeat-x;
                background-position: bottom;*/
                border: 1px solid #ddd;
                width: 420px;
                padding: 15px;
                background: rgb(239,239,239); /* Old browsers */
                background: -moz-linear-gradient(top,  rgba(239,239,239,1) 0%, rgba(204,204,204,1) 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(239,239,239,1)), color-stop(100%,rgba(204,204,204,1))); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  rgba(239,239,239,1) 0%,rgba(204,204,204,1) 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  rgba(239,239,239,1) 0%,rgba(204,204,204,1) 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  rgba(239,239,239,1) 0%,rgba(204,204,204,1) 100%); /* IE10+ */
                background: linear-gradient(to bottom,  rgba(239,239,239,1) 0%,rgba(204,204,204,1) 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#efefef', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */
            }
            .form-group { margin-bottom: 15px; }
            #login_form img { margin-bottom: 10px; }
            #form_login .row { margin: 10px 24px; }
            #form_login .row .errorMessage { color: #f90; font-size: 70%; }
        </style>
    </head>

    <body style="background-color:#FFFFFF;">
        <div style="margin:120px auto;width:420px">
            <div id="login_form">
                <img src="<?= Yii::$app->params['imageUrl'] ?>ebizu_logo.png" width="150" />
                <div id="form_login">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </body>
</html>
