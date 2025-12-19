<?php
/**
 * 用户管理控制器 (Controller层)
 * * @author 组员A
 * @date 2025-12-08
 * @description 用户的增删改查操作
 */

namespace backend\controllers;

use Yii;
use common\models\User; // <--- 关键修改1：改为引用 User 模型
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 用户控制器
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 用户列表
     * @return string
     */
    public function actionIndex()
    {
        // <--- 关键修改2：使用 User::find()
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 查看用户详情
     * @param int $id <--- 参数名建议改为 id，与数据库字段对应
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 创建新用户 (后台直接开户)
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User(); // <--- 使用 User
        $model->status = User::STATUS_ACTIVE;
        // $model->role = User::ROLE_USER; // 注意：User模型里可能没有 role 字段，如果没有请注释掉

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password_hash); // 使用 User 模型自带的方法设置密码
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            
            // 补充必要字段
            $model->email = $model->username . '@backend_create.com'; // 模拟邮箱，防报错
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', '用户创建成功！');
                return $this->redirect(['view', 'id' => $model->id]); // <--- 这里的 uid 改为 id
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新用户
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // 保存旧密码哈希
        $oldPasswordHash = $model->password_hash;

        // 这是一个临时处理：为了不在表单中显示加密后的乱码，我们把密码字段清空
        // 用户如果不填密码框，表示不修改密码
        $model->password_hash = ''; 

        if ($model->load(Yii::$app->request->post())) {
            // 判断用户是否输入了新密码
            if (!empty($model->password_hash)) {
                // 如果输入了，调用 User 模型的方法加密
                $model->setPassword($model->password_hash);
            } else {
                // 如果没输入，恢复旧密码
                $model->password_hash = $oldPasswordHash;
            }
            
            $model->updated_at = time();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', '用户更新成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除用户
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '用户删除成功！');

        return $this->redirect(['index']);
    }

    /**
     * 查找模型
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        // <--- 关键修改3：findOne 使用 id 作为查询条件，且使用 User 模型
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的用户不存在。');
    }
}