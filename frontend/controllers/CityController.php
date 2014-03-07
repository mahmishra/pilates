<?php

namespace frontend\controllers;

use Yii;
use common\models\City;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use yii\caching\Cache;
use yii\web\Request;
use yii\helpers\Json;

class CityController extends Controller {

    public function actionList() {
        $q = isset($_GET['q']) ? $_GET['q'] : NULL;
        $query = "
			SELECT a.cit_id, a.cit_name, b.reg_id, b.reg_name, c.cny_id, c.cny_name
			FROM tbl_city a, tbl_region b, tbl_country c
			WHERE a.cit_region_id = b.reg_id
				AND b.reg_country_id = c.cny_id
				AND a.cit_name LIKE '%" . $q . "%'
			ORDER BY a.cit_name
			LIMIT 10";
        $connection = Yii::$app->db;
        $query = $connection->createCommand($query)->queryAll();
        $answer = [];
        foreach ($query as $row) {
            $answer[] = ['id' => $row['cit_id'], 'text' => $row['cit_name'] . ', ' . $row['reg_name'] . ', ' . $row['cny_name']];
        }
        $res = [];
        $res['total'] = count($answer);
        $res['results'] = $answer;
        return Json::encode($res);
    }

}
