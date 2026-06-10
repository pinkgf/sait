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
        // Получаем список всех месяцев, в которых есть операции (исправленный запрос)
        $monthsWithData = [];
        $rawMonths = Transaction::find()
            ->select(['DATE_FORMAT(transaction_date, "%Y-%m") as month'])
            ->groupBy(['month'])
            ->orderBy(['month' => SORT_DESC])
            ->asArray()
            ->all();
        
        foreach ($rawMonths as $m) {
            $timestamp = strtotime($m['month'] . '-01');
            $monthsWithData[] = [
                'month' => $m['month'],
                'month_name' => date('F Y', $timestamp),
            ];
        }
        
        // Выбранный месяц (по умолчанию последний месяц с операциями или текущий)
        $selectedMonth = Yii::$app->request->get('month');
        if (!$selectedMonth && !empty($monthsWithData)) {
            $selectedMonth = $monthsWithData[0]['month'];
        }
        if (!$selectedMonth) {
            $selectedMonth = date('Y-m');
        }
        
        $startDate = $selectedMonth . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));
        
        // Операции за выбранный месяц
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
        $daysInMonth = date('t', strtotime($selectedMonth));
        $dailyData = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $day = date('Y-m-d', strtotime("$selectedMonth-$i"));
            $dailyData[$i] = [
                'day' => $i,
                'income' => Transaction::find()->where(['type' => 'income', 'transaction_date' => $day])->sum('amount') ?: 0,
                'expense' => Transaction::find()->where(['type' => 'expense', 'transaction_date' => $day])->sum('amount') ?: 0,
            ];
        }
        
        $monthName = date('F Y', strtotime($selectedMonth));
        
        return $this->render('index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'incomeByCategory' => $incomeByCategory,
            'expenseByCategory' => $expenseByCategory,
            'dailyData' => $dailyData,
            'selectedMonth' => $selectedMonth,
            'monthName' => $monthName,
            'monthsWithData' => $monthsWithData,
        ]);
    }
}
