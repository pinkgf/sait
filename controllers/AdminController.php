<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Transaction;
use app\models\Log;

class AdminController extends Controller
{
    
    public function actionUsers()
    {
        $users = User::find()->all();
        $stats = [];
        foreach ($users as $user) {
            $stats[$user->id] = [
                'totalIncome' => Transaction::find()->where(['type' => 'income', 'created_by' => $user->id])->sum('amount') ?: 0,
                'totalExpense' => Transaction::find()->where(['type' => 'expense', 'created_by' => $user->id])->sum('amount') ?: 0,
                'operationsCount' => Transaction::find()->where(['created_by' => $user->id])->count(),
            ];
            $stats[$user->id]['balance'] = $stats[$user->id]['totalIncome'] - $stats[$user->id]['totalExpense'];
        }
        return $this->render('users', ['users' => $users, 'stats' => $stats]);
    }
    
    public function actionAddUser()
    {
        $user = new User();
        if ($_POST) {
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->full_name = $_POST['full_name'];
            $user->role = $_POST['role'];
            $user->permission = $_POST['permission'] ?? 'both';
            $user->setPassword($_POST['password']);
            $user->generateAuthKey();
            $user->status = 10;
            $user->created_at = time();
            $user->updated_at = time();
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Сотрудник добавлен');
                return $this->redirect(['users']);
            }
        }
        return $this->render('add-user');
    }
    
    public function actionEditUser($id)
    {
        $user = User::findOne($id);
        if (!$user || $user->id == Yii::$app->user->id) return $this->redirect(['users']);
        if ($_POST) {
            $user->full_name = $_POST['full_name'];
            $user->email = $_POST['email'];
            $user->role = $_POST['role'];
            if (isset($_POST['permission'])) $user->permission = $_POST['permission'];
            if (!empty($_POST['password'])) $user->setPassword($_POST['password']);
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Данные обновлены');
                return $this->redirect(['users']);
            }
        }
        return $this->render('edit-user', ['user' => $user]);
    }
    
    public function actionDeleteUser($id)
    {
        $user = User::findOne($id);
        if ($user && $user->id != Yii::$app->user->id) {
            Transaction::deleteAll(['created_by' => $user->id]);
            $user->delete();
            Yii::$app->session->setFlash('success', 'Сотрудник удален');
        }
        return $this->redirect(['users']);
    }
    
    public function actionUserTransactions($id)
    {
        $user = User::findOne($id);
        if (!$user) return $this->redirect(['users']);
        $transactions = Transaction::find()->where(['created_by' => $user->id])->with('category')->orderBy(['created_at' => SORT_DESC])->all();
        $totalIncome = Transaction::find()->where(['type' => 'income', 'created_by' => $user->id])->sum('amount') ?: 0;
        $totalExpense = Transaction::find()->where(['type' => 'expense', 'created_by' => $user->id])->sum('amount') ?: 0;
        $balance = $totalIncome - $totalExpense;
        return $this->render('user-transactions', compact('user', 'transactions', 'totalIncome', 'totalExpense', 'balance'));
    }
}
