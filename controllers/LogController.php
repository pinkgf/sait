<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Log;

class LogController extends Controller
{
    
    public function actionIndex()
    {
        $logs = Log::find()->with('user')->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('index', ['logs' => $logs]);
    }
}
