<?php
$this->title = 'Мой профиль';
?>

<div style="max-width: 800px; margin: 0 auto;">
    <!-- Шапка профиля -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 24px; padding: 40px; margin-bottom: 30px; color: white; text-align: center;">
        <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-user" style="font-size: 48px;"></i>
        </div>
        <h2 style="margin-bottom: 8px;"><?= $user->full_name ?: $user->username ?></h2>
        <p style="opacity: 0.9;"><?= $user->email ?></p>
        <div style="margin-top: 20px;">
            <span style="background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 13px;">
                <?= $user->getRoleLabel() ?>
            </span>
        </div>
    </div>

    <!-- Личная информация -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-id-card" style="color: #6366f1;"></i> Личная информация</h3>
            <a href="?r=profile/edit" class="btn" style="background: #e5e7eb; padding: 6px 12px; font-size: 13px;">
                <i class="fas fa-edit"></i> Редактировать
            </a>
        </div>
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">Логин</div>
                <div style="font-weight: 600;"><?= $user->username ?></div>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">Полное имя</div>
                <div style="font-weight: 600;"><?= $user->full_name ?: 'Не указано' ?></div>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">Email</div>
                <div style="font-weight: 600;"><?= $user->email ?></div>
            </div>
            <div>
                <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">Дата регистрации</div>
                <div style="font-weight: 600;"><?= date('d.m.Y в H:i', $user->created_at) ?></div>
            </div>
        </div>
    </div>

    <!-- Действия -->
    <div class="panel" style="margin-top: 24px;">
        <div class="panel-header">
            <h3><i class="fas fa-cog" style="color: #6366f1;"></i> Действия</h3>
        </div>
        <div style="padding: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="?r=profile/change-password" class="btn btn-primary">
                <i class="fas fa-key"></i> Сменить пароль
            </a>
            <a href="?r=transaction/add" class="btn btn-success">
                <i class="fas fa-plus"></i> Добавить операцию
            </a>
            <a href="?r=transaction/index" class="btn" style="background: #e5e7eb;">
                <i class="fas fa-list"></i> Все операции
            </a>
        </div>
    </div>
</div>
