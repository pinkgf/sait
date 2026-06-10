<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Transaction;
use app\models\CashBalance;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $totalIncome = Transaction::find()->where(['type' => 'income'])->sum('amount') ?: 0;
        $totalExpense = Transaction::find()->where(['type' => 'expense'])->sum('amount') ?: 0;
        $balance = $totalIncome - $totalExpense;
        $recent = Transaction::find()->with('category')->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        
        return $this->render('index', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'recent' => $recent,
        ]);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/index']);
        }
        
        return $this->render('login', ['model' => $model]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }
}
