<?php

use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Track and Trace';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4><i class="fa fa-home"></i> Service Wanted</h4>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-horizontal'],
                        'method' => 'GET'
                    ])
            ?>

            <div class="form-group">
                <?= Html::label('Your AWB') ?>
                <?= Html::input('text', 'awb', '', ['class' => 'form-control']) ?>

            </div>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
            <?php
            $listView = new ListView([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'layout' => "{summary}\n{items}\n{pager}\n",
            ]);
            $listView->sorter = ['options' => ['class' => 'mail-sorter']];
            ?>
            <?= $listView->renderSorter() ?>
            <?= $listView->run() ?>
        </div>
    </div>
</div>