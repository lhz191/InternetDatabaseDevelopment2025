<?php
/**
 * 前台站点控制器 (Controller层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 前台首页、文章列表、文章详情、点赞等功能
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\PreNewsArticle;
use common\models\PreNewsCategory;
use common\models\PreNewsComment;
use yii\data\ActiveDataProvider;
use common\models\Tag;

class SiteController extends Controller
{
    /**
     * 允许AJAX点赞不需要CSRF验证
     */
    public function beforeAction($action)
    {
        if ($action->id === 'like') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * 首页
     */
    public function actionIndex()
    {
        // 获取热门文章
        $hotArticles = PreNewsArticle::find()
            ->where(['status' => PreNewsArticle::STATUS_PUBLISHED])
            ->orderBy(['views' => SORT_DESC])
            ->limit(6)
            ->all();
        
        // 获取最新文章
        $latestArticles = PreNewsArticle::find()
            ->where(['status' => PreNewsArticle::STATUS_PUBLISHED])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(6)
            ->all();
        
        // 获取所有分类
        $categories = PreNewsCategory::find()
            ->where(['status' => PreNewsCategory::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'hotArticles' => $hotArticles,
            'latestArticles' => $latestArticles,
            'categories' => $categories,
        ]);
    }

    /**
     * 新闻列表 (支持分类筛选 cid 和 标签筛选 tag)
     */
    public function actionNews($cid = null, $tag = null)
    {
        $query = PreNewsArticle::find()
            ->where(['status' => PreNewsArticle::STATUS_PUBLISHED]);
        
        // 1. 分类筛选
        if ($cid) {
            $query->andWhere(['cid' => $cid]);
        }

        // 2. 标签筛选 (新增逻辑)
        if ($tag) {
            // 先查找标签是否存在
            $tagModel = Tag::findOne(['name' => $tag]);
            if ($tagModel) {
                // 使用 innerJoin 关联中间表 (pre_article_tag)
                // 逻辑：文章表(aid) <-> 中间表(aid, tid) <-> 标签表(id)
                $query->innerJoin('pre_article_tag', 'pre_article_tag.aid = pre_news_article.aid')
                      ->andWhere(['pre_article_tag.tid' => $tagModel->id]);
            } else {
                // 如果标签不存在，则不显示任何文章
                $query->andWhere('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $categories = PreNewsCategory::find()
            ->where(['status' => PreNewsCategory::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        $currentCategory = $cid ? PreNewsCategory::findOne($cid) : null;

        return $this->render('news', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'currentTag' => $tag, // 将标签传给视图（可选，用于在页面显示当前筛选的标签）
        ]);
    }

    /**
     * 文章详情
     */
    public function actionView($id)
    {
        $article = PreNewsArticle::findOne(['aid' => $id, 'status' => PreNewsArticle::STATUS_PUBLISHED]);
        
        if (!$article) {
            throw new \yii\web\NotFoundHttpException('文章不存在');
        }

        // 增加浏览量
        $article->increaseViews();

        // 获取评论
        $comments = PreNewsComment::find()
            ->where(['aid' => $id, 'status' => PreNewsComment::STATUS_APPROVED])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        // 获取相关文章
        $relatedArticles = PreNewsArticle::find()
            ->where(['status' => PreNewsArticle::STATUS_PUBLISHED, 'cid' => $article->cid])
            ->andWhere(['!=', 'aid', $id])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('view', [
            'article' => $article,
            'comments' => $comments,
            'relatedArticles' => $relatedArticles,
        ]);
    }

    /**
     * 关于我们
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * 联系我们
     */
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * 错误页面
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
    
    /**
     * 点赞文章 (AJAX)
     * @param int $id 文章ID
     * @return array
     */
    public function actionLike($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $article = PreNewsArticle::findOne($id);
        if (!$article) {
            return ['success' => false, 'message' => '文章不存在'];
        }
        
        // 检查是否已点赞（使用session存储）
        $likedArticles = Yii::$app->session->get('liked_articles', []);
        if (in_array($id, $likedArticles)) {
            return ['success' => false, 'message' => '您已经点赞过了', 'likes' => $article->likes];
        }
        
        // 增加点赞数
        $article->likes = $article->likes + 1;
        $article->save(false);
        
        // 记录已点赞
        $likedArticles[] = $id;
        Yii::$app->session->set('liked_articles', $likedArticles);
        
        return ['success' => true, 'message' => '点赞成功', 'likes' => $article->likes];
    }
}
