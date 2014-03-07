<?php

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
                'query' => Bid::find()->where('bid_usr_id = :usr_id', [':usr_id' => Yii::$app->user->identity->usr_id]),
                'pagination' => false]
            ),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'header' => 'Date made',
                    'value' => function($data) {
                        return date('d F Y g:i A', $data->bid_created);
                    }
                ],
                [
                    'header' => 'Shipment Thread',
                    'format' => 'html',
                    'value' => function($data){
                        return '<a href="'.$data->shipment->url.'">'.$data->shipment->shp_title.'</a>';
                    }
                ],
                [
                    'header' => 'Amount',
                    'value' => 'bid_amount'
                ],
            ],
        ]);
        ?>
    </div>
</div>

