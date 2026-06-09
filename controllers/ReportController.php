<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Transaction;
use app\models\Category;

class ReportController extends Controller
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
        // Выбранный месяц (по умолчанию текущий)
        $month = Yii::$app->request->get('month', date('Y-m'));
        $year = date('Y', strtotime($month));
        $monthNum = date('m', strtotime($month));
        
        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));
        
        // Все операции за месяц
        $transactions = Transaction::find()
            ->with('category', 'creator')
            ->where(['between', 'transaction_date', $startDate, $endDate])
            ->orderBy(['transaction_date' => SORT_ASC])
            ->all();
        
        // Статистика
        $totalIncome = Transaction::find()
            ->where(['type' => 'income'])
            ->andWhere(['between', 'transaction_date', $startDate, $endDate])
            ->sum('amount') ?: 0;
            
        $totalExpense = Transaction::find()
            ->where(['type' => 'expense'])
            ->andWhere(['between', 'transaction_date', $startDate, $endDate])
            ->sum('amount') ?: 0;
        
        $balance = $totalIncome - $totalExpense;
        
        // Доходы по категориям
        $incomeByCategory = Transaction::find()
            ->select(['category_id', 'SUM(amount) as total'])
            ->where(['type' => 'income'])
            ->andWhere(['between', 'transaction_date', $startDate, $endDate])
            ->groupBy('category_id')
            ->asArray()
            ->all();
            
        // Расходы по категориям
        $expenseByCategory = Transaction::find()
            ->select(['category_id', 'SUM(amount) as total'])
            ->where(['type' => 'expense'])
            ->andWhere(['between', 'transaction_date', $startDate, $endDate])
            ->groupBy('category_id')
            ->asArray()
            ->all();
        
        // Данные для графика по дням
        $daysInMonth = date('t', strtotime($month));
        $dailyData = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $day = date('Y-m-d', strtotime("$month-$i"));
            $dailyData[$i] = [
                'day' => $i,
                'income' => Transaction::find()->where(['type' => 'income', 'transaction_date' => $day])->sum('amount') ?: 0,
                'expense' => Transaction::find()->where(['type' => 'expense', 'transaction_date' => $day])->sum('amount') ?: 0,
            ];
        }
        
        // Список месяцев, в которых есть операции (только те, где есть данные)
        $monthsWithData = Transaction::find()
            ->select(['DATE_FORMAT(transaction_date, "%Y-%m") as month'])
            ->groupBy('month')
            ->orderBy(['month' => SORT_DESC])
            ->asArray()
            ->all();
        
        $months = [];
        foreach ($monthsWithData as $m) {
            $timestamp = strtotime($m['month'] . '-01');
            $months[$m['month']] = date('F Y', $timestamp);
        }
        
        // Если нет ни одной операции, показываем текущий месяц
        if (empty($months)) {
            $months[date('Y-m')] = date('F Y');
        }
        
        return $this->render('index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'incomeByCategory' => $incomeByCategory,
            'expenseByCategory' => $expenseByCategory,
            'dailyData' => $dailyData,
            'currentMonth' => $month,
            'months' => $months,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'monthName' => date('F Y', strtotime($month)),
            'hasData' => !empty($transactions),
        ]);
    }
}
