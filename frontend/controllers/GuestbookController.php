<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\GuestBook; // 假设Gii生成的类名是 PreGuestbook

use yii\data\Pagination;

class GuestbookController extends Controller
{
    public function actionIndex()
    {
        $model = new GuestBook();
        
        // 如果用户已登录，自动填充昵称
        if (!Yii::$app->user->isGuest) {
            $model->nickname = Yii::$app->user->identity->username;
            $model->email = Yii::$app->user->identity->email; // 假设User模型有email字段
        }

        // 处理表单提交
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date('Y-m-d H:i:s');
            $model->ip_address = Yii::$app->request->userIP;
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '感谢您的留言！');
                return $this->refresh();
            }
        }

        // 获取留言列表（带分页）
        $query = GuestBook::find()->orderBy(['created_at' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $messages = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'model' => $model,
            'messages' => $messages,
            'pages' => $pages,
        ]);
    }
}