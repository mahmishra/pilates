<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\Bid;
use common\models\Shipment;

$timeFormatter = extension_loaded('intl') ? Yii::createObject(['class' => 'yii\i18n\Formatter']) : Yii::$app->formatter;

$this->title = 'Index';
$this->params['breadcrumbs'][] = ['label' => 'Service Wanted', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-9">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4><?= $model->shp_title ?> - <?= $model->service->svc_name ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <img data-src="holder.js/190x140" class="img-thumbnail" alt="190x140" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSI+PC9yZWN0Pjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 190px; height: 140px;">       
                </div>
                <div class="col-md-9">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'shp_awb',
                            'shp_pickup_date',
                            'shp_pickup_city',
                            'shp_delivery_date',
                            'shp_destination_city',
                            [
                                'label' => 'Budget',
                                'value' => $model->shp_cur_id . ' ' . $model->shp_price
                            ]
                        ],
                    ]);
                    ?>  
                    <h4>Other Details</h4>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'shp_pickup_address',
                            'shp_destination_address'
                        ],
                    ]);
                    ?>  
                    <?php
                    if (!Yii::$app->user->isGuest):
                        if (!$model->myShipment && $model->shp_status == Shipment::STATUS_APPROVED):
                            Modal::begin([
                                'header' => '<h4>Post bid on shipment : ' . $model->shp_title . '</h4>',
                                'toggleButton' => ['label' => $model->bidModel->isNewRecord ? 'Place a bid on this shipment' : 'Update a bid on this shipment', 'class'=>'btn btn-primary'],
                            ]);
                            ?>
                            <div class="city-form">
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model->bidModel, 'bid_amount')->textInput() ?>

                                <?= $form->field($model->bidModel, 'bid_description')->textarea(['rows' => 6]) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Place bid', ['class' => $model->bidModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                    <?= $model->bidModel->isNewRecord ? '' : Html::submitButton('Cancel bid', ['class' => 'btn btn-danger', 'name' => 'bid-cancel']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <?php
                            Modal::end();
                        endif;
                    endif;
                    ?>
                </div>
            </div>
            <div class="row">
                <h4>Description</h4>
                <?= $model->shp_description ?>
            </div>
            <?php if ($model->shp_status == Shipment::STATUS_USER_SELECT_TRANSPORTER && $model->myShipment): ?>
                <div class="row">
                    <h4>Transporter Details</h4>
                    <?=
                    DetailView::widget([
                        'model' => $model->bid,
                        'attributes' => [
                            'bid_created',
                            'user.usr_username',
                            'bid_amount',
                            'bid_description'
                        ],
                    ]);
                    ?>
                    <?=
                    Html::tag('a', 'Cancel transporter', [
                        'class' => 'btn btn-info',
                        'href' => Yii::$app->urlManager->createUrl('shipment/canceltransporter', ['id' => $model->shp_id])
                    ])
                    ?>
                </div>
            <?php elseif ($model->statusProcess): ?>
                <div class="row">
                    <h4>Transporter Details</h4>
                    <?=
                    DetailView::widget([
                        'model' => $model->bid,
                        'attributes' => [
                            'bid_created',
                            'user.usr_username',
                            'bid_amount',
                            'bid_description',
                            [
                                'label' => 'Status',
                                'format' => 'html',
                                'value' => $model->constLabel('shp_status'),
                            ],
                        ],
                    ]);
                    ?>
                    <h4>Receiver Details</h4>
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'shp_receiver_name',
                            'shp_receiver_address',
                        ],
                    ]);
                    ?>
                    <?php if ($model->asTransporter): ?>
                        <h4>Transporter bank account</h4>
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'shp_transporter_bank_name',
                                'shp_transporter_bank_number',
                                'shp_transporter_description'
                            ],
                        ]);
                        ?>
                        <?php
                        Modal::begin([
                            'header' => '<h4>Testimonial for : ' . $model->shipper->usr_username . '</h4>',
                            'toggleButton' => ['label' => 'Send testimonial', 'class' => 'btn btn-primary'],
                        ]);
                        ?>
                        <div class="review-form">
                            <?php $form = ActiveForm::begin(); ?>

                            <?= Html::activeHiddenInput($model->reviewModel, 'rev_rating') ?>
                            <div class="rateit" id="rate-transporter" data-rateit-value="<?= $model->reviewModel->rev_rating ?>"></div>
                            <?= $form->field($model->reviewModel, 'rev_review')->textArea() ?>

                            <div class="form-group">
                                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'review-shipper']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <?php Modal::end(); ?>
                        <?php
                        Modal::begin([
                            'header' => '<h4>Update status : ' . $model->shp_title . '</h4>',
                            'toggleButton' => ['label' => 'Update', 'class' => 'btn btn-primary'],
                        ]);
                        ?>
                        <div class="city-form">
                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'shp_status')->dropDownList($model->statusTransporter) ?>

                            <div id="form-receiver" style="display: none">

                                <?= $form->field($model, 'shp_receiver_name')->textInput() ?>

                                <?= $form->field($model, 'shp_receiver_address')->textInput() ?>

                                <?= $form->field($model, 'shp_transporter_bank_name')->textInput() ?>

                                <?= $form->field($model, 'shp_transporter_bank_number')->textInput() ?>

                                <?= $form->field($model, 'shp_transporter_description')->textArea() ?>

                            </div>

                            <div class="form-group">
                                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-status']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <?php Modal::end(); ?>
                    <?php elseif ($model->myShipment): ?>
                        <?= Html::tag('a', 'Goods Arrived', ['href' => Yii::$app->urlManager->createUrl('shipment/goodsarrived'), 'class' => 'btn btn-info']) ?>
                        <?php
                        Modal::begin([
                            'header' => '<h4>Testimonial for : ' . $model->transporter->usr_username . '</h4>',
                            'toggleButton' => ['label' => 'Send testimonial', 'class' => 'btn btn-primary'],
                        ]);
                        ?>
                        <div class="review-form">
                            <?php $form = ActiveForm::begin(); ?>

                            <?= Html::activeHiddenInput($model->reviewModel, 'rev_rating') ?>
                            <div class="rateit" id="rate-transporter" data-rateit-value="<?= $model->reviewModel->rev_rating ?>"></div>
                            <?= $form->field($model->reviewModel, 'rev_review')->textArea() ?>

                            <div class="form-group">
                                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'review-transporter']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <?php Modal::end(); ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <h4>Posted Bids</h4>
                    <div class="hint-block">Click on the bidder's name to view their profiles</div>
                    <?=
                    GridView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query' => Bid::find()->where('bid_shp_id = :shp_id', [':shp_id' => $model->shp_id]),
                            'pagination' => false]
                        ),
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'header' => 'Date made',
                                'value' => 'bid_created'
                            ],
                            [
                                'header' => 'Bidder',
                                'value' => 'user.usr_username'
                            ],
                            [
                                'header' => 'Amount',
                                'value' => 'bid_amount'
                            ],
                            [
                                'header' => '',
                                'value' => function($data) {
                                    return '<a href="' . Yii::$app->urlManager->createUrl("shipment/choosetransporter", ['id' => $data->bid_usr_id, 'shpId' => $data->shipment->shp_id]) . '" class="btn btn-primary">choose</a>';
                                },
                                'format' => 'html',
                                'visible' => $model->myShipment
                            ]
                        ],
                    ]);
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>  
</div>
<div class="col-md-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4><i class="fa fa-home"></i> Seller Detail</h4>
        </div>
        <div class="panel-body">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Posted by',
                        'name' => 'shipper.usr_username'
                    ],
                    [
                        'label' => 'Feedback',
                        'name' => 'shipper.feedback'
                    ],
                    [
                        'label' => 'Has Created',
                        'name' => 'shipper.hasCreated'
                    ],
                    [
                        'label' => 'Has Closed',
                        'name' => 'shipper.hasClosed'
                    ],
                ],
            ]);
            ?>      
        </div>
    </div>  
    <!--    <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><i class="fa fa-home"></i> Other Options</h4>
            </div>
            <div class="panel-body">
    
            </div>
        </div>  -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4><i class="fa fa-home"></i> Other Details</h4>
        </div>
        <div class="panel-body">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Posted on',
                        'name' => 'shp_created'
                    ],
                    [
                        'label' => 'Expired on',
                        'name' => 'shp_expired'
                    ],
                    [
                        'label' => 'Category',
                        'name' => 'service.svc_name'
                    ],
                    [
                        'label' => 'Bids',
                        'name' => 'bids.count()'
                    ]
                ],
            ]);
            ?>  
        </div>
    </div>  
</div>
<script type='text/javascript' src='<?= Yii::$app->homeUrl ?>js/jquery-2.0.3.min.js'></script> 
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl ?>plugins/jquery-rateit/src/rateit.css" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        console.log(jQuery.fn.jquery);
        $('#rate-transporter').rateit({max: 5, step: 1});
        $('#rate-transporter').on('beforerated', function(e, value) {
            if (!confirm('Are you sure you want to rate this item: ' + value + ' stars?')) {
                e.preventDefault();
            }else
                $('#review-rev_rating').val(value);
        });
        $('#rate-transporter').on('beforereset', function(e) {
            if (!confirm('Are you sure you want to reset the rating?')) {
                e.preventDefault();
            }
        });
        $("select").change(function() {
            $("select option:selected").each(function() {
                if ($(this).text() == 'received') {
                    $("#form-receiver").slideDown();
                } else {
                    $("#form-receiver").slideUp();
                }
            });
        }).trigger("change");
    });
</script>