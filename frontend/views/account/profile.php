<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserService;
use common\models\UserNotificationService;
use common\models\Currency;

$this->title = $user->isNewRecord ? 'Create' : 'Update' . ' user';
$this->params['breadcrumbs'][] = ['label' => 'user', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'user-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><i class="fa fa-home"></i> User</h4>
    </div>
    <div class="panel-body">
        <div class="user-form">
            <?= $form->field($user, 'usr_username')->textInput(['maxlength' => 150, 'disabled' => 'disabled']) ?>

            <div class="form-group register required">
                <label class="control-label" for="register">Register Date</label>
                <input type="text" id="user-register" class="form-control" name="register" value="<?= date('d F Y', $user->usr_created) ?>" disabled="disabled" maxlength="150">
                <div class="help-block"></div>
            </div> 

            <div class="form-group last_login required">
                <label class="control-label" for="last_login">Last Login</label>
                <input type="text" id="user-last_login" class="form-control" name="last_login" value="<?= date('d F Y', $user->usr_last_login) ?>" disabled="disabled" maxlength="150">
                <div class="help-block"></div>
            </div> 

            <?= $form->field($user, 'usr_email')->textInput(['maxlength' => 150]) ?>

            <?= $form->field($user, 'usr_cur_id')->dropDownList(Currency::getListdata()) ?>

            <?= $form->field($user, 'usr_description')->textarea(['rows' => 6]) ?>

            <?= Html::tag('img', $user->usr_avatar, ['src' => $user->avatar, 'class' => 'img-thumbnail', 'width' => 200]) ?>

            <?= $form->field($user, 'usr_avatar')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><i class="fa fa-home"></i> My Services</h4>
    </div>
    <div class="panel-body">
        <div class="user-form">
            <?php foreach ($services as $row): ?>
                <div class="checkbox">
                    <label for="User[services][<?= $row->svc_id ?>]">
                        <input type="hidden" name="User[services][<?= $row->svc_id ?>]" value="0">
                        <input type="checkbox" name="User[services][<?= $row->svc_id ?>]" value="1" <?= UserService::check($user->usr_id, $row->svc_id) ? 'checked' : '' ?>> <?= $row->svc_name ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <div class="form-group">
                <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><i class="fa fa-home"></i> Service Email Alert</h4>
    </div>
    <div class="panel-body">
        <div class="user-form">
            <?php foreach ($services as $row): ?>
                <div class="checkbox">
                    <label for="User[notifService][<?= $row->svc_id ?>]">
                        <input type="hidden" name="User[notifService][<?= $row->svc_id ?>]" value="0">
                        <input type="checkbox" name="User[notifService][<?= $row->svc_id ?>]" value="1" <?= UserNotificationService::check($user->usr_id, $row->svc_id) ? 'checked' : '' ?>> <?= $row->svc_name ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <div class="form-group">
                <?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>