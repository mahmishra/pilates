<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Shipment;

$timeFormatter = extension_loaded('intl') ? Yii::createObject(['class' => 'yii\i18n\Formatter']) : Yii::$app->formatter;
?>

<div class="list-item row">
    <div class="col-md-3">
        <img data-src="holder.js/190x140" class="img-thumbnail" alt="190x140" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSI+PC9yZWN0Pjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 190px; height: 140px;">
    </div>
    <div class="col-md-9">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'shp_title',
                    'service.svc_name',
                    'shp_pickup_city',
                    'shp_destination_city',
                    [
                        'name' => 'shp_expired',
                        'value' => $timeFormatter->asDate($model['shp_expired']),
                    ],
                ],
            ]);
            ?>  
            <?= Html::tag('a','Read more',['href'=>$model->url,'class'=>'btn btn-info']) ?>
    </div>
</div>

