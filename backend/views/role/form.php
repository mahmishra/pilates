<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? 'Create' : 'Update' . ' role';
$this->params['breadcrumbs'][] = ['label' => 'role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="admin-create">
    <div id="wrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> Role</h4>
                        </div>
                        <div class="panel-body">
                            <div class="role-form">
                                <?php $form = ActiveForm::begin(); ?>

                                		<?= $form->field($model, 'action')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'identity')->textInput(['maxlength' => 45]) ?>

		<?= $form->field($model, 'name')->textInput(['maxlength' => 70]) ?>

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
