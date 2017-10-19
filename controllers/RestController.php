<?php
/**
 * Created by PhpStorm.
 * User: unadm
 * Date: 19.10.17
 * Time: 17:22
 */

namespace app\controllers;


use app\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class RestController extends ActiveController
{
    public $modelClass = 'app\models\Books';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {

        $user = User::findByUsername($username);
        return $user->validatePassword($password) ? $user : null;

    }

}