<?php

namespace app\models\forms;

use yii\base\Model;
use Yii;

class RegistrationForm extends Model {
	public $email;
	public $password;

    public function rules()
	{
		return [
			[['email', 'password'], 'required'],
			[['password'], 'match', 'pattern' => '/^[a-zA-Z0-9_\!]+$/', 'message' => 'Недопустимые символы'],
			[['password'], 'string', 'length' => [6, 12]],
			[['email'], 'email'],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'E-mail',
			'password' => 'Пароль',
		];
	}
}