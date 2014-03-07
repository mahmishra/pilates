<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\widgets\Menu;
use common\models\Shipment;
use common\models\Transporter;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/jquery-2.0.3.min.js'></script> 
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <?= $this->render('//layouts/navbar') ?>
        <div class="container">
            <div class="row">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> My Account Menu</h4>
                        </div>
                        <?php
                        echo Menu::widget([
                            'items' => [
                                ['label' => 'My Acoount Home', 'url' => ''],
                                ['label' => 'Payments', 'url' => ''],
                                ['label' => 'Private Messages', 'url' => ''],
                                ['label' => 'Personal Info', 'url' => ['account/profile']],
                                ['label' => 'Review and Feedback', 'url' => ''],
                            ],
                            'options' => [
                                'class' => 'list-group'
                            ],
                            'itemOptions' => [
                                'class' => 'list-group-item'
                            ],
                            'linkTemplate' => '{count}<a href="{url}">{label}</a>'
                            
                        ]);
                        ?>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> User Menu</h4>
                        </div>
                        <?php
                        echo Menu::widget([
                            'items' => [
                                ['label' => 'Post New Shipment', 'url' => ['shipment/new']],
                                ['label' => 'Unpublished Shipment', 'url' => ['shipment/unpublished'],'count'=>'<span class="badge">'.Shipment::getCountStatus(Shipment::STATUS_NEW).'</span>'],
                                ['label' => 'Awaiting Completion', 'url' => ['shipment/awaiting'],'count'=>'<span class="badge">'.Shipment::getCountStatus(Shipment::STATUS_USER_PAYS).'</span>'],
                                ['label' => 'Active Shipment', 'url' => ['shipment/approved'],'count'=>'<span class="badge">'.Shipment::getCountStatus(Shipment::STATUS_APPROVED).'</span>'],
                                ['label' => 'Waiting Transporter Confirmation', 'url' => ['shipment/transporterconfirmation'],'count'=>'<span class="badge">'.Shipment::getCountStatus(Shipment::STATUS_USER_SELECT_TRANSPORTER).'</span>'],
                                ['label' => 'Shipment Process', 'url' => ['shipment/process'],'count'=>'<span class="badge">'.Shipment::getCountStatus(Shipment::STATUS_PROCESS).'</span>'],
                                ['label' => 'Close Shipment', 'url' => ['shipment/index']],
                                ['label' => 'Outstanding Payments', 'url' => ['shipment/index']],
                                ['label' => 'Completed Payments', 'url' => ['shipment/index']],
                            ],
                            'options' => [
                                'class' => 'list-group'
                            ],
                            'itemOptions' => [
                                'class' => 'list-group-item'
                            ],
                            'linkTemplate' => '<span class="badge">{count}</span><a href="{url}">{label}</a>'
                        ]);
                        ?>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> Transporter Menu</h4>
                        </div>
                        <?php
                        echo Menu::widget([
                            'items' => [
                                ['label' => 'Won Shipments', 'url' => ['transporter/index']],
                                ['label' => 'Outstanding Shipments', 'url' => ['transporter/index']],
                                ['label' => 'Awaiting Payments', 'url' => ['transporter/index']],
                                ['label' => 'Delivered & Paid Shipments', 'url' => ['transporter/index']],
                                ['label' => 'Shipment need confirmation', 'url' => ['transporter/confirmation'],'count'=>'<span class="badge">'.Transporter::getCountStatus(Shipment::STATUS_USER_SELECT_TRANSPORTER).'</span>'],
                                ['label' => 'Shipment process', 'url' => ['transporter/process'],'count'=>'<span class="badge">'.Transporter::getCountStatus('process').'</span>'],
                                ['label' => 'Shipment i bid', 'url' => ['transporter/bid']],
                            ],
                            'options' => [
                                'class' => 'list-group'
                            ],
                            'itemOptions' => [
                                'class' => 'list-group-item'
                            ],
                            'linkTemplate' => '<span class="badge">{count}</span><a href="{url}">{label}</a>'
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-md-9"><?= $content ?></div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
