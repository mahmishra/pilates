<?php

namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use common\models\Shipment;
use yii\data\ActiveDataProvider;
use common\models\Transporter;

class TransporterController extends BaseController {

    public function actionBid() {
        return $this->render('bid');
    }

    public function actionConfirmation() {
        $query = Shipment::find()->where('shp_transporter_usr_id = :transporter_id and shp_status = :status', [
            ':transporter_id' => Yii::$app->user->identity->usr_id,
            ':status' => Shipment::STATUS_USER_SELECT_TRANSPORTER
        ]);
        return $this->render('confirmation', ['query' => $query]);
    }
    
    public function actionAccept($id){
        $model = Shipment::find([
            'shp_transporter_usr_id' => Yii::$app->user->identity->usr_id,
            'shp_status' => Shipment::STATUS_USER_SELECT_TRANSPORTER
        ]);
        $model->shp_status = Shipment::STATUS_TRANSPORTER_CONFIRMATED;
        if($model->update())
            $this->redirect($model->url);
    }
    
     public function actionProcess() {
        $dataProvider = new ActiveDataProvider([
            'query' => Transporter::process(),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);
        return $this->render('list', [
                    'dataProvider' => $dataProvider
        ]);
    }

}
