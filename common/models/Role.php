<?php

namespace common\models;

class Role extends \yii\db\ActiveRecord {

    CONST ADMIN = 1;
    CONST BRANCH = 2;
    CONST INSTRUCTURE = 3;

    public static function tableName() {
        return 'user_role';
    }

    public function rules() {
        return [
            [['action', 'identity', 'name'], 'safe']
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'action' => 'Action',
            'identity' => 'Identity'
        ];
    }

    public function getUsers() {
        return $this->hasMany(User::className(), ['role_id' => 'id']);
    }

}
