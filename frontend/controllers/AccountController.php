<?php

namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use common\models\User;
use common\models\UserService;
use common\models\Service;
use common\models\UserNotificationService;
use Aws\S3\S3Client;
use PHPImageWorkshop\ImageWorkshop;
use yii\web\UploadedFile;

class AccountController extends BaseController {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionProfile() {
        $user = User::find(Yii::$app->user->identity->usr_id);
        $services = Service::find()->all();

        if ($user->load($_POST)) {
            $user->usr_avatar = UploadedFile::getInstance($user, 'usr_avatar');
        }
        if ($user->save()) {

            if (isset($_POST['User']['services'])) {
                UserService::UpdateService($user->usr_id, $_POST['User']['services']);
            }
            if (isset($_POST['User']['notifService'])) {
                UserNotificationService::UpdateService($user->usr_id, $_POST['User']['notifService']);
            }
        }

        return $this->render('profile', [
                    'user' => $user,
                    'services' => $services,
        ]);
    }

}
