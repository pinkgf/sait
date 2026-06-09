<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Вход';
?>

<div class="form-card" style="max-width: 450px;">
    <h2 style="margin-bottom: 24px; text-align: center;">
        <i class="fas fa-sign-in-alt"></i> Вход в систему
    </h2>
    
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <label>Логин</label>
        <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'placeholder' => 'Введите логин']) ?>
    </div>
    
    <div class="form-group">
        <label>Пароль</label>
        <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'placeholder' => 'Введите пароль']) ?>
    </div>
    
    <div class="form-group">
        <label>
            <?= Html::activeCheckbox($model, 'rememberMe', ['label' => 'Запомнить меня']) ?>
        </label>
    </div>
    
    <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fas fa-sign-in-alt"></i> Войти</button>
    
    <div style="text-align: center; margin-top: 20px;">
        Нет аккаунта? <a href="?r=site/register" style="color: #6366f1;">Зарегистрироваться</a>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
