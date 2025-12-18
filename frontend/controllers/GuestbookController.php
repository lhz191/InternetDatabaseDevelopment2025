<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\GuestBook; // 假设Gii生成的类名是 PreGuestbook

class GuestbookController extends Controller
{
    public function actionIndex()
    {
        $model = new GuestBook();
        // 处理表单提交
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '感谢您的留言！');
            return $this->refresh();
        }

        // 获取已审核的留言列表
        $messages = GuestBook::find()
            //->where(['status' => 1]) // 假设有 status 字段
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'model' => $model,
            'messages' => $messages,
        ]);
    }
}