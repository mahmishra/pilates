<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Html;

class User extends ActiveRecord implements IdentityInterface {

    public $changePassword = false;
    public $auth_key = 'member';
    public $services;
    public $notifService;

    const STATUS_ACTIVE = 1;

    public static function tableName() {
        return 'tbl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['usr_username', 'usr_password', 'usr_email'], 'required'],
            [['usr_username', 'usr_password', 'usr_email'], 'required', 'on' => 'signup'],
            [['usr_username', 'usr_password', 'usr_type', 'usr_description', 'usr_created', 'usr_avatar', 'usr_email', 'usr_last_login', 'usr_status','usr_cur_id'], 'safe'],
            [['usr_type', 'usr_created', 'usr_last_login', 'usr_status'], 'integer'],
            [['usr_description'], 'string'],
            [['usr_username', 'usr_password', 'usr_email'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'usr_id' => 'ID',
            'usr_username' => 'Username',
            'usr_password' => 'Password',
            'usr_type' => '1=admin, 2=member',
            'usr_description' => 'Description',
            'usr_created' => 'Created',
            'usr_avatar' => 'Avatar',
            'usr_email' => 'Email',
            'usr_last_login' => 'Last Login',
            'usr_status' => 'Status',
            'usr_cur_id' => 'Default Currency',
        ];
    }
    
    public function behaviors() {
        return [
            's3' => [
                'class' => 'yii\behaviors\S3Behavior',
                'field' => 'usr_avatar',
                'path' => 'users'
            ],
        ];
    }

    public function getId() {
        return $this->usr_id;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord)
                $this->usr_created = time();
            if (($this->isNewRecord || $this->changePassword == true) && !empty($this->usr_password)) {
                $this->usr_password = Yii::$app->hasher->hashPassword($this->usr_password);
                $this->changePassword = false;
            }
            return true;
        }
        return false;
    }

    public function getType() {
        return [
            1 => 'Admin',
            2 => 'member'
        ];
    }

    public function getStatus() {
        return [
            1 => 'Active',
            0 => 'Not Active'
        ];
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public static function findIdentity($id) {
        return static::find($id);
    }

    public function validatePassword($password) {
        return Yii::$app->hasher->checkPassword($password, $this->usr_password);
    }

    public static function findByUsername($username) {
        return static::find(['usr_username' => $username, 'usr_status' => static::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getAvailableServices() {
        return $this->hasMany(AvailableService::className(), ['avs_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getBs() {
        return $this->hasMany(Bid::className(), ['bid_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getReviews() {
        return $this->hasMany(Review::className(), ['rev_from_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getShipments() {
        return $this->hasMany(Shipment::className(), ['shp_transporter_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getUserDetails() {
        return $this->hasMany(UserDetail::className(), ['usd_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getUserServices() {
        return $this->hasMany(UserService::className(), ['usv_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getUserNotificationLocations() {
        return $this->hasMany(UserNotificationLocation::className(), ['unl_usr_id' => 'usr_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getUserNotificationServices() {
        return $this->hasMany(UserNotificationService::className(), ['uns_usr_id' => 'usr_id']);
    }

    public static function getUsers() {
        $model = self::find()->all();
        return Html::listData($model, 'usr_id', 'usr_username');
    }

    public function getFeedback() {
        return '(No rating)';
    }

    public function getHasCreated() {
        $model = Shipment::find()->where(['shp_status' => 1, 'shp_shipper_usr_id' => $this->usr_id])->count();
        return $model;
    }

    public function getHasClosed() {
        return Shipment::find()->where(['shp_status' => 9, 'shp_shipper_usr_id' => $this->usr_id])->count();
    }

    public function getHasRated() {
        
    }

    public static function relationAll($relations = [], $toDate = []) {
        $return = [];
        $model = self::find()->all();
        foreach ($model as $row) {
            $data = [];
            foreach ($toDate as $tdKey => $tdValue) {
                $data[$tdKey] = date('m/d/Y', $row->$tdValue);
            }
            foreach ($row->attributes() as $attr) {
                $data[$attr] = $row->$attr;
            }
            foreach ($relations as $rel) {
                if (is_array($row->$rel)) {
                    $hasMany = [];
                    foreach ($row->$rel as $ar) {
                        $dataHas = [];
                        foreach ($ar->attributes() as $has) {
                            $dataHas[$has] = $ar->$has;
                        }
                        $hasMany[] = $dataHas;
                    }
                    $data[$rel] = $hasMany;
                } else {
                    foreach ($row->$rel->attributes() as $rra) {
                        $data[$rra] = $row->$rel->$rra;
                    }
                }
            }
            $return[] = $data;
        }
        return $return;
    }
    
    public function getAvatar(){
        return Yii::$app->params['imageUrl'].$this->usr_avatar;
    }

}
