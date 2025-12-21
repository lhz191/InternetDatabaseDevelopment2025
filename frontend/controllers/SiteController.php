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
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;
use common\models\PreNewsArticle;
use common\models\PreNewsCategory;
use common\models\PreNewsComment;
use yii\data\ActiveDataProvider;
use common\models\Tag;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        // 如果已登录，直接跳转回首页
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                // 注册成功后直接登录
                $user = \common\models\User::findByUsername($model->username);
                if ($user) {
                    Yii::$app->user->login($user, 3600 * 24 * 30);
                }
                
                Yii::$app->session->setFlash('success', '注册成功，已自动为您登录！');
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new \frontend\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new \frontend\models\ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new \frontend\models\VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new \frontend\models\ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

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
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        
        $articleId = $request->post('article_id');
        $content = $request->post('content');
        $parentId = $request->post('parent_id'); // <--- 新增：接收父评论ID

        if (!$articleId || !$content) {
            return ['success' => false, 'message' => '参数缺失'];
        }

        $model = new PreNewsComment(); 
        $model->aid = $articleId;
        $model->content = $content;
        
        // <--- 新增：如果有 parent_id 就存进去，否则为 null
        $model->parent_id = !empty($parentId) ? $parentId : null; 

        // 处理用户ID
        if (Yii::$app->user->isGuest) {
            $model->uid = 1; // 游客/默认ID
        } else {
            $model->uid = Yii::$app->user->id;
        }

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
    public function actionLikeComment($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // 查找评论
        $comment = PreNewsComment::findOne($id);
        if (!$comment) {
            return ['success' => false, 'message' => '评论不存在'];
        }

        // 检查 Session 防止重复点赞
        $likedComments = Yii::$app->session->get('liked_comments', []);
        if (in_array($id, $likedComments)) {
            return ['success' => false, 'message' => '已点赞', 'likes' => $comment->likes];
        }

        // 更新数据库：点赞数 +1
        $comment->updateCounters(['likes' => 1]);
        
        // 记录到 Session
        $likedComments[] = $id;
        Yii::$app->session->set('liked_comments', $likedComments);

        return ['success' => true, 'likes' => $comment->likes];
    }
}
