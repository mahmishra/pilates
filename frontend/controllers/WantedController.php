<?php

namespace frontend\controllers;

use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use common\models\Shipment;
use common\models\Bid;
use common\models\Review;

class WantedController extends Controller {

    public function actionIndex() {
        $this->layout = '//catalog';

        $query = Shipment::find()
                ->where('shp_status = :status', [':status' => Shipment::STATUS_APPROVED])
                ->orderBy('shp_created Desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionRead($id) {
        $model = Shipment::find($id);
        if (isset($_POST['bid-cancel'])) {
            $bid = $model->bidModel;
            if ($bid->delete())
                Yii::$app->getSession()->setFlash('success', 'Bid Removed !');
        }else if(isset($_POST['update-status'])){
            if($model->load($_POST) && $model->update()){
                Yii::$app->getSession()->setFlash('success', 'Status Updated !');
            }
        } else if (isset($_POST['Bid'])) {
            $bid = $model->bidModel;
            $bid->bid_usr_id = Yii::$app->user->identity->usr_id;
            $bid->bid_shp_id = $model->shp_id;
            if ($bid->load($_POST)) {
                if($bid->bid_amount > $model->shp_price){
                    $bid->addError('bid_amount','you bidding must be lower than budget, max '.$model->budget);
                    Yii::$app->getSession()->setFlash('error', 'you bidding must be lower than budget, max '.$model->budget);
                }
                else if ($bid->load($_POST) && $bid->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Bid Success Added !');
                }else{
                    var_dump($bid->getErrors());exit;
                }
            }
        }
        else if (isset($_POST['review-transporter'])) {
            $review = $model->reviewModel;
            $review->rev_usr_id = $model->shp_transporter_usr_id;
            $review->rev_from_usr_id = $model->shp_shipper_usr_id;
            $review->rev_as = Review::AS_TRANSPORTER;
            $review->rev_shp_id = $model->shp_id;
            if ($review->load($_POST) & $review->save()) {
               Yii::$app->getSession()->setFlash('success', 'Your testimonial submited !');
            }
        }
        else if (isset($_POST['review-shipper'])) {
            $review = $model->reviewModel;
            $review->rev_usr_id = $model->shp_shipper_usr_id;
            $review->rev_from_usr_id = $model->shp_transporter_usr_id;
            $review->rev_as = Review::AS_SHIPPER;
            $review->rev_shp_id = $model->shp_id;
            if ($review->load($_POST) & $review->save()) {
               Yii::$app->getSession()->setFlash('success', 'Your testimonial submited !');
            }
        }
        return $this->render('read', [
                    'model' => $model
        ]);
    }
    
    public function actionTrace($awb=null) {
        $query = Shipment::find()
                ->where('shp_awb = :awb', [':awb' => $awb])
                ->orderBy('shp_created Desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);
        return $this->render('trace', [
                    'dataProvider' => $dataProvider
        ]);
    }

}
