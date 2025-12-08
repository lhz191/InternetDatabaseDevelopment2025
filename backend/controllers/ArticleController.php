<?php
/**
 * 文章管理控制器 (Controller层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 文章的增删改查操作，包含列表、详情、创建、编辑、删除功能
 */

namespace backend\controllers;

use Yii;
use common\models\PreNewsArticle;
use backend\models\PreNewsArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PreNewsCategory;

/**
 * 文章控制器
 */
class ArticleController extends Controller
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
     * 文章列表（支持关键词搜索）
     * @return string
     */
    public function actionIndex()
    {
        $keyword = Yii::$app->request->get('keyword', '');
        
        $query = PreNewsArticle::find()->orderBy(['created_at' => SORT_DESC]);
        
        // 关键词搜索
        if (!empty($keyword)) {
            $query->andWhere(['like', 'title', $keyword]);
        }
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'keyword' => $keyword,
        ]);
    }

    /**
     * 查看文章详情
     * @param int $aid
     * @return string
     */
    public function actionView($aid)
    {
        return $this->render('view', [
            'model' => $this->findModel($aid),
        ]);
    }

    /**
     * 创建新文章
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PreNewsArticle();
        $model->status = PreNewsArticle::STATUS_PUBLISHED;
        $model->views = 0;
        $model->likes = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '文章创建成功！');
            return $this->redirect(['view', 'aid' => $model->aid]);
        }

        $categories = PreNewsCategory::getActiveCategories();

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * 更新文章
     * @param int $aid
     * @return string|\yii\web\Response
     */
    public function actionUpdate($aid)
    {
        $model = $this->findModel($aid);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '文章更新成功！');
            return $this->redirect(['view', 'aid' => $model->aid]);
        }

        $categories = PreNewsCategory::getActiveCategories();

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * 删除文章
     * @param int $aid
     * @return \yii\web\Response
     */
    public function actionDelete($aid)
    {
        $this->findModel($aid)->delete();
        Yii::$app->session->setFlash('success', '文章删除成功！');

        return $this->redirect(['index']);
    }

    /**
     * 查找模型
     * @param int $aid
     * @return PreNewsArticle
     * @throws NotFoundHttpException
     */
    protected function findModel($aid)
    {
        if (($model = PreNewsArticle::findOne(['aid' => $aid])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的文章不存在。');
    }
}

