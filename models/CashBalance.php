<?php
namespace app\models;

use yii\db\ActiveRecord;

class CashBalance extends ActiveRecord
{
    public static function tableName()
    {
        return 'cash_balance';
    }
    
    // Получить текущий баланс кассы
    public static function getBalance()
    {
        $balance = self::find()->orderBy(['date' => SORT_DESC])->one();
        if ($balance) {
            return $balance->balance;
        }
        return self::recalculateBalance();
    }
    
    // Пересчитать баланс на основе всех операций
    public static function recalculateBalance()
    {
        $totalIncome = Transaction::find()->where(['type' => 'income'])->sum('amount') ?: 0;
        $totalExpense = Transaction::find()->where(['type' => 'expense'])->sum('amount') ?: 0;
        $newBalance = $totalIncome - $totalExpense;
        
        $balance = self::find()->orderBy(['date' => SORT_DESC])->one();
        if (!$balance) {
            $balance = new self();
            $balance->date = date('Y-m-d');
        }
        
        $balance->balance = $newBalance;
        $balance->updated_at = time();
        $balance->save();
        
        return $newBalance;
    }
}
