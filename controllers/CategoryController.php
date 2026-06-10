<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Category;

class CategoryController extends Controller
{
    
    public function actionIndex()
    {
        $categories = Category::find()->all();
        return $this->render('index', ['categories' => $categories]);
    }
    
    public function actionAdd()
    {
        $model = new Category();
        if ($_POST) {
            $model->name = $_POST['name'];
            $model->type = $_POST['type'];
            $model->created_at = time();
            $model->updated_at = time();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Категория добавлена');
                return $this->redirect(['index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    
    public function actionDelete($id)
    {
        $model = Category::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Категория удалена');
        }
        return $this->redirect(['index']);
    }
}
