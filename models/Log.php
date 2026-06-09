<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Log extends ActiveRecord
{
    public static function tableName()
    {
        return 'log';
    }
    
    public static function add($action, $description = null)
    {
        if (Yii::$app->user->isGuest) return false;
        
        $log = new Log();
        $log->user_id = Yii::$app->user->id;
        $log->action = $action;
        $log->description = $description;
        $log->ip = Yii::$app->request->userIP;
        $log->created_at = time();
        return $log->save();
    }
    
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
