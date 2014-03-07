<?php

namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use common\models\Shipment;
use yii\data\ActiveDataProvider;
use common\models\Review;
use common\models\Service;
use yii\helpers\Json;
use common\models\ShipmentMeta;

class ShipmentController extends BaseController {

    public function actionIndex() {
        $this->redirect(['new']);
    }

    public function actionNew() {
        $model = new Shipment;
        $model->shp_shipper_usr_id = Yii::$app->user->identity->usr_id;
        $model->shp_cur_id = Yii::$app->user->identity->usr_cur_id;
        if ($model->load($_POST) && $model->save()) {
            $this->redirect(['unpublished']);
        } else {
            $model->load($_POST);
            return $this->render('form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionEdit($id) {
        $model = $this->findModel($id);
        if ($model->load($_POST) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Success !');
            $model = $this->findModel($id);
        }
        return $this->render('form', [
                    'model' => $model,
        ]);
    }

    public function actionPay($id) {
        $model = $this->findModel($id);
        $model->setScenario('pay');
        $model->shp_status = Shipment::STATUS_USER_PAYS;
        if ($model->load($_POST)) {
            if ($model->shp_shipper_amount < $model->shp_price) {
                $model->addError('shp_shipper_amount', 'Amount can not lower than budget');
            } else if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Success !');
                $model = $this->findModel($id);
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('form-payment', [
                    'model' => $model,
        ]);
    }

    protected function dataProvider($status) {
        $query = Shipment::find()
                ->where('shp_status = :status and shp_shipper_usr_id = :usr_id', [
                    ':usr_id' => Yii::$app->user->identity->usr_id,
                    ':status' => $status
                ])
                ->orderBy('shp_created Desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);
        return $dataProvider;
    }

    public function actionApproved() {
        return $this->render('list', [
                    'dataProvider' => $this->dataProvider(Shipment::STATUS_APPROVED)
        ]);
    }

    public function actionTransporterconfirmation() {
        return $this->render('list', [
                    'dataProvider' => $this->dataProvider(Shipment::STATUS_USER_SELECT_TRANSPORTER)
        ]);
    }

    public function actionProcess() {
        $dataProvider = new ActiveDataProvider([
            'query' => Shipment::process(),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);
        return $this->render('list', [
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionUnpublished() {
        return $this->render('list', [
                    'dataProvider' => $this->dataProvider(Shipment::STATUS_NEW)
        ]);
    }

    public function actionAwaiting() {
        return $this->render('list', [
                    'dataProvider' => $this->dataProvider(Shipment::STATUS_USER_PAYS)
        ]);
    }

    protected function findModel($id) {
        $model = Shipment::find($id);
        $model->formUpdate = true;
        $model->checkMyShipment();
        if ($id !== null && ($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChoosetransporter($id, $shpId) {
        $model = Shipment::find($shpId);
        $model->shp_transporter_usr_id = $id;
        $model->shp_status = Shipment::STATUS_USER_SELECT_TRANSPORTER;
        if ($model->update())
            $this->redirect($model->url);
        else {
            $model->save(false);
            $this->redirect($model->url);
        }
    }

    public function actionCanceltransporter($id) {
        $model = Shipment::find($id);
        $model->shp_transporter_usr_id = null;
        $model->shp_status = Shipment::STATUS_APPROVED;
        if ($model->update())
            $this->redirect($model->url);
        else {
            $model->save(false);
            $this->redirect($model->url);
        }
    }

    public function actionServicemeta($id, $shpId = null) {
        $return = [];
        $model = Service::find($id);
        if (unserialize($model->svc_fields)) {
            foreach (unserialize($model->svc_fields) as $row) {
                $data = [];
                $meta = ShipmentMeta::find([
                            'shm_shp_id' => $shpId,
                            'shm_svc_id' => $id,
                            'shm_name' => $row['name'],
                ]);

                $data['name'] = $row['name'];
                $data['label'] = $row['label'];
                $data['value'] = (count($meta) > 0) ? $meta->shm_value : '';
                $return[] = $data;
            }
        }
        return Json::encode($return);
    }

}
