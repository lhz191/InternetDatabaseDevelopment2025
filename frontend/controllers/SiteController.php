<?php
/**
 * 前台站点控制器 (Controller层)
 * @author 团队
 * @date 2025-12-08
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\PreNewsArticle;
use common\models\PreNewsCategory;
use common\models\PreNewsComment;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
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
     * 新闻列表
     */
    public function actionNews($cid = null)
    {
        $query = PreNewsArticle::find()
            ->where(['status' => PreNewsArticle::STATUS_PUBLISHED]);
        
        if ($cid) {
            $query->andWhere(['cid' => $cid]);
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
}
