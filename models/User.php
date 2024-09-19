<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
	{
		return '{{%users}}';
	}
    
    public function rules()
	{
		return [
			[['email', 'password'], 'required', 'except' => 'update'],
			[['email'], 'email'],
			[['email'], 'unique', 'message' => 'Адрес электронной почты уже используется'],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'E-mail',
			'password' => 'Пароль',
		];
	}

    public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	public function getId()
	{
		return $this->id;
	}

    public function getAuthKey()
	{
		return $this->auth_key;
	}

    public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username]);
	}

    public function setPassword($password)
	{
		$password = Yii::$app->security->generatePasswordHash($password);
		return $password;
	}

	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password);
	}

	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
