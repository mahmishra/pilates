<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? 'Create' : 'Update' . ' user';
$this->params['breadcrumbs'][] = ['label' => 'user', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-create">
    <div id="wrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> User</h4>
                        </div>
                        <div class="panel-body">
                            <div class="user-form">
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'role_id')->textInput() ?>

                                <?= $form->field($model, 'username')->textInput(['maxlength' => 150]) ?>

                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => 150]) ?>

                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => 150]) ?>

                                <?= $form->field($model, 'email')->textInput(['maxlength' => 200]) ?>

                                <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

                                <?= $form->field($model, 'city')->textInput(['maxlength' => 200]) ?>

                                <?= $form->field($model, 'postcode')->textInput(['maxlength' => 20]) ?>

                                <?= $form->field($model, 'phone')->textInput(['maxlength' => 45]) ?>

                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
