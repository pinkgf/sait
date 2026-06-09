<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\Transaction;

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
            return $this->render('guest');
        }
        
        $totalIncome = Transaction::find()->where(['type' => 'income', 'created_by' => Yii::$app->user->id])->sum('amount');
        $totalExpense = Transaction::find()->where(['type' => 'expense', 'created_by' => Yii::$app->user->id])->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        $recent = Transaction::find()
            ->where(['created_by' => Yii::$app->user->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(10)
            ->all();
        
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
    
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }
        
        $model = new RegisterForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Регистрация успешна! Теперь войдите.');
            return $this->redirect(['site/login']);
        }
        
        return $this->render('register', ['model' => $model]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }
}
