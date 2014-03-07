<?php

namespace backend\controllers;

use Yii;
use common\models\Role;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use yii\caching\Cache;
use yii\web\Request;
use yii\helpers\Json;

class RoleController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
        
        public function actionLists() {
            $model = Role::find()->all();
            return Json::encode($model);
        }

	public function actionView($id)
	{
		return Json::encode($this->findModel($id));
	}

	public function actionCreate()
	{
		$model = new Role;

		if ($model->load($_POST) && $model->save()) {
			$this->redirect(['index']);
		} else {
			return $this->render('form', [
				'model' => $model,
			]);
		}
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			$this->redirect(['index']);
		} else {
			return $this->render('form', [
				'model' => $model,
			]);
		}
	}

	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
	}

	protected function findModel($id)
	{
		if ($id !== null && ($model = Role::find($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
