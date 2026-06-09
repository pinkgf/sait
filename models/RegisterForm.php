<?php
namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $full_name;
    
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'full_name'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 3],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Логин занят'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Email уже используется'],
        ];
    }
    
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->full_name = $this->full_name;
        $user->setPassword($this->password); // Сохраняем как есть
        $user->generateAuthKey();
        $user->role = 'employee';
        $user->permission = 'both';
        $user->status = 10;
        $user->created_at = time();
        $user->updated_at = time();
        
        return $user->save();
    }
}
