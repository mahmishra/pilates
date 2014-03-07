<?php

use yii\widgets\ListView;

$this->title = 'Index';
$this->params['breadcrumbs'][] = ['label' => 'Service Wanted', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><i class="fa fa-home"></i> Service Wanted</h4>
    </div>
    <div class="panel-body">
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