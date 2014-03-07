<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use yii\caching\Cache;
use yii\web\Request;
use yii\helpers\Json;
use common\models\Role;

class UserController extends Controller {

    public function actionIndex() {
        return $this->render('index', ['role' => 'all']);
    }

    public function actionAdmin() {
        return $this->render('index', ['role' => Role::ADMIN]);
    }

    public function actionBranch() {
        return $this->render('index', ['role' => Role::BRANCH]);
    }

    public function actionInstructure() {
        return $this->render('index', ['role' => Role::INSTRUCTURE]);
    }

    public function actionLists($id = 'all') {
        switch ($id) {
            case Role::ADMIN;
                $role = Role::ADMIN;
                break;
            case Role::BRANCH;
                $role = Role::BRANCH;
                break;
            case Role::INSTRUCTURE;
                $role = Role::INSTRUCTURE;
                break;
            default :
                return Json::encode(User::find()->all());
                break;
        }
        $model = User::find()->where('role_id = :role_id',[':role_id' => $role])->all();
        return Json::encode($model);
    }

    public function actionView($id) {
        return Json::encode($this->findModel($id));
    }

    public function actionCreate() {
        $model = new User;
        $model->changePassword = true;
        if ($model->load($_POST) && $model->save()) {
            $this->redirect(['index']);
        } else {
            return $this->render('form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->changePassword = true;
        if ($model->load($_POST) && $model->save()) {
            $this->redirect(['index']);
        } else {
            return $this->render('form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
    }

    protected function findModel($id) {
        if ($id !== null && ($model = User::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
