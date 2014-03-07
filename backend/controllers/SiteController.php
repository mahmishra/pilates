<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\LoginForm;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\web\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        $this->goLogin();
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load($_POST) && $model->login()) {
            $this->goHome(); //return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goLogin();
    }

    public function goHome() {
        return $this->redirect('user/index/');
    }

    public function goLogin() {
        return $this->redirect('site/login/');
    }

    public function actionHasher() {
        $test = Yii::$app->hasher->hashPassword('admin');
        $test2 = Yii::$app->hasher->checkPassword('admin', $test);
        var_dump($test);
        var_dump($test2);
        exit;
    }

}
