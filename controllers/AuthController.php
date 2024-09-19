<?php

namespace app\controllers;

use app\models\User;
use \Yii;
use yii\web\Controller;
use app\models\forms\LoginForm;
use app\models\forms\RegistrationForm;
use app\helpers\Useful;
use yii\filters\AccessControl;

class AuthController extends Controller {
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'registration', 'logout'],
                'rules' => [
                    [
                        'actions' => ['login', 'registration'],
                        'allow' => true,
                        'roles' => ['?'],
						
                    ],
					[
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
				'denyCallback' => function ($rule, $action) {
					return $this->goHome();
				}
            ],
        ];
    }


    public function actionLogin()
	{
		if (!Yii::$app->getUser()->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();

		if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
			return $this->redirect('/');
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

    public function actionRegistration(){
        $form = new RegistrationForm();
		$request = Yii::$app->request->post('RegistrationForm');

		if($request){
			$form->email = Useful::parseCleanValue($request['email']);
			$form->password = $request['password'];
	
			if($form->validate()) {
				
				$user = new User();
				$user->email = $form->email;
				$user->password = $user->setPassword($form->password);
				if($user->validate() && $user->save()) {
					//авторизуем
					$login = new LoginForm;
					$login->email = $form->email;
					$login->password = $form->password;
					$login->rememberMe = true;

					if($login->validate() && $login->login()){
						return $this->redirect('/');
					}
				} else {
				$form->addErrors($user->getErrors());
				}
			}
		}

        return $this->render('registration', [
			'model' => $form,
		]);
    }

	public function actionLogout()
    {
        Yii::$app->user->logout();
		
        return $this->goHome();
    }

}