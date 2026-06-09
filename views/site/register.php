<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Регистрация';
?>

<div class="form-card" style="max-width: 500px;">
    <h2 style="margin-bottom: 24px; text-align: center;">
        <i class="fas fa-user-plus"></i> Регистрация
    </h2>
    
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <label>Логин</label>
        <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'placeholder' => 'Введите логин']) ?>
    </div>
    
    <div class="form-group">
        <label>Email</label>
        <?= Html::activeTextInput($model, 'email', ['class' => 'form-control', 'type' => 'email', 'placeholder' => 'example@mail.com']) ?>
    </div>
    
    <div class="form-group">
        <label>Полное имя</label>
        <?= Html::activeTextInput($model, 'full_name', ['class' => 'form-control', 'placeholder' => 'Иван Иванов']) ?>
    </div>
    
    <div class="form-group">
        <label>Пароль</label>
        <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'placeholder' => 'Придумайте пароль']) ?>
    </div>
    
    <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fas fa-check"></i> Зарегистрироваться</button>
    
    <div style="text-align: center; margin-top: 20px;">
        Уже есть аккаунт? <a href="?r=site/login" style="color: #6366f1;">Войти</a>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
