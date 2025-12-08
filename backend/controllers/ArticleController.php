<?php
/**
 * 文章管理控制器 (Controller层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 文章的增删改查操作，包含列表、详情、创建、编辑、删除、置顶、热门等功能
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
                    'toggle-top' => ['POST'],
                    'toggle-hot' => ['POST'],
                    'batch-action' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 文章列表（支持关键词搜索、分类筛选、状态筛选）
     * @return string
     */
    public function actionIndex()
    {
        $keyword = Yii::$app->request->get('keyword', '');
        $cid = Yii::$app->request->get('cid', '');
        $status = Yii::$app->request->get('status', '');
        $sort = Yii::$app->request->get('sort', 'created_at');
        
        $query = PreNewsArticle::find();
        
        // 关键词搜索
        if (!empty($keyword)) {
            $query->andWhere(['like', 'title', $keyword]);
        }
        
        // 分类筛选
        if ($cid !== '') {
            $query->andWhere(['cid' => $cid]);
        }
        
        // 状态筛选
        if ($status !== '') {
            $query->andWhere(['status' => $status]);
        }
        
        // 排序
        switch ($sort) {
            case 'views':
                $query->orderBy(['views' => SORT_DESC]);
                break;
            case 'likes':
                $query->orderBy(['likes' => SORT_DESC]);
                break;
            default:
                $query->orderBy(['created_at' => SORT_DESC]);
        }
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        // 获取分类列表
        $categories = PreNewsCategory::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'keyword' => $keyword,
            'cid' => $cid,
            'status' => $status,
            'sort' => $sort,
            'categories' => $categories,
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
     * 切换置顶状态
     * @param int $aid
     * @return \yii\web\Response
     */
    public function actionToggleTop($aid)
    {
        $model = $this->findModel($aid);
        $model->is_top = $model->is_top ? 0 : 1;
        $model->save(false);
        
        $msg = $model->is_top ? '文章已置顶' : '已取消置顶';
        Yii::$app->session->setFlash('success', $msg);
        
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
    
    /**
     * 切换热门状态
     * @param int $aid
     * @return \yii\web\Response
     */
    public function actionToggleHot($aid)
    {
        $model = $this->findModel($aid);
        $model->is_hot = $model->is_hot ? 0 : 1;
        $model->save(false);
        
        $msg = $model->is_hot ? '文章已设为热门' : '已取消热门';
        Yii::$app->session->setFlash('success', $msg);
        
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
    
    /**
     * 批量操作
     * @return \yii\web\Response
     */
    public function actionBatchAction()
    {
        $ids = Yii::$app->request->post('ids', []);
        $action = Yii::$app->request->post('action', '');
        
        if (empty($ids)) {
            Yii::$app->session->setFlash('error', '请选择要操作的文章');
            return $this->redirect(['index']);
        }
        
        $count = 0;
        foreach ($ids as $aid) {
            $model = PreNewsArticle::findOne($aid);
            if ($model) {
                switch ($action) {
                    case 'top':
                        $model->is_top = 1;
                        break;
                    case 'untop':
                        $model->is_top = 0;
                        break;
                    case 'hot':
                        $model->is_hot = 1;
                        break;
                    case 'unhot':
                        $model->is_hot = 0;
                        break;
                    case 'publish':
                        $model->status = 1;
                        break;
                    case 'draft':
                        $model->status = 0;
                        break;
                    case 'delete':
                        $model->delete();
                        $count++;
                        continue 2;
                }
                $model->save(false);
                $count++;
            }
        }
        
        Yii::$app->session->setFlash('success', "成功操作 {$count} 篇文章");
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
