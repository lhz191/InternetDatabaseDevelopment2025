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
        $model = PreNewsArticle::findOne($id);
        
        // 1. 获取该文章下的所有审核通过的评论
        $comments = PreNewsComment::find()
            ->where(['aid' => $id, 'status' => 1]) // status=1 表示已发布/已审核
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        // 2. 实例化一个新的评论模型，给表单用
        $newComment = new PreNewsComment();
        $newComment->aid = $id; // 预先填好文章ID

        return $this->render('view', [
            'article' => $model,
            'comments' => $comments,    // 传给视图：评论列表
            'newComment' => $newComment // 传给视图：新评论表单对象
        ]);
    }

    /**
 * 处理 AJAX 评论提交
 */
public function actionComment()
{
    // 1. 设置返回格式为 JSON
    Yii::$app->response->format = Response::FORMAT_JSON;

    // 2. 接收 POST 数据
    $request = Yii::$app->request;
    $articleId = $request->post('article_id');
    $content = $request->post('content');

    // 简单校验
    if (!$articleId || !$content) {
        return ['success' => false, 'message' => '参数缺失'];
    }

    // ==========================================
    // 3. 关键步骤：先创建对象 (实例化)
    // ==========================================
    $model = new PreNewsComment(); 

    // 4. 然后才能赋值
    $model->aid = $articleId;
    $model->content = $content;

    // 处理游客/登录用户
    if (Yii::$app->user->isGuest) {
        // 如果是游客，指定一个默认的用户ID 
        // 警告：确保你的 user 表里有 id=1 的用户，否则外键约束会报错！
        $model->uid = 1; 
    } else {
        // 如果已登录，使用当前用户ID
        $model->uid = Yii::$app->user->isGuest ? 1 : Yii::$app->user->id;
    }

    // 5. 保存并返回结果
    if ($model->save()) {
        return ['success' => true, 'message' => '评论成功'];
    } else {
        return [
            'success' => false, 
            'message' => '保存失败：' . implode(', ', $model->getFirstErrors())
        ];
    }
}

    /**
     * 提交评论动作 (新增)
     */
    public function actionAddComment()
    {
        $model = new PreNewsComment();

        if ($model->load(Yii::$app->request->post())) {
            // 1. 检查是否登录
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', '请先登录后再评论！');
                return $this->redirect(['site/login']);
            }

            // 2. 自动填充字段
            $model->uid = Yii::$app->user->id; // 当前登录用户ID
            $model->status = 1; // 默认状态：1直接发布 (如果是0则需要后台审核)
            $model->created_at = date('Y-m-d H:i:s');

            // 3. 保存
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '评论发表成功！');
            } else {
                Yii::$app->session->setFlash('error', '评论失败：' . implode(',', $model->getFirstErrors()));
            }
            
            // 4. 跳回文章页
            return $this->redirect(['site/view', 'id' => $model->aid]);
        }

        return $this->goHome();
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
