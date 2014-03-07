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
            <?= $form->field($model, 'shp_title')->textInput(['maxlength' => 255,'disabled'=>'disabled']) ?>

            <div class="form-group">
                <?= Html::activeLabel($model, 'shp_price') ?>
                <div class="row">
                    <div class="col-sm-3"><?= Html::activeDropDownList($model, 'shp_cur_id', Currency::getListdata(), ['class' => 'form-control','disabled'=>'disabled']) ?></div>
                    <div class="col-sm-9"><?= Html::activeInput('text', $model, 'shp_price', ['class' => 'form-control','disabled'=>'disabled']) ?></div>
                </div>
            </div>
            
           <?= $form->field($model, 'shp_pay_id')->dropDownList(Payment::getListData()) ?>
            
            <?= $form->field($model, 'shp_shipper_bank_name')->textInput() ?>
            
            <?= $form->field($model, 'shp_shipper_bank_number')->textInput() ?>
            
            <?= $form->field($model, 'shp_shipper_amount')->textInput() ?>
            
            <?= $form->field($model, 'shp_shipper_description')->textArea() ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
    });
</script>