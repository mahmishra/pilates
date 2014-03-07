<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord implements IdentityInterface {

    public $changePassword = false;
    public $auth_key = 'admin';

    const STATUS_ACTIVE = 1;

    public static function tableName() {
        return 'user';
    }

    public function rules() {
        return [
            [['role_id'], 'safe'],
            [['role_id', 'registered', 'last_login', 'modified_time', 'is_logged'], 'integer'],
            [['address'], 'string'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 150],
            [['password'], 'string', 'max' => 255],
            [['email', 'city'], 'string', 'max' => 200],
            [['postcode'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique']
        ];
    }

    public function attributeLabels() {
        return [
            [['role_id'], 'required'],
            [['role_id', 'registered', 'last_login', 'modified_time', 'is_logged'], 'integer'],
            [['address'], 'string'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 150],
            [['password'], 'string', 'max' => 255],
            [['email', 'city'], 'string', 'max' => 200],
            [['postcode'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique']
        ];
    }

    public function getRole() {
        return $this->hasOne(UserRole::className(), ['id' => 'role_id']);
    }

    public function getId() {
        return $this->id;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (($this->isNewRecord || $this->changePassword == true) && !empty($this->password)) {
                $this->password = Yii::$app->hasher->hashPassword($this->password);
                $this->changePassword = false;
            }
            return true;
        }
        return false;
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
        return Yii::$app->hasher->checkPassword($password, $this->password);
    }

    public static function findByUsername($username) {
        return static::find(['username' => $username, 'status' => static::STATUS_ACTIVE]);
    }

}
