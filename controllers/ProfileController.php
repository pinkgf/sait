<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Transaction;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        
        // Статистика пользователя
        $totalIncome = Transaction::find()->where(['type' => 'income', 'created_by' => $user->id])->sum('amount');
        $totalExpense = Transaction::find()->where(['type' => 'expense', 'created_by' => $user->id])->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $operationsCount = Transaction::find()->where(['created_by' => $user->id])->count();
        
        return $this->render('index', [
            'user' => $user,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'operationsCount' => $operationsCount,
        ]);
    }
    
    public function actionEdit()
    {
        $user = Yii::$app->user->identity;
        
        if ($_POST) {
            $user->full_name = $_POST['full_name'];
            $user->email = $_POST['email'];
            
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Профиль обновлен');
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('edit', ['user' => $user]);
    }
    
    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;
        
        if ($_POST) {
            $old = $_POST['old_password'];
            $new = $_POST['new_password'];
            $confirm = $_POST['confirm_password'];
            
            if ($new !== $confirm) {
                Yii::$app->session->setFlash('error', 'Пароли не совпадают');
            } else {
                $user->setPassword($new);
                $user->generateAuthKey();
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'Пароль изменен');
                    return $this->redirect(['index']);
                }
            }
        }
        
        return $this->render('change-password');
    }
}
