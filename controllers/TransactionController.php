<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Transaction;
use app\models\Category;

class TransactionController extends Controller
{
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $sort = Yii::$app->request->get('sort', 'date_desc');
        
        $query = Transaction::find()->with('category', 'creator');
        
        // Сортировка
        switch($sort) {
            case 'date_asc':
                $query->orderBy(['transaction_date' => SORT_ASC]);
                break;
            case 'date_desc':
                $query->orderBy(['transaction_date' => SORT_DESC]);
                break;
            case 'amount_asc':
                $query->orderBy(['amount' => SORT_ASC]);
                break;
            case 'amount_desc':
                $query->orderBy(['amount' => SORT_DESC]);
                break;
            case 'type_income':
                $query->where(['type' => 'income'])->orderBy(['created_at' => SORT_DESC]);
                break;
            case 'type_expense':
                $query->where(['type' => 'expense'])->orderBy(['created_at' => SORT_DESC]);
                break;
            default:
                $query->orderBy(['created_at' => SORT_DESC]);
        }
        
        $transactions = $query->all();
        
        $totalIncome = Transaction::find()->where(['type' => 'income'])->sum('amount') ?: 0;
        $totalExpense = Transaction::find()->where(['type' => 'expense'])->sum('amount') ?: 0;
        $balance = $totalIncome - $totalExpense;
        
        return $this->render('index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'currentSort' => $sort,
        ]);
    }
    
    public function actionAdd()
    {
        $user = Yii::$app->user->identity;
        $model = new Transaction();
        
        if (Yii::$app->request->isPost) {
            $type = Yii::$app->request->post('Transaction')['type'];
            
            if ($type === 'income' && !$user->canAddIncome()) {
                Yii::$app->session->setFlash('error', 'У вас нет прав на добавление доходов');
                return $this->redirect(['index']);
            }
            if ($type === 'expense' && !$user->canAddExpense()) {
                Yii::$app->session->setFlash('error', 'У вас нет прав на добавление расходов');
                return $this->redirect(['index']);
            }
            
            $model->type = $type;
            $model->amount = Yii::$app->request->post('Transaction')['amount'];
            $model->category_id = Yii::$app->request->post('Transaction')['category_id'];
            $model->description = Yii::$app->request->post('Transaction')['description'];
            $model->transaction_date = Yii::$app->request->post('Transaction')['transaction_date'];
            $model->created_by = $user->id;
            $model->created_at = time();
            $model->updated_at = time();
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Операция добавлена');
                return $this->redirect(['index']);
            }
        }
        
        $incomeCategories = Category::find()->where(['type' => 'income'])->all();
        $expenseCategories = Category::find()->where(['type' => 'expense'])->all();
        
        return $this->render('add', [
            'model' => $model,
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ]);
    }
    
    public function actionEdit($id)
    {
        $user = Yii::$app->user->identity;
        $model = Transaction::findOne($id);
        
        if (!$model) return $this->redirect(['index']);
        
        if ($user->role !== 'admin' && $model->created_by != $user->id) {
            Yii::$app->session->setFlash('error', 'Вы можете редактировать только свои операции');
            return $this->redirect(['index']);
        }
        
        if (Yii::$app->request->isPost) {
            $model->type = Yii::$app->request->post('Transaction')['type'];
            $model->amount = Yii::$app->request->post('Transaction')['amount'];
            $model->category_id = Yii::$app->request->post('Transaction')['category_id'];
            $model->description = Yii::$app->request->post('Transaction')['description'];
            $model->transaction_date = Yii::$app->request->post('Transaction')['transaction_date'];
            $model->updated_at = time();
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Операция обновлена');
                return $this->redirect(['index']);
            }
        }
        
        $incomeCategories = Category::find()->where(['type' => 'income'])->all();
        $expenseCategories = Category::find()->where(['type' => 'expense'])->all();
        
        return $this->render('edit', [
            'model' => $model,
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ]);
    }
    
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $model = Transaction::findOne($id);
        
        if (!$model) return $this->redirect(['index']);
        
        if ($user->role !== 'admin' && $model->created_by != $user->id) {
            Yii::$app->session->setFlash('error', 'Вы можете удалять только свои операции');
            return $this->redirect(['index']);
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Операция удалена');
        return $this->redirect(['index']);
    }
}
