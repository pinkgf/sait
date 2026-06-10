<?php
$this->title = 'Главная';
?>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #3b82f6;">
        <h3>Текущий баланс</h3>
        <div style="font-size: 32px; font-weight: bold;"><?= number_format($balance, 2) ?> ₽</div>
    </div>
    <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #10b981;">
        <h3>Всего доходов</h3>
        <div style="font-size: 32px; font-weight: bold; color: #10b981;">+ <?= number_format($totalIncome, 2) ?> ₽</div>
    </div>
    <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #ef4444;">
        <h3>Всего расходов</h3>
        <div style="font-size: 32px; font-weight: bold; color: #ef4444;">- <?= number_format($totalExpense, 2) ?> ₽</div>
    </div>
</div>

<div style="background: white; padding: 20px; border-radius: 10px;">
    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px;">
        <h3>Последние операции</h3>
        <a href="/cash-system/web/index.php?r=transaction/index">Все →</a>
    </div>
    
    <?php if (empty($recent)): ?>
        <p>Нет операций. Добавьте первую!</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr><th style="padding: 10px; text-align: left;">Дата</th><th>Тип</th><th>Сумма</th><th>Описание</th></tr>
            </thead>
            <tbody>
                <?php foreach ($recent as $t): ?>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= $t->transaction_date ?></td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= $t->type == 'income' ? 'Доход' : 'Расход' ?></td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $t->type == 'income' ? 'color:green' : 'color:red' ?>"><?= number_format($t->amount, 2) ?> ₽</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= $t->description ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
