<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Transaction;
use app\models\Category;

class CashController extends Controller
{
    
    public function actionIndex()
    {
        $transactions = Transaction::find()
            ->where(['created_by' => Yii::$app->user->id])
            ->with('category')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
            
        $totalIncome = Transaction::find()
            ->where(['type' => 'income', 'created_by' => Yii::$app->user->id])
            ->sum('amount');
            
        $totalExpense = Transaction::find()
            ->where(['type' => 'expense', 'created_by' => Yii::$app->user->id])
            ->sum('amount');
            
        $balance = $totalIncome - $totalExpense;
        
        return $this->render('index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
        ]);
    }
    
    public function actionAdd()
    {
        $model = new Transaction();
        
        if ($_POST) {
            $model->type = $_POST['type'];
            $model->amount = $_POST['amount'];
            $model->category_id = $_POST['category_id'];
            $model->description = $_POST['description'];
            $model->transaction_date = $_POST['transaction_date'];
            $model->created_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->updated_at = time();
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Операция добавлена');
                return $this->redirect(['index']);
            }
        }
        
        $categories = Category::find()->all();
        return $this->render('add', ['categories' => $categories]);
    }
    
    public function actionDelete($id)
    {
        $model = Transaction::findOne(['id' => $id, 'created_by' => Yii::$app->user->id]);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Операция удалена');
        }
        return $this->redirect(['index']);
    }
}
