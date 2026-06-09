<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Transaction extends ActiveRecord
{
    public static function tableName()
    {
        return 'transaction';
    }
    
    public function rules()
    {
        return [
            [['type', 'amount', 'transaction_date'], 'required'],
            [['amount'], 'number'],
            [['category_id', 'created_by'], 'integer'],
            [['transaction_date'], 'safe'],
            [['description'], 'string'],
        ];
    }
    
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
