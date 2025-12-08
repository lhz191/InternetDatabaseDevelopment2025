<?php
/**
 * 评论管理控制器 (Controller层)
 * 
 * @author 组员D
 * @date 2025-12-08
 * @description 评论的增删改查操作，包含审核、删除等功能
 */

namespace backend\controllers;

use Yii;
use common\models\PreNewsComment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 评论控制器
 */
class CommentController extends Controller
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
     * 评论列表
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PreNewsComment::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 查看评论详情
     * @param int $id
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 审核通过
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = PreNewsComment::STATUS_APPROVED;
        $model->save(false);
        
        Yii::$app->session->setFlash('success', '评论已审核通过！');
        return $this->redirect(['index']);
    }

    /**
     * 删除评论
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '评论删除成功！');

        return $this->redirect(['index']);
    }

    /**
     * 查找模型
     * @param int $id
     * @return PreNewsComment
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = PreNewsComment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的评论不存在。');
    }
}

