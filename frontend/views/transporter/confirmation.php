<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\Bid;

$this->title = 'Index';
$this->params['breadcrumbs'][] = ['label' => 'Shipment I Bid', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><i class="fa fa-home"></i> Shipment I Bid</h4>
    </div>
    <div class="panel-body">
        <?=
        GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                'pagination' => false]
            ),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'header' => 'Date made',
                    'value' => 'shp_created'
                ],
                [
                    'header' => 'Shipment Thread',
                    'format' => 'html',
                    'value' => function($data) {
                        return Html::tag('a', $data->shp_title, ['href' => $data->url]);
                    }
                ],
                [
                    'header' => '',
                    'format' => 'html',
                    'options' => [
                        'width' => '170px;'
                    ],
                    'value' => function ($data) {
                        $value = Html::tag('a', 'accept', ['href' => Yii::$app->urlManager->createUrl('transporter/accept', ['id' => $data->shp_id]),'class'=>'btn btn-success']);
                        $value .= '&nbsp;';
                        $value .= Html::tag('a', 'cancel', ['href' => Yii::$app->urlManager->createUrl('transporter/cancel', ['id' => $data->shp_id]),'class'=>'btn btn-danger']);
                        return $value;
                         
                    }
                ]
            ],
        ]);
        ?>
    </div>
</div>

