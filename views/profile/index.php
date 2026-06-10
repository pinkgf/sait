<?php
$this->title = 'Мой профиль';
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3>👤 Мой профиль</h3></div>
            <div class="card-body">
                <p><strong>Логин:</strong> <?= $user->username ?></p>
                <p><strong>Email:</strong> <?= $user->email ?></p>
                <p><strong>Полное имя:</strong> <?= $user->full_name ?></p>
                <p><strong>Роль:</strong> <?= $user->getRoleLabel() ?></p>
                <p><strong>Права:</strong> 
                    <?php if ($user->canAddIncome() && $user->canAddExpense()): ?>Все операции
                    <?php elseif ($user->canAddIncome()): ?>Только доходы
                    <?php elseif ($user->canAddExpense()): ?>Только расходы
                    <?php endif; ?>
                </p>
                <a href="/index.php?r=profile/edit" class="btn btn-primary">Редактировать</a>
                <a href="/index.php?r=profile/change-password" class="btn btn-warning">Сменить пароль</a>
            </div>
        </div>
    </div>
</div>
