<?php


namespace app\controllers;

use app\models\Crimes;
use yii\web\Controller;

class CrimeController extends Controller
{
    public function actionView($code_id)
    {
        $model = Crimes::find()->where(['code_id' => $code_id])->one();
        return $this->render('crime-view', [
            'model' => $model,
        ]);
    }
}