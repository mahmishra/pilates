<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

class BaseController extends Controller {

    public function beforeAction($action) {
        if (Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->urlManager->createAbsoluteUrl('site/login'));
        }
        return true;
    }

    public $layout = '//account';

}
