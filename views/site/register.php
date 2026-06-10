<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Регистрация';
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">📝 Регистрация</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                
                <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                
                <?= $form->field($model, 'email')->textInput()->label('Email') ?>
                
                <?= $form->field($model, 'full_name')->textInput()->label('Полное имя') ?>
                
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success btn-block', 'style' => 'width:100%']) ?>
                </div>
                
                <?php ActiveForm::end(); ?>
                
                <hr>
                <div class="text-center">
                    Уже есть аккаунт? <?= Html::a('Войти', ['site/login']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
