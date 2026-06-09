<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\Transaction;
use app\models\Category;
use app\models\CashBalance;
use app\models\Log;

class TransactionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => ['class' => AccessRule::class],
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
        $sort = Yii::$app->request->get('sort', 'date_desc');
        
        // ВСЕ сотрудники видят ВСЕ операции (без фильтрации по типу)
        $query = Transaction::find();
        
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
            default:
                $query->orderBy(['created_at' => SORT_DESC]);
        }
        
        $transactions = $query->with('category', 'creator')->all();
        
        $totalIncome = Transaction::find()->where(['type' => 'income'])->sum('amount') ?: 0;
        $totalExpense = Transaction::find()->where(['type' => 'expense'])->sum('amount') ?: 0;
        $balance = $totalIncome - $totalExpense;
        
        return $this->render('index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'user' => $user,
            'currentSort' => $sort,
        ]);
    }
    
    public function actionAdd()
    {
        $user = Yii::$app->user->identity;
        $model = new Transaction();
        
        if (Yii::$app->request->isPost) {
            $type = Yii::$app->request->post('Transaction')['type'];
            
            // Проверяем права на добавление (по permission)
            if ($type == 'income' && !$user->canAddIncome()) {
                Yii::$app->session->setFlash('error', 'Вы не можете добавлять доходы');
                return $this->redirect(['index']);
            }
            
            if ($type == 'expense' && !$user->canAddExpense()) {
                Yii::$app->session->setFlash('error', 'Вы не можете добавлять расходы');
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
                Log::add('Добавление операции', "Добавлена операция на сумму {$model->amount} руб.");
                Yii::$app->session->setFlash('success', 'Операция добавлена');
                return $this->redirect(['index']);
            }
        }
        
        $incomeCategories = Category::find()->where(['type' => 'income'])->all();
        $expenseCategories = Category::find()->where(['type' => 'expense'])->all();
        
        return $this->render('add', [
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
            'user' => $user,
        ]);
    }
    
    // Редактирование - только свои операции
    public function actionEdit($id)
    {
        $user = Yii::$app->user->identity;
        $model = Transaction::findOne($id);
        
        if (!$model) {
            return $this->redirect(['index']);
        }
        
        // Проверка: только свои операции может редактировать (или админ)
        if (!$user->isAdmin() && $model->created_by != $user->id) {
            Yii::$app->session->setFlash('error', 'Вы можете редактировать только свои операции');
            return $this->redirect(['index']);
        }
        
        if (Yii::$app->request->isPost) {
            $type = Yii::$app->request->post('Transaction')['type'];
            
            $model->type = $type;
            $model->amount = Yii::$app->request->post('Transaction')['amount'];
            $model->category_id = Yii::$app->request->post('Transaction')['category_id'];
            $model->description = Yii::$app->request->post('Transaction')['description'];
            $model->transaction_date = Yii::$app->request->post('Transaction')['transaction_date'];
            $model->updated_at = time();
            
            if ($model->save()) {
                Log::add('Редактирование операции', "Изменена операция #{$model->id}");
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
            'user' => $user,
        ]);
    }
    
    // Удаление - только свои операции
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $model = Transaction::findOne($id);
        
        if (!$model) {
            return $this->redirect(['index']);
        }
        
        // Проверка: только свои операции может удалять (или админ)
        if (!$user->isAdmin() && $model->created_by != $user->id) {
            Yii::$app->session->setFlash('error', 'Вы можете удалять только свои операции');
            return $this->redirect(['index']);
        }
        
        $model->delete();
        Log::add('Удаление операции', "Удалена операция #{$model->id}");
        Yii::$app->session->setFlash('success', 'Операция удалена');
        return $this->redirect(['index']);
    }
}
