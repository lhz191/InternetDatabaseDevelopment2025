<?php
/**
 * 分类管理控制器 (Controller层)
 * 
 * @author 组员B
 * @date 2025-12-08
 * @description 新闻分类的增删改查操作
 */

namespace backend\controllers;

use Yii;
use common\models\PreNewsCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 分类控制器
 */
class CategoryController extends Controller
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
     * 分类列表
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PreNewsCategory::find()->orderBy(['sort_order' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 查看分类详情
     * @param int $cid
     * @return string
     */
    public function actionView($cid)
    {
        return $this->render('view', [
            'model' => $this->findModel($cid),
        ]);
    }

    /**
     * 创建新分类
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PreNewsCategory();
        $model->status = PreNewsCategory::STATUS_ACTIVE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '分类创建成功！');
            return $this->redirect(['view', 'cid' => $model->cid]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新分类
     * @param int $cid
     * @return string|\yii\web\Response
     */
    public function actionUpdate($cid)
    {
        $model = $this->findModel($cid);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '分类更新成功！');
            return $this->redirect(['view', 'cid' => $model->cid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除分类
     * @param int $cid
     * @return \yii\web\Response
     */
    public function actionDelete($cid)
    {
        $model = $this->findModel($cid);
        
        // 检查是否有关联文章
        if ($model->getArticles()->count() > 0) {
            Yii::$app->session->setFlash('error', '该分类下存在文章，无法删除！');
            return $this->redirect(['index']);
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', '分类删除成功！');

        return $this->redirect(['index']);
    }

    /**
     * 查找模型
     * @param int $cid
     * @return PreNewsCategory
     * @throws NotFoundHttpException
     */
    protected function findModel($cid)
    {
        if (($model = PreNewsCategory::findOne(['cid' => $cid])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的分类不存在。');
    }
}

