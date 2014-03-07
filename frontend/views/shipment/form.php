<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Service;
use common\models\User;
use common\models\Payment;
use common\models\Currency;

$this->title = $model->isNewRecord ? 'Create' : 'Update' . ' shipment';
$this->params['breadcrumbs'][] = ['label' => 'shipment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin([
            'id' => 'shipment-form'
        ]);
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><i class="fa fa-home"></i> Shipment</h4>
    </div>
    <div class="panel-body">
        <div class="shipment-form">
            <?= $form->field($model, 'shp_title')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'shp_svc_id')->dropDownList(Service::getServiceListData()) ?>

            <div id="service-meta">

            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'shp_price') ?>
                <div class="row">
                    <div class="col-sm-3"><?= Html::activeDropDownList($model, 'shp_cur_id', Currency::getListdata(), ['class' => 'form-control']) ?></div>
                    <div class="col-sm-9">
                        <div class="row"><?= Html::activeInput('text', $model, 'shp_price', ['class' => 'form-control']) ?></div>
                        <div class="row"><?= Html::error($model, 'shp_price') ?></div>
                    </div>
                </div>
            </div>

            <?= $form->field($model, 'shp_expired')->textInput() ?>

            <?= $form->field($model, 'shp_pickup_date')->textInput() ?>

            <?= Html::activeHiddenInput($model, 'shp_pickup_cit_id') ?>

            <?= $form->field($model, 'shp_pickup_city')->textInput(['maxlength' => 250]) ?>

            <?= Html::input('text', 'display_pickup_city', $model->shp_pickup_city, ['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'display_pickup_city']) ?>

            <?= $form->field($model, 'shp_pickup_address')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'shp_delivery_date')->textInput() ?>

            <?= Html::activeHiddenInput($model, 'shp_destination_cit_id') ?>

            <?= $form->field($model, 'shp_destination_city')->textInput(['maxlength' => 250]) ?>

            <?= Html::input('text', 'display_destination_city', $model->shp_destination_city, ['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'display_destination_city']) ?>

            <?= $form->field($model, 'shp_destination_address')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'shp_description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    $(function() {
        $('#shipment-shp_expired').datepicker();
        $('#shipment-shp_pickup_date').datepicker();
        $('#shipment-shp_delivery_date').datepicker();
        $("#shipment-shp_pickup_city").select2({
            placeholder: "Search for a city",
            minimumInputLength: 3,
            width: 'resolve',
            ajax: {
                url: "<?= Yii::$app->homeUrl ?>city/list/",
                dataType: 'json',
                quietMillis: 100,
                allowClear: true,
                data: function(term, page) {
                    return {
                        q: term,
                        page_limit: 10,
                    };
                },
                results: function(data, page_limit) {
                    var more = (page_limit * 10) < data.total;
                    return {results: data.results, more: more};
                }
            },
            formatResult: function(city) {
                return "<div class='select2-user-result'>" + city.text + "</div>";
            },
            formatSelection: function(city) {
                $('#shipment-shp_pickup_cit_id').val(city.id);
                $('#shipment-shp_pickup_city').val(city.text);
                $('#display_pickup_city').val(city.text);
                return city.text;
            },
            dropdownCssClass: "bigdrop",
            escapeMarkup: function(m) {
                return m;
            }
        });
        $("#shipment-shp_destination_city").select2({
            placeholder: "Search for a city",
            minimumInputLength: 3,
            width: 'resolve',
            ajax: {
                url: "<?= Yii::$app->homeUrl ?>city/list/",
                dataType: 'json',
                quietMillis: 100,
                allowClear: true,
                data: function(term, page) {
                    return {
                        q: term,
                        page_limit: 10,
                    };
                },
                results: function(data, page_limit) {
                    var more = (page_limit * 10) < data.total;
                    return {results: data.results, more: more};
                }
            },
            formatResult: function(city) {
                return "<div class='select2-user-result'>" + city.text + "</div>";
            },
            formatSelection: function(city) {
                $('#shipment-shp_destination_cit_id').val(city.id);
                $('#shipment-shp_destination_city').val(city.text);
                $('#display_destination_city').val(city.text);
                return city.text;
            },
            dropdownCssClass: "bigdrop",
            escapeMarkup: function(m) {
                return m;
            }
        });
        $("select#shipment-shp_svc_id").change(function() {
            $('#service-meta').html('');
            $("select#shipment-shp_svc_id option:selected").each(function() {
                var catId = $(this).val();
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "<?= Yii::$app->urlManager->createUrl('shipment/servicemeta') ?>",
                    data: {id: catId, shpId:<?= ($model->isNewRecord) ? 'null' : $model->shp_id ?>},
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var text = '<div class="row"><div class="col-sm-6 form-group"><label>' + value.label + '</label></div><div class="col-sm-6 form-group"><input type="text" class="form-control" name="Shipment[servicemeta][' + value.name + ']" value="' + value.value + '"></div></div>';
                            $('#service-meta').append(text);
                        });
                    }

                });
            });
        }).trigger("change");
    });
</script>