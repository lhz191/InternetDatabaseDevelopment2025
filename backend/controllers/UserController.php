<?php
/**
 * 用户管理控制器 (Controller层)
 * 
 * @author 组员A
 * @date 2025-12-08
 * @description 用户的增删改查操作
 */

namespace backend\controllers;

use Yii;
use common\models\PreSysUser;
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
        $dataProvider = new ActiveDataProvider([
            'query' => PreSysUser::find()->orderBy(['created_at' => SORT_DESC]),
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
     * @param int $uid
     * @return string
     */
    public function actionView($uid)
    {
        return $this->render('view', [
            'model' => $this->findModel($uid),
        ]);
    }

    /**
     * 创建新用户
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PreSysUser();
        $model->status = PreSysUser::STATUS_ACTIVE;
        $model->role = PreSysUser::ROLE_USER;

        if ($model->load(Yii::$app->request->post())) {
            // 加密密码
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '用户创建成功！');
                return $this->redirect(['view', 'uid' => $model->uid]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新用户
     * @param int $uid
     * @return string|\yii\web\Response
     */
    public function actionUpdate($uid)
    {
        $model = $this->findModel($uid);
        $oldPassword = $model->password_hash;

        if ($model->load(Yii::$app->request->post())) {
            // 如果密码没变，保持原密码
            if ($model->password_hash === $oldPassword || empty($model->password_hash)) {
                $model->password_hash = $oldPassword;
            } else {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            }
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '用户更新成功！');
                return $this->redirect(['view', 'uid' => $model->uid]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除用户
     * @param int $uid
     * @return \yii\web\Response
     */
    public function actionDelete($uid)
    {
        $this->findModel($uid)->delete();
        Yii::$app->session->setFlash('success', '用户删除成功！');

        return $this->redirect(['index']);
    }

    /**
     * 查找模型
     * @param int $uid
     * @return PreSysUser
     * @throws NotFoundHttpException
     */
    protected function findModel($uid)
    {
        if (($model = PreSysUser::findOne(['uid' => $uid])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的用户不存在。');
    }
}

